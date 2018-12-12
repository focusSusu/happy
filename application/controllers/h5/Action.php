<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/12/7
 * Time: 14:31
 */


class Action extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->checkUserLogin();
    }


}