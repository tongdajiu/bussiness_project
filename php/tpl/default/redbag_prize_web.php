<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<link href="res/css/style_wj.css" rel="stylesheet" type="text/css" />

	<div class="lyjd_title_box radius_bg">
		<div class="lyjd_titel_con">
			<h1><?php echo $obj->title;?></h1>

			</div>
			<div class="lyjd_list radius_bg">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="25%" style="border-right:2px solid #dfdfdf; border-bottom:2px solid #dfdfdf;font-size:12px;">奖品</td>
						<td width="75%" style=" border-bottom:2px solid #dfdfdf;font-size:12px;">获得时间</td>
					  </tr>
<?php foreach($prizes as $prize){?>
					  <tr>
						<td style="border-right:2px solid #dfdfdf; border-bottom:2px solid #dfdfdf;font-size:12px;"><?php echo $redbagPrize[$prize->prize];?></td>
						<td style=" border-bottom:2px solid #dfdfdf;font-size:12px;"><?php echo date('Y-m-d H:i:s',$prize->addTime);?></td>
					  </tr>
<?php } ?>
				</table>
<?php if($obj->state == 0){ ?>
				<div class="yqhy_btn" style="text-align:center;">
					<a href="redbag_activity.php?activity_id=<?php echo $activity_id;?>&act=guide" class="yqhy_con">向好友炫耀领到的红包</a>
				</div>
<?php } ?>
		    </div>
	</div>
<?php include_once('common_footer.php');?>