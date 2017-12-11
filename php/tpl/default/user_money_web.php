<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="list-nav">
    <a href="javascript:window.history.back(-1);" class="top-left top-back">后退</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">提现申请</div>
</div>
<form action="user_money.php" method="post" onsubmit="return tgSubmit()">
<input type="hidden" name="act" value="post" />
<div class="index-wrapper">
    <div class="add-txt">
    	<ul class="add-txt-ul">
    		<li><span class="add-txt-item">手机号码</span><input id="mobile" name="mobile" type="text" value="" class="add-txt-number" placeholder="请填写您的真实电话"/></li>
    		<li><span class="add-txt-item">身份证号码</span><input id="id_number" name="id_number" type="text" value="" class="add-txt-add" /></li>
    		<li><span class="add-txt-item">金 额</span><input id="money" name="money" type="text" value="" class="add-txt-add" /></li>
    		<li><span class="add-txt-item">&nbsp;</span><input name="" type="submit" value="提  交" class="add-button" /></li>
    	</ul>
    </div>
</div>
</form>
<?php include "footer_web.php";?>