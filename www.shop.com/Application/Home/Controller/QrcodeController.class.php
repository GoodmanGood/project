<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/6
 * Time: 11:15
 */

namespace Home\Controller;


use Think\Controller;

class QrcodeController extends Controller
{
    /**
     * 生成二维码
     */
    public function index($code){
        $code = base64_decode($code);
        vendor('Qrcode.phpqrcode');
        \QRcode::png($code);
    }
}