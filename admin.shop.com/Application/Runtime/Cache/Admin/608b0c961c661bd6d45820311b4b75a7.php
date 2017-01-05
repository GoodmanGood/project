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
        <?php echo ($title); ?>
    </h3>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo U('Index/index');?>">管理后台</a>
        </li>
        <li> <a href="<?php echo U('Goods/index');?>">商品管理</a> </li>
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
                    新增商品
                </header>
                <div class="panel-body">
                    <form role="form" action="<?php echo U();?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>"/>
                        <div class="form-group">
                            <label for="exampleInputEmail1">商品名称</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="goods_name" placeholder="请输入商品名字" value="<?php echo ($row["goods_name"]); ?>">
                        </div>
                        <!--<?php echo dump($row);?>-->
                        <div class="form-group">
                            <label>分类</label>
                            <select name="category_id" class="form-control" id="cate">
                                <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["good_category_id"]); ?>"><?php echo str_repeat('&nbsp;',$cate['level']-1); echo ($cate["good_category_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>所属品牌</label>
                            <select name="brand_id" class="form-control" id="brand">
                                <?php if(is_array($brands)): $i = 0; $__LIST__ = $brands;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?><option value="<?php echo ($brand["good_brand_id"]); ?>"><?php echo ($brand["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>商品市场价</label>
                            <input type="text" class="form-control" name="market_price"  value="<?php echo ($row["market_price"]); ?>">
                        </div>
                        <div class="form-group">
                            <label>商品本店价</label>
                            <input type="text" class="form-control" name="shop_price" value="<?php echo ($row["shop_price"]); ?>">
                        </div>
                        <div class="form-group">
                            <label>商品库存</label>
                            <input type="text" class="form-control" name="stock" value="<?php echo ($row["stock"]); ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">商品详情</label>
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="goods_content" type="text/plain">
                                <?php echo ($row["goods_content"]); ?>
                            </script>
                            <!-- 配置文件 -->
                            <script type="text/javascript" src="/Public/ueditor/ueditor.config.js"></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="/Public/ueditor/ueditor.all.js"></script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container');
                            </script>
                        </div>
                        <div class="form-group">
                            <label>商品促销</label>
                            <?php if(is_array($sales)): $i = 0; $__LIST__ = $sales;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sale): $mod = ($i % 2 );++$i;?><input type="checkbox" id="sale" name="goods_status[]" value="<?php echo ($sale["id"]); ?>" <?php if(in_array($sale['id'],$ss['prom_type'])): ?>checked<?php endif; ?> /><?php echo ($sale["info_prom_type"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>



                        <div class="form-group">
                            <label>是否上架</label>
                            <input type="radio" name="is_on_sale" value="0" <?php if($row['is_on_sale'] == 0): ?>checked<?php endif; ?> >下架
                            <input type="radio" name="is_on_sale" value="1" <?php if($row['is_on_sale'] == 1): ?>checked<?php endif; ?>>上架
                        </div>
                        <div class="form-group">
                            <label for="logo-upload">LOGO</label>
                            <input type="file" id="logo-upload">
                            <input type="hidden" name="goods_logo" id="logo" value="<?php echo ($row["goods_logo"]); ?>"/><br/>
                            <img src="<?php echo ($row["goods_logo"]); ?>" id="logo-preview" style="max-width: 100px;max-height: 100px"/>
                        </div>


                        <div class="form-group">
                            <label>状态</label>
                            <input type="radio" name="status" value="1" <?php if($row['status'] == 1): ?>checked<?php endif; ?> />正常
                            <input type="radio" name="status" value="0" <?php if($row['status'] == 0): ?>checked<?php endif; ?>  />关闭
                        </div>
                        <div class="form-group">
                            <label>自定义排序</label>
                            <input type="text" class="form-control" name="sort" value="<?php echo ($row["sort"]); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">提交修改</button>
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

        $('#cate').val(<?php echo ($row['category_id']); ?>);
        $('#brand').val(<?php echo ($row['brand_id']); ?>);

        });
    </script>

</body>
</html>