<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 12:39
 */

namespace Home\Model;


use Think\Model;

class LocationsModel extends Model
{
    /**
     * 获取三级联动数据
     * @param $id 父类id
     */
    public function getListByPid($pid){
        return $this->where(['parent_id'=>$pid])->select();
    }
}