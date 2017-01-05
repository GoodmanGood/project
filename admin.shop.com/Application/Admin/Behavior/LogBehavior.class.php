<?php
namespace Admin\Behavior;
use Think\Behavior;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 13:25
 */
class LogBehavior extends Behavior
{
    //µÇÂ¼ÈÕÖ¾
    public function run(&$parm){
        $data = array(
            'log_time' => NOW_TIME,
            'route' => MODULE_NAME.'_'.CONTROLLER_NAME.'_'.ACTION_NAME,
            'ip' => get_client_ip(),
//            'user_id' =>
        );
        $re = M('Log')->add($data);
        if(!$re){
            exit;
        }
    }
}