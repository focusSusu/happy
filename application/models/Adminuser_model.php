<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 11:49
 */

class Adminuser_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserInfo($param)
    {
        return $this->db->where($param)->get('admin_user')->row_array();
    }

    public function update($where=[],$param=[])
    {
        if (empty($param) || empty($where)){
            return false;
        }
        $this->db->where($where)->update('admin_user',$param);

    }

}