<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/script.js"></script>
<script type="text/javascript">
$(function(){
	$('.product-wrap div.product').eq(<?php echo $status;?>).fadeIn(150).siblings('div.product').hide();
		var pmove=0;
		for(var i=0;i<<?php echo $status;?>;i++){
			pmove += $('.title-list li').eq(i).width()
		}
		$('.case .title-list p').stop(false,true).animate({'left' : pmove + 'px'},300);
});
</script>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="top-left top-back"></a>
	<a href="index.php" class="top-right top-index"></a>
</div>
<div class="case">

	<div class="title cf" id="products">

		<ul class="title-list fr cf ">
			<li <?php if($status==-1){echo "class=\"on\"";}?>>全部</li>
			<li <?php if($status==1){echo "class=\"on\"";}?>>待付款</li>
		<li <?php if($status==2){echo "class=\"on\"";}?>>待发货</li>
		<li <?php if($status==3){echo "class=\"on\"";}?>>待收货</li>
		<li <?php if($status==4){echo "class=\"on\"";}?>>已收货</li>
			<p></p>
		</ul>
	</div>

	<div class="product-wrap">
		<div class="product show">
<?php
foreach ($orderList as $row) {
	$obj = $ub->detail($db,$row->customer_id);
	$cart2List = $c2b->get_results_order($db,$row->order_id);
?>
			<div class="table-bg">
			<table width="264" border="0" cellspacing="0" cellpadding="0" class="con1_table">
  <tr>
    <td height="26" colspan="2" class="border_style"><img src="res/images/user-tt.png" width="11" height="16" style="vertical-align:middle; margin-left:3px;" />&nbsp;<?php echo $obj->name; ?></td>
    <td width="19%" class="border_style"><div align="center"><span style="color:#FF0000;"><?php echo $OrderStatus[$row->order_status_id];?></span></div></td>
  </tr>
   <tr>
    <td height="14" colspan="2"></td>
    <td width="19%" ></td>
  </tr>
<?php
	$totalPrice = 0;
	$totalNumber = 0;
	foreach($cart2List as $cart){


		if($cart->product_type > 0){
			$product_price = $cart->product_price;
		}else{
			$product_price = $cart->product_price_old;
		}
		$totalPrice += ($cart->shopping_number * $product_price);
		$totalNumber += $cart->shopping_number;
?>
  <tr >
    <td width="17%" rowspan="2" class="border_style" ><div align="center"><img src="product/small/<?php echo $cart->product_image;?>" width="49" height="49" align="middle" /></div></td>
    <td width="64%" height="30" ><?php echo $cart->product_name;?> <?php if($cart->product_model!=' '){  echo $cart->product_model;}?> </td>
    <td>&yen;<?php echo number_format($product_price,2);?></td>
  </tr>
  <tr>
    <td height="30" class="border_style">&nbsp;</td>
    <td class="border_style"><font class="price_right">x<?php echo $cart->shopping_number;?></font></td>
  </tr>
<?php } ?>
  <tr>
    <td height="35" colspan="3" style="letter-spacing:-1px; "><span class="left_style"><?php echo $row->date_added;?></span><span class="price_right">订单号：<?php echo $row->order_number;?></span></td>
    </tr>
  <tr>
    <td colspan="3"><span style="float:right;">共计<?php echo $totalNumber; ?>件商品&nbsp; 运费：&yen;<?php if($totalPrice >= 150){echo "0.00";}else{echo "10.00";}?>&nbsp; 实付:<font color="#FF0000"class="price_right">&yen;<?php echo number_format($row->pay_online,2);?></font></span> </td>
    </tr>

</table>
		</div>
<?php } ?>
		</div>

		<div id="product1" class="product">
