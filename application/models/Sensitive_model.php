<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/14
 * Time: 18:22
 */

class Sensitive_model extends My_Model
{
    public $tab = 'admin_sensitive_log';
    public $pk = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function write_log($tab,$id,$param,$pk,$sensitive_type)
    {

        $log['sensitive_tab'] = $tab;
        $log['sensitive_data'] = json_encode([$pk=>$id,"update_data"=>$param]);
        $log['sensitive_time'] = date("Y-m-d H:i:s");
        $log['sensitive_type'] = $sensitive_type;
//        $log['sensitive_user_id'] = $userInfo['id'];
        $this->db->insert($this->tab,$log);
//        echo $this->db->last_query();
    }

}
