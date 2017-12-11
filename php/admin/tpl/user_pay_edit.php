<form action="?module=user_pay_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
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
<label id="name">:<font style="color:#f00;">*</font></label>
<input type="text" id="cash_num" value="<?php echo $obj->cash_num; ?>" name="cash_num" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">:<font style="color:#f00;">*</font></label>
<input type="text" id="payment" value="<?php echo $obj->payment; ?>" name="payment" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">:<font style="color:#f00;">*</font></label>
<input type="text" id="userid" value="<?php echo $obj->userid; ?>" name="userid" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">:<font style="color:#f00;">*</font></label>
<input type="text" id="card_number" value="<?php echo $obj->card_number; ?>" name="card_number" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">:<font style="color:#f00;">*</font></label>
<input type="text" id="pay_status" value="<?php echo $obj->pay_status; ?>" name="pay_status" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">null:<font style="color:#f00;">*</font></label>
<input type="text" id="order_number" value="<?php echo $obj->order_number; ?>" name="order_number" class="regTxt" />
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
