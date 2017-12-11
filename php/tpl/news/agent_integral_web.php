<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();

		$("#month").change(function(){
			myForm.submit();
		});
	});
</script>
<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="top-left top-back">后退</a>
    <div class="member-nav-M">营收详情</div>
</div>

<div class="index-wrapper"  style="
    padding: 15px 0 60px 0;
">
	<div class="u-txt">
   	  <p class="add-txt01"><?php echo $obj_user->name;?>，欢迎您</p>

    </div>

    <div class="clear"></div>

    <div class="integral-wrapper">
    	<div class="integral-Record" id="tabs">
			<div style="margin-bottom:10px"><form action="agent_integral.php" method="post" name="myForm">
				<span>
				<select id="year" name="year">
					<option value="2014" <?php if($year==2014){echo "selected;";}?>>2014</option>
					<option value="2015" <?php if($year==2015){echo "selected;";}?>>2015</option>
				</select>&nbsp;年&nbsp;
				<select id="month" name="month">
					<option value="1" <?php if($month=='1'){echo "selected";}?>>1</option>
					<option value="2" <?php if($month=='2'){echo "selected";}?>>2</option>
					<option value="3" <?php if($month=='3'){echo "selected";}?>>3</option>
					<option value="4" <?php if($month=='4'){echo "selected";}?>>4</option>
					<option value="5" <?php if($month=='5'){echo "selected";}?>>5</option>
					<option value="6" <?php if($month=='6'){echo "selected";}?>>6</option>
					<option value="7" <?php if($month=='7'){echo "selected";}?>>7</option>
					<option value="8" <?php if($month=='8'){echo "selected";}?>>8</option>
					<option value="9" <?php if($month=='9'){echo "selected";}?>>9</option>
					<option value="10" <?php if($month=='10'){echo "selected";}?>>10</option>
					<option value="11" <?php if($month=='11'){echo "selected";}?>>11</option>
					<option value="12" <?php if($month=='12'){echo "selected";}?>>12</option>
				</select>&nbsp;月</span>
			</form></div>
        	<div class="clear"></div>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1">
                <tr>
                    <td class="integral-title" colspan="4"><?php echo $year.' 年 '.$month.' 月';?>营收详情</td>
                </tr>
                <tr>
                    <td class="integral-txt" colspan="4" style="align:center;">
                    	总提成=总营业额*提成比例<br/>
                    	<?php echo number_format($all_price*$discount,2);?>=<?php echo number_format($all_price,2); ?>*<?php echo ($discount*100)."%";?>
					</td>
                </tr>
                <tr>
                    <td class="integral-txt" colspan="4" style="align:center;">
<?php
	reset($return_money);
	while(list($key, $val) = each($return_money)){
	if($val > $discount){
?>
您只要再销售<?php echo number_format($key-$all_price,2);?>元即可增加提成比例至<?php echo ($val*100)."%";?>！<br/>
<?php
	}
}
?>
					</td>
                </tr>
                <tr>
                    <td class="integral-title">订单号</td>
                	<td class="integral-title">用户</td>
                    <td class="integral-title">金额</td>
                    <td class="integral-title">时间</td>
                </tr>

<?php
foreach ($orderList as $row) {
	$obj = $ub->detail($db,$row->customer_id);
?>
                <tr>
                    <td class="integral-txt"><a href="orders_info.php?order_id=<?php echo $row->order_id;?>"><?php echo $row->order_number;?></a></td>
                   	<td class="integral-txt"><?php echo $obj->name?></td>
                   	<td class="integral-txt" ><?php echo "￥ ".number_format($row->all_price,2);?></td>
                    <td class="integral-txt" ><?php echo date("Y-m-d H:i:s",$row->addtime);?></td>
                </tr>
             <?php }?>
            </table>
        </div>
    </div>
</div>
<?php include "footer_web.php"; ?>
<?php include_once('common_footer.php');?>
