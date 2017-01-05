<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="http://www.itsource.cn/upload/operationableFile/logo_small.jpg " />
		<title>产品列表</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="/Public/css/basic.css" rel="stylesheet" type="text/css">
		<link href="/Public/css/product_list.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/Public/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="/Public/js/jquery.auto-complete.min.js"></script>
	</head>

	<body>
		<!-- header -->
		<div class="panel header">
			<a href="index.html"><img class="logo" src="/Public/img/logo_2.png"></a>
			<div class="top_menu">
				<p class="at_login">
					<a href="index.html">首页</a><span class="spliter">|</span>
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
				<?php if(is_array($lists)): foreach($lists as $key=>$list): ?><a href="<?php echo U('category',['id'=>$list['good_category_id']]);?>"><?php echo ($list["good_category_name"]); ?></a><span class="spliter">|</span><?php endforeach; endif; ?>
			</p>
		</div>
		
		<!-- center -->
		<div class="container center">
			<div class="panel">
				
				<p class="uposition">你的当前位置：<a href="">全部结果</a><span class="spliter">></span><a href=""><?php echo ($category["good_category_name"]); ?></a></p>
				<table class="filter">
					<tr>
						<td>品牌：</td>
						<td>
							<ul class="brand">
								<?php if(is_array($brands)): foreach($brands as $key=>$brand): ?><li><a href="javascript: void(0)"><?php echo ($brand["name"]); ?></a></li><?php endforeach; endif; ?>
							</ul>
						</td>
					</tr>
					<tr>
						<td>价格段：</td>
						<td>
							<ul class="prices">
								<li><a href="javascript: void(0)">1-59元</a></li>
								<li><a href="javascript: void(0)">60-199元</a></li>
								<li><a href="javascript: void(0)">200-399元</a></li>
								<li><a href="javascript: void(0)">400-599元</a></li>
								<li><a href="javascript: void(0)">600-799元</a></li>
								<li><a href="javascript: void(0)">800元以上</a></li>
							</ul>
						</td>
					</tr>
				</table>
				<p class="counting">
					<?php echo ($pages); ?>
				</p>
				<p class="sorting">
					<button>综合排序</button><button>销量</button><button>人气</button><button>信用</button><button>价格</button>
				</p>
				<p class="distribution">
					配送至
					<select>
					  <option>四川省高新区</option>
					</select>
					<input type="checkbox">京东配送</input>
					<input type="checkbox">货到付款</input>
					<input type="checkbox">仅显示有货</input>
				</p>
				<div class="products">
					<div class="flex-list-box">
						<dl class="products-list">
							<?php if(is_array($goods)): foreach($goods as $key=>$good): ?><a href="product.html">
								<dd>
									<p><img src="<?php echo ($good["goods_logo"]); ?>"></p>
									<p class="paid">127付款</p>
									<p class="price">¥：<?php echo ($good["shop_price"]); ?></p>
									<p><?php echo ($good["goods_name"]); ?></p>
								</dd>
								</a><?php endforeach; endif; ?>
						</dl>
					</div>
				</div>
				<div class="buttons_at_bottom">
					<p class="jumper">共100页　到第<input type="text" />页　<button>确定</button></p>
					<button><上一页</button><button class="focused">1</button><button>2</button><button>3</button><button>4</button><button>5</button><button>6</button><button class="ellipsis">···</button><button>下一页></button>
				</div>
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
	
	<script type="text/javascript" src="/Public/js/basic.js"></script>
	<script type="text/javascript">
		$(".center .sorting button").addClass("button_color_scheme_mixed");
		$(".center .counting button").addClass("button_color_scheme_light");
	</script>
</html>