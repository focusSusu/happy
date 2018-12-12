<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 14:54
 */

/**
 * 专家管理
 * Class Article
 */
class Setting extends My_Controller {
    private $assign;
    public function __construct()
    {

        parent::__construct();
        $this->load->model('Article_model','article_model');

    }

    public function ajaxindex()
    {


        $result = $this->db->get('class_setting')->row_array();

        $this->assign['list'] = $result;

        $this->load->view('setting/ajaxindex',$this->assign);
    }

    public function index()
    {
        $result = $this->db->get('class_setting')->row_array();
        $this->assign['list'] = $result;

        $this->assign['view'] = 'setting/index';
        $this->load->view('common/index',$this->assign);
    }

    public function addView()
    {
        $this->assign['view'] = 'setting/addView';
        $this->load->view('common/index',$this->assign);
    }
    //添加专家
    public function addSetting()
    {

        $post = $this->input->post();
        if (
            empty($post['id']) ||
            empty($post['person_man']) ||
            empty($post['person_phone']) ||
            empty($post['person_code']) ||
            empty($post['person_address'])
        ){
            $this->responseJson(1003,'参数有误');
        }
        $post['update_time'] = date("Y-m-d H:i:s");

        $id = $post['id'];
        unset($post['id']);
        $update = $this->db->where(compact('id'))->update('class_setting',$post);
        if (!$update) {
            $this->responseJson(10038,'添加失败');
        }
        $this->responseJson(0,'添加成功');

    }

    //编辑view
    public function updateView()
    {
        $id = $this->input->get('expert_id');
        if (empty($id)){
            exit('eror');
        }

        $expert = $this->db->where(compact('id'))->get('class_article')->row_array();
        if (empty($expert)) {
            exit('该专家不存在');
        }

        $this->assign['view'] = 'setting/updateView';
        $this->assign['list'] = $expert;
        $this->assign['id'] = $id;
        $this->load->view('common/index',$this->assign);


    }

    //编辑
    public function updateExpert()
    {
        $name = $this->input->post('name');
        $remark = $this->input->post('remark');
        $id = $this->input->post('id');
        $head_img = $this->input->post('head_img');

        $content = $this->input->post('content');
        $add_time = $this->input->post('add_time');

        if (empty($name) || empty($remark) || empty($id)) {
            $this->responseJson(1003,'参数有误');
        }
        //查询是否存在
//        $res = $this->db->where('name',$name)->get('class_expert')->row_array();
//
//        if ($res) {
//            $this->responseJson(1003,'该专家已存在，请修改姓名');
//        }

        $res = $this->article_model->updateById($id,compact('content','add_time','name','remark','create_time','head_img','update_time'));
        if (!$res) {
            $this->responseJson(10038,'修改失败');
        }
        $this->responseJson(0,'修改成功');
    }

    //查看专家的课程
    public function getExpertClass()
    {
        $expert_id = $this->input->get('expert_id');
        $data = $this->article_model->getData($expert_id);

    }









}