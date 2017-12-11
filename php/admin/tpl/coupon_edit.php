<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
<style>
	.red { color:#f00; }
</style>

<form action="?module=coupon_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit_save">
	<input type="hidden" name="id" value="<?php echo $obj->id ?>">

	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">生成优惠券</div>

			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label class="labelName">生效方式：</label>
							<select name="vaild_type" id="vaild_type" class="srchField selectField">
								<option value="0" <?php echo $obj->vaild_type == 0 ? 'selected' : '' ?>>按优惠券生效的时间</option>
								<option value="1" <?php echo $obj->vaild_type == 1 ? 'selected' : '' ?>>按用户得到优惠券的时间</option>
							</select>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">类型：</label>
							<select name="type" id="type" class="srchField selectField">
								<?php foreach( $this->coupon_type as $key=>$coupon ){ ?>
									<option value="<?php echo $key;?>" <?php echo $obj->type == $key ? 'selected' : '' ?> ><?php echo $coupon;?></option>
								<?php } ?>

							</select>
							<div class="clear"></div>
						</li>
						<li>
							<label class="labelName">优惠劵名称:<font style="color:#f00;">*</font></label>
							<input type="text" name="name" placeholder="优惠券名称" class="regTxt" value="<?php echo $obj->name ?>" />
							<div class="clear"></div>
						</li>

						<div class="vaild_type_warp">
							<li>
								<label class="labelName">生效时间:<font style="color:#f00;">*</font></label>
								<input type="text" class="wdatePicker" name="start_time" id="start_time" placeholder="生效时间" onFocus="WdatePicker()" value="<?php echo $obj->start_time == 0 ? '' : date( 'Y-m-d', $obj->start_time); ?>" />
								<div class="clear"></div>
							</li>
							<li>
								<label class="labelName">有效时间:<font style="color:#f00;">*</font></label>
								<input type="text" class="wdatePicker" name="end_time" id="end_time" placeholder="有效时间" onFocus="WdatePicker()" value="<?php echo $obj->end_time == 0 ? '' : date( 'Y-m-d', $obj->end_time); ?>" />
								<div class="clear"></div>
							</li>
						</div>

						<div class="vaild_type_warp">
							<li>
								<label class="labelName">有效天数:<font style="color:#f00;">*</font></label> （注：用户得到优惠券起的可使用的天数）
								<input type="text" name="vaild_date" id="vaild_date" placeholder="用户得到优惠券起的有效天数" class="regTxt" value="<?php echo $obj->vaild_date; ?>" />
								<div class="clear"></div>
							</li>
						</div>

						<div class="type_warp">
							<li>
								<label class="labelName">满:<font style="color:#f00;">*</font></label> (注：没最低消费要求的，请填：0)
								<input type="text" name="max_use" id="max_use" placeholder="满" class="regTxt" value="<?php echo $obj->max_use ?>" />
								<div class="clear"></div>
							</li>
						</div>

						<li>
							<label class="labelName">减:<font style="color:#f00;">*</font></label>
							<input type="text" name="discount" id="discount" placeholder="减" class="regTxt" value="<?php echo $obj->discount ?>" />
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">有效性:<font style="color:#f00;">*</font></label>
							<select name="status" id="status" class="srchField selectField">
								<option value="1" <?php echo  $obj->status==1 ? 'selected' : '' ?>>有效</option>
								<option value="0" <?php echo  $obj->status==0 ? 'selected' : '' ?>>无效</option>
							</select>
							<div class="clear"></div>
						</li>

					</ul>

					<div style="padding-left:210px;">
						<ul>
							<li>
								<h4>满额减</h4>
								<p>如果类型为满额减，要填写满 <i class="red">100</i> 减 <i class="red">5</i> 元的格式，则 在满中 填写 <i class="red">100</i> 在减中 填写 <i class="red">5</i></p>
							</li>

							<li>
								<h4>立即减</h4>
								<p>如果类型为立即减，要填写购买即减 <i class="red">5</i> 元的格式，则 在满中 填写 <i class="red">0</i> 在减中 填写 <i class="red">5</i></p>
							</li>
						</ul>
					</div>
				</dd>
			</dl>
			<div class="clear"></div>

			<p style="float:left; padding-left:10%;"></p>
			<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
		</div>
	</div>
</form>

<script>
change_vaild_type();
change_type();

$("select[name='vaild_type']").bind('change',change_vaild_type);
$("select[name='type']").bind('change',change_type);

function change_vaild_type()
{
	num = $("select[name='vaild_type']").val();
	$('.vaild_type_warp').hide().eq(num).show();
}

function change_type()
{
	num = $("select[name='type']").val();
	$('.type_warp').hide().eq(num).show();
}

$(function(){
	$("#regform").validate({
        rules: {
		   "name": {
			   required: true
		   },
		   "start_time": {
			   required: true,
			   dateISO:true
		   },
		   "end_time": {
			   required: true,
			   dateISO:true
		   },
		   "max_use": {
			   required: true,
			   number: true
		   },
		   "discount": {
			   required: true,
			   number: true
		   }
  		}
    });
})
</script>
