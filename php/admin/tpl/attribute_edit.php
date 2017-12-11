<form action="?module=attribute_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit_save">
	<input type="hidden" name="attr_id" value="<?php echo $obj->attr_id;?>">
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
            <div class="content_title">产品属性编辑</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName">属性名称:<font style="color:#f00;">*</font></label>
							<input type="text" id="attr_name" value="<?php echo $obj->attr_name; ?>" name="attr_name" class="regTxt" />
							<div class="clear"></div>
						</li>
						<li>
							<label class="labelName">属性值:<font style="color:#f00;">*</font></label>
							<textarea name="attr_value" rows="10" cols="40" wrap="off"><?php echo $obj->attr_value; ?></textarea>
							(注：以回车键划分，每一行为一个值)
							<div class="clear"></div>
						</li>
						<li>
							<label class="labelName">排序:<font style="color:#f00;">*</font></label>
							<input type="text" id="sorting" value="<?php echo $obj->sorting; ?>" name="sorting" class="regTxt" />
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
		   "attr_name": {
			   required: true
		   },
		   "attr_value": {
			   required: true
		   },
		   "sorting": {
			   required: true,
			   number: true
		   }
  		}
    });
})
</script>