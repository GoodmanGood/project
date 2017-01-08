<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 18:30
 */

namespace Home\Model;


use Think\Cache\Driver\Redis;
use Think\Model;

class OrderModel extends Model
{
    // 自动完成定义
    protected $_auto = [
        ['create_time',NOW_TIME,1],
        ['user_id','getUserId',self::MODEL_INSERT,'function'],
        ['status',2]
    ];
    /**
     * 生成订单
     */
    public function createOrder(){
        //开启事务
        $this->startTrans();
        $addAdress_id = I('post.address_id');
        if(empty($addAdress_id)){
            $this->error = '收货地址不存在!';
            //事务回滚
            $this->rollback();
            return false;
        }
        $addAdress = D('Address')->where(['id'=>$addAdress_id,'user_id'=>getUserId()])->find();
        $data =[
            'user_id' =>$this->data['user_id'],
            'name' => $addAdress['name'],
            'province_name' => $addAdress['province_name'],
            'city_name' => $addAdress['city_name'],
            'area_name' => $addAdress['area_name'],
            'detail_address' => $addAdress['detail_address'],
            'tel' => $addAdress['tel'],
            'price' => $this->data['price'],
            'payment_id' => $this->data['payment_id'],
            'delivery_id' => 1,
            'delivery_name' => '超级快递',
            'delivery_price' => 0,
            'create_time' => $this->data['create_time'],
            'status' => $this->data['status']
        ];
        $payment_id = $this->data['payment_id'];
//        dump($payment_id);
//        exit;
        switch ($payment_id){
            case 1:
                $data['payment_name'] = '微信支付';
                break;
            case 2:
                $data['payment_name'] = '支付宝支付';
                break;
            case 3:
                $data['payment_name'] = '银联支付';
                break;
            case 4:
                $data['payment_name'] = '货到付款';
                break;
        }
//        dump($data);exit;
        //创建订单
        $oid = $this->add($data);
        if($oid === false){
            $this->error = '订单创建失败!请稍候再试！';
            //事务回滚
            $this->rollback();
            return false;
        }
        //订单信息 详情 就是购物车列表详情
        $cart= M('Cart')->where(['user_id'=>session('login_info.id')])->getField('goods_id,amount');
        $goods_id = array_keys($cart);
        $cart_detail =D('Cart')->getCartList($cart,$goods_id);
        $cart_lists = $cart_detail['cartLists'];
//        dump($cart_lists);exit;
        //判断库存
        $cond = [
            '_logic'=>'OR',
        ];
        foreach ($cart_lists as $good){
            $cond[] = [
                'id'=>$good['id'],
                'stock' =>['lt',$good['amount']],
            ];
        }
        $goods_model = D('Goods');
        $res = $goods_model->where($cond)->getField('id,goods_name');
        if(count($res)){
            $this->error = implode('、',$res).'库存不足!';
            //事务回滚
            $this->rollback();
            return false;
        };
        //扣除库存
        //创建订单详情
        $order_detail_model = D('OrderDetail');
        $data = [];
        foreach ($cart_lists as $good){
            $stock = $goods_model->where(['id'=>$good['id']])->setDec('stock',$good['amount']);
            if($stock === false){
                $this->error = '扣除库存失败!请稍候再试！';
                //事务回滚
                $this->rollback();
                return false;
            }
            $data[] = [
                'order_id' => $oid,
                'goods_id' => $good['id'],
                'goods_name' => $good['goods_name'],
                'goods_price' => $good['shop_price'],
                'amount' => $good['amount'],
                'logo' => $good['goods_logo'],
                'sub_total' => $good['total_price']
            ];
        }
        $order_detail_model->addAll($data);
        //清空购物车
        $rst = D('Cart')->clearCart();
        if($rst === false){
            $this->error = '清空购物车失败!请稍候再试！';
            //事务回滚
            $this->rollback();
            return false;
        }
        //提交事务
        $this->commit();
    }

    /**
     * 用户个人订单列表数据
     */
    public function getOrderList(){
        //查询该用户所有的订单信息
        $orders = $this->where(['user_id'=>getUserId()])->order('id desc')->getField('id,create_time,status,price,delivery_price');
        $oids = array_keys($orders);
        if(empty($oids)){
            return false;
        }
        //订单详情
        $order_detail = M('OrderDetail')->where(['order_id'=>['in',$oids]])->select();
        foreach($order_detail as $detail){
            $orders[$detail['order_id']]['goods_list'][]=$detail;
            //实际付款 总价格+运费
            $total_price = $orders[$detail['order_id']]['price'] + $orders[$detail['order_id']]['delivery_price'];
            $orders[$detail['order_id']]['total_price'] = number_format($total_price,2,'.','');
        }
        return $orders;
    }
    /**
     * 修改订单状态
     */
    public function saveStatus($order,$num){
        $this->where(['id'=>$order['id']])->setField('status',$num);
    }
}