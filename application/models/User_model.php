<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/8
 * Time: 10:15
 */

class User_model extends My_Model {
    public $tab = 'admin_user';
    public $pk = 'id';


    public function getAllData($slist,$curPage=1,$pageSize)
    {

        $offset = (($curPage>0 ? $curPage : 1) - 1) * $pageSize;
        $query = $this->db->where(['deleted'=>0]);

        if (!empty($slist['username'])) {
            $query->like('username',$slist['username'],'both');
        }
        $result = $query->limit($pageSize, $offset)->order_by('id','desc')->get($this->tab)->result_array();
        return $result;
    }

    public function getAllCount($slist)
    {
        $query = $this->db->where(['deleted'=>0]);

        if (!empty($slist['username'])) {
            $query->like('username',$slist['username'],'both');
        }
        $allcount = $query->count_all_results($this->tab);
        return $allcount;
    }



}