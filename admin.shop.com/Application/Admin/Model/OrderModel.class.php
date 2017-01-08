<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/6
 * Time: 16:21
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class OrderModel extends Model
{
    /**
     * 查询全部订单 分页 搜索
     */
    public function getList($where){
        $orders = $this->where($where)->order('id desc')->page(I('get.p', 1), 2)->select();
//        dump($orders);exit;
        $count = $this->where($where)->count();
        $page = new Page($count,2);
        return [
            'orders'=>$orders,
            'pages'=>$page->show(),
        ];
    }
    /**
     * 返回库存
     */
    public function setStock($id){
        //开启事务
        $this->startTrans();
        $res = M('Order')->where(['id'=>$id])->setField('status',1);
        if($res === false){
            $this->error = '取消订单失败!';
            //事务回滚
            $this->rollback();
            return false;
        }
        //订单信息 详情
        $cart= M('OrderDetail')->where(['order_id'=>$id])->getField('goods_id,amount');
        $goods_id = array_keys($cart);
        $cart_detail =$this->getOrderList($cart,$goods_id);
        $cart_lists = $cart_detail['cartLists'];
//        dump($cart_lists);exit;
        foreach ($cart_lists as $good){
            $stock = M('Goods')->where(['id'=>$good['id']])->setInc('stock',$good['amount']);
            if($stock === false){
                $this->error = '返回库存失败!请稍候再试！';
                //事务回滚
                $this->rollback();
                return false;
            }
        }
        //提交事务
        $this->commit();
    }
    /**
     * 查询订单详情
     */
    public function getOrderList($cart,$goods_id){
        //在根据获取的数据中的商品id来查询相关联的商品的详细信息
        $cartList = M('Goods')->where(['id'=>['in',$goods_id],'is_on_sale'=>1,'status'=>1])->select();
        foreach($cartList as $key=>$value){
            //购买的总数量
            $value['amount'] = $cart[$value['id']];
            //传个商品信息的数组中
            $cartList[$key] = $value;
        }
        return [
            'cartLists'=>$cartList
        ];
    }
}