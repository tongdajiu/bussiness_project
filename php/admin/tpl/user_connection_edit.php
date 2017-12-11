<form action="?module=user_connection_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit">
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">用户推荐关系信息编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label id="name">当前用户id:<font style="color:#f00;">*</font></label>
<input type="text" id="userid" value="<?php echo $obj->userid; ?>" name="userid" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">邀请人id:<font style="color:#f00;">*</font></label>
<input type="text" id="fuserid" value="<?php echo $obj->fuserid; ?>" name="fuserid" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">邀请M码信息:<font style="color:#f00;">*</font></label>
<input type="text" id="minfo" value="<?php echo $obj->minfo; ?>" name="minfo" class="regTxt" />
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
			   "userid": {
				   required: true
			   },
			   "fuserid": {
				   required: true
			   },
			   "minfo": {
				   required: true
			   }
	  		}
	    });
    });
</script>