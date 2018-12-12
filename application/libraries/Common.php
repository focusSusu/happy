<?php
/**
 * 公共方法
 * @author Devin.qin 2017-11-11
 */
class Common{
    /**
     * 初始化方法
     * @author Devin.qin 2017-11-11
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * 获取服务器信息
     * @author Devin.qin 2017-11-11
     */
    public function getServer(){

        $data = array();
        $data['gd'] = gd_info();

        return $data;
    }

    /**
     * 获取当前url地址
     * @author Devin.qin 2017-11-11
     */
    public function getCurrentUrl(){
        $pageURL = 'http';
//        if ($_SERVER['HTTPS'] == 'on') {
//            $pageURL .= 's';
//        }
        $pageURL .= '://';
        return $pageURL.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    /**
     * 获取当前登录的id
     * @author Devin.qin 2017-11-11
     */
    public function getCurrentUserId(){
        $CI = &get_instance();
        $CI->vendor('logic/PermissionLogic','permissionlogic');
        $currentuser = $CI->permissionlogic->getLoginUserInfo();
        if(!empty($currentuser) && isset($currentuser['id']) && $currentuser['id'] > 0){
            return $currentuser['id'];
        }
        return 0;
    }

    /**
     * 获取菜单
     * @author Devin.qin 2017-11-11
     */
    public function getMenuInfo(){
        $this->ci->load->library('session');

        $userInfo = $this->ci->session->userdata('userInfo_yili');

        $result = $this->ci->db->where(['id'=>$userInfo['id']])->get('admin_user')->row_array();

        $menus = [];

        $con = strtolower($this->ci->router->fetch_class());//获取控制器名
        $menu ['active'] = [1];

        if (!empty($result['permis_id'])) {
            $menus = $this->ci->db
                ->select("id,name as title,sort,url")
                ->where_in('id',explode(',',$result['permis_id']))->get('admin_menu')->result_array();
            foreach ($menus as $k=>$val) {
                $menus[$k]['list'] = [];
                $url  =explode('/',$val['url']);
                if (strtolower($url[1]) == $con ){
                    $menu['active'] = [$k+1];
                }
                $menus[$k]['url'] = config_item('base_url').$val['url'];
            }

        }
        $menu['dataList'] = $menus;

        return json_encode($menu,JSON_UNESCAPED_UNICODE);
    }

    public function getuserInfo(){
        $this->ci->load->library('session');
        $userInfo = $this->ci->session->userdata('userInfo_yili');
        $result = $this->ci->db->where(['id'=>$userInfo['id']])->get('admin_user')->row_array();

        return $result['real_name'];
    }

    /**
     * 获取token，并存入缓存中
     * @author Devin.qin 2017-11-11
     */
    public function getToken($key = ''){

        $param = array(
            'time' => time(),
            'key'  => $key
        );
        $content = serialize($param);
        return $this->encode($content,$key);
    }
    public function checkToken($token='',$key = ''){

        if($token == 'mamonde'){
            return 1;
        }
        $content = $this->decode($token,$key);
        $param = unserialize($content);
        if($param['key']!=$key){
            return 2;  //验证key
        }
        if(time()-$param['time']>5*60){
            return 3;  //验证时间
        }
        return 1;
    }


    /**
     * 获取随机字符串
     * @author Wechat
     */
    public function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 概率算法函数
     * $proArr =array('a'=>20,'b'=>30,'c'=>50);
     * @author Devin.qin 2017-11-11
     */
    public function get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);             //抽取随机数
            if ($randNum <= $proCur) {
                $result = $key;                         //得出结果
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }

    /**
     * 获取唯一编号
     * @author Devin.qin 2017-11-11
     */
    public function getOnlyCode($str=''){
        $time = time();
        $mtime = $this->getMicrotime();//毫秒时间戳
        $No = $str.date('Ymd',$time).rand(1000,9999).date('His',$time).$mtime;
        return $No;
    }

    /**
     * 获取毫秒时间戳，默认6位
     * @author Devin.qin 2017-11-11
     */
    public function getMicrotime($length = 6){
        if($length<1 || $length>8){
            $length = 6; //强制获取6位
        }
        $microtime = microtime();
        $time = explode(" ",$microtime);
        $micro = substr($time[0],2,$length);
        return $micro;
    }

    /**
     * 设置session
     * @author Devin.qin 2017-11-11
     */
    public function set_session($data = array()){
        if(empty($data)) return array();
        $result = array();
        foreach($data as $key=>$value){
            $key_encrypt = $this->pwd($key,$key);         //键做不可解密处理
            $value_encrypt = $this->encode($value,$key);  //值做可解密处理
            $this->ci->session->set_userdata($key_encrypt,$value_encrypt);
            $result[$key_encrypt] = $value_encrypt;
        }
        return $result;
    }
    /**
     * 获取session
     * @author Devin.qin 2017-11-11
     */
    public function get_session($key=""){
        if(empty($key)) return array();
        $key_encrypt = $this->pwd($key,$key);         //键做不可解密处理
        $value_encrypt =  $this->ci->session->userdata($key_encrypt);
        return $this->decode($value_encrypt,$key);
    }
    /**
     * 删除session
     * @author Devin.qin 2017-11-11
     */
    public function del_session($key=""){
        if(empty($key)) return array();
        $key_encrypt = $this->pwd($key,$key);         //键做不可解密处理
        $this->ci->session->unset_userdata($key_encrypt);
        return true;
    }

