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
                <li class=""><a href="<?php echo U('Index/index');?>"> <span>管理首页</span></a></li>
                <?php if(is_array($nav_menus)): foreach($nav_menus as $key=>$p_nav): if(($p_nav["level"]) == "1"): ?><li class="menu-list nav_active"><a href=""> <span><?php echo ($p_nav["menu_name"]); ?></span></a>
                            <ul class="sub-menu-list">
                                <?php if(is_array($nav_menus)): foreach($nav_menus as $key=>$s_nav): if(($s_nav["parent_id"]) == $p_nav["id"]): ?><li><a href="<?php echo U($s_nav['path']);?>"> <?php echo ($s_nav["menu_name"]); ?></a></li><?php endif; endforeach; endif; ?>
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

        
                <!-- page heading start-->
                <div class="page-heading">
                    <h3>
                        <?php echo ($title); ?>
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?php echo U('Index/index');?>">管理后台</a>
                        </li>
                        <li class="active"> <?php echo ($title); ?> </li>
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
                                    添加品牌
                                </header>
                                <div class="panel-body">
                                    <form role="form" action="<?php echo U('add');?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputName">品牌名称</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="请输入品牌名称" value='<?php echo ($row["name"]); ?>'/>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputIntro">品牌描述</label>
                                            <textarea class="form-control " id="exampleInputIntro" name="intro" placeholder="请输入品牌简介"><?php echo ($row["intro"]); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputSort">排序</label>
                                            <input class=" form-control" id="exampleInputSort" name="sort" type="text"  placeholder="请输入排序数字,数字越小越靠前"  value='<?php echo ($row["sort"]); ?>'/>
                                        </div>
                                        <div class="form-group">
                                            <label for="logo-upload">LOGO</label>
                                            <input type="file" id="logo-upload">
                                            <input type="hidden" name="logo" id="logo" value="/Public/images/good.jpg"/><br/>
                                            <img src="" id="logo-preview" style="max-width: 100px;max-height: 100px"/>
                                        </div>
                                        品牌状态
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="status" value="1" id='status'> 显示
                                            </label>
                                        </div>
                                        <?php if(isset($row)): ?><input type="hidden" name="brand_id" value="<?php echo ($row["brand_id"]); ?>" /><?php endif; ?>
                                        <button type="submit" class="btn btn-primary"> 添加 </button>
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


        <script type='text/javascript'>
            $(function () {
                //默认选中显示
                $('#status').prop('checked', <?php echo ((isset($row["status "]) && ($row["status "] !== ""))?($row["status "]): 1); ?>);
                //初始化一个uploadify控件
                $("#logo-upload").uploadify({
                    height: 30,
                    swf: '/Public/ext/uploadify/uploadify.swf',
                    uploader: '<?php echo U("Upload/upload");?>',
                    width: 120,
                    buttonText:'选择logo文件',
                    fileTypeExts:'*.jpg;*.jpeg;*.jpe;*.png;*.gif',
                    onUploadSuccess:function(file,data){
                        //将响应字符串转换为json对象
                        data = $.parseJSON(data);
                        if(data.status){
                            //成功了
                            $('#logo').val(data.url);
                            $('#logo-preview').attr('src',data.url);
                            layer.msg(data.msg);
                        }else{
                            layer.msg(data.msg);
                        }
                    },
                });
            });
        </script>
        
</body>
</html>