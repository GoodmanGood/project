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
                <a href="<?php echo U('index');?>">管理后台</a>
            </li>
            <li class="active"> <?php echo ($title); ?> </li>
        </ul>
    </div>
    <!-- page heading end-->

    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        商品管理
                            <span class="tools pull-right">
                                <a href="<?php echo U('add');?>" class="btn btn-success btn-link">新增商品</a>
                                <a href="<?php echo U('SaleInfo/add');?>" class="btn btn-success btn-link">新增促销活动</a>
                            </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-inline" action="<?php echo U();?>" method="get">
                            <div class="form-group">
                                <label for="exampleInputName2">商品名字</label>
                                <input type="text" class="form-control" id="exampleInputName2" name="goods_name" value="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">商品分类</label>
                                <select name="category_id" class="form-control">
                                    <option value="0">所有</option>
                                    <?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option <?php if($cate['good_category_id'] == I('get.category_id')): ?>selected<?php endif; ?> value="<?php echo ($cate["good_category_id"]); ?>">
                                        <?php $__FOR_START_10796__=1;$__FOR_END_10796__=$cate['level'];for($i=$__FOR_START_10796__;$i < $__FOR_END_10796__;$i+=1){ ?>&nbsp;&nbsp;<?php } ?>
                                        <?php echo ($cate["good_category_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    <!--<?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>-->
                                        <!--<option value="<?php echo ($cate["good_category_id"]); ?>"><?php echo str_repeat('&nbsp;',$cate['level']-1); echo ($cate["good_category_name"]); ?></option>-->
                                    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">品牌</label>
                                <select name="brand_id" class="form-control">
                                    <option value="0">所有</option>
                                    <?php if(is_array($brands)): $i = 0; $__LIST__ = $brands;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?><option <?php if($brand['good_brand_id'] == I('get.brand_id')): ?>selected<?php endif; ?> value="<?php echo ($brand["good_brand_id"]); ?>"><?php echo ($brand["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    <!--<?php if(is_array($brands)): $i = 0; $__LIST__ = $brands;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?>-->
                                        <!--<option value="<?php echo ($brand["brand_id"]); ?>"><?php echo ($brand["name"]); ?></option>-->
                                    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">价格区间</label>
                                <input type="text" name="min" style="width: 50px;" class="form-control" value="<?php echo I('get.min');?>" /> -
                                <input type="text" name="max"  style="width: 50px;" class="form-control" value="<?php echo I('get.max');?>" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">商品状态</label>
                                <?php if(is_array($sales)): $i = 0; $__LIST__ = $sales;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sale): $mod = ($i % 2 );++$i;?><input type="checkbox" id="sale" name="prom_type[]" value="<?php echo ($sale["id"]); ?>" <?php if(in_array($sale['id'],I('get.prom_type'))): ?>checked<?php endif; ?>><?php echo ($sale["info_prom_type"]); ?>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                        <hr/>
                        <div class="adv-table">
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                <tr>
                                    <!--<th>编号ID</th>-->
                                    <th>商品名称</th>
                                    <th>货号</th>
                                    <th>图片</th>
                                    <th>市场价格</th>
                                    <th>本店价格</th>
                                    <th>库存</th>
                                    <th>促销状态</th>
                                    <th>是否上架</th>
                                    <th>分类 & 品牌</th>
                                    <th class="hidden-phone">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr class="gradeX">
                                        <!--<td><?php echo ($list["id"]); ?></td>-->
                                        <td><?php echo ($list["goods_name"]); ?></td>
                                        <td><?php echo ($list["sn"]); ?></td>
                                        <td><img src="<?php echo ($list['goods_logo']); ?>" width="30" /></td>
                                        <td>￥<?php echo ($list["market_price"]); ?></td>
                                        <td>￥<?php echo ($list["shop_price"]); ?></td>
                                        <td><?php echo ($list["stock"]); ?></td>
                                        <!-- 000000111  -->
                                        <td>
                                            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i; if($list["id"] == $row["goods_id"] ): echo ($row["info_prom_type"]); ?><br/><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </td>
                                        <td>
                                            <?php echo $list['is_on_sale']==1?'上架':'下架';?>
                                        </td>
                                        <td>
                                            <?php echo ($list["category_name"]); ?> &  <?php echo ($list["name"]); ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo U('detail', array('id' => $list['id']));?>" class="btn btn-xs btn-info">商品详情</a>
                                            <a href="<?php echo U('pics', array('id' => $list['id']));?>" class="btn btn-xs btn-warning">商品相册</a>
                                            <a href="<?php echo U('edit', array('id' => $list['id']));?>" class="btn btn-xs btn-success">编辑</a>
                                            <a data-href="<?php echo U('delete', array('id' => $list['id']));?>" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs deleteBtn">删除</a>
                                            <input type="hidden" name="id" value="<?php echo ($list['id']); ?>"/>
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