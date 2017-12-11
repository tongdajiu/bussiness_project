<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">提现申请</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<form action="distributor_money.php" method="post" onsubmit="return tgSubmit()">
<input type="hidden" name="act" value="add_save" />
<div class="index-wrapper">
    <div class="add-txt">
    	<ul class="add-txt-ul">
    		<li><span class="add-txt-item">手机号码：</span><input id="mobile" name="mobile" type="text" value="" class="add-txt-number" placeholder="请填写您的真实电话" /></li>
    		<li><span class="add-txt-item">身份证号码：</span><input id="id_number" name="id_number" type="text" value="" class="add-txt-add" placeholder="请填写您的身份证号码" /></li>
    		<li><span class="add-txt-item">申请金额：</span><input id="d_money" name="d_money" type="text" value="" class="add-txt-add" placeholder="请填写申请金额" /></li>
            <li>
              <span class="add-txt-item">提现方式:</span>
              <div class="add-txt-width-box">
                <select id="pay_method" name="pay_method" class="add-txt-width">
                  <option value="0">请选择</option>
                  <?php foreach ( $PayMethod as  $key=>$info ){ ?>
				          <option value="<?php echo $key ?>" <?php echo $key==$pay_method ? "SELECTED" : "" ?>  ><?php echo $info ?></option>
				  <?php } ?>
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
<script type="text/javascript">

function tgSubmit(){
	var telephone=$("#mobile").val();
	var idnumber=$("#id_number").val();
	var dmoney=$("#d_money").val();
	var accountnumber=$("#account_number").val();
	var paymethod=$("#pay_method").val();
	if($.trim(telephone) == ""){
		alert('请输入手机号码');
		return false;
	}
	if(!isPhone(telephone)){
		alert('请输入正确的手机号码');
		return false;
	}
	if($.trim(idnumber) == ""){
		alert('请输入身份证号码');
		return false;
	}
	if(!isIdNum(idnumber)){
		alert('请输入正确的身份证号码');
		return false;
	}
	if($.trim(dmoney) == ""){
		alert('请输入申请金额');
		return false;
	}
	if($.trim(dmoney) < 100){
		alert('提现金额不能低于100元');
		return false;
	}


	if(paymethod == 0){
		alert('请选择提现方式');
		return false;
	}
	if($.trim(accountnumber) == ""){
		alert('请输入账号');
		return false;
	}
	return true;
}

function isPhone(a)
{
    var reg = /^(\-[0-9]{1,4})?$|(^(13[0-9]|15[0|3|6|7|8|9]|18[8|9])\d{8}$)/;
    return reg.test(a);
}
function isIdNum(a)
{
    var reg = /^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/;
    return reg.test(a);
}
</script>
<?php include TEMPLATE_DIR.'/footer_web.php';?>
<?php include_once('common_footer.php');?>