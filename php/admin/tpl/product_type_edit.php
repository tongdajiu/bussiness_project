<form action="?module=product_type_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save">
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<input type="hidden" name="num" value="<?php echo $obj->num; ?>">
<input type="hidden" name="classid" value="<?php echo $obj->classid; ?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">产品类型信息编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">类型名称:<font style="color:#f00;">*</font></label>
<input type="text" value="<?php echo $obj->name; ?>" name="name" class="regTxt" />
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