<form action="?module=user_connection_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">  
<input type="hidden" name="act" value="post">
<input type="hidden" name="status" value="1">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">添加</div>
 <dl class="ott">
<dd>
<ul class="ottList"> 
<li> 
<label id="name">选择分类<font style="color:#f00;">*</font></label> 
<select name="type" id="type" class="srchField selectField">
<?php
foreach($grouplist as $tlist) {
					$xsel = $obj->type == $tlist->id ? ' selected' : '';
?>
<option value="<?php echo $tlist->id;?>" <?php echo $xsel;?>>
<?php echo $tlist->name;?>
</option>
<?php
}
?>
</select>
<div class="clear"></div> 
</li> 
<li> 
<label id="name">当前用户:<font style="color:#f00;">*</font></label> 
<input type="text" id="userid" value="" name="userid" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">邀请人:<font style="color:#f00;">*</font></label> 
<input type="text" id="fuserid" value="" name="fuserid" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">邀请M码信息:<font style="color:#f00;">*</font></label> 
<input type="text" id="minfo" value="" name="minfo" class="regTxt" /> 
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
