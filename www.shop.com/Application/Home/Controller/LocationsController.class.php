<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 12:46
 */

namespace Home\Controller;


use Think\Controller;

class LocationsController extends Controller
{
    /**
     * 获取三级联动数据
     * @param $id 父类id
     */
    public function getListByPid($pid){
        $lists = D('Locations')->getListByPid($pid);
        $this->ajaxReturn($lists);
    }
}