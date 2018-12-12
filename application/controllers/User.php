<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 16:34
 */

class User extends My_Controller {
    private $assign;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model','user_model');
        $this->assign['active'] = json_encode(['active'=>[5]]);

    }

    public function index()
    {
        $this->assign['view'] = 'user/index';
        $this->load->view('common/index',$this->assign);
    }

    //获取角色
    public function ajaxindex()
    {
        $curPage = $this->input->post('curPage') ?: 1;

        $pageSize = $this->input->post('pageSize') ?: 5;

        $slist = $this->input->post('data');

        $totalSize = $this->user_model->getAllCount($slist);


        $result = $this->user_model->getAllData($slist,$curPage,$pageSize);

        $this->assign['totalCount'] = $totalSize;
        $this->assign['view'] = 'user/userlist';
        $this->assign['userlist'] = $result;
        $this->load->view('user/ajaxindex',$this->assign);

    }
    //添加用户
    public function create()
    {
        //权限
        $menus = $this->db->where(['status'=>1])->get('admin_menu')->result_array();
        $this->assign['view'] = 'user/adduser';
        $this->assign['menus'] = $menus;
        $this->assign['view'] = 'user/adduser';
        $this->load->view('common/index',$this->assign);
    }

    //添加用户
    public function addUser()
    {
        $username  = $this->input->post('username');
        $real_name = $this->input->post('real_name');
        $password  = $this->input->post('password');
        $repassword  = $this->input->post('repassword');
        $permis_id   = $this->input->post('permis_id');


        if (empty($real_name) || empty($password) || empty($repassword) || empty($permis_id)) {
            $this->responseJson(10037,'参数有误');
        }

        if ($password !== $repassword){
            $this->responseJson(10038,'密码不一致');
        }

        if (strlen($password)) {
            $this->responseJson(10038,'密码长度不够');
        }



        //查询是否存在该账号
        $userInfo = $this->user_model->getOne(compact('username'));
        if (!empty($userInfo)) {
            $this->responseJson(10038,'该账号已存在');
        }
        //todo 临时参数
        $permis_id = implode(',',[1,2,3]);
        $password = md5($password);
        $password_time = date("Y-m-d H:i:s");
        $create_time = date("Y-m-d H:i:s");

        $insert_id = $this->user_model->newData(compact('username','real_name','password','permis_id','password_time','create_time'));
        if (!$insert_id) {
            $this->responseJson(10038,'添加失败');
        }
        $this->responseJson(0,'添加成功');
    }

    //修改用户
    public function update()
    {
        $user_id = $this->input->get('user_id');
        $result = $this->db->where(['id'=>$user_id])->get('admin_user')->row_array();

        if (empty($result)){
            exit('用户不存在');
        }
        $where['status'] = 1;
        if ($result['is_admin']) {
            $where = [];
        }
        //权限
        $menus = $this->db->where($where)->get('admin_menu')->result_array();
        $this->assign['view'] = 'user/updateuser';
        $this->assign['userinfo'] = $result;
        $this->assign['menus'] = $menus;
        $this->assign['user_id'] = $user_id;

        $this->load->view('common/index',$this->assign);
    }

    //编辑
    public function updateUser()
    {
        $username    = $this->input->post('username');
        $real_name   = $this->input->post('real_name');

        $permis_id   = $this->input->post('permis_id');
        $id   = $this->input->post('user_id');

        if (empty($username) || empty($real_name)  || empty($id)) {
            $this->responseJson(10037,'参数有误');
        }


        //查询是否存在该账号
        $userInfo = $this->user_model->getOne(compact('id'));
        if (empty($userInfo)) {
            $this->responseJson(10038,'账号不存在');
        }

        if ($userInfo['is_admin'] ) {
            $permis_id = $userInfo['permis_id'];
        } else {
            if (empty($permis_id)){
                $this->responseJson(10038,'缺少参数');
            }
            $permis_id = implode(',',$permis_id);
        }

        //todo 临时参数
        $update_time = date("Y-m-d H:i:s");

        $row = $this->user_model->updateById($id,compact('username','real_name','permis_id','update_time'));

        if (!$row) {
            $this->responseJson(10038,'修改失败');
        }
        $this->responseJson(0,'修改成功');

    }

    public function updatePassView()
    {
        $user_id = $this->input->get('user_id');
        $result = $this->db->where(['id'=>$user_id])->get('admin_user')->row_array();

        if (empty($result)){
            exit('用户不存在');
        }
        $this->assign['userinfo'] = $result;

        $this->assign['view'] = 'user/updatePass';
        $this->assign['user_id'] = $user_id;
        $this->load->view('common/index',$this->assign);

    }


    public function updatePass()
    {

        $password    = $this->input->post('password');
        $repassword  = $this->input->post('repassword');
        $id   = $this->input->post('user_id');

        if (empty($password) || empty($repassword)  || empty($id)) {
            $this->responseJson(10037,'参数有误');
        }

        if ($password !== $repassword){
            $this->responseJson(10038,'密码不一致');
        }

        //查询是否存在该账号
        $userInfo = $this->user_model->getOne(compact('id'));
        if (empty($userInfo)) {
            $this->responseJson(10038,'账号不存在');
        }
        //todo 临时参数
        $password = md5($password);
        $update_time = date("Y-m-d H:i:s");

        $row = $this->user_model->updateById($id,compact('password','update_time'));

        if (!$row) {
            $this->responseJson(10038,'修改失败');
        }
        $this->responseJson(0,'修改成功');

    }

    public function updateStatus()
    {
        $id    = $this->input->post('id');
        $status    = $this->input->post('status');

        if (empty($id) || $status == ""){
            $this->responseJson(10037,'参数有误');
        }
        if (!in_array($status,[1,0])) {
            $this->responseJson(10037,'参数有误');
        }

        $res = $this->db->where(compact('id'))->get('admin_user')->row_array();
        if ($res['is_admin']) {
            $this->responseJson(10038,'不允许禁用');

        }


        $row = $this->user_model->updateById($id,compact('status'));
        if (!$row) {
            $this->responseJson(10038,'修改失败');
        }
        $this->responseJson(0,'修改成功');
    }


    //个人信息
    public function personalInformationIndex()
    {
        $userInfo = $this->session->userdata('userInfo_yili');
        $result = $this->db->where(['id'=>$userInfo['id']])->get('admin_user')->row_array();

        $this->assign['view'] = 'user/personalIndex';
        $this->assign['userinfo'] = $result;
        $this->assign['active'] = json_encode(['active'=>[6]]);
        $this->load->view('common/index',$this->assign);

    }

    //修改个人信息
    public function updateInformation()
    {
        $input  = $this->input->post();

        if (empty($input['real_name'])) {
            $this->responseJson(10037,'参数有误');
        }

        foreach ($input as $k=>$v) {
            if (empty($v)){
                unset($input[$k]);
            }
        }

        if (isset($input['password']) && empty($input['repassword'])) {
            $this->responseJson(10037,'参数有误');
        }

        if (isset($input['repassword']) && !empty($input['password'])) {
            $this->responseJson(10037,'参数有误');
        }

        $userInfo = $this->session->userdata('userInfo_yili');

        $row = $this->user_model->updateById($userInfo['id'],$input);

        if (!$row) {
            $this->responseJson(10038,'修改失败');
        }

        $this->responseJson(0,'修改成功');



    }

}