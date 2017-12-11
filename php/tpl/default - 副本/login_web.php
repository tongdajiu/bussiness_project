<?php include_once('common_header.php');?>
<link href="res/css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<?php include_once('loading.php');?>

<?php include "head_index.php";?>
<form action="" method="post" onsubmit="return tgSubmit()">
<div class="index-wrapper">
    <div class="password-txt">
        请输入账号：<br /><input id="username" name="username" type="text" value="" class="add-txt-add" placeholder="手机号/会员名/邮箱" /><br />
        请输入密码：<br /><input id="pass" name="pass" type="password" value="" class="add-txt-add" placeholder="密码" /><br />

    <div class="add-button"><input name="" type="submit" value="确 认" class="add-button-y" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="register.php">注 册</a></div>
    </div>
</div>
</form>
<div class="index-foot">
	<div class="index-foot-nav"><a href="index.php">商城首页</a>
	<span class="index-foot-nav-line">|</span><a href="list_art.php?id=2">联系我们</a>
	<span class="index-foot-nav-line">|</span><a href="list_art.php?id=1">品牌介绍</a>
    <div class="index-foot-logo"></div>
    </div>
</div>
<script type="text/javascript">
function tgSubmit(){
	var username=$("#username").val();
	if($.trim(username) == ""){
		alert('请输入账号');
		return false;
	}
	var pass=$("#pass").val();
	if($.trim(pass) == ""){
		alert('请输入密码');
		return false;
	}
	return true;
}
</script>
<?php include_once('common_footer.php');?>
