<form action="?module=admin_action" id="regform" class="cmxform" method="post">
	<input type="hidden" name="act" value="edit_save" />

	<div class="regInfo">
		<div class="content_title">管理员修改</div>
			<input type="hidden" value="<?php echo $arrData->id; ?>" name="id" class="regTxt" />
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName" for="username">账号:<font style="color:#f00;">*</font></label>
							<input type="text" id="username" value="<?php echo $arrData->username; ?>" name="username" class="regTxt" />
							<span class="error_tips"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName" for="name">姓名:<font style="color:#f00;">*</font></label>
							<input type="text" value="<?php echo $arrData->name; ?>" name="name" class="regTxt" />
							<span class="error_tips"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName" for="password">密码:<font style="color:#f00;">*</font></label>
							<input type="password" id="password" value="" name="password" class="regTxt" />　（如果不修改密码，则留空！）
							<span class="error_tips"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName" for="group_access">所属用户组:<font style="color:#f00;">*</font></label>
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
								<option value='1' <?php echo $arrData->status == 1 ? 'SELECTED' : ''; ?> >有效</option>
								<option value='0' <?php echo $arrData->status == 0 ? 'SELECTED' : ''; ?> >无效</option>
							</select>
							<span class="error_tips"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName" for="is_del">允许删除:<font style="color:#f00;">*</font></label>
							<select name='is_del' class="regTxt">
								<option value='1' <?php echo $arrData->is_del == 1 ? 'SELECTED' : ''; ?> >允许</option>
								<option value='0' <?php echo $arrData->is_del == 0 ? 'SELECTED' : ''; ?> >不允许</option>
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
			   }
	  		}
	    });
	})
</script>