<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
</script>
<form action="?module=user_action" id="regform" class="cmxform" method="post"
enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit_save">
	<input type="hidden" name="id" value="<?php echo $obj->id;?>">
	<input type="hidden" name="type" value="<?php echo $obj->type;?>">
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">
				用户信息编辑
			</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName">
								会员级别:
							</label>
							<select id="level" name="level">
								<option value="0">
									普通会员
								</option>
							</select>
							<div class="clear">
							</div>
						</li>
						<li style="display: none">
							<label class="labelName">
								推荐值:
							</label>
							<input type="text" id="sorting" value="<?php echo $obj->sorting;?>" name="sorting"
							class="regTxt" />
							<div class="clear">
							</div>
						</li>
						<li>
							<label class="labelName">
								姓名:
							</label>
							<input type="text" value="<?php echo $obj->name;?>" name="name" class="regTxt"
							/>
							<div class="clear">
							</div>
						</li>
						<li>
							<label class="labelName">
								性别:
							</label>
							<label>
								<input type="radio" class="radio" name="sex" value="0" <?php echo $obj->
								sex == 0 ? "checked" : ''; ?> />&nbsp;未知
							</label>
							<label>
								<input type="radio" class="radio" name="sex" value="1" <?php echo $obj->
								sex == 1 ? "checked" : ''; ?> />&nbsp;男
							</label>
							<label>
								<input type="radio" class="radio" name="sex" value="2" <?php echo $obj->
								sex == 2 ? "checked" : ''; ?> />&nbsp;女
							</label>
							<div class="clear">
							</div>
						</li>
						<li>
							<label class="labelName">
								生日:
							</label>
							<input type="text" name="birthday" id="birthday" class="wdatePicker" value="<?php if($obj->birthday!=''){echo date('Y-m-d',$obj->birthday);}else{echo "
							生日 ";}?>" onFocus="WdatePicker()" style="width: 100px; color: green" />
							<div class="clear">
							</div>
						</li>
						<li>
							<label class="labelName">
								邮箱:
							</label>
							<input type="text" id="email" value="<?php echo $obj->email;?>" name="email"
							class="regTxt" />
							<div class="clear">
							</div>
						</li>
						<li>
							<label class="labelName">
								电话:
							</label>
							<input type="text" id="tel" value="<?php echo $obj->tel;?>" name="tel"
							class="regTxt" />
							<div class="clear">
							</div>
						</li>
						<li>
							<label class="labelName">
								手机:
							</label>
							<input type="text" id="phone" value="<?php echo $obj->phone;?>" name="phone"
							class="regTxt" />
							<div class="clear">
							</div>
						</li>
						<li>
							<label class="labelName">
								邀请人:
							</label>
							<input type="text" id="invitation_name" value="<?php echo $obj->invitation_name;?>"
							name="invitation_name" class="regTxt" />
							<div class="clear">
							</div>
						</li>
					</ul>
				</dd>
			</dl>
			<div class="clear">
			</div>
			<p style="float: left; padding-left: 10%;">
			</p>
			<p class="continue">
				<input type="submit" class="continue" id="btn_next" value=" 确定 " />
				<input type="reset" class="continue" id="btn_next" value=" 重置 " />
			</p>
		</div>
	</div>
</form>
<script>
	$(function() {
		jQuery.validator.addMethod("tel",
		function(value, element) {
			var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+$/;
			return this.optional(element) || (tel.test(value));
		},
		"请输入正确的电话号码");
		jQuery.validator.addMethod("phone",
		function(value, element) {
			var tel = /^(\-[0-9]{1,4})?$|(^(13[0-9]|15[0|3|6|7|8|9]|18[8|9])\d{8}$)/;
			return this.optional(element) || (tel.test(value));
		},
		"请输入正确的手机号码");

		$("#regform").validate({
			rules: {
				"email": {
					email: true
				},
				"tel": {
					tel: true
				},
				"phone": {
					phone: true
				}
			}
		});
	})
</script>