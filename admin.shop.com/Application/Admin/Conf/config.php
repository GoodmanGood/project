<?php
return array(
	//'配置项'=>'配置值'
    'URL_MODEL'             =>  2,


    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'admin_shop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  '',    // 数据库表前缀
    'DB_FIELDS_CACHE'       =>  false,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8

    'TMPL_PARSE_STRING' => [
        '__CSS__'       => '/Public/css',
        '__JS__'        => '/Public/js',
        '__IMG__'       => '/Public/images',
        '__FONTS__'     => '/Public/fonts',
        '__UPLOADIFY__' => '/Public/ext/uploadify',
        '__LAYER__' => '/Public/ext/layer',
        '__PUBLIC__' => '/Public',
        '__ZTREE__' => '/Public/ext/ztree',
    ],

    'UPLOAD_SETTING'    => [
        'URL_PREFIX' => 'http://admin.shop.com/',
        'SETTING'    => array(
            'mimes'        => array('image/jpeg', 'image/png', 'image/gif'), //允许上传的文件MiMe类型
            'maxSize'      => 0, //上传的文件大小限制 (0-不做限制)
            'exts'         => array('jpg', 'png', 'gif', 'jpeg', 'jpe'), //允许上传的文件后缀
            'autoSub'      => true, //自动子目录保存文件
            'subName'      => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath'     => './', //保存根路径
            'savePath'     => 'Uploads/', //保存路径
            'saveName'     => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
            'saveExt'      => '', //文件保存后缀，空则使用原后缀
            'replace'      => false, //存在同名是否覆盖
            'hash'         => true, //是否生成hash编码
            'callback'     => false, //检测文件是否存在回调，如果存在返回文件信息数组
            'driver'       => 'Qiniu', // 文件上传驱动
            'driverConfig' => array(
                'secretKey' => 'LjBxzQ5TGP-JdHl3BT3wijHWIY_q8g4oHVDr3_PC', //七牛密码
                'accessKey' => 'kQjxeMXytEQ6v2gc_OmKVn_vXoCAJSJOy1erNZF8', //七牛用户
                'domain'    => 'oidycnd9i.bkt.clouddn.com', //七牛服务器
                'bucket'    => 'shop', //空间名称
                'timeout'   => 300, //超时时间
            ), // 上传驱动配置
        ),
    ],
    'TOKEN_ON'      =>    true,  // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true
    'NOTCHECK' => [
        'ANY'=>[
            'Admin/Login/index',
            'Admin/Verify/index',
        ],
        'USER' =>[
            'Admin/Index/index',
            'Admin/Login/logout',
            'Admin/Menu/getAdminMeunList',
        ]
    ]
);