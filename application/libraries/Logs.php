<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/7/26
 * Time: 23:43
 */

//namespace service\artisan;

//define('DS', 'ws');                 // 设置目录分隔符
//define('self::$log_path','application/logs/customlog/'); // 日志文件目录
/**
 * 日志类
 * @package    log
 * @version    $Id$
 * Class Log
 * @package service\artisan
 */
class Logs
{
    /**
     * 单个日志文件大小限制
     *
     * @var int 字节数
     */

    private static $i_log_size = 524288000; // 1024 * 1024 * 5 = 5M
    private static $log_path = 'application/logs/business/';

    /**
     * 设置单个日志文件大小限制
     *
     * @param int $i_size 字节数
     */
    public static function set_size($i_size)
    {
        if( is_numeric($i_size) ){
            self::$i_log_size = $i_size;
        }
    }

    /**
     * 写日志
     *
     * @param string $s_message 日志信息
     * @param string $s_type    日志类型
     */
    public static function write($s_message, $file_name='',$s_type = 'LOG',$title='')
    {
        self::$log_path = self::$log_path.$file_name.'/';

        // 检查日志目录是否可写
        self::createdirlist(self::$log_path,0777);

//        chmod(self::$log_path,0777);
        if (!is_writable(self::$log_path)) return (self::$log_path ."is not writeable !");

        $start = date('Y-m-d H:i:s').' ['.$s_type.']'  ;
        $s_now_day  = date('Y_m_d');

        // 根据类型设置日志目标位置
        $s_target   = self::$log_path;
        switch($s_type)
        {
            case 'DEBUG':
                $s_target .= 'Out_'.$file_name . $s_now_day . '.log';
                break;
            case 'ERROR':
                $s_target .= $title.'--Err_' .$file_name. $s_now_day . '.log';
                break;
            case 'LOG':
                $s_target .=  $s_now_day .  '.log';
                break;
            default:
                $s_target .= 'Log_'. $file_name. $s_now_day . '.log';
                break;
        }

//        //检测日志文件大小, 超过配置大小则重命名
//        if (file_exists($s_target); self::$i_log_size= filesize($s_target)) {
//        $s_file_name = substr(basename($s_target), 0, strrpos(basename($s_target), '.log')). '_' . time() . '.log';
//        rename($s_target, dirname($s_target) . DS . $s_file_name);173 1749 7069
//    }
        clearstatcache();
        // 写日志, 返回成功与否
        return error_log("$start $s_message\n", 3, $s_target);
    }

   public static  function createdirlist($path,$mode){
        if (is_dir($path)){
            //判断目录存在否，存在不创建
            return true;
                //已经存在则输入路径
        }else{ //不存在则创建目录
            $re=mkdir($path,$mode,true);
            //第三个参数为true即可以创建多极目录
            if ($re){
//                echo "目录创建成功";//目录创建成功
                return true;
            }else{
                return "目录创建失败";
            }
        }
    }
}
?>