<?php
header('Content-Type:text/html;charset=utf8');
return array(
    'view_filter' => array('Behavior\TokenBuildBehavior'),
    // '标签位' => array(行为1, 行为2),
    'action_begin' => array('Admin\Behavior\LogBehavior','Admin\Behavior\CheckrbacBehavior'),

    'app_begin' => array('Behavior\CheckLangBehavior'),
);