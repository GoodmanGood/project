<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/18
 * Time: 23:01
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadController extends Controller
{
    //上传
    public function upload(){
        //读取配置文件
        $config = C('UPLOAD_SETTING.SETTING');
        //实例化图片上传类
        $upload = new Upload($config);
        //调用上传方法
        $fileInfo = $upload->upload();
        //取数组最后一个值
        $fileInfo = array_pop($fileInfo);
        if ($fileInfo) {
            //上传成功,返回文件路径
            if (strnatcasecmp($upload->driver, 'qiniu') == 0) {
                $url = $fileInfo['url'];
            } else {
                $url = C('UPLOAD_SETTING.URL_PREFIX') . $fileInfo['savepath'] . $fileInfo['savename'];
            }
            $data = [
                'status' => 1,
                'msg'    => 'logo上传成功',
                'url'    => $url,
            ];
        } else {
            //上传失败,返回错误原因
            $data = [
                'status' => 0,
                'msg'    => $upload->getError(),
                'url'    => '',
            ];
        }
        $this->ajaxReturn($data);

    }

}