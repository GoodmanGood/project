<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/3
 * Time: 10:56
 */

namespace Home\Controller;


use Think\Controller;

class CartController extends Controller
{
    /**
     * 添加购物车
     * @param $goods_id 商品id
     * @param $amount 商品数量
     * 判断是否登录 登录存到购物车数据库，未登录就存到cookie
     * 然后先判断是否有此商品 有则修改数量 没有直接添加
     *
     */
   public function add2cart($goods_id,$amount){
//       dump($goods_id);exit;
       if(session('login_info')){
            //判断购物车中是否有此商品
           $where = ['goods_id'=>$goods_id,'user_id'=>session('login_info.id')];
           $count = M('Cart')->where($where)->count();
           if($count){
               M('Cart')->where($where)->setInc('amount',$amount);
           }else{
                $data = [
                    'goods_id' => $goods_id,
                    'amount' => $amount,
                    'user_id' => session('login_info.id'),
                ];
               M('Cart')->add($data);
           }
           $this->success('添加成功！',U('Cart/cartList'));
       }else{
           //判断cookie中是否有此商品
           $cart = cookie('cart');
           if($cart[$goods_id]){
               $cart[$goods_id] += $amount;
           }else{
               $cart[$goods_id] = $amount;
           }
//           dump($cart);exit;
           cookie('cart',$cart,604800);
           $this->success('添加成功！',U('Cart/cartList'));
       }
   }

    /**
     * 购物车列表
     */
    public function cartList(){
        //判断是都登录
        if(session('login_info')){
            //登录后的数据要从数据库中获取
            $where = ['user_id'=>session('login_info.id')];
            $cart= M('Cart')->where($where)->getField('goods_id,amount');
            $goods_id = array_keys($cart);
        }else{
            //没有登录时从cookie中获取购物车数据
            $cart = cookie('cart');
            $goods_id = array_keys($cart);
        }
        if(empty($goods_id)){
            $this->assign('msg','您的购物车什么都没有！');
        }else{
            //传输数据
            $this->assign(D('Cart')->getCartList($cart,$goods_id));
        }

        //加载视图
        $this->display();
    }
    /**
     * 从购物车中移除商品
     */
    public function remove($id){
        if(session('login_info')){
            if(!M('cart')->where(['goods_id'=>$id])->delete()){
                $this->error('移除失败！',U('Cart/cartList'));
            }
            $this->success('移除成功！',U('Cart/cartList'));
        }else{
            $cart = cookie('cart');
            unset($cart[$id]);
            cookie('cart',$cart,604800);

            $this->success('移除成功！',U('Cart/cartList'));
        }
    }
}