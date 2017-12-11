<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>
<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="top-left top-back">后退</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">提现详情</div>
</div>
<form action="?module=distributor_money" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="details">
<input type="hidden" name="id" value="<?php echo $obj_dm->id;?>">
	<div class="add-txt">
		<ul class="add-txt-ul">
			<li><span class="add-txt-item2">姓名：</span><?php echo $obj_dm->name;?></li>
			<li><span class="add-txt-item2">手机：</span><?php echo $obj_dm->mobile;?></li>
			<li><span class="add-txt-item2">身份证：</span><?php echo $obj_dm->id_number;?></li>
			<li><span class="add-txt-item2">申请金额：</span><?php echo $obj_dm->d_money;?></li>
			<li>
				<span class="add-txt-item2">提现方式：</span>
				<?php
				switch ($obj_dm->pay_method) {
					case 1;
						echo "支付宝";
						break;
					case 2;
						echo "微信";
						break;
				}
				?>
			</li>
			<li><span class="add-txt-item2">提现账号：</span><?php echo $obj_dm->account_number;?></li>
			<li><span class="add-txt-item2">申请时间：</span><?php echo date('Y-m-d H:i:s',$obj_dm->add_time); ?></li>
			<li>
				<span class="add-txt-item2">审核状态：</span>
				<?php
					switch ($obj_dm->status) {
						case 0;
							echo "未审核";
							break;
						case 1;
							echo "审核通过";
							break;
						case 2;
							echo "审核失败";
							break;
					}
				?>
			</li>
			<li><span class="add-txt-item2">审核时间：</span><?php if($obj_dm->status !=0) echo date('Y-m-d H:i:s',$obj_dm->through_time); ?></li>
			<li><span class="add-txt-item2">审核人：</span><?php echo $obj_dm->username;?></li>
			<li>
				<span class="add-txt-item2">打款状态：</span>
				<?php
				switch ($obj_dm->play_type) {
					case 0;
						echo "未打款";
						break;
					case 1;
						echo "已打款";
						break;
				}?>
			</li>
			<li><span class="add-txt-item2">打款时间：</span><?php if($obj_dm->play_type !=0) echo date('Y-m-d H:i:s',$obj_dm->play_time);?></li>
			<li><span class="add-txt-item2">备注：</span><?php echo $obj_dm->remark;?></li>
		</ul>
	</div>
  </form>
<?php include TEMPLATE_DIR.'/footer_web.php';?>
<?php include_once('common_footer.php');?>