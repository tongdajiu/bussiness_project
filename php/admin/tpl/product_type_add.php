<form action="?module=product_type_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="add_save">
<input type="hidden" name="classid" value="<?php echo $classid; ?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">添加产品类型</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">类型名称:<font style="color:#f00;">*</font></label>
<input type="text" value="" name="name" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">排序:<font style="color:#f00;">*</font></label>
<input type="text" id="sorting" value="" name="sorting" class="regTxt" />
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
		   },
		   "sorting": {
			   required: true,
			   number: true
		   }
  		}
    });
})
</script>
