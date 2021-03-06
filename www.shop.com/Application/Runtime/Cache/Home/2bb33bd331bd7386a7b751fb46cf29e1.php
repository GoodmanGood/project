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
		
	<link href="/Public/css/ucenter.css" rel="stylesheet" type="text/css">
	<style>
		.error{
			color: red;
		}
	</style>

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
		
	<!-- center -->
	<div class="container center">
		<div class="panel">

			<!-- banner START -->
			<div class="banner">
				<img class="logo" src="/Public/img/ucenter/ulogo.png" />
				<p><span class="uname"><?php echo ($_SESSION['login_info']['real_name']); ?></span><span class="greetings">您好~~</span><br />
					上次于<?php echo date('Y-m-d H:s',$_SESSION['login_info']['last_login_time']);?> 在成都登录成功</p>
			</div>
			<!-- banner END -->
			<!-- "新品上市" START -->
			<div class="tabs_nav">
				<p class="title">个人中心</p>
				<ul>
					<li class="order_list">订单列表</li>
					<li class="changing_pwd">修改密码</li>
					<li class="user_info">编辑个人资料</li>
					<li class="delivery_addresses"><a href="<?php echo U('User/addAdress');?>">收货地址管理</a></li>
				</ul>
			</div>
			<div class="tabs">
				<ul>
					<li class="order_list">
						<p class="title2">订单列表</p>
						<?php if($list): ?><tr>
								<td colspan="3"><?php echo ($list); ?></td>
							</tr>
							<?php else: ?>
					<?php if(is_array($orders)): foreach($orders as $k=>$order): ?><table class="all">
							<tr>
								<th>商品信息</th>
								<th>实付款</th>
								<th>订单状态</th>
							</tr>
							<tr>
								<td>
									<p><span class="date"><?php echo date('Y-m-d H:i:s',$order['create_time']);?></span>&emsp;<span class="sequence">订单号：<?php echo ($order["id"]); ?></span></p>
									<img src="<?php echo ($order["goods_list"]["0"]["logo"]); ?>">
									<ul>
										<?php echo ($order["goods_list"]["0"]["goods_name"]); ?>
									</ul>
								</td>
								<td>￥：<?php echo ($order['total_price']); ?></td>
								<td>
									<?php switch($order["status"]): case "1": ?>已取消<?php break;?>
										<?php case "2": ?><a href="<?php echo U('Order/pay',['id'=>$order['id']]);?>" style="color: white;background-color: green;padding: 5px 10px">待付款</a><?php break;?>
										<?php case "3": ?>待发货<?php break;?>
										<?php case "4": ?><a href="<?php echo U('Order/orderTrue',['id'=>$order['id']]);?>" style="color: white;background-color: green;padding: 5px 10px">确认收货</a><?php break;?>
										<?php case "5": ?>交易完成<?php break; endswitch;?>
								</td>
							</tr>
						</table><?php endforeach; endif; endif; ?>
					</li>
					<li class="changing_pwd">
						<p class="title2">设置密码</p>
						<dl>
							<form action="<?php echo U('User/editPassword');?>" method="post" id="Epassword">
								<dt>旧密码：</dt>
								<dd><input type="text" class="old_pwd" name="old_password"/></dd>
								<dt>新密码：</dt>
								<dd><input type="text" class="new_pwd" name="password"/></dd>
								<dt>确认密码：</dt>
								<dd><input type="text" class="new_pwd_confirm" name="repassword"/></dd>
							</dl>
							<button type="submit">提交</button>
						</form>
					</li>
					<li class="user_info">
						<p class="title2">个人资料设置</p>
						<dl>
							<dt>昵称：</dt>
							<dd><input class="uname" type="text" name="username" placeholder="请输入你的新昵称"/></dd>
							<dt>出生年月日：</dt>
							<dd><input class="uage" type="date" name="birth" placeholder="请输入正确的出生年月日"/></dd>
							<!--<dt>邮箱：</dt>-->
							<!--<dd><input class="uemail" type="text" name="email" placeholder="请输入正确的格式"/></dd>-->
							<dt>手机号码：</dt>
							<dd><input class="uphone" type="text" name="tel" placeholder="请输入新的手机号"/>
								<!--<button class="verification_code" type="button">获取验证码</button>-->
								<input type="button" class="verification_code" value="获取验证码" style="background-color:#a0603d ;color: white;height: 30px"/>
							</dd>
						</dl>
						<button type="submit">提交</button>
					</li>
				</ul>
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

	<script type="text/javascript" src="/Public/js/basic.js?v=1"></script>

	<script type="text/javascript" src="/Public/js/jquery.auto-complete.min.js"></script>
	<script type="text/javascript" src="/Public/js/jquery.cxselect.min.js"></script>
	<script type="text/javascript" src="/Public/js/jquery.editable.min.js"></script>
	<script type="text/javascript">

		$(".center .tabs li [type='text'], .center .tabs .user_info select").addClass("borderRadius_scheme_small");
		$(".center .tabs li button").addClass("button_color_scheme_dark borderRadius_scheme_middle");

		$(function(){

			/* Tabs navigator module START */

			// First level tabs

			var $tabs_nav = $(".center .tabs_nav >ul");
			var $tabs_nav_trigger = $tabs_nav.children("li");
			var $tabs = $(".center .tabs >ul");
			var $tabs_item = $tabs.children("li");

			var current_tab_class;
			$tabs_nav_trigger.on("click", function(){
				current_tab_class = $(this).attr('class');

				$tabs_nav_trigger.css({'color': '#000000'});
				$tabs_nav.children("." + current_tab_class).css({'color': '#a0603d'});

				$tabs_item.css({'display':'none'});
				$tabs.children("." + current_tab_class).css({'display':'initial'});
				$tabs.height($tabs.children("." + current_tab_class).height());
			}).hover(function(){
				$(this).css({"cursor":"pointer"});
			}).eq(0).trigger("click");

			// Order list tabs

			var $order_list = $(".center .tabs .order_list");
			var $order_list_nav = $order_list.children(".caption_nav");
			var $order_list_nav_trigger = $order_list_nav.children("li");
			var $order_list_item = $order_list.children("table");

			$order_list_nav_trigger.on("click", function(){

				$order_list_nav_trigger.css({'color': '#000000'});
				$order_list_nav.children("." + $(this).attr('class')).css({'color': '#a0603d'});

				$order_list_item.css({'display':'none'});
				$order_list.children("." + $(this).attr('class')).css({'display':'inline-table'});
				$tabs_nav.children("." + current_tab_class).trigger("click");
			}).hover(function(){
				$(this).css({"cursor":"pointer"});
			}).eq(0).trigger("click");

			/* Tabs navigator module END */

			/* Wait4pay module START */
			$order_list.children(".wait4pay").find(".delete").click(function(){
				$(this).parent().parent().remove();
				// Update UI.
				$order_list_nav.children(".wait4pay").trigger("click");
			}).hover(function(){
				$(this).css({"cursor":"pointer"});
			});
			/* Wait4pay module END */

			/* Address module START */

			var editable_params = {
				lineBreaks : true,
				toggleFontSize : false,
				closeOnEnter : true
			}

			var $address_list = $(".center .addresses");

			// Click to set as default.
			$address_list.find(".default").live({
				click: function(){
					$(this).find("[name='is_default']").attr({"checked":"checked"});
				},
				hover: function(){
					$(this).css({"cursor":"pointer"});
				}
			});

			var $add_address = $address_list.find(".add_address");

			// Add blank address and hide add trigger.
			$add_address.click(function(){
				// Create object.
				$newAddress = $('<li>'+
						'<p class="uname">源码时代</p>'+
						'<p class="pre_address"><select class="province" data-value="四川省"></select><select class="city" data-value="成都市"></select><select class="area" data-value="高新区"></select></p>'+
						'<p class="address" title="双击编辑" old="">地址</p>'+
						'<p class="uphone" title="双击编辑">电话</p>'+
						'<p><button class="save  button_color_scheme_dark">保存该地址</button> <button class="cancel  button_color_scheme_dark">取消</button></p>'+
						'</li>');

				// Select pre-address.
				$newAddress.find('.pre_address').cxSelect({
					url: 'json/cityData.min.json',
					selects: ['province', 'city', 'area'],
					emptyStyle: 'none'
				});

				// Enable directly editing.
				$newAddress.find('.address').editable(editable_params);
				$newAddress.find('.uphone').editable(editable_params);

				// Add to list.
				$newAddress.insertBefore($(this));

				// Hide trigger.
				$(this).css({"display":"none"});
			}).hover(function(){
				$(this).css({"cursor":"pointer"});
			});


			// Save new address.
			$address_list.find(".save").live("click", function(){
				$(this).parent().parent().append(
						'<button class="delete button_color_scheme_dark borderRadius_scheme_middle">删除</button><p class="default"><input type="radio" name="is_default" >作为默认地址</p>'
				);
				// Show add trigger.
				$add_address.css({"display":"initial"});
				// Update UI.
				$tabs_nav.children(".delivery_addresses").trigger("click");
				// Clear.
				$(this).parent().remove();
			});

			// Cancel using new address.
			$address_list.find(".cancel").live("click", function(){
				$(this).parent().parent().remove();
				$add_address.css({"display":"initial"});
			});

			// Delete address.
			$address_list.find(".delete").live("click", function(){
				$(this).parent().remove();
			});

			// Select pre-address.
			$pre_address = $address_list.find(".pre_address");
			$pre_address.cxSelect({
				url: 'json/cityData.min.json',
				selects: ['province', 'city', 'area'],
				emptyStyle: 'none'
			});

			// Directly edit address.
			var $address = $address_list.find(".address");
			var $uphone = $address_list.find(".uphone");
			var currentEditingAddress;
			$address.editable(editable_params);
			$uphone.editable(editable_params);

			// Listen on when elements getting edited

			var editing_func = function() {
				currentEditingAddress = $(this);
				currentEditingAddress.attr({"old":$(this).find("textarea").val()});
				currentEditingAddress.find('textarea').css({"background-color":"white"});
			}

			$address.live('edit', editing_func);
			$uphone.live('edit', editing_func);

			$address.live('edit', function() {
				currentEditingAddress.find('textarea').attr({"maxlength":"44"});
			});
			$uphone.live('edit', function() {
				currentEditingAddress.find('textarea').attr({"maxlength":"11"});
			});

			// Listen on when elements cancel edited
			$(document).keydown(function(event){
				if(event.keyCode == 27){
					currentEditingAddress.editable('close');
					currentEditingAddress.text(currentEditingAddress.attr("old"));
				}
			});

			/* Adress module END */

		});
	</script>
	<script src="/Public/ext/layer/layer.js"></script>
	<script type="text/javascript">
		$(".center input").addClass("borderRadius_scheme_large");
		$(".center button").addClass("button_color_scheme_dark borderRadius_scheme_large");
		$(".center .verification_wrapper input, .center .verification_wrapper button").removeClass("borderRadius_scheme_large").addClass("borderRadius_scheme_small");


		var InterValObj; //timer变量，控制时间
		var count = 60; //间隔函数，1秒执行
		var curCount;//当前剩余秒数
		function code(){
			//自定页
			layer.open({
				title: ['请输入验证码', 'background-color:#A0603D;color:white'],
				type: 1,
				skin: 'layui-layer-demo', //样式类名
				closeBtn: 0, //不显示关闭按钮
				anim: 2,
				shadeClose: true, //开启遮罩关闭
				content: '<div style="text-align:center;padding:10px;">\
								<p>\
								<input type="text" id=\'verify\' class="verification" style="border-radius: 5px;height: 20px;margin-bottom: 15px"/><br />\
								<img src=\'<?php echo U("Verify/index");?>\' onclick="verify()"/>\
								</p>\
						   </div>',
				btnAlign: 'c', //按钮位置
				area: ['200px','210px'], //宽高
				anim:3, //弹出效果
				btn:['发送']
				,yes: function(){

					layer.closeAll();
					//获取码值
					var phoneNum = $('.uphone').val();
					var code = $('.verification').val();
					var url = '<?php echo U("send_sms");?>';
					var data = {
						tel: phoneNum,
						verify: code,
					};
					//获取返回信息
					$.getJSON(url, data, function (res) {
						if(res.status){
							layer.msg(res.msg, {icon: 6});
							curCount = count;
							//设置button效果，开始计时
							$(".verification_code").attr("disabled", "true");
							$(".verification_code").val( curCount + "s后再次获取");
							InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
						}else{
							layer.msg(res.msg, {icon: 5});
						}
					});
				}
			});
		}
		//timer处理函数
		function SetRemainTime() {
			if (curCount == 0) {
				window.clearInterval(InterValObj);//停止计时器
				$(".verification_code").removeAttr("disabled");//启用按钮
				$(".verification_code").val("重新获取");
			}
			else {
				curCount--;
				$(".verification_code").val(curCount + "s后可再获取");
			}
		}


		$('.verification_code').click(code)

		function verify(e){
			var _imgUrl = "<?php echo U('verify/index');?>";
			_imgUrl += '?c=' + Math.random();
			e = e || window.event;
			e.target.src = _imgUrl;
		}



	</script>
	<script type="text/javascript" src="/Public/js/jquery.validate.min.js"></script>
	<script type="text/javascript">
		//-------------jquery-validation验证
		$("#Epassword").validate({
			rules: {
				old_password: {
					required: true,
				},
				password: {
					required: true,
				},
				repassword: {
					required: true,
				},
			},
			messages: {
				old_password: {
					required: "旧密码不能为空！",
				},
				password: {
					required: "密码不能为空！",
				},
				repassword: {
					required: "重复密码不能为空！",
				},
			}
		});
	</script>

</html>