<form action="?module=unit_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="add_save">
<input type="hidden" name="status" value="1">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">单位添加</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">名称:<font style="color:#f00;">*</font></label>
<input type="text" value="" name="name" class="regTxt" />
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
		   "name": {
			   required: true
		   }
  		}
    });
})
</script>