<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 14:04
 */

class Course_model extends My_Model
{

    public $tab = 'class_course';
    public $pk = 'id';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllData($slist,$curPage=1,$pageSize)
    {

        $offset = (($curPage>0 ? $curPage : 1) - 1) * $pageSize;

        $query = $this->db->select("class_course.*,class_expert.name as expert_name")->from('class_course')->join('class_expert','class_expert.id = class_course.expert_id');
        //活动名称
        if (!empty($slist['name'])){
            $query->like('class_course.name',$slist['name'],'both');
        }

        //创建时间
        if (!empty($slist['create_time'])) {      //未开始
            $create_time = explode('~',$slist['create_time']);
            $query->where('class_course.create_time >=',$create_time[0].' 00:00:00');
            $query->where('class_course.create_time <=',$create_time[1].' 23:59:59');
        }

        //有效时间
        if (!empty($slist['valid_time'])) {      //未开始
            $valid_time = explode('~',$slist['valid_time']);
            $query->where('valid_start_time >=',$valid_time[0].' 00:00:00');
            $query->where('valid_end_time <=',$valid_time[1].' 23:59:59');
        }

        if (!empty($slist['type'])) {
            $query->where('class_course.type',$slist['type']);
        }

        //所属专家
        if (!empty($slist['expert_id'])) {
            $query->where('expert_id',$slist['expert_id']);
        }
        $res = $query->order_by('class_course.id','desc')->limit($pageSize, $offset)->order_by('id','desc')->get()->result_array();

        //查询分类
        foreach ($res as $k=>$v) {
            $categoryList = $this->db->select('name')->from('class_course_category')->join('class_category','class_category.id = class_course_category.category_id')->where('course_id',$v['id'])->get()->result_array();
            $category_arr = [];
            foreach ($categoryList as $key=>$val) {
                $category_arr[]  = $val['name'];
            }
            $res[$k]['category_str'] = implode('，',$category_arr);

        }

        return $res;
    }

    public function getAllCount($slist)
    {
        $query = $this->db->from('class_course');
//            ->join('class_expert','class_expert.id = class_course.expert_id');

        //活动名称
        if (!empty($slist['name'])){
            $query->like('class_course.name',$slist['name'],'both');
        }

        //创建时间
        if (!empty($slist['create_time'])) {      //未开始
            $create_time = explode('~',$slist['create_time']);
            $query->where('create_time >=',$create_time[0].' 00:00:00');
            $query->where('create_time <=',$create_time[1].' 23:59:59');
        }

        //有效时间
        if (!empty($slist['valid_time'])) {      //未开始
            $valid_time = explode('~',$slist['valid_time']);
            $query->where('valid_start_time >=',$valid_time[0].' 00:00:00');
            $query->where('valid_end_time <=',$valid_time[1].' 23:59:59');
        }

        if (!empty($slist['type'])) {
            $query->where('type',$slist['type']);
        }
        //所属专家
        if (!empty($slist['expert_id'])) {
            $query->where('expert_id',$slist['expert_id']);
        }
        $allcount = $query->count_all_results();
        return $allcount;
    }

}