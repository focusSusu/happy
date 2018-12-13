<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/7/6
 * Time: 17:53
 */
namespace service\artisan;
class MY_Service
{
    public function __construct()
    {
        log_message('debug', "Service Class Initialized");
    }
    function __get($key)
    {
        $CI = & get_instance();
        return $CI->$key;
    }
}
