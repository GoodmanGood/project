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

/**
 * 发送短信
 * @param $tel
 * @param $data
 * @return array
 */
function sendSms($tel,$data) {
    vendor('alidayu.TopSdk');
    $c            = new \TopClient;
    $c->appkey    = C('SMS.AK');
    $c->secretKey = C('SMS.AS');
    $req          = new \AlibabaAliqinFcSmsNumSendRequest;
    $req->setExtend("");
    $req->setSmsType("normal");
    $req->setSmsFreeSignName(C('SMS.SIGN')); //短信签名
    $json         = json_encode($data); // 短信内容product code  json格式
    $req->setSmsParam($json);
    $req->setRecNum($tel); //接收者号码
    $req->setSmsTemplateCode(C('SMS.TEMPLATE')); //短信模板
    $resp         = $c->execute($req);
    if (isset($resp->result) && isset($resp->result->success)) {
        $data = [
            'status' => 1,
            'msg'    => '发送成功,请注意查收！',
        ];
    } else {
        $data = [
            'status' => 0,
            'msg'    => '发送失败！请稍后重试！',
        ];
    }
    return $data;
}

/**
 * 邮箱发送
 * @param $address
 * @param $subject
 * @param $content
 * @return array
 * @throws Exception
 * @throws phpmailerException
 */
function sendEms($address, $subject, $content) {
    vendor('PHPMailer.PHPMailerAutoload');

    $mail = new \PHPMailer;

    $mail->isSMTP();                                      // 设置邮件使用SMTP
    $mail->Host       = C('EMS.HOST');  // 指定SMTP服务器主备份
    $mail->SMTPAuth   = true;                               // 启用SMTP认证
    $mail->Username   = C('EMS.USERNAME');                 // 发送者
    $mail->Password   = C('EMS.PASSWORD');                 // 密码
    $mail->SMTPSecure = C('EMS.SECURE');                   //启用TLS加密，` SSL `也接受
    $mail->Port       = C('EMS.PORT');                     // TCP端口连接

    $mail->CharSet = 'UTF-8'; //设置编码  识别中文
    $mail->setFrom(C('EMS.USERNAME')); //发送者
    $mail->addAddress($address);     // 收件人 注册的邮箱地址
    $mail->isHTML(true);                                  // 设置邮件格式为HTML

    $mail->Subject = $subject; //标题
    $mail->Body    = $content; //内容

    /**
     * [
     *  status=>0|1
     *  msg=>成功,错误的原因
     * ]
     */
    if (!$mail->send()) {
        $data = [
            'status' => 0,
            'msg'    => $mail->ErrorInfo,
        ];
    } else {
        $data = [
            'status' => 1,
            'msg'    => '发送成功',
        ];
    }
    return $data;
}
function getUserId(){
//    dump(session('login_infoid'));exit;
    return session('login_info.id');
}