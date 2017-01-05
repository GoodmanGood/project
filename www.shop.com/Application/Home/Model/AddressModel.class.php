<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 13:29
 */

namespace Home\Model;


use Think\Model;

class AddressModel extends Model
{
    protected $_auto =[
        ['user_id','getUserId',self::MODEL_INSERT,'function'],
    ];
    /**
     * 设为默认
     */
    public function setDefault($id){
        $this->where(['user_id'=>getUserId()])->setField('is_default',0);
        $this->where(['id'=>$id])->setField('is_default',1);
        return true;
    }
    /**
     * 添加地址
     */
    public function addAddress(){
        if($this->data['is_default'] == 1){
            $this->where(['user_id'=>getUserId()])->setField('is_default',0);
        }
        return $this->add();
    }
}