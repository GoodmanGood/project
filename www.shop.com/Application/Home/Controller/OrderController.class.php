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
     * @var \Admin\Model\OrderModel
     */
    private $model;
    /**
     * 初始化操作
     * 实例化模型对象
     * 给所有视图传递变量
     */
    protected function _initialize(){
        $this->model = D('Order');
    }
    /**
     * 创建订单
     */
    public function create()
    {
        if (IS_POST) {
           if(!$this->model->create()){
               $this->error(get_errors($this->model));
           }
           if($this->model->createOrder() === false){
                $this->error(get_errors($this->model));
            }
           $this->success('订单生成成功！',U('User/ucenter'));

        } else {
            //登录后的数据要从数据库中获取
            $where = ['user_id' => session('login_info.id')];
            $cart = M('Cart')->where($where)->getField('goods_id,amount');
            $goods_id = array_keys($cart);
            //传输数据
            $this->assign(D('Cart')->getCartList($cart,$goods_id));
            //读取用户所有地址信息展示
            $addAdress = D('Address');
            $this->assign('addresses',$addAdress->where(['user_id'=>getUserId()])->order('id desc')->select());
//            dump();exit;
            $this->display();
        }
    }
    /**
     * 支付
     */
    public function pay(){
        //获取订单信息
        $order = $this->model->where(['user_id'=>getUserId(),'status'=>1])->find();
        if(empty($order)){
            $this->error('此订单不存在！');
        }
        switch ($order['payment_id']){
            case 1:
                redirect('WeixinPay/index');
                //微信支付
                break;
            case 2:
                //支付宝支付
                break;
            case 3:
                //银联支付
                break;
        }
    }
}