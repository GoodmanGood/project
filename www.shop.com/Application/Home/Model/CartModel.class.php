<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 21:20
 */

namespace Home\Model;


use Think\Model;

class CartModel extends Model
{
    //购物车列表
    public function getCartList($cart,$goods_id){
        //在根据获取的数据中的商品id来查询相关联的商品的详细信息
        $cartList = M('Goods')->where(['id'=>['in',$goods_id],'is_on_sale'=>1,'status'=>1])->select();
//        dump($cartList);exit;
        //全部总价
        $total_price_all = 0;
        foreach($cartList as $key=>$value){
            //购买的总数量
            $value['amount'] = $cart[$value['id']];
            //商品的总价格
            $value['total_price'] += number_format($value['shop_price'] * $value['amount'],2,'.','');
            //全部商品的总价格
            $total_price_all += $value['total_price'];
            //传个商品信息的数组中
            $cartList[$key] = $value;
        }
        //number_format 价格结果转换成 .00的格式
        $total_price_all = number_format($total_price_all,2,'.','');
        $total_number = array_sum($cart);

        return [
            'total_price_all'=>$total_price_all,
            'total_number'=>$total_number,
            'cartLists'=>$cartList
        ];
    }
    /**
     * 清空购物车
     */
    public function clearCart(){
        return $this->where(['user_id'=>getUserId()])->delete();
    }
}