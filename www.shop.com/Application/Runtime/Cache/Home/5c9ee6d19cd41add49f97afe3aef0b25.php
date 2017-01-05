<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="http://www.itsource.cn/upload/operationableFile/logo_small.jpg " />
		<title>登录</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="/Public/css/basic.css" rel="stylesheet" type="text/css">
		<link href="/Public/css/login.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/Public/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="/Public/js/jquery.auto-complete.min.js"></script>
	</head>

	<body>
		<!-- header -->
		<div class="panel header">
			<a href="<?php echo U('Index/index');?>"><img class="logo" src="/Public/img/logo_2.png"></a>
			<div class="top_menu">
				<p class="at_login">
					<a href="<?php echo U('Index/index');?>">首页</a><span class="spliter">|</span>
					<a onclick="history.go(-1)">返回</a>
				</p>
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
					<button class="cart" type="button" onclick="javascript:window.location.href='ucart.html'"><img src="/Public/img/sygw.png">　购物车</button>
				</div>
				<p class="not_login">
					<a href="login.html">登录</a><span class="spliter">|</span>
					<a href="register.html">注册</a><span class="spliter">|</span>
					<a href="ucenter.html">用户中心</a>
				</p>
				<p class="is_login"><span class="uname" name="uname">源码时代</span><span class="greetings">下午好~</span>
					<a href="">退出</a>
				</p>
			</div>
			<p class="menu">
				<a href="index.html">首页</a><span class="spliter">|</span>
				<a href="product_list.html">朴茶区</a><span class="spliter">|</span>
				<a href="product_list.html">有机区</a><span class="spliter">|</span>
				<a href="product_list.html">老茶区</a><span class="spliter">|</span>
				<a href="product_list.html">自饮区</a><span class="spliter">|</span>
				<a href="product_list.html">老牌区</a><span class="spliter">|</span>
			</p>
		</div>

		<!-- center -->
		<div class="panel center">
			<p class="title">用户登录</p>
			<form action="<?php echo U('login');?>" method="post">
			<ul>
				<li>账号　<input type="text" name="username" placeholder="请输入注册账号"/></li>
				<li>密码　<input type="password" name="password" placeholder="请输入密码"/></li>
				<li>　　　<button class="submit" type="submit">登　录</button></li>
				<input type="checkbox" name="rememberMe" value="1" style="width: 20px; height: 20px"> 自动登录
				<li>
					<a href="">忘记密码？</a>　<a href="<?php echo U('reg');?>">免费注册</a>
				</li>
			</ul>
			</form>
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
							<img alt="源码时代" src="/Public/img/1.jpg">
						</div>
					</div>
				</div>
			</div>

		</div>
	</body>
	
	<script type="text/javascript" src="/Public/js/basic.js"></script>
	<script type="text/javascript">
		$(".center input").addClass("borderRadius_scheme_large");
		$(".center button").addClass("button_color_scheme_dark borderRadius_scheme_large");
	</script>
</html>