<form action="?module=article_type_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit_save" />
	<input type="hidden" name="id" value="<?php echo $obj->id; ?>" />
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">文章分类添加</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName">分类名称:<font style="color:#f00;">*</font></label>
							<input type="text" id="name" value="<?php echo $obj->name; ?>" name="name" class="regTxt" />
							<div class="clear"></div>
						</li>
						<li>
							<label class="labelName">文章类型:<font style="color:#f00;">*</font></label>
							<select class="type" name="type">
							<?php foreach( $ArticleType as $key=>$article ){ ?>
							<option value="<?php echo $key ?>" <?php if($obj->type == $key){ echo 'selected'; } ?> ><?php echo $article ?></option>
							<?php } ?>
							</select>
							<div class="clear"></div>
						</li>			
					</ul>
				</dd>
			</dl>
			<div class="clear"></div>
			<p style="float:left; padding-left:10%;"></p>
			<p class="continue">
				<input type="submit" class="continue" id="btn_next" value=" 确定 " />
				<input type="reset" class="continue" id="btn_reset" value=" 重置 " />
			</p>
		</div>
	</div>
</form>
<script>
$(function(){
	$("#regform").validate({
        rules: {
		   "name": {
			   required: true
		   },
		   "type": {
			   required: true
		   }
  		}
    });
})
</script>