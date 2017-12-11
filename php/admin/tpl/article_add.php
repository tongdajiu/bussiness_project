<form action="?module=article_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="add_save" />
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">文章信息添加</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName">标题:<font style="color:#f00;">*</font></label>
							<input type="text" id="title" value="" name="title" class="regTxt" />
							<div class="clear"></div>
						</li>
						<li>
							<label class="labelName">状态:</label>
							<select id="state" name="status" class="select" style="WIDTH: 100PX;">
							   <option value="0" >禁用</option>
							   <option value="1" >开启</option>
							</select>
							<div class="clear"></div>
						</li>
						<!--  
						<li>
							<label class="labelName">文章封面:</label>
							<input type="file" name="image" value="" class="regTxt" />
							<div class="clear"></div>
						</li>
						-->
						<li>
							<label class="labelName">文章类型:</label>
							<select class="type" name="channel" id="channel">
								<option value="0">----</option>
								<?php foreach($channels as $key=>$row){ ?>
									<option value="<?php echo $key; ?>" ><?php echo $row;?></option>
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
								<script id="editor" type="text/plain" style="width:500px;height:600px;"></script>
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

	triggerCates();
	$("#channel").on("change", function(){
		triggerCates();
	});
});

function triggerCates(){
	var channelid = $("#channel").find("option:selected").val();
	var str = '<option value="0">----</option>';
	var cates = mapTypeCate[channelid];
	for(var i in cates){
		str += '<option value="'+cates[i].id+'">'+cates[i].name+'</option>';
	}
	$("#type").html(str);
}
</script>