<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Admin-X</title>
    <!--common-->
    <link rel="stylesheet" type="text/css" href="/Public/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link href="/Public/css/style.css" rel="stylesheet">
    <link href="/Public/css/page.css" rel="stylesheet">
    <link href="/Public/css/style-responsive.css" rel="stylesheet">
    <link href="/Public/ext/uploadify/common.css" rel="stylesheet">
    <!--<style>-->
        <!--.current{background-color:rgba(0,255,150,0.5);}-->
        <!--.prev,.num,.next,.current{width:auto;height:auto;margin:4px;padding:1px 2px;box-shadow:0 0 2px rgba(0,0,0,0.2);background-color:rgba(255,255,255,0.1);}-->
    <!--</style>-->
    
    <link rel="stylesheet" href="/Public/ext/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <style>
        #treeDemo{
            margin-top: 10px;
            border: 1px solid #617775;
            background: #f0f6e4;
            width: 220px;
            overflow-y: scroll;
            overflow-x: auto;
        }
    </style>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/Public/js/html5shiv.js"></script>
    <script src="/Public/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="index.html"><img src="/Public/images/logo.png" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="/Public/images/logo_icon.png" alt=""></a>
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="active"><a href="<?php echo U('Index/index');?>"><i class="fa fa-home"></i> <span>管理首页</span></a></li>
                <?php if(is_array($nav_menus)): foreach($nav_menus as $key=>$top_nav): if(($top_nav["level"]) == "1"): ?><li class="menu-list"><a href=""> <span><?php echo ($top_nav["menu_name"]); ?></span></a>
                            <ul class="sub-menu-list">
                                <?php if(is_array($nav_menus)): foreach($nav_menus as $key=>$sub_nav): if(($sub_nav["parent_id"]) == $top_nav["id"]): ?><li><a href="<?php echo U($sub_nav['path']);?>"> <?php echo ($sub_nav["menu_name"]); ?></a></li><?php endif; endforeach; endif; ?>
                            </ul>
                        </li><?php endif; endforeach; endif; ?>

            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->

    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--search start-->
            <form class="searchform" action="index.html" method="post">
                <input type="text" class="form-control" name="keyword" placeholder="搜索" />
            </form>
            <!--search end-->

            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <img src="/Public/images/photos/user-avatar.png" alt="" />
                            <?php echo ($_SESSION['login_info']['admin_username']); ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="<?php echo U('Admin/edit',['admin_id'=>$_SESSION['login_info']['admin_id']]);?>"><i class="fa fa-user"></i>  个人资料</a></li>
                            <li><a href="<?php echo U('Admin/update',['admin_id'=>$_SESSION['login_info']['admin_id']]);?>"><i class="fa fa-cog"></i>  修改密码</a></li>
                            <li><a href="<?php echo U('Login/logout',['admin_id'=>$_SESSION['login_info']['admin_id']]);?>"><i class="fa fa-sign-out"></i> 退出</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->

        
<div class="page-heading">
    <h3>
        设置管理员
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo U('Index/index');?>">管理后台</a>
        </li>
        <li class="active"> 设置管理员 </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<section class="wrapper">
    <!-- page start-->

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    设置管理员
                </header>
                <div class="panel-body">
                    <form role="form" action="<?php echo U();?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">用户名</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="admin_username" placeholder="请输入用户名">
                            <p><span>* 字母开头，允许5-16字节，允许字母数字下划线</span></p>
                        </div>

                        <div class="form-group">
                            <label>密码</label>
                            <input type="password" class="form-control" name="admin_password">
                            <p><span>* 以字母开头，长度在6~18之间，只能包含字母、数字和下划线</span></p>
                        </div>
                        <div class="form-group">
                            <label>确认密码</label>
                            <input type="password" class="form-control" name="re_password">
                            <p><span>* 两次密码必须一致</span></p>
                        </div>
                        <div class="form-group">
                            <label>邮箱</label>
                            <input type="email" class="form-control" name="admin_email">
                            <p><span>请输入正确的邮箱地址</span></p>
                        </div>
                        <div class="form-group">
                            <label for="">设置角色</label>
                            <div id="role-ids">
                            </div>
                            <ul id="treeDemo" class="ztree"></ul>
                        </div>

                        <button type="submit" class="btn btn-primary">提交新增</button>
                    </form>

                </div>
            </section>
        </div>
    </div>
</section>





        <!--footer section start-->
        <footer>
            2014 &copy; AdminEx by ThemeBucket
        </footer>
        <!--footer section end-->


    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="/Public/js/jquery-1.10.2.min.js"></script>
<script src="/Public/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/Public/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<script src="/Public/js/jquery.nicescroll.js"></script>
<script src="/Public/js/modernizr.min.js"></script>
<script src="/Public/js/scripts.js"></script>
<script src="/Public/ext/layer/layer.js"></script>
<script src="/Public/ext/uploadify/jquery.uploadify.min.js"></script>



<!--common scripts for all pages-->
<script type="text/javascript" src="/Public/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/Public/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/Public/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>


    <script type="text/javascript" src="/Public/ext/ztree/js/jquery.ztree.core.js"></script>
    <script type="text/javascript" src="/Public/ext/ztree/js/jquery.ztree.excheck.js"></script>
    <script type='text/javascript'>

        <!--
        var setting = {
            check: {
                enable: true
            },
            data: {
                key:{
                    name:'role_name',
                },
                simpleData: {
                    enable: true,
                    idKey:'role_id',
                }
            },
            callback:{
                onCheck:function(){
                    //获取所有节点
                    var node = ztreeObj.getCheckedNodes(true);
                    var role_node = $('#role-ids');
                    //清空选择值
                    role_node.empty();
                    $(node).each(function(i,v){
                        var id = v.role_id;
                        var html = '<input type="hidden" name="role_id[]" value="'+ id +'"/>';
                        $(html).appendTo(role_node);
                    });
                }
            }
        };

        var zNodes =<?php echo ($roles); ?>;

        var ztreeObj = $.fn.zTree.init($("#treeDemo"),setting,zNodes);
        ztreeObj.expandAll(true);



    </script>

</body>
</html>