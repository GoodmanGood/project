$(".header .top_menu .search_bar .search_bar-input").addClass("borderRadius_scheme_large");
$(".header .top_menu .search_bar .search_bar-submit").addClass("button_color_scheme_dark borderRadius_scheme_large");
$(".header .top_menu .search_bar .cart").addClass("button_color_scheme_dark");

$(function(){
	$searched = $(".header .top_menu .search_bar .search_bar-input");
	$auto_wrapper = $(".header .top_menu .search_bar .auto_wrapper");
	$auto_list = $(".header .top_menu .search_bar .auto_wrapper >*");
	
	$searched.on("input", function(){
		if($(this).val().length > 0){
			var url = search_url;
			var data = {keyword:$('#search-input').val()};
			$.getJSON(url,data,function(res){
				console.debug(res);
				return
				var html = '<li><a href="'+ v.url+'" target="_blank">'+ v.goods_name+'</a></li>';
				$(res).each(function(i,v){
					html += '';
				});
				$('#search-res').html(html);
			})
			$auto_list.css({"color":"currentColor"});
			$auto_wrapper.css({"visibility":"visible"});
		}else{
			$auto_list.css({"color":"transparent"});
			$auto_wrapper.css({"visibility":"hidden"});
		}
	});
	$searched.blur(function(){
		$auto_list.css({"color":"transparent"});
		$auto_wrapper.css({"visibility":"hidden"});
	});
	$auto_list.click(function(){
		$searched.val($(this).text());
	});
});
