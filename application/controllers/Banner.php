<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/8
 * Time: 17:29
 */

class Banner extends My_Controller {
    private $assign;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Banner_model','banner_model');
        $config['upload_path']      = './upload/';
        $config['allowed_types']    = 'gif|jpg|png';
        $this->load->library('upload', $config);
        $this->assign['active'] = json_encode(['active'=>[3]]);
    }

    //banner view
    public function ajaxindex()
    {

        $curPage = $this->input->post('curPage') ?: 1;

        $pageSize = $this->input->post('pageSize') ?: 5;

        $slist = $this->input->post('data');

        $totalSize = $this->banner_model->getAllCount($slist);


        $result = $this->banner_model->getAllData($slist,$curPage,$pageSize);

        //todo  banner模块？？？
//        foreach ($result as $k=>$v) {
//            $bannerType = $this->db->select('vals')->get('class_picklist')->row_array();
//            $result[$k]['bannername'] = $bannerType['vals'];
//        }

        $this->assign['totalCount'] = $totalSize;
        $this->assign['list'] = $result;
        $this->load->view('banner/ajaxindex',$this->assign);

    }

    public function index()
    {
        $this->assign['picklist'] = $this->db->get('class_picklist')->result_array();
        $this->assign['view'] = 'banner/index';
        $this->load->view('common/index',$this->assign);
    }

    public function addView()
    {
        $bannerType  = $this->db->order_by('sort','asc')->get('class_picklist')->result_array();
        $this->assign['list'] = $bannerType;
        $this->assign['view'] = 'banner/addView';
        $this->load->view('common/index',$this->assign);
    }

    //添加banner
    public function addBanner()
    {
        $input = $this->input->post();
        try {
            $this->checkField($input);

            //查询相同名称
            $res = $this->db->where(['type'=>$input['type'],'name'=>$input['name']])->get('class_banner')->row_array();
            if ($res) {
                $this->responseJson(1003,'该banner已存在，请修改名字');
            }

            $input['is_valid_time'] = 0;
            if (!empty($input['valid_time'])){
                $volid_time = explode(' - ',$input['valid_time']);
                if (count($volid_time) != 2 || empty($volid_time)){
                    throw  new \Exception('网络错误');
                }
                $input['valid_start_time'] = $volid_time[0];
                $input['valid_end_time'] = $volid_time[1];
                $input['is_valid_time'] = 1;
            }

            unset($input['valid_time']);

            $input['create_time'] = date("Y-m-d H:i:s");
            $res = $this->banner_model->newData($input);
            if (!$res) {
                $this->responseJson(1003,'添加失败');
            }

            $this->responseJson(0,'添加成功');
        }catch (\Exception $e) {
            $this->responseJson(10038,$e->getMessage());
        }

    }

    //修改
    public function updateView()
    {
        $id = $this->input->get('banner_id');
        if (empty($id)){
            exit('banner不存在');
        }

        $result = $this->db->where(compact('id'))->get('class_banner')->row_array();  //banner
        if (empty($result)){
            exit('banner不存在');
        }



        $picklist = $this->db->get('class_picklist')->result_array();  //分类

        $this->assign['list'] = $result;
        $this->assign['picklist'] = $picklist;
        $this->assign['view'] = 'banner/updateView';
        $this->assign['banner_id'] = $id;

        $this->load->view('common/index',$this->assign);



    }
    //修改banner
    public function updateBanner()
    {
        $input = $this->input->post();

        try {
            if (empty($input['banner_id'])){
                throw  new \Exception('参数错误');
            }

//            $res = $this->db->where(['type'=>$input['type'],'name'=>$input['name']])->get('class_banner')->row_array();
//            if ($res) {
//                $this->responseJson(1003,'该banner已存在，请修改名字');
//            }

            $id = $input['banner_id'];
            unset($input['banner_id']);
            $this->checkField($input);

            $input['is_valid_time'] = 0;
            if (!empty($input['valid_time'])){
                $volid_time = explode(' - ',$input['valid_time']);
                if (count($volid_time) != 2 || empty($volid_time)){
                    throw  new \Exception('网络错误');
                }
                $input['valid_start_time'] = $volid_time[0];
                $input['valid_end_time'] = $volid_time[1];
                $input['is_valid_time'] = 1;
            }

            unset($input['valid_time']);

//            if (!$this->upload->do_upload('img_url')){
//                $this->responseJson(1003,'图片上传失败');
//            }
//            $uploadData = $this->upload->data();
//            $input['img_url'] = $uploadData['file_name'];
            $input['create_time'] = date("Y-m-d H:i:s");
            $res = $this->banner_model->updateById($id,$input);
            if (!$res) {
                $this->responseJson(1003,'添加失败');
            }

            $this->responseJson(0,'添加成功');
        }catch (\Exception $e) {
            $this->responseJson(10038,$e->getMessage());
        }

    }
    /**
     * 检查参数
     * @param
     * @return
     * @throws \Exception
     */
    private function checkField($input)
    {
        if (empty($input['name'])){
            throw  new \Exception('banner名称不能为空');
        }

        if (empty($input['type'])){
            throw  new \Exception('请选择模块');
        }

        if (!isset($input['img_url'])) {
            throw  new \Exception('请上传图片');
        }
//
//        if (empty($input['valid_start_time']) && !empty($input['valid_end_time'])) {
//            throw  new \Exception('请填写结束时间');
//        }
//        if (!empty($input['valid_start_time']) && empty($input['valid_end_time'])) {
//            throw  new \Exception('请填写开始时间');
//        }

//        if ($input['valid_time'] == "") {
//            throw  new \Exception('请选择生效时间');
//        }

        if ($input['link_type'] == "") {
            throw  new \Exception('请选择跳转方式');
        }

        if ($input['link_type'] == 1 && empty($input['link_url'])) {
            throw  new \Exception('请填写跳转链接');
        }

        if ($input['link_type'] == 2 && empty($input['app_id'])) {
            throw  new \Exception('请填写appid');
        }

        if ($input['link_type'] == 2 && empty($input['app_url'])) {
            throw  new \Exception('请填写app_url');
        }
    }


    //删除
    public function delBanner()
    {
        $this->load->model('Sensitive_model','sensitive_model');

        $id = $this->input->post('id');
        if (empty($id)) {
            $this->responseJson(10037,'error');
        }
        $res = $this->db->where(compact('id'))->update('class_banner',['deleted'=>1,'delete_time'=>date("Y-m-d H:i:s")]);

        if (!$res) {
            $this->responseJson(1003,'删除失败');
        }

        $this->responseJson(0,'删除成功');


    }

    //修改状态
    public function updateBannerStatus()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if (empty($id) || $status == "") {
            $this->responseJson(10037,'error');
        }
        $res = $this->db->where(compact('id'))->update('class_banner',['status'=>$status,'update_time'=>date("Y-m-d H:i:s")]);
        if (!$res) {
            $this->responseJson(1003,'修改失败');
        }

        $this->responseJson(0,'修改成功');


    }




}