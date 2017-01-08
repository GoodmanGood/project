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
                订单管理
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo U('Index/index');?>">管理后台</a>
                </li>
                <li class="active"> 订单列表</li>
            </ul>
        </div>
        <!-- page heading end-->

        <div class="wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                           订单列表
                        </header>
                        <div class="panel-body">
                            <form class="form-inline" action="<?php echo U();?>" method="get">
                                <div class="form-group">
                                    <label>订单号</label>
                                    <input type="text" class="form-control"  name="id" value="<?php echo I('get.id');?>">
                                </div>
                                <div class="form-group">
                                    <label>收件人</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo I('get.name');?>">
                                </div>
                                <div class="form-group">
                                    <label>联系方式</label>
                                    <input type="text" class="form-control" name="tel" value="<?php echo I('get.tel');?>">
                                </div>
                                <div class="form-group">
                                    <label>状态</label>
                                    <select name="status" class="form-control status">
                                        <option value="0">请选择</option>
                                        <option value="1">已取消</option>
                                        <option value="2">待付款</option>
                                        <option value="3">待发货</option>
                                        <option value="4">待收货</option>
                                        <option value="5">交易完成</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default">搜索</button>
                                </form>
                            </div>
                        <div class="panel-body">
                            <div class="adv-table text-center">
                                <table  class="display table table-bordered table-striped" id="dynamic-table">
                                    <thead>
                                    <tr>
                                        <th>订单号</th>
                                        <th>创建时间</th>
                                        <th>收件人</th>
                                        <th>联系方式</th>
                                        <th>收货地址</th>
                                        <th>配送方式</th>
                                        <th>价格</th>
                                        <th>支付方式</th>
                                        <th class="hidden-phone">状态</th>
                                        <th class="hidden-phone">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr class="gradeX">
                                                <td><?php echo ($order["id"]); ?></td>
                                                <td><?php echo date('Y-m-d H:i:s',$order['create_time']);?></td>
                                                <td><?php echo ($order["name"]); ?></td>
                                                <td><?php echo ($order["tel"]); ?></td>
                                                <td><?php echo ($order["province_name"]); ?> <?php echo ($order["city_name"]); ?> <?php echo ($order["area_name"]); ?></td>
                                                <td><?php echo ($order["delivery_name"]); ?></td>
                                                <td><?php echo ($order["price"]); ?></td>
                                                <td><?php echo ($order["payment_name"]); ?></td>
                                                <td class="center hidden-phone">
                                                    <?php switch($order["status"]): case "1": ?>已取消<?php break;?>
                                                        <?php case "2": ?>待付款<?php break;?>
                                                        <?php case "4": ?>待收货<?php break;?>
                                                        <?php case "3": ?><a href="<?php echo U('Order/send',['id'=>$order['id']]);?>" style="color: white;background-color: green;padding: 5px 10px">发货</a><?php break;?>
                                                        <?php case "5": ?>交易完成<?php break; endswitch;?>
                                                </td>
                                                <td class="center hidden-phone">
                                                    <?php switch($order["status"]): case "1": ?><a data-href="" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs removeBtn">删除订单</a>
                                                            <input type="hidden" name="id" value="<?php echo ($order['id']); ?>"/><?php break;?>
                                                        <?php case "5": ?><a data-href="" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs removeBtn">删除订单</a>
                                                            <input type="hidden" name="id" value="<?php echo ($order['id']); ?>"/><?php break;?>
                                                        <?php case "3": ?><a data-href="" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs deleteBtn">取消订单</a>
                                                        <input type="hidden" name="id" value="<?php echo ($order['id']); ?>"/><?php break;?>
                                                        <?php case "4": ?><a data-href="" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs deleteBtn">取消订单</a>
                                                    <input type="hidden" name="id" value="<?php echo ($order['id']); ?>"/><?php break;?>
                                                        <?php case "2": ?><a data-href="" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs deleteBtn">取消订单</a>
                                                            <input type="hidden" name="id" value="<?php echo ($order['id']); ?>"/><?php break; endswitch;?>
                                                </td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                                <div id="demo1">
                                    <div class="scott" id="layui-laypage-0" style="float:right;">
                                        <?php echo ($pages); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>





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
        $(function(){
            $('.deleteBtn').click(function(){
                var del_id = $(this).next().val();
                var url = "<?php echo U('delete');?>?id="+del_id;
                layer.confirm('你确定要取消它吗？', {
                    btn: ['必须啊','算了吧'] //按钮
                }, function(){
                    location.href=url;
                }, function(){

                });
            });
            $('.removeBtn').click(function(){
                var del_id = $(this).next().val();
                var url = "<?php echo U('remove');?>?id="+del_id;
                layer.confirm('你确定要删除它吗？', {
                    btn: ['必须啊','算了吧'] //按钮
                }, function(){
                    location.href=url;
                }, function(){

                });
            });
          $('.status').val(<?php echo I('get.status');?>);
        });
    </script>

</body>
</html>