<form action="?module=admin_action" id="regform" class="cmxform" method="post">
	<input type="hidden" name="act" value="add_save" />

	<div class="regInfo">
		<div class="content_title">管理员添加</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName" for="username">账号:<font style="color:#f00;">*</font></label>
							<input type="text" id="username" value="" name="username" class="regTxt" />
							<span class="error_tips"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName" for="name">姓名:<font style="color:#f00;">*</font></label>
							<input type="text" value="" name="name" class="regTxt" />
							<span class="error_tips"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName" for="password">密码:<font style="color:#f00;">*</font></label>
							<input type="password" id="password" value="" name="password" class="regTxt" />
							<span class="error_tips"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName" for="group">所属用户组:<font style="color:#f00;">*</font></label>
							<select name='group_access' class="regTxt">
								<?php foreach( $arrAdminGroup as $AdminGroup ){ ?>
									<option value='<?php echo $AdminGroup->id; ?>'><?php echo $AdminGroup->title; ?></option>
								<?php } ?>
							</select>
							<span class="error_tips"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName" for="status">状态:<font style="color:#f00;">*</font></label>
							<select name='status' class="regTxt">
								<option value='1'>有效</option>
								<option value='0'>无效</option>
							</select>
							<span class="error_tips"></span>
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
			   "username": {
				   required: true
			   },
			   "name": {
				   required: true
			   },
			   "password": {
				   required: true
			   },
			   "privileges[]": {
				   required: true
			   }
	  		}
	    });
	})
</script>