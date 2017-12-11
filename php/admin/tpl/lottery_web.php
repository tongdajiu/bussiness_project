<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
<form action="?module=lottery_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="post" />
<input type="hidden" name="status" value="1" />
<input type="hidden" name="type" value="512" />
<input type="hidden" name="lottery_id" value="<?php echo $lotteryList->lottery_id ?>" />
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title content_title_tab">
	<a href="index.php?module=lottery_action" class="active">转盘设置</a>
	<a href="index.php?module=lottery_setting_action">奖项设置</a>
</div>
	<dl class="ott">
		<dd>
			<ul class="ottList">

				<li>
					<label id="name">主题:</label>
                    <input type="text" name="subject" value="<?php echo $lotteryList->subject ;?>" class="regTxt" />
					<div class="clear"></div>
				</li>
                <li>
                  <label id="name">活动背景图：</label>
                  <input type="file" name="background" />
                  <p style="padding-left:212px;"><img src="../upfiles/lottery/turntable/<?php echo $lotteryList->background; ?>" height="100" /></p>
                  <input type="hidden" name="image_before1" value="<?php echo $lotteryList->background; ?>" />
                  <p class="ottTips"></p>
                  <div class="clear"></div>
               </li>
               <li>
                  <label id="name">活动标题图:</label>
                  <input type="file" name="title_image" />
                  <p style="padding-left:212px;"><img src="../upfiles/lottery/turntable/<?php echo $lotteryList->title_image; ?>" height="100" /></p>
                  <input type="hidden" name="image_before2" value="<?php echo $lotteryList->title_image; ?>" />
                  <p class="ottTips"></p>
                  <div class="clear"></div>
               </li>

               <li>
                  <label id="name">转盘图:</label>
                  <input type="file" name="turntable" />
                  <p style="padding-left:212px;"><img src="../upfiles/lottery/turntable/<?php echo $lotteryList->turntable; ?>" height="100" /></p>
                  <input type="hidden" name="image_before3" value="<?php echo $lotteryList->turntable; ?>" />
                  <p class="ottTips"></p>
                  <div class="clear"></div>
               </li>

               <li>
                  <label id="name">指针图:</label>
                  <input type="file" name="pointer" />
                  <p style="padding-left:212px;"><img src="../upfiles/lottery/turntable/<?php echo $lotteryList->pointer; ?>" height="100" /></p>
                  <input type="hidden" name="image_before4" value="<?php echo $lotteryList->pointer; ?>" />
                  <p class="ottTips"></p>
                  <div class="clear"></div>
               </li>
               <!--<li>
                  <label id="name">底部说明图:</label>
                  <input type="file" name="explain_image" />
                  <p style="padding-left:212px;"><img src="../upfiles/lottery/turntable/<?php echo $lotteryList->explain_image; ?>" height="100" /></p>
                  <input type="hidden" name="image_before5" value="<?php echo $lotteryList->explain_image; ?>" />
                  <p class="ottTips"></p>
                  <div class="clear"></div>
               </li>-->

				<li>
					<label id="name">状态:</label>
                    <select class="status" name="status">
	                    <option value="0" <?php if($lotteryList->lottery_id){if($lotteryList->status ==0){?> selected= "selected"<?php }}?>> 禁用</option>
	                    <option value="1" <?php if($lotteryList->lottery_id){if($lotteryList->status ==1){?> selected= "selected" <?php }}?>>开启</option>
                    </select>
					<div class="clear"></div>
				</li>
				<li>
					<label id="name">开始时间:</label>
                    <input type="text" name="start_time" id="starttime" class="wdatePicker" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\');}'})" value="<?php echo date('Y-m-d', $lotteryList->start_time) ;?>"/>
					<div class="clear"></div>
				</li>
				<li>
					<label id="name">结束时间:</label>
                    <input type="text" name="end_time" id="endtime" class="wdatePicker" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime\');}'})" value="<?php echo  date('Y-m-d', $lotteryList->end_time) ;?>"/>
					<div class="clear"></div>
				</li>

			</ul>
		</dd>
	</dl>
	<p class="continue">
    <input type="submit" class="btn btn-big btn-blue" id="btn_next" value=" 确定 " />
    <input type="reset" class="btn btn-big" id="btn_next" value=" 重置 " />
  </p>
</div>
</div>
</form>