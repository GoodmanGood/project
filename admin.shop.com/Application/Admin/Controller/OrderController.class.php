<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/6
 * Time: 16:17
 */

namespace Admin\Controller;


use Think\Controller;

class OrderController extends BaseController
{
    /**
     * 订单列表
     */
    public function index(){
        //搜索
        $where = [];
        if(!empty($_GET)){
            if($order_id = I('get.id')){
                $where['id'] = $order_id;
            }
            if($name = I('get.name')){
                $where['name'] = ['LIKE',"%$name%"];
            }
            if($tel = I('get.tel')){
                $where['tel'] = $tel;
            }
            if($status = I('get.status')){
                $where['status'] = $status;
            }
        }
        $res = D('Order')->getList($where);
//        dump($res);exit;
        $this->assign($res);
        $this->display();
    }
    /**
     * 发货
     */
    public function send($id){
        $res = M('Order')->where(['id'=>$id])->setField('status',4);
        if($res === false){
            $this->error('发货失败！请稍候再试！',U('index'));
        }else{
            $this->error('发货成功！',U('index'));
        }
    }
    /**
     * 取消订单
     */
    public function delete($id){
        //取消之后返回库存
        $res = D('Order')->setStock($id);
        if($res === false){
            $this->error(get_errors(D('Order')));
        }else{
            $this->error('取消成功！',U('index'));
        }
    }
    /**
     * 删除订单
     */
    public function remove($id){
        $res = M('Order')->where(['status'=>['in',[1,5]]])->delete($id);
        if($res === false){
            $this->error('删除失败！请稍候再试！',U('index'));
        }else{
            $this->error('删除成功！',U('index'));
        }
    }
}