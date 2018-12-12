<?php
# 公共函数文件
/**
 * 打印数组
 * @author Tujt 2017-1-5
 */
function d($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
/**
 * 打印数组
 * @author Tujt 2017-1-5
 */
function dd($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';die;
}
/**
 * 根据键获取数组的值
 * @author Toby.tu 2017-05-17
 */
function arrayval($arr=array(),$key='',$default=''){
    if(empty($arr) || empty($key)) return $default;
    if(isset($arr[$key]) && !empty($arr[$key])){
        return $arr[$key];
    }
    return $default;
}
/**
 * 判断是否存在，存在则为true，否则为false
 * @author Toby.tu 2017-05-18
 */
function isempty($input=array(),$keys=array(),$f=false){
    if(empty($input) || empty($keys)) return false;
    $b = true;
    foreach ($keys as $key) {
        if($f){//数字
            if(!isset($input[$key]) || trim($input[$key]) == ''){
                $b = false;break;
            }
        }else{
            if(!isset($input[$key]) || empty(trim($input[$key]))){
                $b = false;break;
            }
        }
    }
    return $b;
}
/**
 * 处理金额显示字段
 * @author Toby.tu 2017-05-31
 */
function setMoney($money=0){
    if(empty($money)) return 0;
    $money = sprintf('%.2f',$money);
    return number_format($money,2);
}
/**
 * Created by PhpStorm.
 * User: y.chen
 * Date: 2016/8/15
 * Time: 15:38
 */
function doCurl($curl_options){
    if(empty($curl_options)){
        return null;
    }
    $ch = curl_init();
    $curl_options[CURLOPT_SSL_VERIFYPEER]=false;
    $curl_options[CURLOPT_SSL_VERIFYHOST]=false;
    $rs = curl_setopt_array($ch,$curl_options);
    if($rs){
        $output = curl_exec($ch);
        curl_close($ch);
    }else{
        $output = null;
    }
    return $output;
}

/**
 * 返回json
 */

function responseJson($code=200,$msg='',$data=''){
    exit(json_encode(array('code' => $code, 'msg' => $msg, 'data' => $data),JSON_UNESCAPED_UNICODE));
}

//判断字段是否存在
function exitField($arr = [],$field = []){
    if (empty($arr) || empty($field)){
        return false;
    }


    foreach ($field as $k=>$v){
        if (!array_key_exists($v,$arr)) {
            return false;
        }
        if (empty($arr[$v])){
            return false;
        }
    }
    return true;

}

/**
 * 去空  换行
 * @param
 * @return
 */
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");
    $res = str_replace($qian, '', $str);
    if (empty($res)){
        return 0;
    }
    return $res;
}

function isMobilePhone($phoneNumber)
{

    return $phoneNumber && \is_string($phoneNumber) && \preg_match('/^1[3-9]\d{9}$/', $phoneNumber);
}

function getRealTel($tel)
{
    if(strlen((string)$tel) < 3) {
        return '';
    }
    // 去除换行空格空字符以及非数字字符
    $tel = preg_replace('/\s+|[^0-9]/', '', (string)$tel);
    // 统一号码格式为不带86国家码
    return preg_replace('/^(86|086|\+86|0086)/', '', $tel);
}


?>
