
<form action="?module=user_address_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save">
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">用户地址编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">城市:<font style="color:#f00;">*</font></label>
<input type="text" id="city" value="<?php echo $obj->city; ?>" name="city" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">区:<font style="color:#f00;">*</font></label>
<input type="text" id="area" value="<?php echo $obj->area; ?>" name="area" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">详细地址:<font style="color:#f00;">*</font></label>
<input type="text" id="address" value="<?php echo $obj->address; ?>" name="address" class="regTxt" />
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
<script type="text/javascript">
    $(function(){
		$("#regform").validate({
	        rules: {
			   "city": {
				   required: true
			   },
			   "area": {
				   required: true
			   },
			   "address": {
				   required: true
			   }
	  		}
	    });
    });
</script>