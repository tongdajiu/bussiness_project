<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

$order_number = $_GET['order_number'] == null ? '0' : $_GET['order_number'];

$result = check_wxpay_order($order_number);
//print_r($result);
$order_info = $result->order_info;
?>

<form action="#" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<dl class="ott">
<dt>订单号：<?php echo $order_number; ?></dt>
</dl>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label id="name">订单状态: </label><?php if($order_info->trade_state === '0'){echo "成功";}else{echo "失败:".$order_info->ret_msg;} ?>
<div class="clear"></div>
</li>
<li>
<label id="name">交易模式: </label><?php if($order_info->trade_mode == 1){echo "及时到账";}else{echo "其他";} ?>
<div class="clear"></div>
</li>
<li>
<label id="name">银行类型: </label><?php echo $order_info->bank_type; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">银行订单号: </label><?php echo $order_info->bank_billno; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">总金额: </label><?php echo number_format(($order_info->total_fee/100),2); ?>
<div class="clear"></div>
</li>
<li>
<label id="name">币种: </label><?php if($order_info->fee_type == 1){echo "人民币";}else{echo "其他";} ?>
<div class="clear"></div>
</li>
<li>
<label id="name">财付通订单号: </label><?php echo $order_info->transaction_id; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">支付完成时间: </label><?php echo $order_info->time_end; ?>
<div class="clear"></div>
</li>
  </ul>
   </dd>
    </dl>
	<div class="clear"></div>
	</div>
</div>
</form>