<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 13:31
 */

class Index extends My_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }


    public function index()
    {
        //获取所属权限
        $userInfo = $this->session->userdata('userInfo_yili');

        $result = $this->db->where(['id'=>$userInfo['id']])->get('admin_user')->row_array();

        $menus = [];
        if (!empty($result['permis_id'])) {
            $menus = $this->db->where_in('id',explode(',',$result['permis_id']))->get('admin_menu')->result_array();
        }

        $assign['menus'] = $menus;
        $assign['name'] = $userInfo['real_name'];
        $this->load->view('common/index',$assign);
    }

    //用户  权限  menu
}