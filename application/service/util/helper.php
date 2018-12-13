<?php

namespace util;

class helper{

	
	public static function basename($path, $suffix = ''){
        if (($len = mb_strlen($suffix)) > 0 && mb_substr($path, -$len) == $suffix) {
            $path = mb_substr($path, 0, -$len);
        }
        $path = rtrim(str_replace('\\', '/', $path), '/\\');
        if (($pos = mb_strrpos($path, '/')) !== false) {
            return mb_substr($path, $pos + 1);
        }

        return $path;
    }

    public static function generateKey($unique = false){
        $key = md5(uniqid(rand(), true));
        if ($unique){
            list($usec,$sec) = explode(' ',microtime());
            $key .= dechex($usec).dechex($sec);
        }
        return $key;
    }    

    public static function uniqid_salt(){
        return substr(uniqid(rand()), -6);
    }


    static public function is_phone($param) {
        // return preg_match("/^13[0-9]{1}[0-9]{8}$|15[012356789]{1}[0-9]{8}$|18[012356789]{1}[0-9]{8}$|14[57]{1}[0-9]$/",$param);
        return preg_match ( "/^[1-9]{1}[0-9]{10}$/", $param );
    }
}