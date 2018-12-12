<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/12/4
 * Time: 14:57
 */

class Api extends My_Controller {


    /**
     * 首页
     * @param
     * @return
     */
    public function index()
    {
        $result = [];

        //banner
        $result['banner']  = $this->db->select('name,img_url,link_type,link_url,app_id,app_url')->where_in('type','home_banner')->where('status',1)->where('deleted',0)->get('class_banner')->result_array();
        $result['advert_left']  = $this->db->select('name,img_url,link_type,link_url,app_id,app_url')->where_in('type','advert_left')->where('status',1)->where('deleted',0)->get('class_banner')->row_array();
        $result['advert_right']  = $this->db->select('name,img_url,link_type,link_url,app_id,app_url')->where_in('type','advert_right')->where('status',1)->where('deleted',0)->get('class_banner')->result_array();

        //分类
        $result['category'] = $this->db->select('id,name,icon')->where(['status'=>1])->get('class_category')->result_array();

        $this->load->view('home/index',$result);

    }

    //获取列表
    public function getRelaese()
    {
        $data= $this->input->post('data');
        if (empty($data)) {
            exit;
        }
        $type = $data['type'];

        $category_id = isset($data['category_id']) ? $data['category_id'] : '';


        $curPage = $this->input->post('curPage') ?: 1;

        $pageSize = $this->input->post('pageSize') ?: 5;

        $offset = (($curPage>0 ? $curPage : 1) - 1) * $pageSize;



        $result['list'] = [];
        if ($type == '_newest') {

            //最新招聘信息
            $result['list'] = $this->db->where(['status'=>1])->limit($pageSize, $offset)->order_by('create_time','desc')->get('class_release')->result_array();

        } elseif($type == '_hot') {

            //最热
            $result['list'] = $this->db->where(['status'=>1])->limit($pageSize, $offset)->order_by('browse_count','desc')->get('class_release')->result_array();

        } elseif($type == '_list') {

            //列表
            $result['list'] = $this->db->where(['status'=>1,'category_id'=>$category_id])->limit($pageSize, $offset)->order_by('browse_count','desc')->get('class_release')->result_array();

        } elseif($type == '_my') {
            $user_id = 1;
            $result['list'] = $this->db->where(['user_id'=>$user_id,'category_id'=>$category_id])->limit($pageSize, $offset)->order_by('browse_count','desc')->get('class_release')->result_array();
        }

        array_walk($result['list'],function (&$val){
           $val['img_list'] = json_decode($val['img']);
        });


        $result['page'] = $curPage;

        $this->load->view('home/relaese',$result);

    }

    /**
     * 列表
     * @param
     * @return
     */
    public function imformation_list()
    {
        $id = $this->input->get('id') ?: 0;
        $result['banner']  = $this->db->select('name,img_url,link_type,link_url,app_id,app_url')->where_in('type','list')->where('status',1)->where('deleted',0)->get('class_banner')->result_array();
        $result['category'] = $this->db->select('id,name,icon')->where(['status'=>1])->get('class_category')->result_array();

        $result['id'] = $id;
        $this->load->view('home/imformation_list',$result);

    }

    public function details()
    {
        $id = $this->input->get('id');
        if (empty($id)) {
            exit;
        }

        $result['list'] = $this->db->where(compact('id'))->get('class_release')->row_array();

        $result['list']['img_list'] = [];
        if (!empty($result['list']['img'])) {
            $result['list']['img_list'] = json_decode($result['list']['img']);
        }
        $this->detailsPlus($id,'class_release');

        $this->load->view('home/detail',$result);


    }

    //获取咨询
    public function getArticle()
    {

        $curPage = $this->input->post('curPage') ?: 1;
        $pageSize = $this->input->post('pageSize') ?: 10;

        $offset = (($curPage>0 ? $curPage : 1) - 1) * $pageSize;

        $result = $this->db->where(['status'=>1])->limit($pageSize, $offset)->order_by('id','desc')->get('class_article')->result_array();

        $res['list'] = $result;
        $res['curPage'] = $curPage;
        $this->load->view('home/news',$res);

    }

