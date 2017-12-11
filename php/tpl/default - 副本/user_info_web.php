<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">用户昵称编辑</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<form action="user_info.php" method="post" onsubmit="return tgSubmit()">
<input type="hidden" name="act" value="post" />
<div class="index-wrapper">

    <div class="add-txt">

    <ul class="add-txt-ul">
		<li><span class="add-txt-item">昵称</span><input id="name" name="name" type="text" value="<?php echo $obj_user_name;?>" class="add-txt-name" placeholder="请填写您的昵称"/></li>
		<li><span class="add-txt-item">电话</span><input id="tel" name="tel" type="text" value="<?php echo $obj_user->tel;?>" class="add-txt-name" placeholder="请填写您的手机号码"/></li>
		<li><span class="add-txt-item">&nbsp;</span><input name="" type="submit" value="保 存" class="add-button" /></li>
	</ul>

    </div>
</div>
</form>
<?php include TEMPLATE_DIR.'/footer_web.php';?>
<?php include_once('common_footer.php');?>
