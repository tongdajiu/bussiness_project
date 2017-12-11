<?php include_once('common_header.php');?>

<link href="res/css/style_wj.css" rel="stylesheet" type="text/css" />
<?php include_once('loading.php');?>

	<div class="lyjd_title_box radius_bg">
		<div class="lyjd_titel_con">
			<h1><?php echo $obj->title;?></h1>

			</div>
			<div class="lyjd_list radius_bg">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="25%" style="border-right:2px solid #dfdfdf; border-bottom:2px solid #dfdfdf;font-size:12px;">抽奖号</td>
						<td width="75%" style=" border-bottom:2px solid #dfdfdf;font-size:12px;">获得时间</td>
					  </tr>
<?php foreach($numbers as $number){?>
					  <tr>
						<td style="border-right:2px solid #dfdfdf; border-bottom:2px solid #dfdfdf;font-size:12px;"><?php echo sprintf("%04d", $number->number);?></td>
						<td style=" border-bottom:2px solid #dfdfdf;font-size:12px;"><?php echo date('Y-m-d H:i:s',$number->addTime);?></td>
					  </tr>
<?php } ?>
				</table>
<?php if($obj->state == 0){ ?>
				<div class="yqhy_btn" style="text-align:center;">
					<a href="draw_activity.php?activity_id=<?php echo $activity_id;?>&act=guide" class="yqhy_con">邀请好友,获得更多抽奖号</a>
				</div>
<?php } ?>
		    </div>
	</div>
<?php include_once('common_footer.php');?>
