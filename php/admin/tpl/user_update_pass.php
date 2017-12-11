<form action="?module=user_update_pass" id="regform" class="cmxform" method="post">
	<input type="hidden" name="act" value="post">
	<input type="hidden" name="id" value="<?php echo $user->id; ?>">
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
            <div class="content_title">修改密码</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName">新密码:<font style="color:#f00;">*</font></label>
							<input type="password" id="password" value="" name="password" class="regTxt" />
							<div class="clear"></div>
						</li>
                        <li>
                            <label class="labelName">确认新密码:<font style="color:#f00;">*</font></label>
                            <input type="password" id="repassword" value="" name="repassword" class="regTxt" />
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
<script>
$(function(){
	$("#regform").validate({
        rules: {
		   "password": {
			   required: true
		   },
		   "repassword": {
			   required: true,
			   equalTo: '#password'
		   }
  		},
  		messages:{
  			"repassword": {
			   equalTo: '两次密码输入不一致'
		   }
  		}
    });
})
</script>