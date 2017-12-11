<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>

<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">物流信息</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="order-wrapper">
<table>
<tr>
	<td style="padding:10px;padding-bottom:0px;font-size:17px;fontpadding-top:5px">物流类型：<span style="color:#f00;font-weight:bold;font-size:16px;"><?php echo $ExpressType[$express_type];?></span></td>
</tr>
<tr>
	<td style="padding:10px;padding-bottom:0px;font-size:17px;padding-top:5px">物流单号：<span style="color:#f00;font-weight:bold;font-size:16px;"><?php echo $express_number;?></span></td>
</tr>
<?php foreach($result['data'] as $rs){ ?>
	<tr>
		<td style="padding:10px;padding-bottom:0px"><?php echo $rs['time']."  ".$rs['context'];?></td>
	</tr>
<?php } ?>
</table>
</div>
<?php include_once('common_footer.php');?>