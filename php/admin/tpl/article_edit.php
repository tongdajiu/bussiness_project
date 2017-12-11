<form action="?module=article_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit_save" />
	<input type="hidden" name="status" value="1" />
	<input type="hidden" name="type" value="512" />
	<input type="hidden" name="id" value="<?php echo $list->id;?>" />
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">文章信息修改</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName">标题:<font style="color:#f00;">*</font></label>
							<input type="text" id="title" value="<?php echo $list->title;?>" name="title" class="regTxt" />
							<div class="clear"></div>
						</li>
						<li>
							<label class="labelName">状态:</label>
							<select id="state" name="status" class="select" style="WIDTH: 100PX;">
							   <option value="0"<?php if($list->status == 0){echo "selected";}?> >禁用</option>
							   <option value="1"<?php if($list->status == 1){echo "selected";}?> >开启</option>
							</select>
							<div class="clear"></div>
						</li>
						<!-- 
						<li>
							<label class="labelName">文章封面:</label>
							<input type="file" name="image" value="" class="regTxt" />
							<p style="clear:both;padding-left:212px;"><?php renderPic($list->image, 'small', 6,array('h'=>150));?></p>
							<div class="clear"></div>
						</li>
						 -->
						<li>
							<label class="labelName">文章类型:</label>
							<select class="type" name="channel" id="channel">
								<option value="0">----</option>
								<?php foreach($channels as $key=>$row){ ?>
									<option value="<?php echo $key; ?>"<?php if($key == $channelId) echo ' selected';?>><?php echo $row;?></option>
								<?php } ?>
							</select>
							<div class="clear"></div>
						</li>
						<li>
							<label class="labelName">文章分类:</label>
							<select class="type" name="type" id="type"></select>
							<div class="clear"></div>
						</li>
						<li>
							<label class="labelName">内容:<font style="color:#f00;">*</font></label>
							<div style="margin-left:212px;" >
								<script id="editor" type="text/plain" style="width:500px;height:600px;"><?php echo $list->content;?></script>
							</div>
							<input type="hidden" name="content" value="" id="content" />
							<div class="clear"></div>
						</li>
					</ul>
				</dd>
			</dl>
			<div class="clear"></div>
			<p style="float:left; padding-left:10%;"></p>
			<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" value=" 重置 " id="btn_reset"  /></p>
		</div>
	</div>
</form>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.all.min.js"> </script>
<script language="javascript">
var mapTypeCate = <?php if(empty($map)){echo '{}';}else{echo json_encode($map);}?>;
var ue = UE.getEditor('editor');
window.onload=function(){
	var btn_next=document.getElementById("btn_next");
	var mycontent=document.getElementById("content");
	var btn_reset=document.getElementById("btn_reset");
	var title=document.getElementById("title");


	btn_next.onclick=function(){

		if (ue.getContent() == '')
		{
			alert('内容不能为空');
			return false;
		}
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
		   "editor": {
			   required: true
		   }
  		}
    });

	triggerCates(<?php echo $list->type;?>);
	$("#channel").on("change", function(){
		triggerCates();
	});
})

function triggerCates(cid){
	var channelid = $("#channel").find("option:selected").val();
	var str = '<option value="0">----</option>';
	var cates = mapTypeCate[channelid];
	for(var i in cates){
		str += '<option value="'+cates[i].id+'"';
		if((typeof(cid) != "undefined") && (cid == cates[i].id)) str += ' selected';
		str += '>'+cates[i].name+'</option>';
	}
	$("#type").html(str);
}
</script>