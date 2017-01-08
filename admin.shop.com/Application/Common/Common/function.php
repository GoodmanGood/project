<?php
header('Content-Type:text/html;charset=utf8');

/**
 * 将所有错误提示接收为一个数组 然后拼接成字符串后返回
 * @param \Think\Model $model 模型对象
 * @return string 返回错误信息
 */
function get_errors(\Think\Model $model){
    //接收错误信息
    $errors = $model->getError();
    //判断是否是一个数组  如不是则转换为数组
    if(!is_array($errors)){
        $errors = [$errors];
    }
//    var_dump($errors);exit;
    //将数组拼接成字符串返回
    $html ='<ol>';
    foreach($errors as $error){
        $html .= "<li>".$error."</li>";
    }
    $html .= '</ol>';
    return $html;
}
