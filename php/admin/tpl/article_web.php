<form action="?module=article_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="post">
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<input type="hidden" name="type" value="<?php echo $type;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">文章编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label id="name">标题:</label>
<?php echo $obj->title; ?>
<input type="hidden" id="title" value="<?php echo $obj->title; ?>" name="title" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label id="name">内容:<font style="color:#f00;">*</font></label>
<div style="margin-left:212px;" >
<script id="editor" type="text/plain" style="width:500px;height:240px;"><?php echo $obj->content?></script>
</div>
<input type="hidden" name="content" value="" id="content" />
<div class="clear"></div>
</li>
  </ul>
   </dd>
    </dl>
   <div class="clear"></div>
  <p style="float:left; padding-left:10%;"></p>
  <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" value=" 重置 " /></p>
   </div>
  </div>
  </form>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.all.min.js"> </script>
<script language="javascript">
	var ue = UE.getEditor('editor');
	window.onload=function(){
		var btn_next=document.getElementById("btn_next");
		var mycontent=document.getElementById("content");
		btn_next.onclick=function(){
			mycontent.value=ue.getContent();
			return true;
		}
	}
</script>