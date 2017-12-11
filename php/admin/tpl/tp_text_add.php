<form action="?module=tp_text" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="add_save">
	<input type="hidden" name="status" value="1">
	<input type="hidden" name='from' value="<?php echo isset($_GET['from']) ? $_GET['from'] : '' ?>">
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">添加</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<?php if ( $from != 'subscribe' ){ ?>
							<li>
								<label class="labelName">关键词:<font style="color:#f00;">*</font></label>（注：subscribe为关键词，不给予设置）
								<input type="text" id="keyword" value="" name="keyword" class="regTxt" />
								<div class="clear"></div>
							</li>
						<?php } ?>

						<li>
							<label class="labelName">内容:<font style="color:#f00;">*</font></label>
							<div style="margin-left:212px;" >
								<textarea style="width:500px;height:240px; font-size:14px; padding:5px;" name="text"></textarea>
							</div>
							<p style="margin-left: 212px;font-size:12px;color:red;">
								在换行处用\n替代;<br/>
								如需使用链接，请用：<?php echo htmlspecialchars('<a href="链接地址">链接标题</a>') ?>
							</p>
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
<script>
	$(function(){
		$("#regform").validate({
	        rules: {
			   "keyword": {
				   required: true
			   },
			   "text": {
				   required: true,
			   }
	  		}
	    });
	});
</script>