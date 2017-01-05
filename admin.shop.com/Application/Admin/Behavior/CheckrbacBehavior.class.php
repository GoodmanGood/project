<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 13:30
 */

namespace Admin\Behavior;


use Think\Behavior;

class CheckrbacBehavior extends Behavior
{
    public function run(&$parm){
        //当前url控制器和方法
        $currentRoute = MODULE_NAME. '/' .CONTROLLER_NAME . '/' .ACTION_NAME;

        if(in_array($currentRoute,C('NOTCHECK.ANY'))){
            return;
        }
            //判断是否登录
            $userInfo = session('login_info');
            if(!$userInfo){
                $rememberToken = cookie(md5('admin_remember_token'));
                if($rememberToken){

                    //存在的话  和数据库比对token值
                    $user= D('Admin')->where([
                            'token'=>$rememberToken
                        ]
                    )->find();
                    if($user){
                        //自动登录成功 存入session
                        session('login_info',$user);
                        //获取管理员权限
                        D('Admin')->_getPermissions();
                        //跳转到后台
                        redirect('Index/index');
                    }
                    }else{
                    //用户没有登录  调回到登录页面
                    redirect(U('Login/index'),3,'您尚未登录！请登录！');
                    return false;
                }
            }
            if($userInfo['admin_username'] == 'admin'){
                return;
            }
            //已登录用户都可以看到的页面
            if(in_array($currentRoute, C('NOTCHECK.USER'))){
                return;
            }
            //获取到该管理员所有的权限列表 然后给限制提示
            $permissions = session('PERMISSIONS');
            if(!in_array($currentRoute, $permissions)){
                echo '<script type="text/javascript">alert("抱歉！您无权访问此功能！");history.back();</script>';
                exit;
            }
        }

    }
