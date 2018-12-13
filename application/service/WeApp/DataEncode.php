<?php

namespace service\WeApp;

use service\artisan\MY_Service;

/**
 * 数据处理类
 * @author Tujt 2016-07-14
 */
class Dataencode extends MY_Service{
    // CRYPTO_CIPHER_BLOCK_SIZE 32
    private static $_secret_key = 'dslr-userinfo-aeckey';
    private static $default = 'aes';//默认加密方法
    private static $token_keys = 'dslr-tokenkeys-20160715';
    private static $key;


    /**
     * 加密
     * @author Toby.Tu 2016-07-14
     */
    public static function md5($code='') {
        if(empty($code)) return '';
        $code = md5(md5(self::$_secret_key).$code.md5(self::$_secret_key));
        return md5($code);
    }
    /**
     * 加密
     * @author Toby.Tu 2016-07-14
     */
    public static function sha1($code='') {
        if(empty($code)) return '';
        $code = sha1(sha1(self::$_secret_key).$code.sha1(self::$_secret_key));
        return sha1($code);
    }
    /**
     * 可变加密
     * @author Toby.Tu 2016-07-14
     */
    public static function des($key='',$data='',$xcrypt=false) {
        if(empty($key) || empty($data)) return '';
        $key = self::md5(self::sha1($key));
        if($xcrypt){//解密
            $data = base64_decode($data);
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
            $iv = mb_substr($data,0,32,'latin1');
            mcrypt_generic_init($td,$key,$iv);
            $data = mb_substr($data,32,mb_strlen($data,'latin1'),'latin1');
            $data = mdecrypt_generic($td,$data);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return trim($data);
        }else{
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
            $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td),MCRYPT_RAND);
            mcrypt_generic_init($td,$key,$iv);
            $encrypted = mcrypt_generic($td,$data);
            mcrypt_generic_deinit($td);
            return base64_encode($iv . $encrypted);
        }
    }
    /**
     * AES加解密
     * @author Toby.Tu 2016-07-14
     */
    public static function aes($key='',$data='',$xcrypt=false) {
        if(empty($key) || empty($data)) return '';
        $key = self::md5(self::sha1($key));
        if($xcrypt){//解密
            $data = base64_decode($data);
            $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,MCRYPT_MODE_ECB),MCRYPT_RAND);
            $encrypt_str =  mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv);
            $encrypt_str = trim($encrypt_str);
            $encrypt_str = self::stripPKSC7Padding($encrypt_str);
            return $encrypt_str;
        }else{
            $data = trim($data);
            $data = self::addPKCS7Padding($data);
            $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,MCRYPT_MODE_ECB),MCRYPT_RAND);
            $encrypt_str =  mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv);
            return base64_encode($encrypt_str);
        }
    }
    /**
     * AES加解密
     * @author Toby.Tu 2016-07-14
     */
    public static function base64($key='',$data='',$xcrypt=false) {
        if(empty($key) || empty($data)) return '';
        $key = self::md5(self::sha1($key));
        if($xcrypt){//解密
            $data    = $data;
            $data    = base64_decode($data);
            $len    = strlen($key);
            $code   = '';$t_len = strlen($data);
            for($i=0; $i<$t_len; $i++){
                $k  = $i % $len;
                $code  .= $data[$i] ^ $key[$k];
            }
        }else{//加密
            $data    = (string)$data;
            $len    = strlen($key);
            $code   = '';$t_len = strlen($data);
            for($i=0; $i<$t_len; $i++){
                $k  = $i % $len;
                $code  .= $data[$i] ^ $key[$k];
            }
            $code = base64_encode($code);
        }
        return $code;
    }
    /**
     * 加密
     * @author Toby.Tu 2016-07-14
     */
    public static function encode($data='',$key='',$deft='') {
        if(empty($data)) return '';

        if (empty($key)){
            $key =  config_item('openid_salt');
        }

        if(empty($deft)) $deft = self::$default;
        if('aes' == $deft){
            return self::aes($key,$data);
        }else{
            return self::base64($key,$data);
        }
    }
    /**
     * 解密
     * @author Toby.Tu 2016-07-14
     */
    public static function decode($data='',$key='',$deft='') {
        if( empty($data)) return '';
        if (empty($key)){
            $key = config_item('openid_salt');
        }
        if(empty($deft)) $deft = self::$default;
        if('aes' == $deft){
            return self::aes($key,$data,true);
        }else{
            return self::base64($key,$data,true);
        }
    }
    /**
     * 填充算法
     * @param string $source
     * @return string
     */
    private static function addPKCS7Padding($source){
        $source = trim($source);
        $block = mcrypt_get_block_size('rijndael-256', 'ecb');
        $pad = $block - (strlen($source) % $block);
        if ($pad <= $block) {
            $char = chr($pad);
            $source .= str_repeat($char, $pad);
        }
        return $source;
    }
    /**
     * 移去填充算法
     * @param string $source
     * @return string
     */
    private static function stripPKSC7Padding($source){
        $source = trim($source);
        $char = substr($source, -1);
        $num = ord($char);
        if($num==62)return $source;
        $source = substr($source,0,-$num);
        return $source;
    }
    /**
     * token安全机制
     * @author Toby.Tu 2016-07-15
     */
    public static function token($val='') {
        if(empty($val)) $val = self::$token_keys.self::$token_keys;
        $time = time();
        $key = self::$token_keys.date('YmdH',$time);
        $key = self::aes(self::$token_keys,$key);
        $val = self::des(self::$token_keys,$val);
        $_SESSION[$key] = $val;
        $m = date('i',$time);
        if($m > 50){
            //获取一个小时后的时间
            $time = mktime(date('H',$time)+1,date('i',$time),date('s',$time),date('m',$time) ,date('d',$time),date('Y',$time));
            $key = self::$token_keys.date('YmdH',$time);
            $key = self::aes(self::$token_keys,$key);
            $_SESSION[$key] = $val;
        }
        return $val;
    }

    /**
     * 检测token是否正确
     * @author Toby.Tu 2016-07-15
     */
    public static function checkToken($token='') {
        if(empty($token)) return false;
        $time = time();
        $key = self::$token_keys.date('YmdH',$time);
        $key = self::aes(self::$token_keys,$key);
        if(isset($_SESSION[$key])){
            $val = self::des(self::$token_keys,$_SESSION[$key],true);
            unset($_SESSION[$key]);//删掉session
            $token = self::des(self::$token_keys,$token,true);
            if($token == $val){
                return true;
            }
        }
        return false;
    }


}
?>
