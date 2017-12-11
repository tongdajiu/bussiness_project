<style>
	.regInfo ul{position:relative;margin-top:10px;border:1px dashed #7F99BE;}
	.lotteryNone_tips{display:none;padding:200px 0 200px 280px;font-size:14px;color:#333;}
	.regInfo li.lotteryDrop{position:absolute;top:0;right:0;width:50px;height:30px;padding:0;text-align:center;line-height:30px;background:#7F99BE;color:#fff;font-size:12px;cursor:pointer;}
</style>
<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
<form action="?module=lottery_setting_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="add_save" />
	<input type="hidden" name="setting_id" value="<?php echo $setting_id ;?>" />
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">
				<a>奖项设置</a>
			</div>

			<div class="lotteryNone_tips">暂无奖项设置</div>
                   <div class="t_r_btn">
                       <input type="button" class="btn btn-big btn-blue" value=" 新增奖品 " onclick="addLottery();" />
                   </div>

			<dl class="ott">
				<?php foreach( $prizeList as $prize ){ ?>
					<dd>
						<ul class="ottList">
							<li>
								<label class="labelName">奖品:</label>
								<input type="hidden" id="prize" name="id[]" class="regTxt"  value="<?php echo $prize->id;?>" />
				                <input type="text" id="prize" name="prize[]" class="regTxt"  value="<?php echo $prize->prize;?>" />
								<div class="clear"></div>
							</li>
							<li>
				                <label class="labelName">奖品类型:</label>
				                <select class="prize_type" name="prize_type[]" class="select" style="WIDTH: 100PX;">
				                    <?php foreach ( $PrizeType as  $key=>$info ){ ?>
				                    	<option value="<?php echo $key ?>" <?php echo $key==$prize->prize_type ? "SELECTED" : "" ?>  ><?php echo $info ?></option>
				                   <?php } ?>
				                </select>

				                <select class="prize_val" name="prize_val[]" class="select" style="WIDTH: 100PX; display:none" >
					                <option value="0">--</option>
					                <?php foreach($couponList as $cl){?>
					                <?php if($cl->status ==1){?>
					                	<option value="<?php echo $cl->id ;?>" <?php echo $cl->id==$prize->prize_val ? "SELECTED" : "" ?> ><?php  echo $cl->name ;?></option>
					                <?php }}?>
				                </select>
								<div class="clear"></div>
							</li>
							<li>
								<label class="labelName">奖品数量:</label>
				                <input type="text" id="number" name="number[]" class="regTxt"  value="<?php echo $prize->number;?>" style="WIDTH: 100PX;"/>
								<div class="clear"></div>
							</li>
							<li>
								<label class="labelName">角度值:</label>
				                <input type="text" id="pos" name="pos[]" class="regTxt"  value="<?php echo $prize->pos;?>" style="WIDTH: 100PX;"/>
								<div class="clear"></div>
							</li>
							<li>
								<label class="labelName">概  率:</label>
				                <input type="text" id="chance" name="chance[]" class="regTxt"  value="<?php echo $prize->chance;?>" style="WIDTH: 100PX;"/>
								<div class="clear"></div>
							</li>

							<li class="lotteryDrop" onclick="dropLottery(this,<?php echo $prize->id;?>)">删除</li>
						</ul>
					</dd>

				<?php } ?>
			</dl>


			<p class="continue">

				<input type="submit" class="continue" id="btn_next" value=" 确定 " onclick="return myvalidate_submit()" />
				<input type="reset" class="continue" value=" 重置 " />
			</p>
		</div>
	</div>

</form>
<script>
/**
*是否有奖项
*/
function ifLottery()
{
	($(".ott dd").length>0) ? $(".lotteryNone_tips").hide() : $(".lotteryNone_tips").show();
}
ifLottery();
/**
*新增奖项
*/
function addLottery(){
	var num = parseInt($(".ott dd").length);

	$.ajax({
		url:'/admin/lottery_add_prize.php',
		dataType:'text',
		success:function(data){
			$('.ott').append(data);
			ifLottery();
		}
	})
}
/**
*删除奖项
*/
function dropLottery(obj,id)
{
	if (confirm('是否删除该奖品？'))
	{
		$.ajax({
			url:'?module=lottery_setting_action_new&act=del&setting_id=<?php echo $setting_id ;?>&id=' + id,
			dataType:'text',
			success:function(data){
				//删除
				var _this = $(obj)
				_this.parents("dd").remove();
				//修改后缀数
				$(".ott dd").each(function(index,el){
					$(el).find("select,input").each(function(index2, el2) {
						var lotteryName = $(el2).attr("name").split("[")[0];
						$(el2).attr("name",lotteryName+"["+index+"]");
					});
					$(el).find("input:hidden").val(index+1)
					$(el).find("label.prizeName font").text(index+1);
				});

				ifLottery();
			}
		})
	}
}

$(function(){

	/**
	*优惠券选择
	*/
	$(document).delegate(".prize_type", "change", function(){
		($(this).val() == "1") ? $(this).next(".prize_val").show() : $(this).next(".prize_val").hide();
	});

	$(".prize_type").each(function(index,el){
		($(el).val() == "1") ? $(el).next(".prize_val").show() : $(el).next(".prize_val").hide();
	});

	$(document).delegate(".ottList input[type='text']", "change", function(event) {
		var _this = $(this);
		if(_this.val() == ""){
			if(_this.next("label.error").length<=0){
				_this.addClass("error")
				_this.after('<label for="subject" class="error">不能为空.</label>');
			}
		}else{
			_this.removeClass("error")
			_this.next("label.error").remove();
		}
	});

});

function myvalidate_submit(){
	var ifSubmit = true;
	$(".ottList input[type='text']").each(function(index, el) {
		if($(el).val() == ""){
			ifSubmit = false;
			if($(el).next("label.error").length<=0){
				$(el).addClass("error")
				$(el).after('<label for="subject" class="error">不能为空.</label>');
			}
		}else{
			$(el).removeClass("error")
			$(el).next("label.error").remove();
		}
	});
	return ifSubmit;
}
</script>