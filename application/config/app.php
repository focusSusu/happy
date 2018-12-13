<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 公共配置
 * @author Devin.qin 2017-12-01
 */
$config = array(
    'app'=>[
        'app_id'=>'wx2eff379977cb93c0',
        'app_key'=>'2d51badb080f8817e9d1af803b5305d2'
    ],

    //图片
    'image_upload_file'=>[
        "allowType"=>['jpg', 'png'],
        "size"=>1000000
    ],

    //音频
    "audio_upload_file"=>[
        "allowType"=>['mp3'],
        "size"=>8000000
    ]
);

//时区设置
date_default_timezone_set('Asia/ShangHai');
$config['time_zone'] = date_default_timezone_get();