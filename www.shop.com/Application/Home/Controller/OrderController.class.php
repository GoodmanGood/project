<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/3
 * Time: 17:43
 */

namespace Home\Controller;


use Think\Controller;

class OrderController extends  Controller
{
    /**
     * 创建订单
     */
    public function create()
    {
        if (IS_POST) {

        } else {
            //登录后的数据要从数据库中获取
            $where = ['user_id' => session('login_info.id')];
            $cart = M('Cart')->where($where)->getField('goods_id,amount');
            $goods_id = array_keys($cart);
            //在根据获取的数据中的商品id来查询相关联的商品的详细信息
            $cartList = M('Goods')->where(['id' => ['in', $goods_id], 'is_on_sale' => 1, 'status' => 1])->select();
//        dump($cartList);exit;
            //全部总价
            $total_price_all = 0;
            foreach ($cartList as $key => $value) {
                //购买的总数量
                $value['amount'] = $cart[$value['id']];
                //商品的总价格
                $value['total_price'] += number_format($value['shop_price'] * $value['amount'], 2, '.', '');
                //全部商品的总价格
                $total_price_all += $value['total_price'];
                //传个商品信息的数组中
                $cartList[$key] = $value;
            }
            //number_format 价格结果转换成 .00的格式
            $total_price_all = number_format($total_price_all, 2, '.', '');
            $total_number = array_sum($cart);
//        dump($value);exit;
            //传输数据
            $this->assign('total_price_all', $total_price_all);
            $this->assign('total_number', $total_number);
            $this->assign('cartLists', $cartList);
            //读取用户所有地址信息展示
            $addAdress = D('Address');
//            $this->assign('address',$addAdress->where(['user_id'=>getUserId(),'is_default'=>1])->find());
            $this->assign('addresses',$addAdress->where(['user_id'=>getUserId()])->order('id desc')->limit(3)->select());
            $this->display();
        }
    }
}