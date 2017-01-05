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
		
    <link href="/Public/css/settlement.css" rel="stylesheet" type="text/css">

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
            <form action="<?php echo U();?>" method="post">
                <p class="title">收货地址</p>

                <ul class="addresses">
                    <?php if(is_array($addresses)): foreach($addresses as $key=>$address): ?><li>
                        <span class="is_default">默认地址</span>
                        <p class="uname"><?php echo ($address["name"]); ?></p>
                        <p class="pre_address">
                            <select class="province" data-value="">
                                <option><?php echo ($address["province_name"]); ?></option>
                            </select>
                            <select class="city" data-value=" ">
                                <option><?php echo ($address["city_name"]); ?></option>
                            </select>
                            <select class="area" data-value="">
                                <option><?php echo ($address["area_name"]); ?></option>
                       z     </select>
                        </p>
                        <p class="address" title="双击编辑" old="">
                            <?php echo ($address["province_name"]); ?> <?php echo ($address["city_name"]); ?> <?php echo ($address["area_name"]); ?> <?php echo ($address["detail_address"]); ?>
                        </p>
                        <p class="uphone" title="双击编辑">
                            <?php echo ($address["tel"]); ?>
                        </p>
                        <img class="is_checked" src="/Public/img/settlement/checked.png" />
                        <p class="actived">
                            <input type="radio" name="in_using" checked="checked">
                            使用该地址
                        </p>
                    </li><?php endforeach; endif; ?>
                    <li class="add_address">
                        <p class="plus"><a href="<?php echo U('User/addAdress');?>">+</a></p>
                        使用新地址
                    </li>
                </ul>

                <table class="summation">
                    <thead>
                    <tr>
                        <td>商品信息</td>
                        <td>单价</td>
                        <td>数量</td>
                        <td>小计</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($cartLists)): foreach($cartLists as $key=>$good): ?><tr>
                        <td>
                            <img src="<?php echo ($good["goods_logo"]); ?>" />
                            <?php echo ($good["goods_name"]); ?>
                        </td>
                        <td>￥：<?php echo ($good["shop_price"]); ?></td>
                        <td><?php echo ($good["amount"]); ?></td>
                        <td>￥：<?php echo ($good["total_price"]); ?></td>
                    </tr><?php endforeach; endif; ?>
                    <tr>
                        <td></td>
                        <td><p>运送方式：京东快递</p><p>运费险：0.00</p></td>
                        <td></td>
                        <td><p>0.00</p><p>0.00</p></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td>合计：<span class="sum">￥<?php echo ($total_price_all); ?></span></td>
                    </tr>
                    </tfoot>
                </table>
                <p class="title2">发票信息</p>
                <div class="invoice_info">
                    <p class="subtitle2"><input class="not_issuing_invoicing" type="checkbox" checked="checked">不开发票　<span class="alter">修改</span></p>
                    <div class="content"></div>
                </div>
                <div class="bill">
                    <div class="payment">
                        <ul>
                            <li><input type="checkbox">微信支付</input></li>
                            <li><input type="checkbox">在线支付</input></li>
                        </ul>
                        <ul>
                            <li><input type="checkbox">货到付款</input></li>
                            <li><input type="checkbox">支付宝支付</input></li>
                        </ul>
                    </div>
                    <ul class="summary">
                        <li>实付款：<span class="sum">￥<?php echo ($total_price_all); ?></span></li>
                        <li>寄送至：<span class="address"><?php echo ($address["province_name"]); ?> <?php echo ($address["city_name"]); ?> <?php echo ($address["area_name"]); ?>
                        <?php echo ($address["detail_address"]); ?></span></li>
                        <li>收货人：<span class="uname"><?php echo ($address["name"]); ?></span></li>
                        <li>
                            联系方式：<span class="uphone"><?php echo ($address["tel"]); ?></span>
                        </li>
                    </ul>
                    <p><button class="button_color_scheme_dark borderRadius_scheme_small" onclick="history.go(-1)">返回购物车</button><button class="button_color_scheme_dark borderRadius_scheme_small" type="submit">提交订单</button></p>
                </div>
            </form>
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



    <script type="text/javascript" src="/Public/js/jquery.auto-complete.min.js"></script>
    <script type="text/javascript" src="/Public/js/jquery.cxselect.min.js"></script>
    <script type="text/javascript" src="/Public/js/jquery.editable.min.js"></script>
    <script type="text/javascript">

        $(".invoice .content .normal .details button, .invoice .content .digital .details button, .invoice .navigator button").addClass("button_color_scheme_light borderRadius_scheme_small");
        $(".invoice .content .normal .confirmation button, .invoice .content .digital .confirmation button").addClass("button_color_scheme_mixed");
        $(".invoice .content [type='text']").addClass("borderRadius_scheme_small");
        $(".invoice .content .VAT .confirmation button").addClass("button_color_scheme_dark");
        $(".invoice .content .confirmation button").addClass("borderRadius_scheme_small");

        $(function(){

            /* Address module START */

            var $address_list = $(".center .addresses");

            // Click to active.
            var $actived_address = $address_list.find(".actived");
            $actived_address.live({
                click: function(){
                    $(this).find("[name='in_using']").attr({"checked":"checked"});
                    $is_checked = $address_list.find(".is_checked").clone();
                    $address_list.find(".is_checked").remove();
                    $(this).before($is_checked);
                },
                hover: function(){
                    $(this).css({"cursor":"pointer"});
                }
            });

            // Add blank address and hide add trigger.
            var $add_address = $address_list.find(".add_address");
            $add_address.click(function(){
                $newAddress = $('<li>'+
                        '<p class="uname">源码时代</p>'+
                        '<p class="pre_address"><select class="province" data-value="四川省"></select><select class="city" data-value="成都市"></select><select class="area" data-value="高新区"></select></p>'+
                        '<p class="address" title="双击编辑" old="">地址</p>'+
                        '<p class="uphone" title="双击编辑">电话</p>'+
                        '<p><button class="save button_color_scheme_dark">保存并使用该地址</button> <button class="cancel button_color_scheme_dark">取消</button></p>'+
                        '</li>');

                // Select pre-address.
                $newAddress.find('.pre_address').cxSelect({
                    url: 'json/cityData.min.json',
                    selects: ['province', 'city', 'area'],
                    emptyStyle: 'none'
                });

                // Enable directly editing.
                $newAddress.find('.address').editable({
                    lineBreaks : true,
                    toggleFontSize : false,
                    closeOnEnter : true
                });
                $newAddress.find('.uphone').editable({
                    lineBreaks : true,
                    toggleFontSize : false,
                    closeOnEnter : true
                });

                // Add to list.
                $newAddress.insertBefore($(this));

                // Hide trigger.
                $(this).css({"display":"none"});
            }).hover(function(){
                $(this).css({"cursor":"pointer"});
            });

            // Save and using new address.
            $save_address = $address_list.find(".save");
            $save_address.live("click", function(){
                $(this).parent().parent().append(
                        '<p class="actived"><input type="radio" name="in_using" >使用该地址</p>'
                );
                // Show add trigger.
                $add_address.css({"display":"initial"});
                // Using address.
                $(this).parent().parent().find(".actived").trigger("click");
                // Clear.
                $(this).parent().remove();
            });

            // Cancel using new address.
            $cancel_address = $address_list.find(".cancel");
            $cancel_address.live("click", function(){
                $(this).parent().parent().remove();
                $add_address.css({"display":"initial"});
            });


            // Select pre-address.
            $pre_address = $address_list.find(".pre_address");
            $pre_address.cxSelect({
                url: 'json/cityData.min.json',
                selects: ['province', 'city', 'area'],
                emptyStyle: 'none'
            });

            // Directly edit address.
            var editable_params = {
                lineBreaks : true,
                toggleFontSize : false,
                closeOnEnter : true
            }
            $address = $address_list.find(".address");
            $uphone = $address_list.find(".uphone");

            var $editing;
            $address.editable(editable_params);
            $uphone.editable(editable_params);

            // Listen on when elements getting edited
            var editing_func = function() {
                $editing = $(this);
                $editing.attr({"old":$(this).find("textarea").val()});
                $editing.find('textarea').css({"background-color":"white"});
            }
            $address.live('edit', editing_func);
            $uphone.live('edit', editing_func);
            $address.live('edit', function() {
                $editing.find('textarea').attr({"maxlength":"44"});
            });
            $uphone.live('edit', function() {
                $editing.find('textarea').attr({"maxlength":"11"});
            });
            // Listen on when elements cancel edited
            $(document).keydown(function(event){
                if(event.keyCode == 27){
                    $editing.editable('close');
                    $editing.text($editing.attr("old"));
                }
            });

            /* Adress module END */

            /* Invoice module START */

            $(".invoice .content .title [type='radio']").click(function(){
                if($(this).val() == "institution") {
                    $(this).parent().parent().find(".institution_address").removeAttr("disabled");
                } else {
                    $(this).parent().parent().find(".institution_address").attr("disabled", "disabled");
                }

            });
            $(".center .invoice_info .not_issuing_invoicing").click(function() {
                if($(this).is(':checked')) {
                    $(this).siblings().css({"display":"none"});
                } else {
                    $(this).siblings().css({"display":"initial"});
                }
            });

            $(".center .invoice_info .subtitle2 .alter").click(function(){
                $(".invoice").fadeIn(100);
            }).hover(function(){
                $(this).css({"cursor":"pointer"});
            });

            $(".invoice .close_window").click(function(){
                $(".invoice").fadeOut(100);
            }).hover(function(){
                $(this).css({"cursor":"pointer"});
            });

            /* Invoice navigator START */

            $(".invoice .navigator >*").click(function(){
                $(".invoice .navigator >.actived").removeClass("actived");
                $(this).addClass("actived");
                $(".invoice .content >.actived").removeClass("actived");
                $(".invoice .content >*").eq($(this).index()).addClass("actived");
            });

            /* Invoice navigator END */

            $(".invoice .content .normal button, .invoice .content .digital button").click(function(){
                $(this).siblings("*").removeClass("actived");
                $(this).addClass("actived");
            })

            var step = 1;
            $(".invoice .content .VAT .prev").click(function(){
                step--;
                updateVATStepsUI();
            });
            $(".invoice .content .VAT .next").click(function(){
                step++;
                updateVATStepsUI();
            });

            var $vat = $(".invoice .content .VAT");
            function updateVATStepsUI(){
                if (step > 1){
                    $vat.find(".option-innerHTML").text($vat.find("[type='radio'][name='option']:checked").attr("text"));
                    $vat.find(".option").addClass("actived");
                } else {
                    $vat.find(".option").removeClass("actived");
                }
                $vat.find(".diagram >*, .invoice .content .VAT .steps >*").removeClass("actived");
                $vat.find(".diagram >:lt(" + step + ")").addClass("actived");
                $vat.find(".diagram >:lt(" + step + ") hr").addClass("actived");
                $vat.find(".steps >:nth-child(" + step + ")").addClass("actived");
            }

            $(".invoice .content .submit").click(function(){
                $(".invoice").fadeOut(100);
            });

            // Initial invoice
            $(".invoice .navigator :first-child").trigger("click");
            /* Invoice module END */

        });
    </script>

</html>