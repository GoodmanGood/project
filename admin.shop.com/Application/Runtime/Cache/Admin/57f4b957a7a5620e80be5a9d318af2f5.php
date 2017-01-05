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

        
<div class="page-heading">
    <h3>
        商品相册
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo U('Index/index');?>">管理后台</a>
        </li>
        <li> <a href="<?php echo U('Goods/index');?>">商品管理</a> </li>
        <li class="active"> 商品相册 </li>
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
                    商品相册
                </header>
                <div class="panel-body">
                    <form role="form" action="<?php echo U();?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>商品相册（最多可同时上传五张图片）</label>
                            <div class="file-box">
                                <div id="divPreview">

                                </div>
                                <input type="file" name="file" class="file" id="fileField"  />
                            </div>
                        </div>
                        <input type="hidden" name="goods_id" value="<?php echo ($id); ?>"/>
                        <button type="submit" class="btn btn-primary">上传相册</button>
                    </form>
                    <div class="row imgBox">
                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><div style="float: left;">
                                <div>
                                    <img src="<?php echo ($img["gallery_path"]); ?>" alt="..."  style="width: 200px; height: 200px"">
                                </div>

                                <div class="caption">
                                    <p><a data-href="<?php echo U('pic_delete', array('article_id' => $img.gallery_id));?>" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs deleteBtn" id="">删除</a>
                                        <input type="hidden" name="gallery_id" value="<?php echo ($img["gallery_id"]); ?>"/></p>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
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


    <script>
        $(function(){
        //初始化一个uploadify控件 相册
        $("#fileField").uploadify({
            'height'        : 30,
            'swf'       : '/Public/ext/uploadify/uploadify.swf',
            'uploader'      :'<?php echo U("Upload/upload");?>',
            'width'         : 120,
            'onUploadSuccess' : function(file, data, response) {
                data = $.parseJSON(data);
                if(!data.status){
                    layer.msg(data.msg);
                }else{

                    // 上传成功
                    $("#divPreview").append("<img src="+data.url+" style='max-width: 100px;max-height: 100px'/>");
                    $("#divPreview").append("<input type='hidden' name='gallery_path[]' value='" + data.url + "'/>");

                    layer.msg(data.msg);

                }
            },
            'uploadLimit'   : 5,                                                                      //上传最多图片张数
            'buttonText'    : '选择相册文件',
        });
            $('.deleteBtn').click(function(){
                var del_id = $(this).next().val();
                var url = "<?php echo U('pic_delete');?>?gallery_id="+del_id+"&goods_id=<?php echo ($id); ?>";
                layer.confirm('你确定要删除它吗？', {
                    btn: ['必须啊','算了吧'] //按钮
                }, function(){
                    location.href=url;
                }, function(){

                });
            });
        });
    </script>

</body>
</html>