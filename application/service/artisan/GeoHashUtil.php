<?php
namespace service\artisan;
/**
 ***********************************************************************************************************************
 * geohash算法
 * @author llq
 * @todo 使用singleton，
 ***********************************************************************************************************************
 */
class GeoHashUtil
{

    private $neighbors = [];
    private $borders = [];

    private $coding = '0123456789bcdefghjkmnpqrstuvwxyz';
    private $codingMap = [];

    /**
     * @var GeoHashUtil
     */
    private static $instance;

    public function __construct()
    {
        $this->neighbors['right']['even'] = 'bc01fg45238967deuvhjyznpkmstqrwx';
        $this->neighbors['left']['even'] = '238967debc01fg45kmstqrwxuvhjyznp';
        $this->neighbors['top']['even'] = 'p0r21436x8zb9dcf5h7kjnmqesgutwvy';
        $this->neighbors['bottom']['even'] = '14365h7k9dcfesgujnmqp0r2twvyx8zb';

        $this->borders['right']['even'] = 'bcfguvyz';
        $this->borders['left']['even'] = '0145hjnp';
        $this->borders['top']['even'] = 'prxz';
        $this->borders['bottom']['even'] = '028b';

        $this->neighbors['bottom']['odd'] = $this->neighbors['left']['even'];
        $this->neighbors['top']['odd'] = $this->neighbors['right']['even'];
        $this->neighbors['left']['odd'] = $this->neighbors['bottom']['even'];
        $this->neighbors['right']['odd'] = $this->neighbors['top']['even'];

        $this->borders['bottom']['odd'] = $this->borders['left']['even'];
        $this->borders['top']['odd'] = $this->borders['right']['even'];
        $this->borders['left']['odd'] = $this->borders['bottom']['even'];
        $this->borders['right']['odd'] = $this->borders['top']['even'];
        //build map from encoding char to 0 padded bitfield
        for ($i = 0; $i < 32; $i++) {
            $this->codingMap[$this->coding[$i]] = str_pad(decbin($i), 5, '0', STR_PAD_LEFT);
        }
    }

    /**
     * @return GeoHashUtil
     */
    public static function getInstance()
    {
        return self::$instance ?: self::$instance = new self();
    }

    /**
     * geohash转换为经纬度
     */
    public function decode($hash)
    {
        //decode hash into binary string
        $binary = '';
        $hl = strlen($hash);
        for ($i = 0; $i < $hl; $i++) {
            $binary .= $this->codingMap[$hash[$i]];
        }
        //split the binary into lat and log binary strings
        $bl = strlen($binary);
        $blat = '';
        $blong = '';
        for ($i = 0; $i < $bl; $i++) {
            if ($i % 2) {
                $blat .= $binary[$i];
            } else {
                $blong .= $binary[$i];
            }
        }

        //now concert to decimal
        $lat = $this->binDecode($blat, -90, 90);
        $long = $this->binDecode($blong, -180, 180);

        //figure out how precise the bit count makes this calculation
        $latErr = $this->calcError(strlen($blat), -90, 90);
        $longErr = $this->calcError(strlen($blong), -180, 180);

        //how many decimal places should we use? There's a little art to
        //this to ensure I get the same roundings as geohash.org
        $latPlaces = max(1, -round(log10($latErr))) - 1;
        $longPlaces = max(1, -round(log10($longErr))) - 1;

        //round it
        $lat = round($lat, $latPlaces);
        $long = round($long, $longPlaces);

        return [
            $long,
            $lat,
        ];
    }


    private function calculateAdjacent($srcHash, $dir)
    {

        $srcHash = strtolower($srcHash);
        $lastChr = $srcHash[strlen($srcHash) - 1];
        $type = (strlen($srcHash) % 2) ? 'odd' : 'even';
        $base = substr($srcHash, 0, strlen($srcHash) - 1);

        if (strpos($this->borders[$dir][$type], $lastChr) !== false) {
            $base = $this->calculateAdjacent($base, $dir);
        }
        return $base . $this->coding[strpos($this->neighbors[$dir][$type], $lastChr)];
    }

    // 计算附近的区块
    public function nearby($srcHash)
    {
        $nearby['top'] = $this->calculateAdjacent($srcHash, 'top');
        $nearby['bottom'] = $this->calculateAdjacent($srcHash, 'bottom');
        $nearby['right'] = $this->calculateAdjacent($srcHash, 'right');
        $nearby['left'] = $this->calculateAdjacent($srcHash, 'left');
        $nearby['topleft'] = $this->calculateAdjacent($nearby['left'], 'top');
        $nearby['topright'] = $this->calculateAdjacent($nearby['right'], 'top');
        $nearby['bottomright'] = $this->calculateAdjacent($nearby['right'], 'bottom');
        $nearby['bottomleft'] = $this->calculateAdjacent($nearby['left'], 'bottom');
        return $nearby;
    }