<?php
foreach ($orderList1 as $row) {
	$obj = $ub->detail($db,$row->customer_id);
	$cart2List = $c2b->get_results_order($db,$row->order_id);
?>
			<div class="table-bg">
			<table width="264" border="0" cellspacing="0" cellpadding="0" class="con1_table">
  <tr>
    <td height="26" colspan="2" class="border_style"><img src="res/images/user-tt.png" width="11" height="16" style="vertical-align:middle; margin-left:3px;" />&nbsp;<?php echo $obj->name; ?></td>
    <td width="19%" class="border_style"><div align="center"><span style="color:#FF0000;"><?php echo $OrderStatus[$row->order_status_id];?></span></div></td>
  </tr>
   <tr>
    <td height="14" colspan="2"></td>
    <td width="19%" ></td>
  </tr>
<?php
	$totalPrice = 0;
	$totalNumber = 0;
	foreach($cart2List as $cart){


		if($cart->product_type > 0){
			$product_price = $cart->product_price;
		}else{
			$product_price = $cart->product_price_old;
		}
		$totalPrice += ($cart->shopping_number * $product_price);
		$totalNumber += $cart->shopping_number;
?>
  <tr >
    <td width="17%" rowspan="2" class="border_style" ><div align="center"><img src="product/small/<?php echo $cart->product_image;?>" width="49" height="49" align="middle" /></div></td>
    <td width="64%" height="30" ><?php echo $cart->product_name;?> <?php if($cart->product_model!=' '){  echo $cart->product_model;}?> </td>
    <td>&yen;<?php echo number_format($product_price,2);?></td>
  </tr>
  <tr>
    <td height="30" class="border_style">&nbsp;</td>
    <td class="border_style"><font class="price_right">x<?php echo $cart->shopping_number;?></font></td>
  </tr>
<?php } ?>
  <tr>
    <td height="35" colspan="3" style="letter-spacing:-1px; "><span class="left_style"><?php echo $row->date_added;?></span><span class="price_right">订单号：<?php echo $row->order_number;?></span></td>
    </tr>
  <tr>
    <td colspan="3"><span style="float:right;">共计<?php echo $totalNumber; ?>件商品&nbsp; 运费：&yen;<?php if($totalPrice >= 150){echo "0.00";}else{echo "10.00";}?>&nbsp; 实付:<font color="#FF0000"class="price_right">&yen;<?php echo number_format($row->pay_online,2);?></font></span> </td>
    </tr>

</table>
		</div>
<?php } ?>
		</div>

		<!--案例3-->
		<div id="product2" class="product">
<?php
foreach ($orderList2 as $row) {
	$obj = $ub->detail($db,$row->customer_id);
	$cart2List = $c2b->get_results_order($db,$row->order_id);
?>
			<div class="table-bg">
			<table width="264" border="0" cellspacing="0" cellpadding="0" class="con1_table">
  <tr>
    <td height="26" colspan="2" class="border_style"><img src="res/images/user-tt.png" width="11" height="16" style="vertical-align:middle; margin-left:3px;" />&nbsp;<?php echo $obj->name; ?></td>
    <td width="19%" class="border_style"><div align="center"><span style="color:#FF0000;"><?php echo $OrderStatus[$row->order_status_id];?></span></div></td>
  </tr>
   <tr>
    <td height="14" colspan="2"></td>
    <td width="19%" ></td>
  </tr>
<?php
	$totalPrice = 0;
	$totalNumber = 0;
	foreach($cart2List as $cart){


		if($cart->product_type > 0){
			$product_price = $cart->product_price;
		}else{
			$product_price = $cart->product_price_old;
		}
		$totalPrice += ($cart->shopping_number * $product_price);
		$totalNumber += $cart->shopping_number;
?>
  <tr >
    <td width="17%" rowspan="2" class="border_style" ><div align="center"><img src="product/small/<?php echo $cart->product_image;?>" width="49" height="49" align="middle" /></div></td>
    <td width="64%" height="30" ><?php echo $cart->product_name;?> <?php if($cart->product_model!=' '){  echo $cart->product_model;}?> </td>
    <td>&yen;<?php echo number_format($product_price,2);?></td>
  </tr>
  <tr>
    <td height="30" class="border_style">&nbsp;</td>
    <td class="border_style"><font class="price_right">x<?php echo $cart->shopping_number;?></font></td>
  </tr>
<?php } ?>
  <tr>
    <td height="35" colspan="3" style="letter-spacing:-1px; "><span class="left_style"><?php echo $row->date_added;?></span><span class="price_right">订单号：<?php echo $row->order_number;?></span></td>
    </tr>
  <tr>
    <td colspan="3"><span style="float:right;">共计<?php echo $totalNumber; ?>件商品&nbsp; 运费：&yen;<?php if($totalPrice >= 150){echo "0.00";}else{echo "10.00";}?>&nbsp; 实付:<font color="#FF0000"class="price_right">&yen;<?php echo number_format($row->pay_online,2);?></font></span> </td>
    </tr>

</table>
		</div>
<?php } ?>
		</div>

		<!--案例4-->
		<div id="product3" class="product">
