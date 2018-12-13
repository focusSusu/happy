<?php
/**
 ***********************************************************************************************************************
 * HTTP请求工具类
 * @author llq
 ***********************************************************************************************************************
 */

//use soa\check\EnvCheck;
//use util\http\monitor\CurlRequestLogger;

/**
 * Class http
 * @package artisan
 */
class http
{
    /**
     * @var string
     */
    private static $curlOptionString;

    /**
     * @var array|null
     */
    private static $lastRequestInfo;

    /**
     * @var array
     */
    private static $allRequestInfo = [];

    /**
     * @param $url
     * @param array|object $data
     * @param array $options
     * @return mixed
     */
    public static function get($url, $data = [], $options = [])
    {
        if(empty($data)) {
            return self::curl($url, [], $options);
        }
        !(\is_object($data) || \is_array($data)) && $data = [];
        // 拼接参数到url中
        $url = \strpos($url, '?') ? \rtrim($url, '&') . '&' . \http_build_query($data) : \rtrim($url, '?') . '?' . \http_build_query($data);
        return self::curl($url, [], $options);
    }
    /**
     * @param $url
     * @param array|object|string $data
     * @param array $options
     * @return mixed
     */
    public static function post($url, $data = [], $options = [])
    {
        return self::curl($url, $data, $options);
    }

    /**
     * @param $url
     * @param array|object|string $data
     * @param array $options
     * @return mixed|null
     */
    public static function curl($url, $data = [], $options = [])
    {
        //////////////////全局检测某些环境下跳过某些url请求////////////////////////////
        //先屏蔽全局url拦截
//        $retValue = EnvCheck::skipTheUrl($url);
//        if(false !== $retValue){
//            return $retValue;
//        }
        ////////////////////////////////////////////////////////////////////////////////
//        $url = "http://robotcare3.live800.com/robot/wechat/search?timestamp=1530255484&&hashCode=0a39d7ea6114d8246a55505cd7332fd7&&companyId=80000057&&question=%E7%9C%8B%E7%A9%BA%E9%97%B4%E7%BB%93%E6%9E%84&&weixinId=o0rBV4z8YHFsMe32dgU07opfXnhw&&userId=&&chatfrom=wechat";
//        $url = "http://robotcare3.live800.com/robot/wechat/search?timestamp=1530255639&&hashCode=ba37a724b900a96e3839ef389daef3c5&&companyId=80000057&&weixinId=o0rBV4z8YHFsMe32dgU07opfXnhw&&userId=&&chatfrom=wechat";
        if(empty($url)) {
            return null;
        }

        // 自动添加HTTP
        if(!\preg_match('/^https?:\/\/(?:.*)/', $url)) {
            $url = 'http://' . $url;
        }

        // 处理$options
        if(\is_array($options) && \count($options)) {
            $options = \array_change_key_case($options, \CASE_UPPER);
            $tmp = [];
            foreach($options as $key => $option) {
                $tmp[\str_replace('CURLOPT_', '', $key)] = $option;
            }
            $options = $tmp;
            unset($tmp);
        }

        // 初始化
        $ch = \curl_init();
        \curl_setopt($ch, \CURLOPT_URL, $url);

        // 设置HTTPHEADER
//        if(!empty($options['HTTPHEADER'])) {
//
////            \curl_setopt($ch, \CURLOPT_HTTPHEADER, $options['HTTPHEADER']);
//        }

        // 设置超时时间 默认5秒
        $timeout = $originalTimeout = !empty($options['TIMEOUT']) ? (int)$options['TIMEOUT'] : 2;
        \curl_setopt($ch, \CURLOPT_TIMEOUT, $timeout);

        \curl_setopt($ch, \CURLOPT_CONNECTTIMEOUT_MS, 800);
        // 设置只解析IPV4
        \curl_setopt($ch, \CURLOPT_IPRESOLVE, \CURL_IPRESOLVE_V4);

        \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, false);
        \curl_setopt($ch, \CURLOPT_SSL_VERIFYHOST, false);
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);

        // 处理dns秒级信号丢失问题
        \curl_setopt($ch, \CURLOPT_NOSIGNAL, true);

        // 模拟浏览器标识
        //\curl_setopt($ch, \CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36');

        // 设置COOKIE
        if(!empty($options['COOKIE'])) {
            \curl_setopt($ch, \CURLOPT_COOKIE, $options['COOKIE']);
        }

        // POST请求
        // 注意：这里默认GET请求的参数附带在URL里，如果直接使用http::curl()方法，并且传data参数，会触发POST请求
        if(!empty($data)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ));
            \curl_setopt($ch, \CURLOPT_POST, true);
            \curl_setopt($ch, \CURLOPT_POSTFIELDS, \is_array($data) ? \http_build_query($data) : $data);
        }

        // 设置返回头部
        if(!empty($options['HEADER'])) {
            \curl_setopt($ch, \CURLOPT_HEADER, true);
        }
        //暂无针对CURLINFO_HEADER_OUT的设置
        // 设置其他参数
        foreach($options as $option => $val) {
            if(!\in_array($option, array('HEADER', 'COOKIE', 'TIMEOUT', 'HTTPHEADER'), true)) {
                $opt_defined = self::getCurlOptionKey( 'CURLOPT_' . $option);
                //$opt_defined = constant('CURLOPT_' . $option); //basically same
                if($opt_defined !== null) {
                    \curl_setopt($ch, $opt_defined, $val);
                }
            }
        }
        $response = \curl_exec($ch);
