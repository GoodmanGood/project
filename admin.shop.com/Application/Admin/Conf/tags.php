<?php
header('Content-Type:text/html;charset=utf8');
return array(
    'view_filter' => array('Behavior\TokenBuildBehavior'),
    // '��ǩλ' => array(��Ϊ1, ��Ϊ2),
    'action_begin' => array('Admin\Behavior\LogBehavior','Admin\Behavior\CheckrbacBehavior'),

    'app_begin' => array('Behavior\CheckLangBehavior'),
);