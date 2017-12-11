<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="list-nav">
    <a href="javascript:window.history.back(-1);" class="top-left top-back">后退</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">提现申请</div>
</div>
<form action="distributor_application.php" method="post" onsubmit="return tgSubmit()">
<input type="hidden" name="act" value="post" />
<div class="index-wrapper">
    <div class="add-txt">
    	<ul class="add-txt-ul">
    		<li><span class="add-txt-item">姓名：</span><input id="name" name="name" type="text" value="" class="add-txt-number" placeholder="请填写您的姓名" /></li>
    		<li><span class="add-txt-item">身份证号码：</span><input id="id_number" name="id_number" type="text" value="" class="add-txt-add" placeholder="请填写您的身份证号码" /></li>
              <span class="add-txt-item">提现方式:</span>
              <div class="add-txt-width-box">
                <select id="pay_method" name="pay_method" class="add-txt-width">
                 <option value="0">请选择</option>
                 <option value="1"<?php if($distributor_money->pay_method == 1){echo "selected";}?> >支付宝</option>
                 <option value="2"<?php if($distributor_money->pay_method == 2){echo "selected";}?> >微信</option>
                </select>
              </div>
              <div class="clear"></div>
            </li>
    		 <li><span class="add-txt-item">账  号：</span><input id="account_number" name="account_number" type="text" value="" class="add-txt-add" placeholder="请填写您的账号" /></li>
    		<li><span class="add-txt-item">&nbsp;</span><input name="" type="submit" value="提  交" class="add-button" /></li>
    	</ul>
    </div>
</div>
</form>