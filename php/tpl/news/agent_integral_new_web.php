<?php include_once('common_header.php');?>
<script>
	$(function() {
		$("#month").change(function(){
			myForm.submit();
		});
	});
</script>
<style type="text/css">
*{margin:0; padding:0;}
body{
	font-family:"Microsoft yahei" !important;
	-webkit-tap-highlight-color:rgba(0, 0, 0 , 0);
	background-color:#fff;
	font-size:12px;
	color:#666;
}
img{border:none;}
 ul{ list-style:none;}
a{text-decoration:none; color:#666;}
.ysxq_header_bg{ width:320px; height:153px; background:url(images/ysxq_01.png) no-repeat; background-size:320px 153px;}
.ysxq_header_bg,.wdzh_box{ margin:0 auto;}
.wdzh_box{width:320px; overflow:hidden;}
.wdzh_con{padding:8px 21px; overflow:hidden;}
.ys_gz{ width:220px; height:26px; background:#46c68b; margin-top:3px; margin:0 auto;}
.ys_gz em{ font-style:normal; color:#fff;}
.ys_gz_con{ text-align:center; line-height:26px;}
</style>
<?php include_once('loading.php');?>
	<div class="ysxq_header_bg">
	  <form action="agent_integral_new.php" method="post" name="myForm" style="padding:0 2px; float:right; margin-right:10px; margin-top:10px;">
				<span>
				<select id="year" name="year">
					<option value="2014" <?php if($year=='2014'){echo "selected";}?>>2014</option>
					<option value="2015" <?php if($year=='2015'){echo "selected";}?>>2015</option>
					<option value="2016" <?php if($year=='2016'){echo "selected";}?>>2016</option>
				</select>&nbsp;年&nbsp;
				<select id="month" name="month">
					<option value="01" <?php if($month=='01'){echo "selected";}?>>1</option>
					<option value="02" <?php if($month=='02'){echo "selected";}?>>2</option>
					<option value="03" <?php if($month=='03'){echo "selected";}?>>3</option>
					<option value="04" <?php if($month=='04'){echo "selected";}?>>4</option>
					<option value="05" <?php if($month=='05'){echo "selected";}?>>5</option>
					<option value="06" <?php if($month=='06'){echo "selected";}?>>6</option>
					<option value="07" <?php if($month=='07'){echo "selected";}?>>7</option>
					<option value="08" <?php if($month=='08'){echo "selected";}?>>8</option>
					<option value="09" <?php if($month=='09'){echo "selected";}?>>9</option>
					<option value="10" <?php if($month=='10'){echo "selected";}?>>10</option>
					<option value="11" <?php if($month=='11'){echo "selected";}?>>11</option>
					<option value="12" <?php if($month=='12'){echo "selected";}?>>12</option>
				</select>&nbsp;月</span>
			</form>
	</div>
	<div class="wdzh_box">
		<div class="wdzh_con">
			<p style="font-size:14px; font-weight:bold; text-align:center; letter-spacing:1px; margin-bottom:5px;">总提成=总营业额*提成比例</p>
			<div class="ys_gz">
				<div class="ys_gz_con">
					<span style="padding:2px; background:#fff;"><?php echo number_format($all_price*$discount,0);?></span>
					<em>=</em>
					<span style="padding:2px; background:#fff;"><?php echo number_format($all_price,0); ?></span>
					<em style=" margin-top:7px;">*</em>
					<span style="padding:2px; background:#fff;"><?php echo ($discount*100)."%";?></span>
				</div>
			</div>
<?php
	reset($return_money);
	while(list($key, $val) = each($return_money)){
	if($val > $discount){
?>
			<div style=" height:26px; line-height:26px; margin-top:10px; text-align:center;">
				    <span style="letter-spacing:2px; font-weight:bold;">您还差<span style="background:#46c68b; color:#fff;"><?php echo number_format($key-$all_price,0);?></span><span style="letter-spacing:2px; font-weight:bold;">元可升到<?php echo ($val*100)."%";?>百分比例</span></span>
			</div>
<?php
	}
}
?>
			<table width="100%" border="2" bordercolor="#dadada" cellspacing="0" cellpadding="0" style=" text-align:center; border:3px solid #dadada; margin-top:28px; ">
  <tr  style=" color:#4d4c4c;">
    <td height="20">订单号</td>
    <td>用户</td>
    <td>金额</td>
    <td>日间</td>
  </tr>
<?php
foreach ($orderList as $row) {
	$obj = $ub->detail($db,$row->customer_id);
?>
  <tr bgcolor="#f8f8f8" background="#f8f8f8">
    <td  height="20"><a href="orders_info.php?order_id=<?php echo $row->order_id;?>"><?php echo $row->order_number;?></a></td>
    <td><?php echo $obj->name?></td>
    <td><?php echo "￥ ".number_format($row->all_price,2);?></td>
    <td><?php echo date("Y-m-d",$row->addtime);?></td>
  </tr>
<?php }?>
</table>

		</div>
	</div>
<?php include_once('common_footer.php');?>
