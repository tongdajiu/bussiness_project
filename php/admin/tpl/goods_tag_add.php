<!--<script>
$(function(){
	$("#type").on("change", function(){
		($(type).val() == "3") ? $("#typeclass").show() : $("#typeclass").hide();
	});
});
</script>-->
<form action="?module=goods_tag_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="add_save" />
<input type="hidden" name="status" value="1" />
<input type="hidden" name="type" value="512" />
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">标签图片添加</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">标题:</label>
<input type="text" id="form-field-icon-1" value="" name="title" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">标签类型:</label>
<select id="type" name="type" >
<?php while(list($key,$var) = each($HotType)){ ?>
      <option value="<?php echo $key;?>"><?php echo $var;?></option>
<?php } ?>
</select>
<div class="clear"></div>
</li>

<li>
<label class="labelName">请上传图片：</label>
<input multiple type="file" id="id-input-file-3"  name="images" />
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


