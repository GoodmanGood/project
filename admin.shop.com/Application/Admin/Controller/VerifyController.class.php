<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/6
 * Time: 12:02
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Verify;

class VerifyController extends Controller
{
    public function index(){
        $config = array(
            'useImgBg'  =>  false,           // ʹ�ñ���ͼƬ
            'fontSize'  =>  25,              // ��֤�������С(px)
            'useCurve'  =>  true,            // �Ƿ񻭻�������
            'useNoise'  =>  true,            // �Ƿ�����ӵ�
            'imageH'    =>  0,               // ��֤��ͼƬ�߶�
            'imageW'    =>  0,               // ��֤��ͼƬ���
            'length'    =>  4,               // ��֤��λ��
            'fontttf'   =>  '',              // ��֤�����壬�����������ȡ
            'bg'        =>  array(243, 251, 254),  // ������ɫ
            'codeSet'   =>  '1',
        );
        $verify = new Verify($config);
        //������֤��
        $verify->entry();
    }
}