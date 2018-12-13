<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/12/13
 * Time: 14:57
 */

class Wechat extends CI_Controller
{
    private $appId;
    private $appKey;

    public function __construct()
    {
        parent::__construct();
        $this->appId = config_item('app')['app_id'];
        $this->appKey = config_item('app')['app_key'];
        $this->load->library('Http');
    }


}