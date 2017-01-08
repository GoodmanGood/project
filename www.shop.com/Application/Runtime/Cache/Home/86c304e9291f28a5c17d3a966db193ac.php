<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="http://www.itsource.cn/upload/operationableFile/logo_small.jpg " />
		<title>源码时代</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="/Public/css/basic.css" rel="stylesheet" type="text/css">
		<link href="/Public/css/index.css" rel="stylesheet" type="text/css">
		<link href="/Public/css/unslider.css" rel="stylesheet" type="text/css">
		<link href="/Public/css/unslider-dots.css" rel="stylesheet" type="text/css">
		
	<!--<link href="/Public/css/jquery.auto-complete.css" rel="stylesheet" type="text/css">-->
	<link href="/Public/css/ucart.css" rel="stylesheet" type="text/css">
	<!--<link href="/Public/css/bootstrap.min.css" rel="stylesheet" type="text/css">-->

		<script type="text/javascript" src="/Public/js/jquery3.1.0.js"></script>
		<script type="text/javascript" src="/Public/js/unslider-min.js"></script>
	</head>

	<body>
		<!-- header -->
		<div class="panel header">
			<a href="<?php echo U('Index/index');?>"><img class="logo" src="/Public/img/logo_2.png"></a>
			<div class="top_menu">
				<div class="search_bar">
					<input class="search_bar-input" type="text" placeholder="查找你需要的茶叶" />
					<div style="position: relative; display: inline;">
						<ul class="auto_wrapper">
							<li>数据一</li>
							<li>数据二</li>
							<li>数据三</li>
							<li>数据四</li>
							<li>数据五</li>
						</ul>
					</div>
					<button class="search_bar-submit" type="search"><img src="/Public/img/syss.png">搜索</button>
					<button class="cart" type="button" onclick="javascript:window.location.href='<?php echo U('Cart/cartList');?>'"><img src="/Public/img/sygw.png">　购物车</button>
				</div>
				<!--<?php echo dump();?>-->
				<p class="not_login">
					<?php if(!getUserId()): ?><a href="<?php echo U('User/login');?>">登录</a><span class="spliter">|</span>
					<a href="<?php echo U('User/reg');?>">注册</a><span class="spliter"></span>
						<?php else: ?>
						<!--<?php echo dump($_SESSION);?>-->
						<?php echo ($_SESSION['login_info']['real_name']); ?>&nbsp;&nbsp;|</span>
						<!--<?php echo ($_SESSION['sess_']['login_info']['real_name']); ?>&nbsp;&nbsp;|</span>-->
						<a href="<?php echo U('User/ucenter');?>">个人中心</a><span class="spliter">|</span>
						<a href="<?php echo U('User/logout',['id'=>$_SESSION['login_info']['id']]);?>">退出</a><?php endif; ?>
				</p>

			</div>
			<p class="menu">
				<a href="<?php echo U('Index/index');?>">首页</a><span class="spliter">|</span>
				<?php if(is_array($lists)): foreach($lists as $key=>$list): ?><a href="<?php echo U('Goods/category',['id'=>$list['good_category_id']]);?>"><?php echo ($list["good_category_name"]); ?></a><span class="spliter">|</span><?php endforeach; endif; ?>
			</p>
		</div>
		
		<!-- center -->
		
	<div style="margin: 50px auto; border: 1px solid #c0c0c0;width: 900px;height:500px;">
		<h2 style="color: green;margin: 20px 10px 10px 10px;">神仙茶产品订单支付</h2>
		<h3 style="color: red;margin: 20px 10px 10px 10px;">微信支付</h3>
		<hr/>
		<span style="margin: 10px 200px 0 20px;">订单号：<?php echo ($order["id"]); ?> </span>   配送地址：<?php echo ($order["province_name"]); ?> <?php echo ($order["city_name"]); ?> <?php echo ($order["area_name"]); ?> <?php echo ($order["detail_address"]); ?>
		<span style="margin: 10px 20px 0 80px;">金额：<span style="color: red;font-size: 16px;">￥<?php echo number_format($order['price']+$order['delivery_price'],2,',','');?></span></span>
		<hr style="margin-top: 20px"/>
		<span style="margin: 10px 200px 0 20px;"><b>微信扫码支付：</b></span><br>

		<div style="margin: 50px auto;width: 200px">
				<img src="<?php echo U('Qrcode/index',['code'=>$code]);?>">
		</div>
		<button style="margin-left: 800px;" class="button_color_scheme_dark borderRadius_scheme_small" onclick="history.go(-1)">返回我的订单</button>

	</div>

		
		<!-- footer -->
		<div class="container footer">
			<div class="panel cfooter">
				<div class="f_top">
					<div class="t_left">
						<p>源码时代商城-出售源码时代周边产品，学习资料</p>
						<p>地&emsp;&emsp;址：&emsp;成都市高新区府城大道西段399号天府新谷1号楼6F</p>
						<p>电&emsp;&emsp;话：&emsp;028-86261949</p>
						<p>邮&emsp;&emsp;箱：&emsp;yuandaima@itsource.cn</p>
						<p>2006-2016成都源代码教育咨询有限公司 版权所有</p>
						<p>
							<a href="http://www.miitbeian.gov.cn" target="_blank">蜀ICP备14030149号-1</a>
						</p>
					</div>
					<div class="t_right">
						<div class="footer_right_wx">
							<img alt="源码时代" src="/Public/img/1.JPG">
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

	<script type="text/javascript" src="/Public/js/basic.js?v=1"></script>



</html>