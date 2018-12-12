<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/7
 * Time: 18:24
 */

class My_Controller extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
//        $this->checkUserLogin();
    }



    public function checkUserLogin()
    {
        $userInfo = $this->session->userdata('userInfo_yili');

        if (!self::isAjax()) {
            if (empty($userInfo)) {
                $url = config_item("base_url")."/login/index";
                header("location:$url");
            }
            $result = $this->db->where(['id'=>$userInfo['id']])->get('admin_user')->row_array();
            $con = strtolower($this->router->fetch_class());//获取控制器名
            $func = $this->router->fetch_method();           //获取方法名
            $notCheckAction = ['personalInformationIndex'];
            if (!$result['is_admin']){
                if (!in_array($func,$notCheckAction)){
                    if (empty($result['permis_id'])) {
                        echo "<script>history.back();</script>";
                    }
                    $menus = $this->db->select("url")->where_in('id',explode(',',$result['permis_id']))->get('admin_menu')->result_array();
                    foreach ($menus as $k=>$val) {
                        $urls  =explode('/',$val['url']);
                        $pre[]  =strtolower($urls[1]);
                    }
                    if (!in_array($con,$pre)) {
                        echo "<script>history.back();</script>";
                    }
                }
            }
        }

    }

    /**
     * 判断请求是否是AJAX请求
     * @return bool
     */
    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && \strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
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

    public  function sensitive_log($sensitive_tab,$sensitive_user_id,$sensitive_data,$sensitive_type)
    {
        if (empty($sensitive_data) || empty($sensitive_user_id) || empty($sensitive_tab) || empty($sensitive_type)) {
            return false;
        }
        if (!in_array($sensitive_type,[1,2])){
            return false;
        }
        $sensitive_time = date("Y-m-d H:i:s");
        $sensitive_ip = self::ip();
        $sensitive_data = json_encode($sensitive_data,JSON_UNESCAPED_UNICODE);
        $this->db->insert('admin_sensitive_log',compact('sensitive_tab','sensitive_user_id','sensitive_data','sensitive_type','sensitive_time','sensitive_ip'));
    }

}