    //获取咨询详情
    public function getArticleDetails()
    {

        $id = $this->input->get('id');

        $result = $this->db->where(['status'=>1,'id'=>$id])->get('class_article')->row_array();
        $res['list'] = $result;
        $this->detailsPlus($id,'class_article');
        $this->load->view('home/news_detail',$res);

    }

    /**
     * 联系我们
     * @param
     * @return
     */
    public function contact_us()
    {
        $res = $this->db->get('class_setting')->row_array();

        $this->load->view('home/contact_us',$res);

    }
    public function map()
    {
        $this->load->view('home/map.html');

    }

    //阅读数加一
    public function detailsPlus($id,$table)
    {
        if (empty($id) || empty($table)) {
            return false;
        }

        $sql = "update $table set browse_count=browse_count+1 where id = $id";
        $this->db->query($sql);
    }



    /**
     * 获取分类
     * @param
     * @return
     */
    public function getCategory()
    {

        $res = $this->db->select('id,name,icon')->where(['status'=>1])->get('class_category')->result_array();

        $this->responseJson(200,'success',$res);
    }

    //发布view
    public function release_view()
    {
        $result['category'] = $this->db->select('id,name,icon')->where(['status'=>1])->get('class_category')->result_array();

        $this->load->view('home/upload',$result);

    }


    /**
     * 获取我的发布
     * @param
     * @return
     */
    public function getMyRelease()
    {


        $result['category'] = $this->db->select('id,name')->where(['status'=>1])->get('class_category')->result_array();

        $this->load->view('home/public_history',$result);
    }
    /**
     * 发布
     * @param
     * @return
     */
    public function release()
    {
        $input = $this->input->post();
        $input['user_id'] = 1;

        if (
            empty($input['category_id']) ||
            empty($input['title']) ||
            empty($input['content']) ||
            empty($input['img']) ||
            empty($input['phone']) ||
            empty($input['address'])||
            !$this->isMobilePhone($input['phone'])
        ) {
            $this->responseJson(10037,'参数有误');
        }

        $input['img'] = json_encode($input['img']);
        $input['create_time'] = date("Y-m-d H:i:s");
        $res = $this->db->insert('class_release',$input);
        $insert_id = $this->db->insert_id();
        if ($res) {
            $this->responseJson(0,'success',$insert_id);
        }
        $this->responseJson(10037,'error');
    }

    public function isMobilePhone($phoneNumber)
    {

        return $phoneNumber && \is_string($phoneNumber) && \preg_match('/^1[3-9]\d{9}$/', $phoneNumber);
    }


    //我的
    public function me()
    {
        $this->load->view('home/me');

    }

    //投广告
    public function advertising()
    {
        $input = $this->input->post();
        if (empty($input['personal']) || empty($input['phone']) || empty($input['demand']) || !$this->isMobilePhone($input['phone'])) {
            $this->responseJson(10037,'参数有误');
        }
        $res = $this->db->insert('class_demand',$input);
        if ($res) {
            $this->responseJson(0,'success');

        }
        $this->responseJson(10037,'失败');

    }

    //获取分类
    public function getRelease()
    {
        $category_id = $this->input->post('category_id');

        if (!empty($category_id)) {
            $where['category_id'] = $category_id;
        }
        $curPage = $this->input->post('curPage') ?: 1;
        $pageSize = $this->input->post('pageSize') ?: 10;


        $offset = (($curPage>0 ? $curPage : 1) - 1) * $pageSize;

        $result = $this->db->where($where)->limit($pageSize, $offset)->order_by('id','desc')->get('class_release')->result_array();
        $res['list'] = $result;
        $res['curPage'] = $curPage;
        $this->responseJson(200,'success',$result);
    }


    //获取咨询详情
    public function getArticleDetail()
    {

        $id = $this->input->post('id');

        $result = $this->db->where(compact('id'))->get('class_article')->row_array();

        $this->responseJson(200,'success',$result);
    }




    public function responseJson($code=200,$msg='',$data=''){
        exit(json_encode(array('code' => $code, 'msg' => $msg, 'data' => $data),JSON_UNESCAPED_UNICODE));
    }

}