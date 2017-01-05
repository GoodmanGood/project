<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/6
 * Time: 12:02
 */

namespace Home\Controller;


use Think\Controller;
use Think\Verify;

class VerifyController extends Controller
{
    public function index(){
        $config = array(
            'useImgBg'  =>  false,
            'fontSize'  =>  25,
            'useCurve'  =>  true,
            'useNoise'  =>  true,
            'imageH'    =>  50,
            'imageW'    =>  175,
            'length'    =>  4,
            'fontttf'   =>  '',
            'bg'        =>  array(243, 251, 254),
            'codeSet'   =>  '1',

        );
        $verify = new Verify($config);
        $verify->entry();
    }
}