<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
<form action="?module=redpack" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="add_save">
	<input type="hidden" name="status" value="1">
	<input type="hidden" name='from' value="<?php echo isset($_GET['from']) ? $_GET['from'] : '' ?>">
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">添加红包活动</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">

						<li>
							<label class="labelName">红包类型：</label>
							<select name="type"  class="srchField selectField">
								<option value="redpack">现金红包</option>
								<!--<option value="groupredpack">裂变红包</option>-->
							</select>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">红包金额:<font style="color:#f00;">*</font></label>
							<input type="text" id="total_amount" value="" name="total_amount" class="regTxt" />
							（单位：分）
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">活动名称:<font style="color:#f00;">*</font></label>
							<input type="text" id="act_name" value="" name="act_name" class="regTxt" />
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">商家名称:<font style="color:#f00;">*</font></label>
							<input type="text" id="send_name" value="" name="send_name" class="regTxt" />
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">祝福语:<font style="color:#f00;">*</font></label>
							<input type="text" id="wishing" value="" name="wishing" class="regTxt" />
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">备注:<font style="color:#f00;">*</font></label>
							<input type="text" id="remark" value="" name="remark" class="regTxt" />
							<div class="clear"></div>
						</li>

			            <li>
							<label class="labelName">开始发放时间:<font style="color:#f00;">*</font></label>
		                    <input type="text" name="start_time" id="starttime" style="width:160px;background-position:145px center;" class="wdatePicker" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\');}', dateFmt:'yyyy-MM-dd HH:mm:ss'})" value=""/>
							<div class="clear"></div>
						</li>
						
						<li>
							<label class="labelName">结束发放时间:<font style="color:#f00;">*</font></label>
		                    <input type="text" name="end_time" id="endtime" style="width:160px;background-position:145px center;" class="wdatePicker" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime\');}', dateFmt:'yyyy-MM-dd HH:mm:ss'})" value=""/>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">发放数量:<font style="color:#f00;">*</font></label>
							<input type="text" id="count" value="" name="count" class="regTxt" />
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">有效性:<font style="color:#f00;">*</font></label>
							<select name="status" id="status" class="srchField selectField">
								<option value="1">有效</option>
								<option value="0">失效</option>
							</select>

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