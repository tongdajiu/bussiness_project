<?php include_once('common_header.php');?>
<link href="res/css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/main.js"></script>
<script type="text/javascript">
function check_newpass(){
	if($("#pass").val() != $("#re_pass").val()){
		alert("密码输入不一致");
		return false;
	}
	return true;
}
</script>

<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="index.php" class="top-left top-index">首页</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">修改密码</div>
</div>
<form action="" method="post" onsubmit="return check_newpass()">
<input type="hidden" name="userid" value="<?php echo $userid;?>" />
<div class="index-wrapper">
    <div class="password-txt">
    	请输入旧密码：<br /><input name="pass_old" type="password" value="" class="add-txt-add" /><br />
        请输入新密码（6-16位字母或数字）：<br /><input id="pass" name="pass" type="password" value="" class="add-txt-add" /><br />
        再次输入新密码：<br /><input id="re_pass" type="password" value="" class="add-txt-add" />
    <div class="add-button"><input name="" type="submit" value="确 认" class="add-button-y" /></div>
    </div>
</div>
</form>
<?php include "tpl/footer_web.php";?>
<?php include_once('common_footer.php');?>
