<!--<script>
$(function(){
	($(type).val() == "3") ? $("#typeclass").show() : $("#typeclass").hide();
	$("#type").on("change", function(){
		($(type).val() == "3") ? $("#typeclass").show() : $("#typeclass").hide();
	});
});
</script>-->
<form action="?module=goods_tag_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save"/>
<input type="hidden" name="id" value="<?php echo $tagInfo->id; ?>"/>
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">标签图片编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList">

<li>
<label class="labelName">标题:</label>
<input type="text" id="title" value="<?php echo $tagInfo->title; ?>" name="title" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">标签类型:</label>
<select id="type" name="type" class="select" style="WIDTH: 100PX;" >
<?php while(list($key,$var) = each($HotType)){ ?>
      <option value="<?php echo $key;?>"<?php if($tagInfo->type == $key){echo 'selected';}?> ><?php echo $var;?></option>
<?php } ?>
</select>
<div class="clear"></div>
</li>

<li>
<label class="labelName">图片：</label>
<img src="../upfiles/label/<?php echo $tagInfo->images; ?>" height="100" /><input type="file" name="images" />
<input type="hidden" name="image_before" value="<?php echo $tagInfo->images; ?>" />
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