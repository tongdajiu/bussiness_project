<form action="?module=tp_member_card_create_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="post">
<input type="hidden" name="status" value="1">
<input type="hidden" name="token" value="<?php echo $weixinfo[token];?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">添加</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label id="name">卡号英文编号:<font style="color:#f00;">*</font></label>
<input type="text" id="token" value="" name="serialname" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">起始卡号:<font style="color:#f00;">*</font></label>
<input type="text" id="token" value="" name="stanumber" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">结束卡号:<font style="color:#f00;">*</font></label>
<input type="text" id="number" value="" name="endnumber" class="regTxt" />
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
