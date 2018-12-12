<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/8
 * Time: 10:46
 */

class Article_model extends My_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public $tab = 'class_article';
    public $pk = 'id';

    public function getMyClass($expert_id)
    {
        return $this->db->where(compact('expert_id'))->get($this->tab)->result_array();
    }

    public function getAllData($slist,$curPage=1,$pageSize)
    {

        $offset = (($curPage>0 ? $curPage : 1) - 1) * $pageSize;

        $query = $this->db;
        if (!empty($slist['username'])){
            $query->like('name',$slist['username'],'both');
        }

        if (!empty($slist['create_time'])){
            $time = explode('~',$slist['create_time']);
//            $nextTime = date('Y-m-d',strtotime($slist['create_time'].'-1 day'));
            $query->where('create_time>=',$time[0].' 00:00:00');
            $query->where('create_time<=',$time[1].' 23:59:59');
        }

        $result = $query->limit($pageSize, $offset)->order_by('id','desc')->get('class_article')->result_array();
//        echo $this->db->last_query();die;
//        echo $query->last_query();die;
         return $result;

    }

    public function getAllCount($slist)
    {
        //获取总数量
        $query = $this->db;

        if (!empty($slist['username'])){
            $query->like('name',$slist['username'],'both');
        }

        if (!empty($slist['create_time'])){
            $time = explode('~',$slist['create_time']);
//            $nextTime = date('Y-m-d',strtotime($slist['create_time'].'-1 day'));
            $query->where('create_time>=',$time[0].' 00:00:00');
            $query->where('create_time<=',$time[1].' 23:59:59');
        }

        $allcount = $query->count_all_results($this->tab);
        return $allcount;
    }
}