    /**
     * 经纬度转换成geohash
     */
    public function encode($long, $lat)
    {
        // how many bits does latitude need?
        $plat = $this->precision($lat);
        $latbits = 1;
        $err = 45;
        while ($err > $plat) {
            $latbits++;
            $err /= 2;
        }
        //how many bits does longitude need?
        $plong = $this->precision($long);
        $longbits = 1;
        $err = 90;
        while ($err > $plong) {
            $longbits++;
            $err /= 2;
        }
        //bit counts need to be equal
        $bits = max($latbits, $longbits);
        //as the hash create bits in groups of 5, lets not
        //waste any bits - lets bulk it up to a multiple of 5
        //and favour the longitude for any odd bits
        $longbits = $bits;
        $latbits = $bits;
        $addlong = 1;
        while (($longbits + $latbits) % 5 != 0) {
            $longbits += $addlong;
            $latbits += !$addlong;
            $addlong = !$addlong;
        }

        //encode each as binary string
        $blat = $this->binEncode($lat, -90, 90, $latbits);
        $blong = $this->binEncode($long, -180, 180, $longbits);

        //$binary = self::stringCross($blong, $blat);
        $codeArr = str_split(self::stringCross($blong, $blat), 5);
        $hash = '';
        foreach ($codeArr as $item) {
            $hash .= $this->coding[bindec($item)];
        }
        return $hash;
    }

    private static function stringCross($str1, $str2)
    {
        $minLen = min(strlen($str1), strlen($str2));
        $str = '';
        for ($i = 0; $i < $minLen; $i++) {
            $str .= $str1[$i] . $str2[$i];
        }
        return $str . substr(isset($str1[$minLen]) ? $str1 : $str2, $minLen);
    }

    /**
     * What's the maximum error for $bits bits covering a range $min to $max
     */
    private function calcError($bits, $min, $max)
    {
        $err = ($max - $min) / 2;
        while ($bits--) {
            $err /= 2;
        }
        return $err;
    }

    /*
    * returns precision of number
    * precision of 42 is 0.5
    * precision of 42.4 is 0.05
    * precision of 42.41 is 0.005 etc
    */
    private function precision($number)
    {
        $precision = 0;
        $pt = strpos($number, '.');
        if ($pt !== false) {
            $precision = -(strlen($number) - $pt - 1);
        }
        return pow(10, $precision) / 2;
    }


    /**
     * create binary encoding of number as detailed in http://en.wikipedia.org/wiki/Geohash#Example
     * removing the tail recursion is left an exercise for the reader
     */
    private function binEncode($number, $min, $max, $bitcount)
    {
        if ($bitcount == 0) {
            return '';
        }
        //this is our mid point - we will produce a bit to say
        //whether $number is above or below this mid point
        $mid = ($min + $max) / 2;
        if ($number > $mid) {
            return '1' . $this->binEncode($number, $mid, $max, $bitcount - 1);
        } else {
            return '0' . $this->binEncode($number, $min, $mid, $bitcount - 1);
        }
    }


    /**
     * decodes binary encoding of number as detailed in http://en.wikipedia.org/wiki/Geohash#Example
     * removing the tail recursion is left an exercise for the reader
     */
    private function binDecode($binary, $min, $max)
    {
        $mid = ($min + $max) / 2;
        if (strlen($binary) == 0) {
            return $mid;
        }
        $bit = $binary[0];
        $binary = substr($binary, 1);

        if ($bit == 1) {
            return $this->binDecode($binary, $mid, $max);
        } else {
            return $this->binDecode($binary, $min, $mid);
        }
    }

    /**
     * 计算用户坐标和目标坐标的距离
     * @param $usr_lng
     * @param $usr_lat
     * @param $target_lng
     * @param $target_lat
     * @return float
     */
    public function getDistance($usr_lng, $usr_lat, $target_lng, $target_lat)
    {
        // 地球半径
        $R = 6378137;
        // 将角度转为狐度
        $radLat1 = deg2rad($usr_lat);
        $radLat2 = deg2rad($target_lat);
        $radLng1 = deg2rad($usr_lng);
        $radLng2 = deg2rad($target_lng);
        $x = cos($radLat1) * cos($radLat2) * cos($radLng1 - $radLng2) + sin($radLat1) * sin($radLat2);
        $s = acos((int)$x == 1 ? 1 : $x) * $R;
        $s = round($s * 10000) / 10000;
        return round($s);
    }

    /**
     * 数据结果排序
     * @param $data
     * @return mixed
     */
    public function getSort($result, $field = 'distance', $order_by = 'asc')
    {
        if (count($result) > 1) {
            array_multisort(array_column($result, $field), strtolower($order_by) === 'asc' ? SORT_ASC : SORT_DESC, SORT_NUMERIC, $result);
        }
        return $result;
    }
}
