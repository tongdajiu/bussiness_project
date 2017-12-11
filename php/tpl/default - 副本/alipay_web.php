<?php include_once('common_header.php');?>
<link href="res/css/index3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<?php include_once('loading.php');?>
<?php include "head_index.php";?>
<div class="index-wrapper">
    <div class="list02-pic-intro">
    	 <div class="list02-pic-txt">
    		<p class="list02-pic-txt_01">&nbsp;&nbsp;支付宝支付：</p>
   		 </div>
    	<div class="list02-pic-intro">
    		<div class="list02-pic-intro-txt">
        		<p class="list02-pic-txt_01">由于微信暂不支持支付宝端口，需要您先转账，收到货款后我们会尽快安排发货。谢谢您的支持和信任！</p><br/>
        		<p class="list02-pic-txt_01">订单编号：<?php echo $obj_order->order_number;?></p>
        		<p class="list02-pic-txt_01">订单总额：<?php echo $obj_order->pay_online;?></p><br/>
        		<p class="list02-pic-txt_01">支付宝账号：13927013777  林耿明</p>
       		</div>
   		</div>
    </div>
</div>
<?php include "footer_web.php";?>
<?php include_once('common_footer.php');?>
