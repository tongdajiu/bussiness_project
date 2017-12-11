<?php include_once('common_header.php');?>
<link href="res/css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/main.js"></script>

<?php include_once('loading.php');?>
<?php include "head_index.php";?>
<form action="" method="post" onsubmit="return tgSubmit()">
<div class="index-wrapper">
    <div class="password-txt">
        请输入账号：<br /><input id="username" name="username" type="text" value="" class="add-txt-add" placeholder="请输入账号" /><br />
        请输入手机号码：<br /><input id="phone" name="phone" type="text" value="" class="add-txt-add" placeholder="请输入手机号码" /><br />
        请输入邮箱：<br /><input id="email" name="email" type="text" value="" class="add-txt-add" placeholder="请输入邮箱" /><br />
        请输入密码（6-16位字母或数字）：<br /><input id="password" name="password" type="password" value="" class="add-txt-add" placeholder="请输入密码" /><br />
        再次输入密码：<br /><input id="re_password" type="password" value="" class="add-txt-add" placeholder="再次输入密码" /><br />
        邀请码(输入正确的邀请码)：<br /><input id="minfo" name="minfo" type="text" value="" class="add-txt-add" placeholder="邀请码" />
    <div class="add-button"><input name="" type="submit" value="确 认" class="add-button-y" /></div>
    </div>
</div>
</form>
<script type="text/javascript">
function tgSubmit(){
	var username=$("#username").val();
	if($.trim(username) == ""){
		alert('请输入账号');
		return false;
	}
	var phone=$("#phone").val();
	if($.trim(phone) == ""){
		alert('请输入手机号码');
		return false;
	}
	var password=$("#password").val();
	if($.trim(password) == ""){
		alert('请输入密码');
		return false;
	}
	var re_password=$("#re_password").val();
	if(password != re_password){
		alert('密码输入不一致');
		return false;
	}
	return true;
}
</script>
<?php include "footer_web.php";?>
<?php include_once('common_footer.php');?>
