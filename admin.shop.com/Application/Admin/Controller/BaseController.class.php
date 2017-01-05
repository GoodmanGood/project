<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/29
 * Time: 21:54
 */

namespace Admin\Controller;




use Think\Controller;

class BaseController extends Controller
{
    //构造方法 给每个页面都提供菜单数据
    public function __construct(){
        parent::__construct();
        //获取菜单
        $menus = D('Menu')->getAdminMenuList();
//        dump($menus);exit;
        //将获取的菜单数据传输给页面展示
        $this->assign('nav_menus',$menus);
    }
}