<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();

		$("#year").on("change", function(){
			submitDateFilter()
		});
		$("#month").on("change", function(){
			submitDateFilter();
		});
	});
	function submitDateFilter(){
		if(($("#year").val() != 0) && ($("#month").val() != 0)) myForm.submit();
	}
</script>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">营收详情</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="integral-wrapper">
	<div class="integral-Record" id="tabs">
		<div style="margin-top:10px">
			<form action="agent_commission.php" method="get" name="myForm">
				<span>
					<select id="year" name="year">
						<?php foreach($years as $_y){ ?>
							<option value="<?php echo $_y;?>"<?php echo $selYear[$_y];?>><?php echo $_y;?></option>
						<?php } ?>
					</select>&nbsp;年&nbsp;
					<select id="month" name="month">
						<?php foreach($months as $_m){ ?>
							<option value="<?php echo $_m;?>"<?php echo $selMonth[$_m];?>><?php echo $_m;?></option>
						<?php } ?>
					</select>&nbsp;月
				</span>
			</form>
		</div>
    	<div class="clear"></div>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1">
            <tr>
                <td class="integral-title">订单号</td>
            	<td class="integral-title">用户</td>
                <td class="integral-title">金额</td>
                <td class="integral-title">时间</td>
            </tr>
			<?php if(empty($list)){ ?>
				<tr>
					<td colspan="4" align="center" class="integral-txt" style="padding:20px;">没有相关记录</td>
				</tr>
			<?php }else{ ?>
				<?php foreach($list as $row){ ?>
					<tr>
						<td class="integral-txt"><?php echo $row->order_no;?></td>
						<td class="integral-txt"><?php echo $userList[$row->order_no]['name'];?></td>
						<td class="integral-txt" ><?php echo "￥ ".number_format($row->money,6);?></td><?php //todo 临时改为6位小数，测试完后需改为2位小数?>
						<td class="integral-txt" ><?php echo date("Y-m-d H:i:s",$row->time);?></td>
					</tr>
				<?php } ?>
			<?php } ?>
        </table>
    </div>
</div>
<?php include "footer_web.php"; ?>
<?php include_once('common_footer.php');?>
