<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 13:55
 */

namespace Home\Controller;


use Think\Controller;

class AddressController extends Controller
{
    /**
     * @var \Admin\Model\AddressModel
     */
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $this->model = D('Address');
    }
    /**
     * 删除地址
     * @param $id
     */
    public function deleteAddress($id){
        if($this->model->delete($id) === false){
            $this->error(get_errors($this->model));
        }
        $this->success('删除成功！',U('User/addAdress'));
    }
    /**
     * 设为默认
     * @param $id
     */
    public function setDefault($id){
        if($this->model->setDefault($id) === false){
            $this->error(get_errors($this->model));
        }
        $this->success('设置成功！',U('User/addAdress'));
    }
}