//        CurlRequestLogger::log($ch, ['timeout' => $timeout], $response);
        self::$lastRequestInfo = [
            'errno' => \curl_errno($ch),
            'error' => \curl_error($ch),
            'info' => \curl_getinfo($ch),
        ];
//        print_r(self::$lastRequestInfo['info']);die;
        //记录所有请求错误, 超时, 4XX,5XX
//        $serviceName = 'httpRequest';
//        $requestData = $data ?: 'null';
//        if (
//            !empty($errorResponse = self::$lastRequestInfo['info']['http_code']) &&
//            \in_array((int)(self::$lastRequestInfo['info']['http_code'] / 100), [3,4, 5], true)
//        ){
//            Log::write("ERROR ".$url.":".$requestData.":".json_encode(self::$lastRequestInfo),'curl');
//        } else if (isset(self::$lastRequestInfo['info']['total_time']) && self::$lastRequestInfo['info']['total_time'] >= 2){
//            Log::write("TIMEOUT ".$url.":".$requestData.":".json_encode(self::$lastRequestInfo),'curl');
//        }

//        if ($response === false) {
//            $methodName = '\\logCritical';
//            $breakpoint = 'curlRequest:error';
//        } elseif (!empty($errorResponse = self::$lastRequestInfo['info']['http_code']) && \in_array((int)(self::$lastRequestInfo['info']['http_code'] / 100), [4, 5], true)) {
////            $methodName = '\\logError';
//            $breakpoint = 'curlRequest:unexpectedResponse';
//            $serviceName .= ':' . $errorResponse;
//        } elseif (isset(self::$lastRequestInfo['info']['total_time']) && self::$lastRequestInfo['info']['total_time'] > 1.8) {
//            $methodName = '\\logWarning';
//            $breakpoint = 'curlRequest:slowRequest';
//        }
//        isset($methodName) && $methodName([
//            'duration' => self::$lastRequestInfo['info']['total_time'],
//            'timeout' => $timeout,
//            'url' => $url,
//            'currentUrl' => input::url(),
//            'originalTimeout' => $originalTimeout,
//            'info' => self::$lastRequestInfo,
//            'trace' => \array_slice(\debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS), 1, \PHP_SAPI === 'cli' ? null : -3)
//        ], $breakpoint, $serviceName, true);
        //@TODO 临时监控总请求量, 注意移除
