<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../res/js/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="../res/js/jquery.datepick-zh-CN.js"></script>
<link rel="stylesheet" type="text/css" href="../res/css/jquery.datepick.css" />
<script type="text/javascript">
	$(function(){
		$("#birthday").datepick({showOn:'button',buttonImage:'../res/images/calendar-blue.gif',dateFormat:'yy-mm-dd'});
	});
</script>
<form action="?module=user_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="post" />
<input type="hidden" name="status" value="1" />
<input type="hidden" name="type" value="512" />
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">添加</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<!--<li>
<label id="name">选择分类<font style="color:#f00;">*</font></label>
<select name="type" id="type" class="srchField selectField">
<?php
while(list($key, $val) = each($UserType)){
?>
<option value="<?php echo $key;?>"><?php echo $val;?></option>
<?php
}
?>
</select>
<div class="clear"></div>
</li>
<li>
<label id="name">会员级别:</label>
<select name="level">
	<option value="0">普通会员</option>
</select>
<div class="clear"></div>
</li>
-->
<li>
<label id="name">推荐值:</label>
<input type="text" id="sorting" value="" name="sorting" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">账户:<font style="color:#f00;">*</font></label>
<input type="text" id="username" value="" name="username" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">密码:<font style="color:#f00;">*</font></label>
<input type="password" id="pass" value="" name="pass" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">姓名:</label>
<input type="text" id="name" value="" name="name" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">性别:</label>
<input type="radio" class="radio" id="male" name="sex" value="0" checked="checked" /><label for="male">&nbsp;男</label>
<input type="radio" class="radio" id="female" name="sex" value="1" /><label for="female">&nbsp;女</label>
<div class="clear"></div>
</li>
<li>
<label id="name">生日:</label>
<input type="text" name="birthday" id="birthday" value="" onfocus="if (value =='生日'){value =''}" onblur="if (value ==''){value='生日'}" style="width:100px;color:green"/>
<div class="clear"></div>
</li>
<li>
<label id="name">邮箱:</label>
<input type="text" id="email" value="" name="email" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">电话:</label>
<input type="text" id="tel" value="" name="tel" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">手机:</label>
<input type="text" id="phone" value="" name="phone" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">邀请人:</label>
<input type="text" id="invitation_name" value="" name="invitation_name" class="regTxt" />
<div class="clear"></div>
</li>
<!--<li>
<label id="name">是否查看:</label>
<input type="radio" class="radio" id="yes" name="isread" value="1" checked="checked" /><label for="yes">&nbsp;是</label>
<input type="radio" class="radio" id="no" name="isread" value="0" /><label for="no">&nbsp;否</label>
<div class="clear"></div>
</li>
<li>
<label id="name">微信ID:</label>
<input type="text" id="openid" value="" name="openid" class="regTxt" />
<div class="clear"></div>
</li> -->
<li>
<label id="name">权限:</label>
<?php foreach($privileges as $pri){
	if($pri->id != 4){
?>
<input type="checkbox" id="privileges<?php echo $pri->id;?>" name="privileges[]" value="<?php echo $pri->id ?>" /><label for="privileges<?php echo $pri->id;?>"><?php echo $pri->name; ?></label>
<?php } } ?>
<div class="clear"></div>
</li>
</ul>
   </dd>
    </dl>
   <div class="clear"></div>

  <p style="float:left; padding-left:10%;"></p>
  <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
   </div>
  </div>
  </form>