<?php
foreach ($orderList3 as $row) {
	$obj = $ub->detail($db,$row->customer_id);
	$cart2List = $c2b->get_results_order($db,$row->order_id);
?>
			<div class="table-bg">
			<table width="264" border="0" cellspacing="0" cellpadding="0" class="con1_table">
  <tr>
    <td height="26" colspan="2" class="border_style"><img src="res/images/user-tt.png" width="11" height="16" style="vertical-align:middle; margin-left:3px;" />&nbsp;<?php echo $obj->name; ?></td>
    <td width="19%" class="border_style"><div align="center"><span style="color:#FF0000;"><?php echo $OrderStatus[$row->order_status_id];?></span></div></td>
  </tr>
   <tr>
    <td height="14" colspan="2"></td>
    <td width="19%" ></td>
  </tr>
<?php
	$totalPrice = 0;
	$totalNumber = 0;
	foreach($cart2List as $cart){


		if($cart->product_type > 0){
			$product_price = $cart->product_price;
		}else{
			$product_price = $cart->product_price_old;
		}
		$totalPrice += ($cart->shopping_number * $product_price);
		$totalNumber += $cart->shopping_number;
?>
  <tr >
    <td width="17%" rowspan="2" class="border_style" ><div align="center"><img src="product/small/<?php echo $cart->product_image;?>" width="49" height="49" align="middle" /></div></td>
    <td width="64%" height="30" ><?php echo $cart->product_name;?> <?php if($cart->product_model!=' '){  echo $cart->product_model;}?> </td>
    <td>&yen;<?php echo number_format($product_price,2);?></td>
  </tr>
  <tr>
    <td height="30" class="border_style">&nbsp;</td>
    <td class="border_style"><font class="price_right">x<?php echo $cart->shopping_number;?></font></td>
  </tr>
<?php } ?>
  <tr>
    <td height="35" colspan="3" style="letter-spacing:-1px; "><span class="left_style"><?php echo $row->date_added;?></span><span class="price_right">订单号：<?php echo $row->order_number;?></span></td>
    </tr>
  <tr>
    <td colspan="3"><span style="float:right;">共计<?php echo $totalNumber; ?>件商品&nbsp; 运费：&yen;<?php if($totalPrice >= 150){echo "0.00";}else{echo "10.00";}?>&nbsp; 实付:<font color="#FF0000"class="price_right">&yen;<?php echo number_format($row->pay_online,2);?></font></span> </td>
    </tr>

</table>
		</div>
<?php } ?>
		</div>

		<!--案例5-->
		<div id="product4" class="product">
<?php
foreach ($orderList4 as $row) {
	$obj = $ub->detail($db,$row->customer_id);
	$cart2List = $c2b->get_results_order($db,$row->order_id);
?>
			<div class="table-bg">
			<table width="264" border="0" cellspacing="0" cellpadding="0" class="con1_table">
  <tr>
    <td height="26" colspan="2" class="border_style"><img src="res/images/user-tt.png" width="11" height="16" style="vertical-align:middle; margin-left:3px;" />&nbsp;<?php echo $obj->name; ?></td>
    <td width="19%" class="border_style"><div align="center"><span style="color:#FF0000;"><?php echo $OrderStatus[$row->order_status_id];?></span></div></td>
  </tr>
   <tr>
    <td height="14" colspan="2"></td>
    <td width="19%" ></td>
  </tr>
<?php
	$totalPrice = 0;
	$totalNumber = 0;
	foreach($cart2List as $cart){


		if($cart->product_type > 0){
			$product_price = $cart->product_price;
		}else{
			$product_price = $cart->product_price_old;
		}
		$totalPrice += ($cart->shopping_number * $product_price);
		$totalNumber += $cart->shopping_number;
?>
  <tr >
    <td width="17%" rowspan="2" class="border_style" ><div align="center"><img src="product/small/<?php echo $cart->product_image;?>" width="49" height="49" align="middle" /></div></td>
    <td width="64%" height="30" ><?php echo $cart->product_name;?> <?php if($cart->product_model!=' '){  echo $cart->product_model;}?> </td>
    <td>&yen;<?php echo number_format($product_price,2);?></td>
  </tr>
  <tr>
    <td height="30" class="border_style">&nbsp;</td>
    <td class="border_style"><font class="price_right">x<?php echo $cart->shopping_number;?></font></td>
  </tr>
<?php } ?>
  <tr>
    <td height="35" colspan="3" style="letter-spacing:-1px; "><span class="left_style"><?php echo $row->date_added;?></span><span class="price_right">订单号：<?php echo $row->order_number;?></span></td>
    </tr>
  <tr>
    <td colspan="3"><span style="float:right;">共计<?php echo $totalNumber; ?>件商品&nbsp; 运费：&yen;<?php if($totalPrice >= 150){echo "0.00";}else{echo "10.00";}?>&nbsp; 实付:<font color="#FF0000"class="price_right">&yen;<?php echo number_format($row->pay_online,2);?></font></span> </td>
    </tr>

</table>
		</div>
<?php } ?>
		</div>
	</div>
</div>
<?php include_once('common_footer.php');?>