//        \PHP_SAPI === 'cli' || self::$allRequestInfo[] = [
//            'originalTimeout' => $originalTimeout,
//            'duration' => self::$lastRequestInfo['info']['total_time'],
//            'requestUrl' => \strstr($url, '?', true) ?: $url,
//            'error' => self::$lastRequestInfo['error'],
//        ];
        \curl_close($ch);
        return $response;
    }

    /**
     * @return array|null
     */
    public static function getLastRequestInfo()
    {
        return self::$lastRequestInfo;
    }

    /**
     * @return array
     */
    public static function getAllRequestInfo()
    {
        return self::$allRequestInfo ? self::$allRequestInfo + [
                'currentUrl' => input::url(),
            ] : [];
    }

    /**
     * 减少内存消耗，一个访问周期只调用一次
     * @param string $optionKey
     * @return mixed|null
     */
    private static function getCurlOptionKey($optionKey)
    {
        if(self::$curlOptionString === null){
            self::$curlOptionString = \implode(',', \array_filter(\array_keys(\get_defined_constants(true)['curl']), function ($key) {
                    return \strpos($key, 'CURLOPT_') === 0;
                })).',';
        }
        return \strpos(self::$curlOptionString, $optionKey.',') !== false ? \constant($optionKey) : null;
    }

    /**
     * 批量发GET送请求
     * @param $urls
     * @param array $options
     * @param null $callback
     * @return array
     */
    public static function mutiGet($urls, $options = [], $callback = null)
    {
        // 组织数据
        foreach((array)$urls as $key => $url) {
            if(\is_string($url)) {
                $urls[$key] = [
                    'url' => $url,
                    'data' => null
                ];
            }
        }
        return self::mutiCurl($urls, $options, $callback);
    }


    /**
     * 批量发POST送请求
     * @param $requests
     * @param array $options
     * @param null $callback
     * @return array
     */
    public static function mutiPost($requests, $options = [], $callback = null)
    {
        return self::mutiCurl($requests, $options, $callback);
    }

    /**
     * 兼容multi正确的拼写
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \BadMethodCallException
     */
    public static function __callStatic($name, $arguments)
    {
        static $methodMap = null;
        if ($methodMap === null) {
            $methodMap = [
                'mutiCurl' => 'multiCurl',
                'mutiGet' => 'multiGet',
                'mutiPost' => 'multiPost',
            ];
        }
        if (isset($methodMap[$name])) {
            return \call_user_func_array(['self', $methodMap[$name]], $arguments);
        }
        throw new \BadMethodCallException('调用的方法不存在:' . $name);
    }

    /**
     * @param $requests
     * @param array $options
     * @param null $callback
     * @param int $delay
     * @return array|null
     */
    public static function mutiCurl($requests, $options = [], $callback = null, $delay = 50)
    {
        if(empty($requests)) {
            return null;
        }
        isset(self::$allRequestInfo['multi']['requestCount']) and self::$allRequestInfo['multi']['requestCount']++ or self::$allRequestInfo['multi']['requestCount'] = 1;
        $startAt = \microtime(true);
        $urlSample = null;
        // 处理$options
        if(\is_array($options) && \count($options)) {
            $options = \array_change_key_case($options, \CASE_UPPER);
            $tmp = [];
            foreach($options as $key => $option) {
                $tmp[\str_replace('CURLOPT_', '', $key)] = $option;
            }
            $options = $tmp;
            unset($tmp);
        }

        $queue = \curl_multi_init();
        $map = [];
        foreach ($requests as $id => $request) {
            $ch = \curl_init();

            // 自动添加HTTP
            if(!\preg_match('/^https?:\/\/(?:.*)/i', $request['url'])) {
                $request['url'] = 'http://' . $request['url'];
            }
            //get url sample
            isset($urlSample) || $urlSample = \strstr($request['url'], '?', true) ?: $request['url'];
            \curl_setopt($ch, \CURLOPT_URL, $request['url']);

            // 设置HTTPHEADER
            if(!empty($options['HTTPHEADER'])) {
                \curl_setopt($ch, \CURLOPT_HTTPHEADER, $options['HTTPHEADER']);
            }

            // 设置超时时间 默认5秒
            $timeout = !empty($options['TIMEOUT']) ? (int)$options['TIMEOUT'] : 10;
            \curl_setopt($ch, \CURLOPT_TIMEOUT, $timeout);

            // 设置只解析IPV4
            \curl_setopt($ch, \CURLOPT_IPRESOLVE, \CURL_IPRESOLVE_V4);

            \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, 1);
            \curl_setopt ($ch, \CURLOPT_FOLLOWLOCATION, 1);
            \curl_setopt($ch, \CURLOPT_HEADER, 0);
            \curl_setopt($ch, \CURLOPT_NOSIGNAL, true);
            \curl_setopt($ch, \CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36');

            // 设置COOKIE
            if(!empty($options['COOKIE'])) {
                \curl_setopt($ch, \CURLOPT_COOKIE, $options['COOKIE']);
            }

            // POST请求
            if(!empty($request['data'])) {
                \curl_setopt($ch, \CURLOPT_POST, true);
                \curl_setopt($ch, \CURLOPT_POSTFIELDS, \is_array($request['data']) ? \http_build_query($request['data']) : $request['data']);
            }

            // 设置头部
            if(!empty($options['HEADER'])) {
                \curl_setopt($ch, \CURLOPT_HEADER, true);
            }

            // 设置其他参数
            foreach($options as $option => $val) {
                if(!\in_array($option, array('HEADER', 'COOKIE', 'TIMEOUT', 'HTTPHEADER'), true)) {
                    $opt_defined = self::getCurlOptionKey( 'CURLOPT_' . $option);
                    if($opt_defined !== null) {
                        \curl_setopt($ch, $opt_defined, $val);
                    }
                }
            }

            \curl_multi_add_handle($queue, $ch);
            $map[(string) $ch] = $id;
        }

        $responses = [];
        do {
            while (($code = \curl_multi_exec($queue, $active)) === \CURLM_CALL_MULTI_PERFORM);
            if ($code !== \CURLM_OK) {
                break;
            }

            // 找出当前已经完成的请求
            while ($done = \curl_multi_info_read($queue)) {
                $data = \curl_multi_getcontent($done['handle']);
                $id = $map[(string) $done['handle']];
                self::$lastRequestInfo[$id] = [
                    'errno' => \curl_errno($done['handle']),
                    'error' => \curl_error($done['handle']),
                    'info' => \curl_getinfo($done['handle']),
                ];
                // 是否使用回调函数
                if($callback != null) {
                    // 异步立即处理当前请求
                    $ret = array(
                        'ret' => array(
                            'id' => $id,
                            'delay' => $delay,
                            'response' => $data,
                        )
                    );
                    \call_user_func_array($callback, $ret);
                }
                // 移除已经处理完毕请求
                \curl_multi_remove_handle($queue, $done['handle']);
                \curl_close($done['handle']);

                $responses[$id] = $data;
            }
            if ($active > 0) {
                \curl_multi_select($queue, 0.5);
            }

        } while ($active);
        \curl_multi_close($queue);
        self::$allRequestInfo['multi'][] = [
            'cost' => \microtime(true) - $startAt,
            'totalRequest' => \count($requests),
            'urlSample' => $urlSample,
        ];
        // 返回批量响应结果
        return $responses;
    }


    /**
     * 解析rest api返回
     * @param string $data
     * @param string $code
     * @param string $msg
     * @param string $data
     * @return mixed
     */
    public static function parse($result = '', $code = 'code', $msg = 'msg', $data = 'data')
    {
        $json = \json_decode('{"error":0,"msg":"success","code":1000}');

        // 返回数据为空
        if(empty($result)) {
            $json->error += 1;
            $json->msg = 'The api return empty !';
            return $json;
        }

        // 返回数据格式错误
        $arr = \json_decode($result, true);
        if(\json_last_error() != 0) {
            $json->error += 1;
            $json->msg = 'Can\'t parse the result of api return !';
            return $json;
        }

        // 返回数据状态码错误
        if(!isset($arr[$code]) || $arr[$code] != 0) {
            $json->error += 1;
            $json->msg = !empty($arr[$msg]) ? $arr[$msg] : 'The api return an Invalid code !';
            return $json;
        }

        $json->code = $arr[$code];
        $json->data = !empty($arr[$data]) ? $arr[$data] : '';

        return $json;
    }
}