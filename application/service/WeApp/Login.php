<?php
/**
 * Created by PhpStorm.
 * User: colin.wang
 * Date: 2018/11/20
 * Time: 17:53
 */
namespace service\WeApp;

use service\artisan\http;
use service\artisan\MY_Service;

class Login extends MY_Service{
    public $app_key;

    public $app_secret;

    public $app_url;

    const SUB = 'authorization_code';

    private  $sendmsg_channel = ['bind_member'];


    public function __construct($app = 'wxfd31a68ce95d0d98')
    {
        parent::__construct();
        $app = config_item('mini_program')[$app];
        $this->app_key =  $app['appid'];

        $this->app_secret = $app['secret'];

        $this->app_url = "https://api.weixin.qq.com/sns/jscode2session?grant_type=authorization_code";
    }

    /**
     *  綁定
     * @param array $memberInfo
     * @param integer $mobile
     * @param string $name
     * @return
     */
    public function bind($memberInfo,$mobile,$name)
    {
        $this->load->model('Member_model','member_model');
        $this->load->library('Arvato','arvato');
        if (empty($memberInfo['wechatOpenid']) || empty($mobile) ||empty($name)) {
            throw new \Exception('参数有误', 1133);
        }

        //存在未绑定成功的记录直接修改
        $member = $this->db->select('id')->where(['mobile'=>$mobile,'deleted'=>0,'bind_status'=>0])->get('member')->row_array();
        if (!empty($member)) {
            $update_id = $member['id'];
        } else {
            $update_id = $this->member_model->newData([
                'name'=>$name,
                'mobile'=>$mobile,
                'miniOpenid'=>$memberInfo['openId'],
                'openid'=>$memberInfo['wechatOpenid'],
                'unionid'=>$memberInfo['unionId'],
                'create_time'=>date("Y-m-d H:i:s"),
            ]);
        }

        //新增潜客
        $res = $this->arvato->createMember($memberInfo['wechatOpenid'],$mobile,$name);
        $this->member_model->updateById($update_id,['create_msg'=>$res['msg'] ?: '']);
        //绑定
        $ret = $this->arvato->bindMember($memberInfo['wechatOpenid'],$mobile,$name);
        $this->member_model->updateById($update_id,['bind_msg'=>$ret['msg'] ?: '','bind_status'=>$ret['code'] ?: 0,'bind_time'=>$ret['code'] ? date("Y-m-d H:i:s") : ""]);

        if (empty($ret)) {
            throw new \Exception('网络错误', 1002);
        }
        if (!$ret['code']) {
            throw new \Exception($ret['msg'] ?: '绑定失败', 1002);
        }

    }

    /**
     *  查詢是否是会员
     * @param $openid
     * @param $mobile
     * @throws \Exception
     */
    public function checkArvatoMemberInfo($mobile='',$openid='')
    {
        if (empty($openid) && empty($mobile)) {
            throw new \Exception('参数有误', 1133);
        }

        if (!empty($mobile)) {
            $member_arvato = $this->arvato->getMemberByMobile($mobile);
            if(isset($member_arvato['data']['CustomerType']) && $member_arvato['data']['CustomerType'] != '会员'){
                throw new \Exception('非会员',10031);
            }
        } else {
            $memberInfo = $this->arvato->getMemberInfo($openid);
            if (!isset($memberInfo['data']['CustomerType'])  || $memberInfo['data']['CustomerType'] != '会员'){
                throw new \Exception('非会员',10031);
            };
        }

        return true;

    }

    /**
     * @param $mobile
     * @param $smscode
     * @param $password
     * @return array
     * @throws \Exception
     */
    public function checkSmscode($mobile,$code,$channel)
    {
        if (empty($mobile) || empty($code) || empty($channel)) {
            throw new \Exception('参数有误',201);
        }
        if(!in_array($channel,$this->sendmsg_channel)){
            throw new \Exception('不存在的发送渠道',203);
        }

        if (!isMobilePhone($mobile)) {
            throw new \Exception('手机号格式不正确',210);
        }
        //验证验证码
        $sendmsg_log = $this->db->select('code,create_time')
            ->where('channel',$channel)->where('mobile',$mobile)->where('type',1)->where('status',1)
            ->order_by('id','desc')->limit(1)
            ->get('sendmsg_log')->row_array();

        if(empty($sendmsg_log)){
            throw new \Exception('未检测到短信发送记录',221);
        }
        if($sendmsg_log['code']!=$code){
            throw new \Exception('验证码错误',221);
        }
        $diff_time = time() - strtotime($sendmsg_log['create_time']);
        if($diff_time > 300){
            throw new \Exception('验证码已失效',221);
        }
        return true;
    }


    /**
     * @param string $code
     * @return mixed {"session_key":"nMs1\/6UHoqCConfYoexSQg==","expires_in":7200,"openid":"oN_kX0QaYzCTbLgdZz_CdxgDgn-c","unionid":"oEp1_t_6LTwFXEuG-uADHRa2E-cQ"}
     * @throws \Exception
     */
    public function authorize($code)
    {
        if (empty($code)) {
            throw new \Exception('缺少code', 4003);
        }

        $url = "{$this->app_url}&appid={$this->app_key}&secret={$this->app_secret}&js_code={$code}";
        $res = http::curl($url);

        $ret = json_decode($res, true);

        if (empty($ret) || !empty($ret['errcode'])) {
            \service\artisan\Log::write(json_encode(['code'=>$code,'reutrn'=>$res]) , 'authorize');
            throw new \Exception('code解析失败', 4003);
        }
        return $ret;
    }

