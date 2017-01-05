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
		
	<link href="/Public/css/jquery.auto-complete.css" rel="stylesheet" type="text/css">
	<link href="/Public/css/ucart.css" rel="stylesheet" type="text/css">

		<script type="text/javascript" src="/Public/js/jquery-1.10.2.min.js"></script>
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
					<?php if($_SESSION['login_info'] == null): ?><a href="<?php echo U('User/login');?>">登录</a><span class="spliter">|</span>
					<a href="<?php echo U('User/reg');?>">注册</a><span class="spliter"></span>
						<?php else: ?>
						<?php echo ($_SESSION['login_info']['real_name']); ?>&nbsp;&nbsp;|</span>
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
		
	<div class="container center">
		<div class="panel">

			<p class="title">我的购物车</p>
			<?php if(isset($msg)): ?><table class="cargo">
				<?php echo ($msg); ?>
				</table>
				<?php else: ?>
			<table class="cargo">
				<thead>
				<tr>
					<td colspan="2"><input type="checkbox" />全部</td>
					<td>商品信息</td>
					<td>单价</td>
					<td>数量</td>
					<td>小计</td>
					<td>操作</td>
				</tr>
				</thead>
				<tbody>
				<?php if(is_array($cartLists)): foreach($cartLists as $key=>$good): ?><tr>
						<td><input type="checkbox" /></td>
						<td><img src="<?php echo ($good["goods_logo"]); ?>" /></td>
						<td><?php echo ($good["goods_name"]); ?></td>
						<td>￥：<?php echo ($good["shop_price"]); ?></td>
						<td><button class="decrease">-</button>
							<input class="amount" type="text" value="<?php echo ($good["amount"]); ?>"/>
							<button class="increase">+</button></td>
						<td>￥：<?php echo ($good["total_price"]); ?></td>
						<td>
							<span class="delete">
								<a href="<?php echo U('Cart/remove',['id'=>$good['id']]);?>">×</a>
							</span>
						</td>
					</tr><?php endforeach; endif; ?>

				</tbody>
				<tfoot>
				<tr>
					<td colspan="4">
						<input type="checkbox" />全选　<a href="">删除</a>
					</td>
					<td>
						已选择商品 <span class="count"><?php echo ($total_number); ?></span> 件
					</td>
					<td colspan="2">
						合计（不含运费）：<span class="sum">￥<?php echo ($total_price_all); ?></span>　
						<a href="<?php echo U('Order/create');?>">
							<button class="submit">结算</button>
						</a>
					</td>
				</tr>
				</tfoot>
			</table><?php endif; ?>
		</div>
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

	<script type="text/javascript" src="/Public/js/jquery.auto-complete.min.js"></script>
	<script type="text/javascript">
		$(".center .cargo .decrease, .center .cargo .increase").addClass("button_color_scheme_dark");
		$(".center .cargo .submit").addClass("button_color_scheme_dark borderRadius_scheme_small");

		$(function(){
			$(".center .cargo .delete").live({
				click: function(){
					$(this).parent().parent().remove();
				},
				hover: function(){
					$(this).css({"cursor":"pointer"});
				}
			});
		});
	</script>

</html>