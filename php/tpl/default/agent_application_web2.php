<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="index.php" class="top-left top-index">首页</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">分销审核中</div>
</div>
<form action="agent_application.php" method="post" onsubmit="return tgSubmit()">
<input type="hidden" name="act" value="edit_save" />
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<input type="hidden" name="userid" value="<?php echo $obj->userid;?>">
<div class="index-wrapper">
    <div class="add-txt">
    	<ul class="add-txt-ul">
    		<li><span class="add-txt-item">真实姓名</span><input id="name" name="name" type="text" value="<?php echo $obj->name;?>" class="add-txt-name" placeholder="请填写您的真实姓名"/></li>
    		<li><span class="add-txt-item">手机号码</span><input id="mobile" name="mobile" type="text" value="<?php echo $obj->mobile;?>" class="add-txt-number" placeholder="请填写您的真实电话"/></li>
    		<li><span class="add-txt-item">身份证号码</span><input id="id_number" name="id_number" type="text" value="<?php  echo $obj->id_number;?>" class="add-txt-add" /></li>
    		<li><span class="add-txt-item">邮箱</span><input id="email" name="email" type="text" value="<?php echo $obj->email;?>" class="add-txt-add" /></li>
    	   	<li><span class="add-txt-item">&nbsp;</span><input name="" type="submit" value="修 改" class="add-button" /></li>
    	</ul>
    </div>
</div>
</form>
<?php include "footer_web.php";?>
<script type="text/javascript">

function tgSubmit(){

	var name=$("#name").val();
	if($.trim(name) == ""){
		alert('请输入真实姓名');
		return false;
	}
	var mobile=$("#mobile").val();
	if($.trim(mobile) == ""){
		alert('请输入手机号码');
		return false;
	}
	if(!isInt(mobile)){
		alert('手机号码必须为11位数字');
		return false;
	}
	var id_number=$("#id_number").val();
	if(!checkIdNum(id_number)){
		alert('身份证格式不正确');
		return false;
	}
	var email=$("#email").val();
	if(!checkEmail(email)){
		alert('邮箱格式不正确');
		return false;
	}
	return true;
}

function isInt(a){
    var reg = /^(\d{11})$/;
    return reg.test(a);
}

function checkIdNum(a){
	var reg18 = /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
	var reg15 = /^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/;
    return reg18.test(a)||reg15.test(a);
}

function checkEmail(a){
	var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return reg.test(a);
}



</script>
<?php include_once('common_footer.php');?>