    /**
     * @param string $session_key
     * @param string $encrypted_data
     * @param string $iv
     * @return mixed {"openId":"oN_kX0QaYzCTbLgdZz_CdxgDgn-c","nickName":"维新一","gender":1,"language":"zh_CN","city":"Chengdu","province":"Sichuan","country":"CN","avatarUrl":"https:\/\/wx.qlogo.cn\/mmopen\/vi_32\/PiajxSqBRaEI4tLe04S6yeqpVE4IWfUNm5PERuXorWmEvEueR2cqAEpFticP5rcJ9gJHjcuWyz3bKBOrL814ZvPg\/0","unionId":"oEp1_t_6LTwFXEuG-uADHRa2E-cQ","watermark":{"timestamp":1508809453,"appid":"wxfaeec4255298e6c6"}}
     * @throws \Exception
     */
    public function getUserInfo($session_key, $encrypted_data, $iv)
    {
        if(empty($encrypted_data) || empty($iv) || empty($session_key)) {
            throw new \Exception('缺少解密参数', 1009);
        }

        return json_decode($this->decryptData($this->app_key, $session_key, $encrypted_data, $iv), true);


    }
    /**
     * @param string $session_key
     * @param string $encrypted_data
     * @param string $iv
     * @return mixed {"openId":"oN_kX0QaYzCTbLgdZz_CdxgDgn-c","nickName":"维新一","gender":1,"language":"zh_CN","city":"Chengdu","province":"Sichuan","country":"CN","avatarUrl":"https:\/\/wx.qlogo.cn\/mmopen\/vi_32\/PiajxSqBRaEI4tLe04S6yeqpVE4IWfUNm5PERuXorWmEvEueR2cqAEpFticP5rcJ9gJHjcuWyz3bKBOrL814ZvPg\/0","unionId":"oEp1_t_6LTwFXEuG-uADHRa2E-cQ","watermark":{"timestamp":1508809453,"appid":"wxfaeec4255298e6c6"}}
     * @throws \Exception
     */
    public function  getUserPhone($session_key, $encrypted_data, $iv)
    {
        if(empty($encrypted_data) || empty($iv || empty($session_key))) {
            throw new \Exception('参数有误', 4001);
        }
        return json_decode($this->decryptData($this->app_key, $session_key, $encrypted_data, $iv), true);
    }


    /**
     * @param $appid
     * @param $sessionKey
     * @param $encryptedData
     * @param $iv
     * @return mixed
     * @throws \Exception
     */
    private function decryptData($appid, $sessionKey, $encryptedData, $iv)
    {
        $pc = new \service\util\aes\WXBizDataCrypt($appid, $sessionKey);

        $errCode = $pc->decryptData($encryptedData, $iv, $data);
        \service\artisan\Log::write(json_encode($errCode),'log');
        if ($errCode == 0) {
            return $data;
        } else {
            print_r($errCode);die;

            throw new \Exception('decrypt data failed', 4006);
        }
    }


    /**
     * 发送验证码
     * @param
     * @return
     */

    public function sendMessage($mobile,$channel)
    {

        if(!in_array($channel,$this->sendmsg_channel)){
            throw new \Exception('不存在的发送渠道',203);
        }

        //获取当天发送次数
        $sendmsg_log = $this->db->select('count(0) as counts')
            ->where('channel',$channel)->where('mobile',$mobile)->where("status",1)
            ->where('create_time>=',date("Y-m-d 00:00:00"))
            ->get('sendmsg_log')->row_array();
        if($sendmsg_log['counts'] >= 5){
            throw new \Exception('当天发送次数已达上限',222);
        }

        //获取最后一条发送记录
        $sendmsg_log = $this->db->select('code,create_time')
            ->where('channel',$channel)->where('mobile',$mobile)->where("status",1)
            ->order_by('id','desc')->limit(1)
            ->get('sendmsg_log')->row_array();
        $code = '';
        if(!empty($sendmsg_log)){
            $diff_time = time() - strtotime($sendmsg_log['create_time']);
            if($diff_time <= 60){
                throw new \Exception('发送过于频繁',205);
            }
            if($diff_time <= 300){//5分钟内发送同一验证码
                $code = $sendmsg_log['code'];
            }
        }

        //发送短信

        if(empty($code)){
            $code = $channel == 'pc_login' ?  rand(1000,9999) : rand(100000,999999);
        }

        if ($channel == 'pc_login') {
            $content = "尊敬的贵宾,您的验证码为:".$code."，请在验证界面填入后完成绑定。".date('Y/m/d H:i:s');
        } else if ($channel == 'pc_booking') {
            $content = "尊敬的贵宾,您的验证码为:".$code."，请在验证界面填入后完成绑定。".date('Y/m/d H:i:s');
        }

        $result = $this->arvato->sendMessage($mobile,$content);

        //记录发送日志
        $param = array(
            'channel' => $channel,
            'type' => 1,
            'mobile' => $mobile,
            'code' => $code,
            'content' => $content,
            'create_time' => date('Y-m-d H:i:s'),
            'back_json' => json_encode($result['data'])
        );
        if($result['code']){
            $param['status'] = 1;
        }
        $this->db->insert('sendmsg_log',$param);
        $insert_id = $this->db->insert_id();
        return $insert_id;

    }
}

