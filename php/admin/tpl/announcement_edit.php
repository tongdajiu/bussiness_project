<form action="?module=announcement_action" id="regform" class="cmxform"
	method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit_save" /> 
	<input type="hidden" name="id" value="<?php echo $list->id;?>" />
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">信息修改</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li><label class="labelName">标题:<font style="color: #f00;">*</font></label>
							<input type="text" id="title" value="<?php echo $list->title;?>"
							name="title" class="regTxt" />
							<div class="clear"></div></li>
						<li><label class="labelName">信息地址:</label> <input type="text"
							id="url" value="<?php echo $list->url;?>" name="url"
							class="regTxt" />(如设置了信息地址，下方的内容可不用设置)
							<div class="clear"></div></li>
						<li><label class="labelName">状态:</label> <select id="state"
							name="status" class="select" style="WIDTH: 100PX;">
								<option value="0"
									<?php if($list->status == 0){echo "selected";}?>>禁用</option>
								<option value="1"
									<?php if($list->status == 1){echo "selected";}?>>开启</option>
						</select>
							<div class="clear"></div></li>
						<li><label class="labelName">内容:</label>
							<div style="margin-left: 212px;">
								<script id="editor" type="text/plain"
									style="width: 500px; height: 600px;"><?php echo $list->content;?></script>
							</div> <input type="hidden" name="content" value="" id="content" />
							<div class="clear"></div></li>
					</ul>
				</dd>
			</dl>
			<div class="clear"></div>
			<p style="float: left; padding-left: 10%;"></p>
			<p class="continue">
				<input type="submit" class="continue" id="btn_next" value=" 确定 " /><input
					type="reset" class="continue" value=" 重置 " id="btn_reset" />
			</p>
		</div>
	</div>
</form>
<script type="text/javascript" charset="utf-8"
	src="<?php echo __UTILS__;?>/umeditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8"
	src="<?php echo __UTILS__;?>/umeditor/ueditor.all.min.js"> </script>
<script language="javascript">
	var ue = UE.getEditor('editor');
	window.onload=function(){
		var btn_next=document.getElementById("btn_next");
		var mycontent=document.getElementById("content");
		var btn_reset=document.getElementById("btn_reset");
		var title=document.getElementById("title");


		btn_next.onclick=function(){


			mycontent.value=ue.getContent();
			return true;
		}

		btn_reset.onclick=function(){
			mycontent.value = '';
			ue.setContent('');
		}
	}

$(function(){

	$("#regform").validate({
        rules: {
		   "title": {
			   required: true
		   },
  		"url": {
			   url: true
  		  },
  		}
    });
})
</script>