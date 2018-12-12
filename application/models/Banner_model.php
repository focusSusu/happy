<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 11:49
 */

class Banner_model extends MY_Model {

    public $tab = 'class_banner';
    public $pk = 'id';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllData($slist,$curPage=1,$pageSize)
    {

        $offset = (($curPage>0 ? $curPage : 1) - 1) * $pageSize;


        $query = $this->db->select("class_banner.*,class_picklist.vals as bannername")->from($this->tab)->join('class_picklist','class_picklist.keys = class_banner.type')->where(['deleted'=>0]);
        //活动名称
        if (!empty($slist['name'])){
            $query->like('class_banner.name',$slist['name'],'both');
        }

        //活动状态
        if ($slist['banner_status'] == 1) {      //未开始
            $query->where('valid_start_time>',date("Y-m-d H:i:s"));
        } elseif ($slist['banner_status'] == 2) {     //轮播中
            $query->where('valid_start_time<=',date("Y-m-d H:i:s"));
            $query->where('valid_end_time>',date("Y-m-d H:i:s"));
        } elseif ($slist['banner_status'] == 3) {      //已结束
            $query->where('valid_end_time<',date("Y-m-d H:i:s"));
        }

        //所属模块
        if ($slist['status_vals']){
            $query->where('keys',$slist['status_vals']);
        }

        //生效时间
        if (!empty($slist['valid_time'])){
            $time = explode('~',$slist['valid_time']);
            $query->where('valid_start_time>=',$time[0].' 00:00:00');
            $query->where('valid_end_time<=',$time[1].' 23:59:59');

        }


        $result = $query->limit($pageSize, $offset)->order_by('id','desc')->get()->result_array();
        return $result;

    }

    public function getAllCount($slist)
    {
        $query = $this->db->from($this->tab)->where(['deleted'=>0]);
//            ->join('class_picklist','class_picklist.keys = class_banner.type')
        //活动名称
        if (!empty($slist['name'])){
            $query->like('class_banner.name',$slist['name'],'both');
        }

        //活动状态
        if ($slist['banner_status'] == 1) {      //未开始
            $query->where('valid_start_time>',date("Y-m-d H:i:s"));
        } elseif ($slist['banner_status'] == 2) {     //轮播中
            $query->where('valid_start_time<=',date("Y-m-d H:i:s"));
            $query->where('valid_end_time>',date("Y-m-d H:i:s"));
        } elseif ($slist['banner_status'] == 3) {      //已结束
            $query->where('valid_end_time<',date("Y-m-d H:i:s"));
        }

        //所属模块
        if ($slist['status_vals']){
            $query->where('keys',$slist['status_vals']);
        }

        //生效时间
        if (!empty($slist['valid_time'])){
            $time = explode('~',$slist['valid_time']);
            $query->where('valid_start_time>=',$time[0].' 00:00:00');
            $query->where('valid_end_time<=',$time[1].' 23:59:59');

        }
//        if (!empty($slist['valid_start_time']) && empty($slist['valid_end_time'])){
//            $query->where('valid_start_time<',date("Y-m-d H:i:s"));
//        }
//        if (empty($slist['valid_start_time']) && !empty($slist['valid_end_time'])){
//            $query->where('valid_end_time>',date("Y-m-d H:i:s"));
//        }
//        if (!empty($slist['valid_start_time']) && !empty($slist['valid_end_time'])){
//            $query->where('valid_start_time<=',date("Y-m-d H:i:s"));
//            $query->where('valid_end_time>',date("Y-m-d H:i:s"));
//        }
        $allcount = $query->count_all_results();
        return $allcount;
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