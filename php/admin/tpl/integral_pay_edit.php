<form action="?module=integral_pay_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit">
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList"> 
<li> 
<label id="name">选择分类<font style="color:#f00;">*</font></label> 
<select name="group" id="group" class="srchField selectField">
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
<label id="name">所属用户:<font style="color:#f00;">*</font></label> 
<input type="text" id="userid" value="<?php echo $obj->userid; ?>" name="userid" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">使用积分的数量:<font style="color:#f00;">*</font></label> 
<input type="text" id="integral" value="<?php echo $obj->integral; ?>" name="integral" class="regTxt" /> 
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