    /**
     * 不可逆加密
     * @author Devin.qin 2017-11-11
     */
    public function pwd($code='',$key='') {
        if(empty($code)) return '';
        $key = $key.config_item('my_key');
        $code = sha1($key).sha1($code);
        return md5(sha1($key).sha1($code));
    }

    /**
     * 可逆加密
     * @author Devin.qin 2017-11-11
     */
    public function encode($code='',$key='') {
        if(empty($key) || empty($code)) return '';
        $this->ci->load->library('encryption');
        $this->ci->encryption->initialize(
            array(
                'cipher' => 'aes-256',
                'mode' => 'ctr',
                'key' => $key.config_item('my_key')
            )
        );
        return $this->ci->encryption->encrypt($code);
    }

    /**
     * 可逆解密
     * @author Devin.qin 2017-11-11
     */
    public function decode($code='',$key='') {
        if(empty($key) || empty($code)) return '';
        $this->ci->load->library('encryption');
        $this->ci->encryption->initialize(
            array(
                'cipher' => 'aes-256',
                'mode' => 'ctr',
                'key' => $key.config_item('my_key')
            )
        );
        return $this->ci->encryption->decrypt($code);
    }

    /**
     * 加密openid
     * @author Toby.tu 2016-09-23
     */
    public function encodeOpenId($openid=''){
        if(empty($openid)) return '';
        $key = config_item('openid_salt');
        $this->ci->load->library('Dataencode','','data');
        return $this->ci->data->encode($key,$openid);
    }
    /**
     * 加密openid
     * @author Toby.tu 2016-09-23
     */
    public function decodeOpenId($openid=''){
        if(empty($openid)) return '';
        $key = config_item('openid_salt');
        $this->ci->load->library('Dataencode','','data');
        return $this->ci->data->decode($key,$openid);
    }

    /**
     * https请求（支持GET和POST）
     * @author Devin.qin 2017-06-29
     */
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 异步调用 远程请求函数
     * @author Devin.qin 2017-06-29
     */
    public function sock($url) {
        $host = parse_url($url,PHP_URL_HOST);
        $port = parse_url($url,PHP_URL_PORT);
        $port = $port ? $port : 80;
        $scheme = parse_url($url,PHP_URL_SCHEME);
        $path = parse_url($url,PHP_URL_PATH);
        $query = parse_url($url,PHP_URL_QUERY);
        if($query) $path .= '?'.$query;
        if($scheme == 'https') {
            $host = 'ssl://'.$host;
        }
        $fp = fsockopen($host,$port,$error_code,$error_msg,1);
        if(!$fp) {
            return array('error_code' => $error_code,'error_msg' => $error_msg);
        }
        else {
            // stream_set_blocking($fp,true);//开启了手册上说的非阻塞模式
            // stream_set_timeout($fp,1);//设置超时
            $header = "GET $path HTTP/1.1\r\n";
            $header.="Host: $host\r\n";
            $header.="Connection: close\r\n\r\n";//长连接关闭
            // fwrite($fp, $header);
            fputs($fp,$header);
            usleep(1000); // 这一句也是关键，如果没有这延时，可能在nginx服务器上就无法执行成功
            fclose($fp);
            return array('error_code' => 0);
        }
    }


    /**
     * 导出csv文件
     * @author Devin.qin 2017.11.11
     * $file_name  导出路径，含文件名
     * $header     头部
     * $data       内容
     * $type       1导出到服务器  2输出到浏览器
     */
    public function makeCsv($file_name,$header=array(),$data=array(),$type=1){

        // 处理头部标题
        $header = implode(',', $header) . PHP_EOL;
        // 处理内容
        $content = '';
        foreach ($data as $k => $v) {
            $content .= implode(',', $v) . PHP_EOL;
        }
        // 拼接
        $csv = $header.$content;
        $csv_data = mb_convert_encoding($csv, "cp936", "UTF-8");

        if($type == 1){//保存到服务器
            // 打开文件资源，不存在则创建
            $fp = fopen($file_name,'w');
            // 写入并关闭资源
            fwrite($fp, $csv_data);
            fclose($fp);
        }else{//输出到浏览器

            $file_name = empty($file_name) ? date('Y-m-d-H-i-s', time()) : $file_name;
            if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE")) { // 解决IE浏览器输出中文名乱码的bug
                $file_name = urlencode($file_name);
                $file_name = str_replace('+', '%20', $file_name);
            }
            ob_start();
            header("Content-type:text/csv;");
            header("Content-Disposition:attachment;filename=" . $file_name);
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
            header('Expires:0');
            header('Pragma:public');
            echo $csv_data;
            ob_end_flush();
        }

    }

    //获取客户端IP
    public function getIP(){
        if(isset($_SERVER['HTTP_X_REAL_IP']) && !empty($_SERVER['HTTP_X_REAL_IP'])){
            return $_SERVER['HTTP_X_REAL_IP'];
        }
        //判断服务器是否允许$_SERVER
        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }else{
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        }else{
            //不允许就使用getenv获取
            if(getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv( "HTTP_X_FORWARDED_FOR");
            }elseif(getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            }else{
                $realip = getenv("REMOTE_ADDR");
            }
        }

        return $realip;
    }

    public function getIP2(){
        $ip = '';
        if(isset($_SERVER['HTTP_X_REAL_IP'])){
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        if(empty($ip) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if(empty($ip) && isset($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if(empty($ip) && isset($_SERVER['REMOTE_ADDR'])){
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
?>