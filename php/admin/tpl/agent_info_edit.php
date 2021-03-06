<form action="?module=agent_info_action" id="regform" class="cmxform"
	method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit_save"> <input type="hidden"
		name="id" value="<?php echo $infoList->id;?>"> <input type="hidden"
		name="userid" value="<?php echo $infoList->userid; ?>">
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">加盟分销商信息编辑</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li><label class="labelName">真实姓名:<font style="color: #f00;">*</font></label>
							<input type="text" value="<?php echo $infoList->name; ?>"
							name="name" class="regTxt" />
							<div class="clear"></div></li>
						<li><label class="labelName">手机号码:<font style="color: #f00;">*</font></label>
							<input type="text" id="mobile"
							value="<?php echo $infoList->mobile; ?>" name="mobile"
							class="regTxt" />
							<div class="clear"></div></li>
						<li><label class="labelName">邮箱:<font style="color: #f00;">*</font></label>
							<input type="text" id="email"
							value="<?php echo $infoList->email; ?>" name="email"
							class="regTxt" />
							<div class="clear"></div></li>
						<li><label class="labelName">身份证号码:<font style="color: #f00;">*</font></label>
							<input type="text" id="id_number"
							value="<?php echo $infoList->id_number; ?>" name="id_number"
							class="regTxt" />
							<div class="clear"></div></li>
						<li><label class="labelName">保证金:<font style="color: #f00;">*</font></label>
							<input type="text" id="pre_money"
							value="<?php echo $infoList->pre_money; ?>" name="pre_money"
							class="regTxt" />
							<div class="clear"></div></li>
						<li><label class="labelName">加盟费:<font style="color: #f00;">*</font></label>
							<input type="text" id="join_money"
							value="<?php echo $infoList->join_money; ?>" name="join_money"
							class="regTxt" />
							<div class="clear"></div></li>

					</ul>
				</dd>
			</dl>
			<div class="clear"></div>
			<p style="float: left; padding-left: 10%;"></p>
			<p class="continue">
				<input type="submit" class="continue" id="btn_next" value=" 确定 " /><input
					type="reset" class="continue" id="btn_next" value=" 重置 " />
			</p>
		</div>
	</div>
</form>
<script>
      $(function(){
		jQuery.validator.addMethod("phone", function(value, element) {
		    var tel = /^(\-[0-9]{1,4})?$|(^(13[0-9]|15[0|3|6|7|8|9]|18[8|9])\d{8}$)/;
		    return this.optional(element) || (tel.test(value));
		}, "请输入正确的手机号码");
		jQuery.validator.addMethod("idNumber", function(value, element) {
		    var tel = /^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/;
		    return this.optional(element) || (tel.test(value));
		}, "请输入正确的身份证号码");
		$("#regform").validate({
	        rules: {
			   "name": {
				   required: true
			   },
			   "mobile": {
				   required: true,
				   phone: true
			   },
			   "id_number": {
				   required: true,
				   idNumber: true
			   },
			   "email": {
				   required: true,
				   email: true
			   },
			   "pre_money": {
				   required: true,
				   number: true
			   },
			   "join_money": {
				   required: true,
				   number: true
			   }
	  		}
	    });
    });
</script>