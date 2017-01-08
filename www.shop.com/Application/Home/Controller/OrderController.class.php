<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/3
 * Time: 17:43
 */

namespace Home\Controller;


use Think\Controller;
use Wechat\Lib\Tools;

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
    public function pay($id){
        //获取订单信息
        $order = $this->model->where(['user_id'=>getUserId(),'status'=>2])->find($id);
        if(empty($order)){
            $this->error('此订单不存在！');
        }
        switch ($order['payment_id']){
            case 1:
                //微信支付
                $this->WxPay($order);
                break;
            case 2:
                //支付宝支付
                break;
            case 3:
                //银联支付
                break;
        }
    }
    /**
     * 微信支付
     */
    public function WxPay($order){
//        $this->model->saveStatus($order,3);
//        $this->success('付款成功！卖家将尽快发货！',U('User/ucenter'));
//        exit;
        vendor('wechat.include');
        $options = [
            'token'          => '', //填写你设定的token
            'appid'          => 'wx85adc8c943b8a477', //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret'      => '', //填写高级调用功能的密钥
            'encodingaeskey' => '', //填写加密用的EncodingAESKey（可选，传输加密时必需）
            'mch_id'         => '1228531002',  //微信支付，商户ID（可选）
            'partnerkey'     => 'a687728a72a825812d34f307b630097b',  //微信支付，密钥（可选）
            'ssl_cer'        => '', //微信支付，双向证书（可选，操作退款或打款时必需）
            'ssl_key'        => '' , //微信支付，双向证书（可选，操作退款或打款时必需）
            'cachepath'      => '', //设置SDK缓存目录（可选，默认在Wechat/Cache，需写权限）
        ];
        //向SDK注入配置参数
        \Wechat\Loader::config($options);
        //实例sdk相关操作对象
        $pay = new \Wechat\WechatPay();
        $code = $pay->getPrepayId(null,'神仙茶','1228531002'.$order['id'],1,U('Order/wxNotify',['id'=>$order['id']],true,true),'NATIVE');
//        ($order['price']+$order['delivery_price'])*100
        if(empty($code)){
            $this->assign('error',$pay->errMsg);
            $this->display('wx_error');
        }else{
            $code = base64_encode($code);
            $this->assign('order',$order);
            $this->assign('code',$code);
            $this->display('wxpay');
        }
    }
    /**
     * 支付通知处理
     */
    public function wxNotify($id){
        header('Content-Type:text/xml; charset=utf-8');
        $postStr = file_get_contents("php://input");
        $notifyInfo = (array) simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($notifyInfo['result_code'] == 'SUCCESS' && $notifyInfo['return_code'] == 'SUCCESS') {
            # 记录支付通知信息
            file_put_contents(LOG_PATH . 'pay_notify.log', var_export($notifyInfo, TRUE));
            //支付成功 改变订单状态
            M('Order')->where(['id'=>$id])->setField('status',3);
            # 所有操作成功，返回正常状态
            echo Tools::arr2xml(['return_code' => 'SUCCESS', 'return_msg' => 'SAVE DATA SUCCESS']);
        }
    }
    /**
     * 确认收货
     */
    public function orderTrue($id){
        $res = M('Order')->where(['id'=>$id])->setField('status',5);
        if($res === false){
            $this->error('确认失败！请稍候再试！',U('index'));
        }else{
            $this->error('确认收货成功！',U('User/ucenter'));
        }
    }
    /**
     * 清除超时的订单
     */
    public function clearTimeOutOrder(){
        while(true){
        $where = [
            'status'=>1,
            'create_time' => ['lt',NOW_TIME - 900],
        ];
        //取消返回库存
        $oids = M('Order')->where($where)->getField('id',true);
        if($oids){
            $goods = M('OrderDetail')->where(['order_id'=>['in',$oids]])->select();
            foreach ($goods as $good){
                M('Goods')->where(['id'=>$good['goods_id']])->setInc('stock',$good['amount']);
            }
            $conut = M('Order')->where($where)->setField('status',1);
            echo iconv('utf-8','gbk','取消了'.$conut.'个超时订单');
        }
        sleep(10);
        }
    }
}