<script type="text/javascript">
	$(function(){
		$("input[name='is_show'][value='<?php echo $obj->is_show;?>']").attr("checked","checked");
	});
</script>

<form action="?module=tp_diymen_class" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit_save">
	<input type="hidden" name="id" value="<?php echo $obj->id;?>">

	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">编辑</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName">标题:<font style="color:#f00;">*</font></label>
							<input type="text" id="title" value="<?php echo $obj->title; ?>" name="title" class="regTxt" />
							<span style="font-size:12px; color:red;"> (注： 如果该选项不显示在微信菜单栏中，请重置该值) </span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">类型:<font style="color:#f00;">*</font></label>
							<select name="type">
								<option value='1' <?php echo $obj->type == 1 ? 'selected' : ''; ?> >click 点击推事件</option>
								<option value='2' <?php echo $obj->type == 2 ? 'selected' : ''; ?> >view 跳转URL</option>
							</select>
							<div class="clear"></div>
						</li>

						<li class="tp_diymen_class_type">
							<label class="labelName">菜单KEY值:<font style="color:#f00;">*</font></label>
							<input type="text" id="keyword" value="<?php echo $obj->keyword; ?>" name="keyword" class="regTxt" />
							<div class="clear"></div>
						</li>

						<li class="tp_diymen_class_type">
							<label class="labelName">网页链接:<font style="color:#f00;">*</font></label>
							<input type="text" id="url" value="<?php echo $obj->url; ?>" name="url" class="regTxt" />
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">排序:<font style="color:#f00;">*</font></label>
							<input type="text" id="sort" value="<?php echo $obj->sort; ?>" name="sort" class="regTxt" />
							<div class="clear"></div>
						</li>
					</ul>
				</dd>


<dl>
	<h3> 类型说明：</h3>
  	<dd style="margin:10px;">
  		<p>1、click：点击推事件</p>
		<p>用户点击click类型按钮后，通过自定义的key值与用户进行交互；</p>
	</dd>
	<dd style="margin:10px;">
		<p>2、view：跳转URL</p>
		<p>用户点击view类型按钮后，会跳到相应的URL地址，显示相应的内容。</p>
	</dd>
</dl>

			</dl>
			<div class="clear"></div>
			<p style="float:left; padding-left:10%;"></p>
			<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
		</div>


	</div>
</form>
<script>
$(function(){
	settype();
	$("select[name='type']").bind("change",settype);
	function settype(){
		var num = $("select[name='type']").val() - 1;
		$(".tp_diymen_class_type").hide().eq(num).show();
	}

	$("#regform").validate({
        rules: {
		   "keyword": {
			   required: true
		   },
		   "sort": {
			   required: true,
			   number: true
		   },
		   "url": {
			   required: true,
			   url: true
		   }
  		}
    });
});
</script>