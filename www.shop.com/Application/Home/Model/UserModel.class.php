<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/31
 * Time: 13:11
 */
namespace Home\Model;
use Org\Util\String;
use \Think\Model;

class UserModel extends Model
{
    //开启批处理验证
    protected $patchValidate = true;
    //验证
    protected $_validate = [
        ['username','require','用户名不能为空！'],
        ['real_name','require','姓名不能为空！'],
        ['birth','require','生日不能为空！'],
        ['tel','require','手机号码不能为空！'],
        ['tel','/^1[345678]\d{9}$/','手机号码格式不正确！',1,'regex',3],
        ['password','require','密码不能为空！',0],
        ['password','6,16','密码长度不符合格式!',1,'length',3],
        ['username','','用户名已存在!',1,'unique'],
        ['tel','','该手机号码已被注册!',1,'unique'],
        ['email','','该邮箱已被注册!',1,'unique'],
        ['repassword','password','两次密码不一致!',0,'confirm',3],
        ['email','email','邮箱格式不正确!',0],
        ['tel_code', 'checkTelCode', '手机验证码不匹配', self::MUST_VALIDATE, 'callback'],
    ];
    // 自动完成定义
    protected $_auto = array(
        ['create_time',NOW_TIME,1],
        ['salt','salt',3,'callback'],
        ['status',0]
    );

    //盐
    public function salt(){
        return $salt = substr(base64_encode(mcrypt_create_iv(32,MCRYPT_DEV_RANDOM)),0,6);
    }
    //注册
    public function regUser(){
        //加盐加密
        $this->data['password'] = md5(md5($this->data['password']).$this->data['salt']);
        //收件人邮箱地址
        $address = $this->data['email'];
        //标题
        $subject = '欢迎注册神仙茶的会员';
        //邮箱令牌
        $token = String::randString(32);
        //激活地址
        $url = U('User/active',['email' => $address,'token'=>$token],true,true);
        //邮箱内容
        $content = '<a href="'.$url.'">'.$url.'点击激活账号</a>';
        //将邮箱令牌存入数据库
        $this->data['email_token'] = $token;
        //调用发送邮件发法
        sendEms($address,$subject,$content);
        //注册
        $data = $this->data;
        if(($id = $this->add($data)) === false){
            $this->error = '注册失败！';
            return false;
        }else{
            return $id;
        }
    }
    /**
     * 验证手机验证码
     */
    public function checkTelCode($in_code){
        $tel_code = session('tel_code');
        session('tel_code',null);
        return $in_code == $tel_code;
    }
    /**
     * 验证登录
     */
    public function checkLogin(){
        //验证用户名
        $user = $this->where(
            ['username' => I('post.username')]
        )->find();
        if (!$user) {
            $this->error ='用户名或密码错误！';
            return false;
        }
        if($user['status'] == 0){
            $this->error ='亲，您的账号尚未激活！';
            return false;
        }
        //验证密码
        $pwd = md5(md5(I('post.password')) . $user['salt']);
        if ($pwd != $user['password']) {
            $this->error ='用户名或密码错误！';
            return false;
        }
        session('login_info', $user);
        $data = [
            'id' => $user['id'],
            'last_login_time' => NOW_TIME,
            'last_login_ip' => get_client_ip(),
        ];
        if ($this->save($data) === false) {
            $this->error(get_errors(D('User')));
        }
        //判断是否勾选记住密码
        if (I('post.rememberMe', 0) == 1) {
            //勾选了
            $token = md5(microtime() . '@!#$%^&*(' . rand(0, 1000000));
            $data1 = [
                'id' => $user['id'],
                'token' => $token,
                'token_create_time' => NOW_TIME,
            ];
            $this->save($data1);
            // 在COOKIE中也保存一个TOKEN
            cookie(md5('user_remember_token'), $token, 7 * 24 * 3600);
        }
        return true;
    }

    /**
     * 将cookie中的商品存入数据库
     */
    public function addCookieGood(){
        $cart = cookie('cart');
        foreach($cart as $key=>$value){
            //判断购物车中是否有此商品
            $where = ['goods_id'=>$key,'user_id'=>session('login_info.id')];
            $count = M('Cart')->where($where)->count();
            if($count){
                M('Cart')->where($where)->setField('amount',$value);
            }else{
                $data = [
                    'goods_id' => $key,
                    'amount' => $value,
                    'user_id' => session('login_info.id'),
                ];
                M('Cart')->add($data);
            }
        }
    }
    /**
     * 修改密码
     */
    public function editPassword(){
        $user = $this->where(['id'=>getUserId()])->find();
        if (!$user) {
            $this->error ='非法操作！该用户不存在！';
            return false;
        }
        //验证旧密码
        $pwd = md5(md5(I('post.old_password')) . $user['salt']);
        if ($pwd != $user['password']) {
            $this->error ='旧密码错误！';
            return false;
        }
        //修改新密码
        $password = I('post.password');
        $repassword = I('post.repassword');
        if($password != $repassword){
            $this->error ='确认密码不一致！';
            return false;
        }
        //新密码加盐加密
        $salt = $this->salt();
        $password = md5(md5($password) . $salt);
        $data = [
            'id'=>getUserId(),
            'password' => $password,
            'salt' => $salt
        ];
        $res = $this->save($data);
        if($res === false){
            $this->error ='密码修改失败！请稍候再试！';
            return false;
        }
        return $res;
    }
}