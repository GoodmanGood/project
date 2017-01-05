<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/31
 * Time: 12:32
 */

namespace Home\Controller;


use Org\Util\String;
use Think\Controller;
use Think\Verify;

class UserController extends Controller
{
    /**
     * @var \Admin\Model\UserModel
     */
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $this->model = D('User');
    }

    /**
     * 注册
     */
    public function reg(){
        if(IS_POST){
            if($this->model->create() === false){
                $this->error(get_errors($this->model));
            }
            if($this->model->regUser() === false){
                $this->error(get_errors($this->model));
            }
            $this->success('注册成功！',U('User/login'));
        }else{
            $this->display();
        }
    }
    /**
     * 验证验证码 发送短信
     */
    public function send_sms($tel,$verify){
        //验证验证码
        $cap = new Verify();
        if(!$cap->check($verify)){
            $data = [
                'status' => 0,
                'msg' => '请输入正确的验证码！'
            ];
        }else{
            $re = [
               'product' => '神仙茶',
                'code' => String::randNumber(100000,999999),
            ];
            //先查询数据库中是否有此号码，没有就添加数据，有则还要判断此号码的第一次发送时间是否大于5分钟
            //大于则重新生成验证码，没有则调用数据库中的验证码再次发给用户；
            $tel_info = M('TelCode')->where(['tel'=>$tel])->find();
            if(!$tel_info){
                $tel_code = [
                    'tel' => $tel,
                    'code' => $re['code'],
                    'send_time' => NOW_TIME,
                ];
                M('TelCode')->add($tel_code);
            }else{
                if(NOW_TIME < (300 + $tel_info['send_time'])){
                    $re['code'] = $tel_info['code'];
                }else{
                    $tel_code = [
                        'id' => $tel_info['id'],
                        'code' => $re['code'],
                        'send_time' => NOW_TIME,
                    ];
                    M('TelCode')->save($tel_code);
                }
            }
            session('tel_code',$re['code']);
            $data = sendSms($tel,$re);
        }
        $this->ajaxReturn($data);
    }

    /**
     * 激活账号
     */
    public function active($email,$token){
        //接收并拼接where条件
        $where = [
            'email' => $email,
            'email_token' => $token,
            'status' => 0,
        ];
        //改变状态
        if($this->model->where($where)->setField('status',1)){
            $this->success('账号激活成功，即将跳转到登录页面',U('User/login'));
        }else{
            $this->error('激活失败！',U('Index/index'));
        }
    }
    /**
     * 登录
     */
    public function login()
    {
        //判断是否记住我  实现自动登录
        //从cookie中取出值
        $rememberToken = cookie(md5('user_remember_token'));
        if ($rememberToken) {
            //存在的话  和数据库比对token值
            $user = $this->model->where([
                    'token' => $rememberToken
                ]
            )->find();
            if ($user) {
                //自动登录成功 存入session
                session('login_info', $user);
                //跳转到首页
                $this->redirect('Index/index');
            }
        }

        if (IS_POST) {
                $data = I('post.');
                if (!$data) {
                    $this->error(get_errors($this->model));
                    exit;
                }
                if($this->model->checkLogin() === false){
                    $this->error(get_errors($this->model));
                }
                $url = substr(cookie('url'),0,-5);
                if($url){
                    cookie('url',null);
                }else{
                    $url = 'Index/index';
                }
                //如果cookie中有商品就将cookie中的商品存入数据库
                if(cookie('cart')){
                    $this->model->addCookieGood();
                    cookie('cart',null);
                }
                $this->success('登录成功！', U($url));
        } else {
            $this->display();
        }
    }
    /**
     * 注销
     */
    public function logout(){
        if(!empty($admin_id)){
            $this->error('亲！不能这样退出额！');
        }
        session('login_info',null);
        cookie(md5('user_remember_token'),null);
        $this->model->save([
            'id' =>I('get.id'),
            'token' => '',
            'token_create_time' => 0,
        ]);
        $this->success('退出成功！',U('Index/index'));
    }
    /**
     * 收货地址管理
     */
    public function addAdress(){
        if(IS_POST){
            $addAdress = D('Address');
            if($addAdress->create() === false){
                $this->error(get_errors($this->model));
            }
            if($addAdress->addAddress() === false){
                $this->error(get_errors($this->model));
            }
            $this->success('添加成功！',U('User/addAdress'));
        }else{
            //读取用户所有地址信息展示
            $addAdress = D('Address');
            $this->assign('addresses',$addAdress->where(['user_id'=>getUserId()])->select());
            //读取所有省份 城市 区域 数据
            $provinces = D('Locations')->getListByPid(0);
            $this->assign('provinces',$provinces);
            $this->display();
        }
    }
    /**
     * 编辑地址
     * @param $id
     */
    public function editAddress($id){
        if(IS_POST){
            $addAdress = D('Address');
            if($addAdress->create() === false){
                $this->error(get_errors($this->model));
            }
            if($addAdress->save() === false){
                $this->error(get_errors($this->model));
            }
            $this->success('编辑成功！',U('User/addAdress'));
        }else{
            //读取用户所有地址信息展示
            $addAdress = D('Address');
            $this->assign('addresses',$addAdress->where(['user_id'=>getUserId()])->select());
            //读取所有省份 城市 区域 数据
            $provinces = D('Locations')->getListByPid(0);
            $this->assign('provinces',$provinces);
            $this->assign('list',D('Address')->find($id));
//            dump(D('Address')->find($id));die;
            $this->display('addAdress');
        }
    }
    /**
     * 用户个人订单列表
     */
    public function ucenter(){
        $orderList = D('Order')->getOrderList();
//        dump($orderList);exit;
        $this->assign('orders',$orderList);
        $this->display();
    }
}