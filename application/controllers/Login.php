<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 10:02
 */

class Login extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Adminuser_model','user_model');
    }

    public function index()
    {
        $this->load->view('login/land');  //登录

    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if (empty($username) || empty($password)) {
            $this->responseJson(10001,'参数有误');
        }

        try {
            //记录log
            $last_ip = self::ip();
            $last_time = date("Y-m-d H:i:s");
            $this->db->insert('admin_login_log',['login_name'=>$username,'service_ip'=>$last_ip,'login_time'=>$last_time]);

            $userInfo = $this->user_model->getUserInfo(['username'=>$username,'deleted'=>0]);

            if (empty($userInfo)) {
                throw new \Exception('该用户不存在',10001);
            }
            if ($userInfo && md5($password) != $userInfo['password'] ) {
                throw new \Exception('账号或密码错误',10078);
            }
            if (!$userInfo['status']){
                throw new \Exception('该账户已停用',10078);
            }


            $this->user_model->update(compact('username','password'),compact('last_ip','last_time'));



            $information = ['id'=>$userInfo['id'],'real_name'=>$userInfo['real_name'],'username'=>$userInfo['username']];
            //记录登录信息
            $this->session->set_userdata('userInfo_yili', $information);
            $this->responseJson(0,'success');

        }catch (\Exception $e) {
            $this->user_model->update(compact('username','password'),['error_start_time'=>date("Y-m-d H:i:s")]);
            $this->responseJson($e->getCode(),$e->getMessage());
        }


    }

    //退出啊
    public function loginOut()
    {
        $this->session->unset_userdata('userInfo_yili');
        $url = base_url()."login/index";
        header("location:$url");
    }


    public function responseJson($code=200,$msg='',$data=''){
        exit(json_encode(array('code' => $code, 'msg' => $msg, 'data' => $data),JSON_UNESCAPED_UNICODE));
    }

    //获取ip
    public static function ip()
    {
        static $ip = null;
        if ($ip === null){
            $ip = empty($_SERVER['REMOTE_ADDR']) ? \getenv('REMOTE_ADDR') ?: 'unknown' : $_SERVER['REMOTE_ADDR'];
            if((\strpos($ip, '100.') === 0 && \preg_match('#^100\.(?:6[4-9]|[7-9]\d|1[0-1]\d|12[0-7])\.#', $ip)) || $ip === 'unknown') {
                if($xForwardedForIps = empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? \getenv('HTTP_X_FORWARDED_FOR') ?: '' : $_SERVER['HTTP_X_FORWARDED_FOR']){
                    $xForwardedForIps = \explode(',', $xForwardedForIps);
                    $ip = \trim(\array_pop($xForwardedForIps));
                }
            }
        }
        return $ip;
    }
}
