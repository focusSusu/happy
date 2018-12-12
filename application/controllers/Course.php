<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 14:40
 */

/**
 * 课程管理
 * Class Course
 */
class Course extends My_Controller {
    private $assign;
    private $uploadDir = "upload/";
    private $MAXSIZE = 2000000;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Course_model','course_model');
        $this->load->model('Expert_model','expert_model');
        $this->assign['active'] = json_encode(['active'=>[1]]);
        $this->load->library('Logs');
    }

    //添加
    public function addView()
    {
        $this->assign['view'] = 'course/addCourse';
        $this->load->view('common/index',$this->assign);
    }

    //修改
    public function updateView()
    {
        $this->assign['view'] = 'course/addCourse';
        $this->load->view('common/index',$this->assign);
    }

    //课程列表
    public function ajaxindex()
    {
        $curPage = $this->input->post('curPage') ?: 1;

        $pageSize = $this->input->post('pageSize') ?: 5;

        $slist = $this->input->post('data');

        $totalSize = $this->course_model->getAllCount($slist);

        $result = $this->course_model->getAllData($slist,$curPage,$pageSize);

        $this->assign['list'] = $result;
        $this->assign['totalCount'] = $totalSize;
        $this->load->view('course/ajaxindex',$this->assign);

    }

    //课程
    public function index()
    {
        $expert_id = $this->input->get('expert_id') ?: '';  //是否是从专家列表跳过来
        $this->assign['expert_id'] = $expert_id;
        $this->assign['view'] = 'course/index';
        $this->load->view('common/index',$this->assign);
    }

    /**
     * 添加课程
     * @return
     */
    public function addCourse()
    {
        $input = $this->input->post();
        Logs::write(json_encode($input),'inputs');//        print_r($input);die;

        try {

            $this->checkField($input);

            if ($input['is_recommend'] == 1 && !empty($input['recommend_time'])){
                $recommend_time =  explode('~',$input['recommend_time']);
                $input['recommend_start_time'] = $recommend_time[0];
                $input['recommend_end_time'] = $recommend_time[1];
            }

            if (!empty($input['valid_time'])){
                $valid_time = explode('~',$input['valid_time']);
                $input['valid_start_time'] = $valid_time[0];
                $input['valid_end_time'] = $valid_time[1];
                $input['is_valid_time'] = 1;
            }

            //处理detail_content
            $detail_content = [];
            foreach ($input['detail_content'] as $key=>$value) {
                $detail_content[$key]['content'] =  @explode(PHP_EOL,$value['content']);
                $detail_content[$key]['imgUrl'] =  $value['imgUrl'];
            }
            $input['detail_content'] = json_encode($detail_content);

            //取出音频列表和分类列表
            if (isset($input['audiolist'])){
                $audiolist = $input['audiolist'];
            };

            $category_id = array_unique($input['category_id']);

            unset($input['valid_time']);
            unset($input['recommend_time']);
            unset($input['audiolist']);
            unset($input['category_id']);
            if ($input['type'] == 1){
                unset($input['video_url']);
                unset($input['audiolist']);
            }
            if ($input['type'] == 2) {
                unset($input['video_url']);
                unset($input['video_length']);
            }
            if ($input['type'] == 3) {
                //获取视频时长
                $input['video_length'] = $this->getSecond($input['hour'],$input['minute'],$input['second']);
                unset($input['audiolist']);
            }

            unset($input['hour']);
            unset($input['minute']);
            unset($input['second']);

            unset($input['tagOne']);
            unset($input['id']);
            unset($input['audio_name']);
            unset($input['audio_url']);
            unset($input['audio_length']);
            unset($input['audio_length']);
            unset($input['content']);
            unset($input['imgUrl']);


            $input['create_time'] = date("Y-m-d H:i:s");

            $course_id = $this->course_model->newData($input);
            if (!$course_id){
                throw  new \Exception('添加失败',10037);
            }

            //添加分类表
            foreach ($category_id as $k=>$v) {
                $this->db->insert('class_course_category',['course_id'=>$course_id,'category_id'=>$v,'create_time'=>date("Y-m-d H:i:s")]);
            }

            //添加音频
            if ($input['type'] == 2) {
                $i = 0;
                foreach ($audiolist as $k=>$v) {
                    //获取音频时长
                    if (empty(intval($v['hour'])) &&
                        empty(intval($v['minute'])) &&
                        empty(intval($v['second']))
                    ){
                        throw  new \Exception('缺少音频时长',10037);
                    }

                    $audio_length = $this->getSecond(intval($v['hour']),intval($v['minute']),intval($v['second']));
                    $this->db->insert('class_course_audio',['course_id'=>$course_id,'audio_name'=>$v['audio_name'],'audio_url'=>$v['audio_url'],'audio_length'=>$audio_length,'create_time'=>date("Y-m-d H:i:s"),'sort'=>$i++]);
                }
            }

            $this->responseJson(200,'success');

        } catch (\Exception $e) {
            $this->responseJson(10038,$e->getMessage());
        }
    }
    /**
     * 获取修改
     * @return
     */
    public function getDataById()
    {
        $id = $this->input->post('id');
        if (empty($id)){
            $this->responseJson(10038,'缺少参数');
        }
        $res = $this->db->where(compact('id'))->get('class_course')->row_array();
        if (empty($res)){
            $this->responseJson(10038,'课程不存在');
        }
        $res['category'] = $this->db->select('class_course_category.category_id,pid')->from('class_course_category')->join('class_category','class_course_category.category_id = class_category.id')->where(['course_id'=>$id])->get()->result_array();

        if ($res['type'] == 2){
            $audio = $this->db->select('audio_name,audio_url,audio_length')->where(['course_id'=>$id])->get('class_course_audio')->result_array();
            array_walk($audio,function (&$val){
                $time = $this->secToTime($val['audio_length']);

                $val['hour'] = $time['hour'];
                $val['minute'] = $time['minute'];
                $val['second'] = $time['second'];
            });
            $res['audio'] = $audio;
        }

        if ($res['type'] == 3) {
            $time = $this->secToTime($res['video_length']);
            $res['hour'] = $time['hour'];
            $res['minute'] = $time['minute'];
            $res['second'] = $time['second'];
        }

        unset($res['detail_title3']);
        unset($res['detail_title2']);
        unset($res['detail_content2']);
        unset($res['detail_content3']);
        $res['recommend_time'] = $res['recommend_start_time'].'~'.$res['recommend_end_time'];
        $res['valid_time'] = $res['valid_start_time'].'~'.$res['valid_end_time'];
        unset($res['recommend_start_time']);
        unset($res['recommend_end_time']);
        unset($res['valid_start_time']);
        unset($res['valid_end_time']);

        //处理详情内容
        $detail_content = json_decode($res['detail_content'],true);

        $res['detail_content'] = [];

        if (!empty($detail_content)){
            foreach ($detail_content as $key=>$value) {
                $res['detail_content'][$key]['content'] =  @implode(PHP_EOL,$value['content']);
                $res['detail_content'][$key]['imgUrl'] = $value['imgUrl'];
            }
        }

        $this->responseJson(200,'success',$res);

    }

    /**
     * 修改课程
     * @return
     */
    public function updateCourse()
    {

        $input = $this->input->post();
        Logs::write(json_encode($input),'input');//        print_r($input);die;

        if (empty($input['id'])){
            $this->responseJson(10038,'缺少参数');
        }
        try {

            $this->checkField($input);

            if ($input['is_recommend'] == 1 && !empty($input['recommend_time'])){
                $recommend_time =  explode('~',$input['recommend_time']);
                $input['recommend_start_time'] = $recommend_time[0];
                $input['recommend_end_time'] = $recommend_time[1];
            }
            if (!empty($input['valid_time'])){
                $valid_time = explode('~',$input['valid_time']);
                $input['valid_start_time'] = $valid_time[0];
                $input['valid_end_time'] = $valid_time[1];
                $input['is_valid_time'] = 1;
            }

            //处理detail_content
            $detail_content = [];
            foreach ($input['detail_content'] as $key=>$value) {
                $detail_content[$key]['content'] =  explode(PHP_EOL,$value['content']);
                $detail_content[$key]['imgUrl'] =  $value['imgUrl'];
            }
            $input['detail_content'] = json_encode($detail_content);
            //取出音频列表和分类列表
            if (isset($input['audiolist'])){
                $audiolist = $input['audiolist'];
            };
            $category_id = array_unique($input['category_id']);

            unset($input['valid_time']);
            unset($input['recommend_time']);
            unset($input['audiolist']);
            unset($input['category_id']);
            if ($input['type'] == 1){
                unset($input['video_url']);
                unset($input['audiolist']);
            }
            if ($input['type'] == 2) {
                unset($input['video_url']);
                unset($input['video_length']);
            }
            if ($input['type'] == 3) {
                //获取视频时长
                $input['video_length'] = $this->getSecond($input['hour'],$input['minute'],$input['second']);
                unset($input['audiolist']);
            }

            unset($input['hour']);
            unset($input['minute']);
            unset($input['second']);

            unset($input['tagOne']);
            unset($input['audio_name']);
            unset($input['audio_url']);
            unset($input['audio_length']);
            unset($input['audio_length']);
            unset($input['content']);
            unset($input['imgUrl']);

            $course_id = $input['id'];
            unset($input['id']);
            $input['update_time'] = date("Y-m-d H:i:s");

            $this->db->trans_start(); //开启事务

            $update_row = $this->course_model->updateById($course_id,$input);

            if (!$update_row){
                throw  new \Exception('修改失败',10037);
            }


            //删除之前的分类
            $this->db->where(['course_id'=>$course_id])->delete('class_course_category');

            //删除之前的音频
            $this->db->where(['course_id'=>$course_id])->delete('class_course_audio');


            //添加音频
            if ($input['type'] == 2) {
                $i = 0;

                foreach ($audiolist as $k=>$v) {
                    //获取音频时长
                    if (empty(intval($v['hour'])) &&
                        empty(intval($v['minute'])) &&
                        empty(intval($v['second']))
                    ){
                        throw  new \Exception('缺少音频时长',10037);
                    }

                    $audio_length = $this->getSecond(intval($v['hour']),intval($v['minute']),intval($v['second']));

                    $this->db->insert('class_course_audio',['course_id'=>$course_id,'audio_name'=>$v['audio_name'],'audio_url'=>$v['audio_url'],'audio_length'=>$audio_length,'create_time'=>date("Y-m-d H:i:s"),'sort'=>$i++]);
                }
            }
            //添加分类表
            foreach ($category_id as $k=>$v) {
                $this->db->insert('class_course_category',['course_id'=>$course_id,'category_id'=>$v,'create_time'=>date("Y-m-d H:i:s")]);
            }

            $this->db->trans_complete();

            $this->responseJson(200,'success');

        } catch (\Exception $e) {
            $this->responseJson($e->getCode(),$e->getMessage());
        }
    }




    public function uploadFormData($fileName, $uploadDir, $allowType, $imagePrefix = true,$maxsize)
    {
        $this->load->library('Uploads');
        $params = [
            'randName' => $imagePrefix,
            'allowType' => $allowType,
            'FilePath' => $uploadDir,
            'MAXSIZE' => $maxsize,
            'isgroup' => true
        ];


        $objFileUpload = new Uploads($params);

        if (!$objFileUpload->uploadFile($fileName)) {

            throw new \Exception($objFileUpload->getErrorMsg(), 10004);
        }

        return $objFileUpload->getPathName();
    }


    /**
     * 检查参数
     * @param
     * @return
     * @throws \Exception
     */
    public function checkField($input)
    {

        if (empty($input['name'])){
            throw  new \Exception('课程名称不能为空');
        }

        if ($input['is_top'] == ""){
            throw  new \Exception('课选择是否置顶');
        }

        if (empty($input['type'])) {
            throw  new \Exception('课程类型不能为空');
        }

        if (empty($input['category_id']) || !is_array($input['category_id'])) {
            throw  new \Exception('请选择分类');
        }


        if (!in_array($input['is_recommend'],[1,0])) {
            throw  new \Exception('请选择今日推荐');
        }

        if ($input['is_recommend'] == 1 && empty($input['recommend_time'])){
            throw  new \Exception('请选择推荐时间范围');
        }

        if (($input['type'] == 2 || $input['type'] == 3) && $input['is_vip'] == "") {
            throw  new \Exception('请选择是否会员推荐');
        }

        if (empty($input['expert_id'])){
            throw  new \Exception('请选择专家');
        } else {
            //验证专家是否存在
            $res = $this->expert_model->getOne(['id'=>$input['expert_id']]);
            if (empty($res)) {
                throw  new \Exception('请检查专家是否存在');
            }

        }

        if (!isset($input['cover_img'])) {
            throw  new \Exception('请上传封面图片');
        }

        if (!isset($input['detail_img'])) {
            throw  new \Exception('请上传详情图片');
        }

        if (empty($input['detail_title'])){
            throw  new \Exception('请填写课程标题');
        }

        //todo 音频
        if ($input['type'] == 2 && empty($input['audiolist'])) {
            throw  new \Exception('请上传音频文件');
        }

        //todo 视频
        if ($input['type'] == 3  ) {
            if (empty($input['video_url'])){
                throw  new \Exception('请填写视频地址');
            }
            if (empty($input['second']) && empty($input['hour']) && empty($input['minute'])){
                throw  new \Exception('请填写视频时长');
            }

        }
        if (empty($input['detail_content'])) {
            throw  new \Exception('请填写详情内容');
        }



    }


    //修改状态
    public function updateStatus()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if ((empty($id) || empty($status)) && !in_array($status,[1,0])) {
            $this->responseJson(10038,'参数有误');
        }

        $res = $this->db->where(['id'=>$id])->update('class_course',['status'=>$status]);

        if (!$res) {
            $this->responseJson(10038,'修改失败');
        }

        $this->responseJson(0,'修改成功');
    }

    //获取专家、获取分类
    public function getExpert()
    {

        $res = $this->db->select('id,name')->get('class_expert')->result_array();
        $this->responseJson(200,'success',$res);
    }

    public function getCategory()
    {
        $category_id = $this->input->post('pid') ?: 0;

        $res = $this->db->select('id,name')->where(['pid'=>$category_id])->get('class_category')->result_array();

        $this->responseJson(200,'success',$res);
    }


    public function getSecond($hour=0,$minute=0,$second=0)
    {
        if (empty($hour) && empty($minute) && empty($second)) {
            throw  new \Exception('参数有误',10037);
        }

        $time = $hour .":".$minute.":".$second;
        $parsed = date_parse($time);
        $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
        return  $seconds;
    }


    /**
     *      把秒数转换为时分秒的格式
     *      @param Int $times 时间，单位 秒
     *      @return array
     */
    public function secToTime($times)
    {
        $hour = 0;
        $minute = 0;
        $second = 0;
        if ($times > 0) {
            $hour = floor($times / 3600);
            $minute = floor(($times - 3600 * $hour) / 60);
            $second = floor((($times - 3600 * $hour) - 60 * $minute) % 60);
        }
        $res = ['hour'=>$hour,'minute'=>$minute,'second'=>$second];
        return $res;
    }



}