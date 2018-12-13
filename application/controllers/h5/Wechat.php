<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/12/13
 * Time: 14:57
 */

class Wechat extends CI_Controller {
    private $appId;
    private $appKey;
    public function __construct()
    {
        parent::__construct();
        $this->appId = config_item('app')['app_id'];
        $this->appKey = config_item('app')['app_key'];
        $this->load->library('Http');
        $this->load->library('session');
    }

    public function wechatLogin()
    {
        /*
        $code = $this->input->get('code');
        $url = base_url().'h5/wechat/wechatLogin';

        if (empty($code)) {
            header("Location:".$this->menuUrl($url));
            exit;
        }
        $getToken = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appKey&code=$code&grant_type=authorization_code";

        $ret = Http::curl($getToken);
        $userInfo= json_decode($ret,true);

        if (empty($userInfo) || empty($userInfo['openid'])) {
            header("Location:".$this->menuUrl($url));
            exit;
        }
*/

        $userInfo['openid'] = $this->input->get('openid');;

        $user = $this->getUserInfo($userInfo['openid']);

        $this->session->set_userdata('userInfo_wechat', $user);

        header("Location:".base_url().'h5/api/index');


    }

    private function menuUrl($url){
        $baseUrl = "https://open.weixin.qq.com/connect/oauth2/authorize";
        $params = [
            "appid" => $this->appId,
            "redirect_uri" => $url,
            "response_type" => "code",
            "scope" => "snsapi_userinfo",
            "state" => "",
        ];

        foreach($params as $key => $value){
            $urlArr[] = $key . "=" . $value;
        }
        return $baseUrl . "?" . implode("&",$urlArr) . "#wechat_redirect";
    }

    private function getUserInfo($openid='')
    {
        if (empty($openid)) {
            return false;
        }
        $token = $this->getToken();
        if (empty($token)) {
            exit('公众号错误');
        }

        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid&lang=zh_CN";
        $userInfo = json_decode(Http::curl($url),true);

        $res = $this->db->where(['openid'=>$userInfo['openid']])->get('class_member')->row_array();

        $data = [
            'nickname'=>isset($userInfo['nickname']) ? $userInfo['nickname'] : "",
            'headimgurl'=>isset($userInfo['nickname']) ? $userInfo['headimgurl'] : ""
        ];

        if (empty($res)) {
            $data['create_time'] = date("Y-m-d H:i:s");
            $data['openid'] = $openid;
            $this->db->insert('class_member',$data);
            $data['id'] = $this->db->insert_id();
        } else {
            $data['update_time'] = date("Y-m-d H:i:s");
            $this->db->where(['openid'=>$openid])->update('class_member',$data);
            $data['id'] = $res['id'];
        }

        return $data;
    }

    //定时获取token
    public function getToken()
    {
        $res = json_decode(file_get_contents("storage/ackey.json"),true);

        if ( empty($res) || time() - $res['create_time'] > $res['expires_in']  - 120){
            $res = $this->_makeToken();
            $res = json_decode($res,true);
            if (!empty($res) || isset($res['errcode'])) {
                $res['create_time'] = time();
                file_put_contents('storage/ackey.json',json_encode($res));
            }
        }



        return isset($res['access_token']) ? $res['access_token'] : "";

    }

    private function _makeToken()
    {
        $this->load->library('Http');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appKey";
        $res = Http::curl($url);
        return $res;
    }

}