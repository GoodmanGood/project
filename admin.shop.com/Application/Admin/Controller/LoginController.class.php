<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/23
 * Time: 16:41
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Verify;

class LoginController extends  Controller
{

    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $this->model = D('Admin');
    }
    //登录首页
    public function index(){

        //判断是否记住我  实现自动登录
        //从cookie中取出值
        $rememberToken = cookie(md5('admin_remember_token'));
        if($rememberToken){
            //存在的话  和数据库比对token值
            $user= $this->model->where([
                    'token'=>$rememberToken
                ]
            )->find();
            if($user){
                //自动登录成功 存入session
                session('login_info',$user);
                //跳转到后台
                $this->redirect('Index/index');
            }
        }
        if(IS_POST){
//            var_dump($this->model->data());exit;
            //验证验证码
            $verify = new Verify();
            if($verify->check(I('post.cpatcha'))){
                $data = I('post.');
                if(!$data){
                    $this->error(get_errors($this->model));
                    exit;
                }
                //验证用户名
                $user = $this->model->where(
                    ['admin_username'=>I('post.admin_username')]
                )->find();
//                var_dump($user);exit;
                if(!$user){
                    $this->error('用户名或密码错误！');
                    exit;
                }
//                var_dump(I('post.admin_password'));exit;
                //验证密码
                $pwd = md5(md5(I('post.admin_password')).$user['admin_salt']);
                if($pwd != $user['admin_password']){
                    $this->error('用户名或密码错误！');
                    exit;
                }
                session('login_info',$user);
                //获取管理员权限
                $this->model->_getPermissions();
                $data = [
                    'admin_id' => $user['admin_id'],
                  'last_login_time' => NOW_TIME,
                    'last_login_ip' => ip2long(get_client_ip()),
                ];
                if($this->model->save($data) === false){
                    $this->error(get_errors($this->model));
                }
                //判断是否勾选记住密码
                if(I('post.rememberMe',0) == 1){
                    //勾选了
                    $token = md5(microtime() .'@!#$%^&*('. rand(0, 1000000));
                    $data1 = [
                        'admin_id' => $user['admin_id'],
                        'token' => $token,
                        'token_create_time' => NOW_TIME,
                    ];
                    $this->model->save($data1);
                    // 在COOKIE中也保存一个TOKEN
                    cookie(md5('admin_remember_token'), $token, 7*24*3600);
                }
                $this->success('登录成功！',U('Index/index'));
            }else{
                $this->error('验证码输入错误！');
            }

        }else{
            $this->display();
        }
    }

    /**
     * 注销
     */
    public function logout(){
//        var_dump();exit;
        if(!empty($admin_id)){
            $this->error('亲！不能这样退出额！');
        }
        session('login_info',null);
        cookie(md5('admin_remember_token'),null);
        $this->model->save([
            'admin_id' =>I('get.admin_id'),
            'token' => '',
            'token_create_time' => 0,
        ]);
        $this->success('注销成功！',U('index'));
    }

}