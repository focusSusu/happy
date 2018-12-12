<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 13:46
 */
class Category extends My_Controller {

    private $assign;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model','category_model');
        $this->assign['active'] = json_encode(['active'=>[2]]);

    }


    /**
     * 查询数据
     * @param string $md5
     * @param int $offset 起始位
     * @param int $limit
     *
     * @return array
     */
    function get_limit($md5, $offset, $limit=5)
    {
        //起始位置处理
        $offset = (($offset>0 ? $offset : 1) - 1) * $limit;

        //条件初始化
        $where = array('state'=>0);
        //条件
        if( $md5 ) {
            $where['md5'] = $md5;
        }

        $this->db->where( $where );

        //在order、group或limit前查询总数
        $db = clone($this->db);
        $total = $this->db->count_all_results('class');
        echo $this->db->last_query();
        echo '<hr/>';

        $this->db = $db;
        $this->db->order_by('id desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('class');

        $data = $query->result_array();

        //sql调试方法
        echo $this->db->last_query();

        //return 数据和总数
        return array('data'=>$data, 'total'=>$total);
    }


    public function addView()
    {
        $typeList = $this->db->where('pid',0)->get('class_category')->result_array();

        $this->assign['list'] = $typeList;
        $this->assign['view'] = 'category/addView';
        $this->load->view('common/index',$this->assign);
    }

    public function updateView()
    {
        $id = $this->input->get('category_id');
        $result = $this->db->where('id',$id)->get('class_category')->row_array();

        $typeList = $this->db->where('pid',0)->get('class_category')->result_array();

        $this->assign['typeList'] = $typeList;
        $this->assign['list'] = $result;
        $this->assign['view'] = 'category/updateView';
        $this->assign['id'] = $id;

        $this->load->view('common/index',$this->assign);
    }
    public function index()
    {
        $this->assign['view'] = 'category/index';
        $this->load->view('common/index',$this->assign);
    }


    //分类列表
    public function ajaxindex()
    {
//        $curPage = $this->input->post('curPage') ?: 1;
//        $limit = $this->input->post('pageSize') ?: 5;
//
//
//        $offset = (($curPage>0 ? $curPage : 1) - 1) * $limit;

//        $total = $this->db->where(['pid'=>0])->count_all_results('class_category');

        $result = $this->db->select('id,name,sort,create_time,status,is_home')->where(['pid'=>0])->order_by('sort','asc')->get('class_category')->result_array();

        foreach ($result as $k=>$v) {
            $result[$k]['child'] = $this->db->select('id,name,sort,create_time,status,is_home')->where(['pid'=>$v['id']])->order_by('sort','asc')->get('class_category')->result_array();
        }
        $this->assign['list'] = $result;
//        $this->assign['page'] = $curPage;
//        $this->assign['totalCount'] = $total;
        $this->assign['success'] = 'success';
//        $this->responseJson(200,'success',$this->assign);
        $this->load->view('category/ajaxindex',$this->assign);

    }

    //获取一级分类
    public function getCategoryData()
    {
        $result = $this->db->where(['pid'=>0])->get('class_category')->result_array();
        $this->responseJson(200,'success',$result);
    }

    //添加分类
    public function addCategory()
    {
        $name = $this->input->post('name');
        $pid = $this->input->post('parent_id');
        if (empty($name)){
            $this->responseJson(1001,'参数有误');
        }

        if ($pid == "") $pid=0;

        //查询是否重复
        $res = $this->db->where(['name'=>$name,'pid'=>$pid])->get('class_category')->row_array();
        if ($res) {
            $this->responseJson(1003,'该分类已存在');
        }

        if ($pid > 0){
            //验证父级
            $existence = $this->db->where(['id'=>$pid,'pid'=>0])->get('class_category')->row_array();
            if (!$existence){
                $this->responseJson(1003,'请确认父类是否存在');
            }
        }

        $create_time = date("Y-m-d H:i:s");

        $ret  =  $this->category_model->newData(compact('name','pid','create_time'));
        if (!$ret) {
            $this->responseJson(1003,'添加失败');
        }

        $this->responseJson(0,'添加成功');
    }

    //修改分类
    public function updateCategory()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $pid  = $this->input->post('parent_id');
        $icon = $this->input->post('icon');

        if (empty($id)) {
            $this->responseJson(1003,'参数有误');
        }


        $result = $this->db->where(compact('id'))->get('class_category')->row_array();
        if (empty($result)) {
            $this->responseJson(1003,'确认该分类是否存在');
        }

        if (!$result['status']) {
            $this->responseJson(1003,'该分类已禁用，请先启用');
        }

        /**
         * 1 . 1级修改为二级   确认该分类下有没有子集分类
         */

//        if ($result['type'] == 1 && $type == 2){
//            $sonCategoryId = $this->db->select('id')->where(['pid'=>$result['id']])->get('class_category')->result_array();
//        }

        $update_time = date("Y-m-d H:i:s");
        $res = $this->category_model->updateById($id,compact('name','pid','update_time','icon'));

       if ($res){
           $this->responseJson(0,'修改成功');
       }
        $this->responseJson(0,'修改失败');

    }


    /**
     * 状态
     * @param
     * @return
     */
    public function updateStatus()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $type = $this->input->post('type');  //is_home显示状态  status：是否禁用

        if (
            empty($id) ||
            !in_array($status,[1,0]) ||
            !in_array($type,['is_home','status'])
            ){
            $this->responseJson(1005,'参数有误');
         }


        $category = $this->db->select('id,pid')->where(compact('id'))->get('class_category')->row_array();
        //if  parent the subset is disabled.
        if ($category['pid']){
             $this->category_model->updateById($category['pid'],[$type=>$status,'update_time'=>date("Y-m-d H:i:s")]);

            $res = $this->category_model->updateById($id,[$type=>$status,'update_time'=>date("Y-m-d H:i:s")]);
        } else {
            $this->category_model->updateById($category['id'],[$type=>$status,'update_time'=>date("Y-m-d H:i:s")],'','pid');
            $res = $this->category_model->updateById($category['id'],[$type=>$status,'update_time'=>date("Y-m-d H:i:s")]);
        }

        if ($res) {
            $this->responseJson(0,'success');
        }
        $this->responseJson(1003,'error ');

    }


    //修改排序
    public function updateSort()
    {
        $id = $this->input->post('id');
        $sort = $this->input->post('sort');

        if (empty($id) || empty(intval($sort))) {
            $this->responseJson(1003,'参数有误');
        }

        $res = $this->db->where(compact('id'))->update('class_category',compact('sort'));
        if ($res){
            $this->responseJson(0,'success');
        }

        $this->responseJson(1003,'error');
    }

}