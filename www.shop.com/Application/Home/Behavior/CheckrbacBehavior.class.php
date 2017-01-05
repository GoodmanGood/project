<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 13:30
 */

namespace Home\Behavior;


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
                $rememberToken = cookie(md5('user_remember_token'));
                if($rememberToken){

                    //存在的话  和数据库比对token值
                    $user= D('User')->where([
                            'token'=>$rememberToken
                        ]
                    )->find();
                    if($user){
                        //自动登录成功 存入session
                        session('login_info',$user);
                        //跳转到后台
                        redirect('Index/index');
                    }
                }else{
                    cookie('url',__SELF__);
                    //用户没有登录  调回到登录页面
                    redirect(U('User/login'),3,'您尚未登录！请登录！');
                    return false;
                }
            }

        }

    }
