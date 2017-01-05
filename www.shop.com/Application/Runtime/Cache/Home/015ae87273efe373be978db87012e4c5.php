<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>收货地址管理</title>
    <link href="/Public/css/ucart.css" rel="stylesheet" type="text/css">
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>


<div class="container">
    <button class="button_color_scheme_dark borderRadius_scheme_small" onclick="history.go(-1)">返回</button>
    <h4>收货地址管理</h4>
    <table class="table table-advance table-bordered text-hover table-striped">
        <tr>
            <th>收货人</th>
            <th>联系方式</th>
            <th>收货地址</th>
            <th>操作</th>
        </tr>
            <?php if(is_array($addresses)): foreach($addresses as $key=>$address): ?><tr>
                <td><?php echo ($address["name"]); ?></td>
                <td><?php echo ($address["tel"]); ?></td>
                <td><?php echo ($address["province_name"]); ?> <?php echo ($address["city_name"]); ?> <?php echo ($address["area_name"]); ?>
                    <?php echo ($address["detail_address"]); ?></td>
                <td>
                    <a data-href="<?php echo U('Address/deleteAddress',['id'=>$address['id']]);?>" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs deleteBtn" id="">删除</a>
                    <input type="hidden" name="id" value="<?php echo ($address['id']); ?>"/>
                    <a href="<?php echo U('User/editAddress',['id'=>$address['id']]);?>"  class="btn btn-xs btn-success">编辑</a>|
                    <?php if($address['is_default'] == 1): ?><span style="color: red;">默认地址 </span>
                    <?php else: ?>
                    <a href="<?php echo U('Address/setDefault',['id'=>$address['id']]);?>">设为默认</a><?php endif; ?>
                </td>
        </tr><?php endforeach; endif; ?>
    </table>
</div>
<div class="container">
    <h4>添加收货地址</h4>
</div>
<div class="container">
    <form class="form" method="post" action="<?php echo U();?>" id="address_form">
        <div class="form-group form-inline">
            <select class="form-control province" style="width: 200px;height: 30px;" name="province_id">
                <option>请选择省份</option>
                <?php if(is_array($provinces)): foreach($provinces as $key=>$province): ?><option value="<?php echo ($province["id"]); ?>"><?php echo ($province["name"]); ?></option><?php endforeach; endif; ?>
            </select>
            <input type="hidden" name="province_name" class="province_name"/>
            <select class="form-control city" style="width: 200px;height: 30px;" name="city_id">
                <option>请选择城市</option>
            </select>
            <input type="hidden" name="city_name" class="city_name"/>
            <select class="form-control area" style="width: 200px;height: 30px;" name="area_id">
                <option>请选择区域</option>
            </select>
            <input type="hidden" name="area_name" class="area_name"/>
        </div>
        <div class="form-group ">
            <label style="float: left">详细地址&nbsp;</label>
            <input type="text" class="form-control" id="exampleInputEmail" placeholder="输入收货人详细地址" style="width: 550px;height: 30px;" name="detail_address" value="<?php echo ($list["detail_address"]); ?>">
        </div>
        <div class="form-group">
            <label style="float: left">收 货 人&nbsp;&nbsp;</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="输入收货人姓名" style="width: 400px;height: 30px;" name="name" value="<?php echo ($list["name"]); ?>">
        </div>
        <div class="form-group">
            <label style="float: left">联系方式&nbsp;</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="输入收货人联系方式" style="width: 400px;height: 30px;" name="tel" value="<?php echo ($list["tel"]); ?>">
        </div>
        <?php if(isset($list)): ?><div class="checkbox">
                <label>
                    <input type="checkbox" name="is_default" value="1" <?php if($list['is_default'] == 1): ?>checked<?php endif; ?>>是否设为默认地址
                </label>
            </div>
            <input type="hidden" name="id" value="<?php echo ($list["id"]); ?>"/>
            <button type="submit" class="btn btn-danger">编辑</button>
            <?php else: ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="is_default" value="1">是否设为默认地址
                </label>
            </div>
            <button type="submit" class="btn btn-danger">添加</button><?php endif; ?>

    </form>
</div>
</body>
<script type="text/javascript" src="/Public/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.validate.min.js"></script>
<script src="/Public/ext/layer/layer.js"></script>
<script>
   $(function(){
       var url = '<?php echo U("Locations/getListByPid");?>';
       $('.province').change(function(){
//           获取选中值的id
           var province_id = $(this).val();
           var data = {pid:province_id};
           $.getJSON(url,data,function(res){
               //先清空城市的数据 值保留第一个
               $('.city').get(0).length = 1;
               $('.area').get(0).length = 1;
               $('.city_name').val('');
               $('.area_name').val('');
               $(res).each(function(i,v){
                   var html = '<option value="'+ v.id+'">'+ v.name+'</option>';
                   $(html).appendTo($('.city'));
               });
           });
       });
       $('.city').change(function(){
//           获取选中值的id
           var area_id = $(this).val();
           var data = {pid:area_id};
           $.getJSON(url,data,function(res){
               //先清空城市的数据 值保留第一个
               $('.area').get(0).length = 1;
               $(res).each(function(i,v){
                   var html = '<option value="'+ v.id+'">'+ v.name+'</option>';
                   $(html).appendTo($('.area'));
               });
           });
       });

       //选中地区时 将值名称加入到隐藏域中
       $('.province').click(function(){
           var name = $(this).find(':checked').text();
           $('.province_name').val(name);
       })
       $('.city').click(function(){
           var name = $(this).find(':checked').text();
           $('.city_name').val(name);
       })
       $('.area').click(function(){
           var name = $(this).find(':checked').text();
           $('.area_name').val(name);
       });

       //-------------jquery-validation验证
           // validate signup form on keyup and submit
           $("#address_form").validate({
               rules: {
                   detail_address: {
                       required: true,
                   },
                   name: {
                       required: true,
                       minlength: 2
                   },
                   tel: {
                       required: true,
                       Ptel:true
                   },
               },
               messages: {
                   detail_address: {
                       required: "详细地址不能为空！",
                   },
                   name: {
                       required: "收货人不能为空！",
                       minlength: "姓名不合法！"
                   },
                   tel: {
                       required: "联系方式不能为空！",
                   },
               }
           });
       $.validator.addMethod('Ptel',telPhone,'手机号码不合法！');
       function telPhone(value){
           if(/^1[34578]\d{9}$/m.test(value)){
               return true;
           }else{
               return false;
           }
       };
       $('.deleteBtn').click(function(){
           var del_id = $(this).next().val();
           var url = "<?php echo U('Address/deleteAddress');?>?id="+del_id;
           layer.confirm('你确定要删除它吗？', {
               btn: ['必须啊','算了吧'] //按钮
           }, function(){
               location.href=url;
           }, function(){

           });
       });
   });

</script>
</html>