<?php include_once('common_header.php');?>
<link href="res/css/index4.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript">
function del(id){
	if(window.confirm('确定删除该记录？')){
		location.href='address_info.php?act=del&id[]='+id;
	}

}
</script>
<?php include_once('loading.php');?>
<div class="list-nav">

	<a href="user.php" class="add-nav-L"></a>
    <div class="member-nav-M">领奖信息管理</div>
	<a href="index.php" class="member-to-index-R" ></a>
</div>
<form action="egg_address.php" method="post" onsubmit="return tgSubmit()">
<input type="hidden" name="act" value="post" />
<div class="index-wrapper">
	<div class="add-title"><img src="res/images/add_04.png" alt="" width="93" height="60" /></div>
    <div class="add-txt">
		姓&nbsp;&nbsp;名：<input id="shipping_firstname" name="shipping_firstname" type="text" value="<?php echo $obj_user->name;?>" class="add-txt-name" placeholder="请填写你的真实姓名"/><br />
		手机号码：<input id="telephone" name="telephone" type="text" value="<?php echo $obj_user->tel;?>" class="add-txt-number" placeholder="请填写你的真实电话"/><br />
<!--         收货地址：

         <br/>
        <select id="s_province" name="s_province" style="height:20px;font-size: 15px;"><option value="">省份</option><option value="北京市">北京市</option><option value="天津市">天津市</option><option value="上海市">上海市</option><option value="重庆市">重庆市</option><option value="河北省">河北省</option><option value="山西省">山西省</option><option value="内蒙古">内蒙古</option><option value="辽宁省">辽宁省</option><option value="吉林省">吉林省</option><option value="黑龙江省">黑龙江省</option><option value="江苏省">江苏省</option><option value="浙江省">浙江省</option><option value="安徽省">安徽省</option><option value="福建省">福建省</option><option value="江西省">江西省</option><option value="山东省">山东省</option><option value="河南省">河南省</option><option value="湖北省">湖北省</option><option value="湖南省">湖南省</option><option value="广东省">广东省</option><option value="广西">广西</option><option value="海南省">海南省</option><option value="四川省">四川省</option><option value="贵州省">贵州省</option><option value="云南省">云南省</option><option value="西藏">西藏</option><option value="陕西省">陕西省</option><option value="甘肃省">甘肃省</option><option value="青海省">青海省</option><option value="宁夏">宁夏</option><option value="新疆">新疆</option><option value="香港">香港</option><option value="澳门">澳门</option><option value="台湾省">台湾省</option></select>&nbsp;&nbsp;<br/>
    	<select id="s_city" name="s_city" style="height:20px;font-size: 15px;"><option value="">地级市</option></select>&nbsp;&nbsp;<br/>
    	<select id="s_county" name="s_county" style="height:20px;font-size: 15px;"><option value="">市、县级市</option></select>
    	<script class="resources library" src="js/area.js" type="text/javascript"></script>
    	<script type="text/javascript">_init_area();</script>
       <br />
       <input id="address" name="address" type="text" value="" class="add-txt-add" placeholder="请填写详细的街道和门牌号"/><br/>-->
    <div class="add-button"><input name=""   style="/* text-align: center; */ margin-left: 25px;"  type="submit" value="添 加" class="add-button-y" /></div>
    </div>
</div>
</form>
<?php include "tpl/footer_web.php";?>
<script type="text/javascript">

function tgSubmit(){


	var telephone=$("#telephone").val();
	if($.trim(telephone) == ""){
		alert('请输入手机号码');
		return false;
	}
		if(!isInt(telephone)){
		alert('手机号码必须为11位数字');
		return false;
	}
//	var s_province=$("#s_province").val();
//	if($.trim(s_province) == "省份"){
//		alert('请选择省份');
//		return false;
//	}
//
//	var s_city=$("#s_city").val();
//	if($.trim(s_city) == "地级市"){
//		alert('请选择市区');
//		return false;
//	}
//	/*
//	var s_county=$("#s_county").val();
//	if($.trim(s_county) == "市、县级市"){
//		alert('请选择区县');
//		return false;
//	}*/
//	var address=$("#address").val();
//	if($.trim(address) == ""){
//		alert('请输入新地址');
//		return false;
//	}
	return true;
}

function isInt(a)
{
    var reg = /^(\d{11})$/;
    return reg.test(a);
}
</script>
<?php include_once('common_footer.php');?>
