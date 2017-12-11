<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
<form action="?module=lottery_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="add_save" />
<input type="hidden" name="status" value="1" />
<input type="hidden" name="type" value="512" />
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">
	<a>活动设置</a>
</div>
	<dl class="ott">
		<dd>
			<ul class="ottList">

				<li>
					<label class="labelName">主题:<font style="color:#f00;">*</font></label>
                    <input type="text" name="subject" value="" class="regTxt" />
					<div class="clear"></div>
				</li>
                
        <li>
					<label class="labelName">活动类型:<font style="color:#f00;">*</font></label>
          <select class="lottery_type" name="lottery_type">
          	<?php foreach( $ActivityType as $key=>$activity ){ ?>
           		<option value="<?php echo $key ?>"><?php echo $activity ?></option>
          	<?php } ?>
          </select>
					<div class="clear"></div>
				</li>

        <li class="active_img active_img_1">
          <label class="labelName">活动背景图:<font style="color:#f00;">*</font></label>
          <input type="file" name="background" />
          <p class="ottTips"></p>
          <div class="clear"></div>
        </li>
       
        <li class="active_img active_img_2">
          <label class="labelName">活动标题图:<font style="color:#f00;">*</font></label>
          <input type="file" name="title_image" />
          <p class="ottTips"></p>
          <div class="clear"></div>
        </li>

        <li class="active_img active_img_3">
          <label class="labelName">配件图1:<font style="color:#f00;">*</font></label>
          <input type="file" name="turntable" />
          <p class="ottTips"></p>
          <div class="clear"></div>
        </li>

        <li class="active_img active_img_4">
          <label class="labelName">配件图2:<font style="color:#f00;">*</font></label>
          <input type="file" name="pointer" />
          <p class="ottTips"></p>
          <div class="clear"></div>
        </li>

        <li class="active_img active_img_5">
          <label class="labelName">效果图:<font style="color:#f00;">*</font></label>
          <input type="file" name="explain_image" /> 
          <p class="ottTips"></p>                
          <div class="clear"></div>
        </li>

				<li>
					<label class="labelName">状态:<font style="color:#f00;">*</font></label>
          <select class="status" name="status">
            <option value="0">禁用</option>
            <option value="1">启用</option>
          </select>
					<div class="clear"></div>
				</li>

       <!--  <li>
          <label class="labelName">抽奖次数:<font style="color:#f00;">*</font></label>
          <input type="text" name="number" value="" class="regTxt" />
          <div class="clear"></div>
        </li> -->

				<li>
					<label class="labelName">开始时间:<font style="color:#f00;">*</font></label>
                    <input type="text" name="start_time" id="starttime" style="width:160px;background-position:145px center;" class="wdatePicker" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\');}', dateFmt:'yyyy-MM-dd HH:mm:ss'})" value=""/>
					<div class="clear"></div>
				</li>
				<li>
					<label class="labelName">结束时间:<font style="color:#f00;">*</font></label>
                    <input type="text" name="end_time" id="endtime" style="width:160px;background-position:145px center;" class="wdatePicker" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime\');}', dateFmt:'yyyy-MM-dd HH:mm:ss'})" value=""/>
					<div class="clear"></div>
				</li>

			</ul>
		</dd>
	</dl>
	<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="button" onclick="history.go(-1)" class="continue" id="btn_next" value=" 取消 " /></p>
</div>
</div>
</form>
<script>
$(function(){
  $("#regform").validate({
        rules: {
       "subject": {
         required: true
       },
       "background": {
         required: true
       },
       "title_image": {
         required: true
       },
       "turntable": {
         required: true
       },
       "pointer": {
         required: true
       },
       "number": {
         required: true,
         number: true
       },
       "start_time": {
         required: true
       },
       "end_time": {
         required: true
       }
      }
    });

  $(".lottery_type").change(function(){
    fn_lottery_type($(this));
    $(".active_img img").remove();
      $(".active_img input").val("");
  });
  fn_lottery_type($(".lottery_type"));
});
function fn_lottery_type(obj){
    var val = obj.val();
    if(val == 1){                     //大转盘
      $(".active_img").show();

      $(".active_img_1").attr({"data-title":"活动背景图","data-width":"600","data-height":"1067"});
      $(".active_img_2").attr({"data-title":"活动标题图","data-width":"600","data-height":"250"});
      $(".active_img_3").attr({"data-title":"转盘图","data-width":"600","data-height":"537"});
      $(".active_img_4").attr({"data-title":"指针图","data-width":"300","data-height":"300"});
      $(".active_img_5").attr({"data-title":"底部说明图","data-width":"600","data-height":"300"});
    }else if(val == 2){               //砸金蛋
      $(".active_img").show();
      $(".active_img_5").hide();

      $(".active_img_1").attr({"data-title":"活动背景图","data-width":"640","data-height":"1136"});
      $(".active_img_2").attr({"data-title":"活动标题图","data-width":"600","data-height":"250"});
      $(".active_img_3").attr({"data-title":"金蛋图","data-width":"158","data-height":"187"});
      $(".active_img_4").attr({"data-title":"砸蛋效果图","data-width":"158","data-height":"187"});
    }else if(val == 3){               //摇一摇
      $(".active_img").show();
      $(".active_img_4,.active_img_5").hide();

      $(".active_img_1").attr({"data-title":"活动背景图","data-width":"640","data-height":"786"});
      $(".active_img_2").attr({"data-title":"活动标题图","data-width":"640","data-height":"350"});
      $(".active_img_3").attr({"data-title":"摇动图标","data-width":"640","data-height":"386"});
    }
    fn_imgSize_show();
}
function fn_imgSize_show(){
  $(".active_img").each(function(index, el) {
    var width = $(el).attr("data-width");
    var height = $(el).attr("data-height");
    var title = $(el).attr("data-title");
    $(el).find(".labelName").html(title + ':<font style="color:#f00;">*</font>');
    $(el).find(".ottTips").html('建议像素为'+width+'*'+height);
  });
}
</script>