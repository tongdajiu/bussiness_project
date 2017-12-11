<form action="?module=tp_keyword_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit">
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList"> 
<li> 
<label id="name">:<font style="color:#f00;">*</font></label> 
<input type="text" id="keyword" value="<?php echo $obj->keyword; ?>" name="keyword" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">:<font style="color:#f00;">*</font></label> 
<input type="text" id="pid" value="<?php echo $obj->pid; ?>" name="pid" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">:<font style="color:#f00;">*</font></label> 
<input type="text" id="token" value="<?php echo $obj->token; ?>" name="token" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">:<font style="color:#f00;">*</font></label> 
<input type="text" id="module" value="<?php echo $obj->module; ?>" name="module" class="regTxt" /> 
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
