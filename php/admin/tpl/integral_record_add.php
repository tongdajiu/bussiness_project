<form action="?module=integral_record_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">  
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
<label id="name">用户ID:<font style="color:#f00;">*</font></label> 
<input type="text" id="userid" value="" name="userid" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">团购ID:<font style="color:#f00;">*</font></label> 
<input type="text" id="pin_id" value="" name="pin_id" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">团购类型0->发起，1->参与，:<font style="color:#f00;">*</font></label> 
<input type="text" id="pin_type" value="" name="pin_type" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">订单id:<font style="color:#f00;">*</font></label> 
<input type="text" id="order_id" value="" name="order_id" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">积分:<font style="color:#f00;">*</font></label> 
<input type="text" id="integral" value="" name="integral" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">null:<font style="color:#f00;">*</font></label> 
<input type="text" id="total_time" value="" name="total_time" class="regTxt" /> 
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
