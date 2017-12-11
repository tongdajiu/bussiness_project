<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">全部订单</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="order_state">
	<ul>
		<li <?php if($status==-1){echo 'class="active"';}?>><a href="/orders.php">全部</a></li>
		<li <?php if($status==0){echo 'class="active"';}?>><a href="/orders.php?status=1">待付款</a></li>
		<li <?php if($status==1){echo 'class="active"';}?>><a href="/orders.php?status=2">待发货</a></li>
		<li <?php if($status==2){echo 'class="active"';}?>><a href="/orders.php?status=3">待收货</a></li>
		<li <?php if($status==3){echo 'class="active"';}?>><a href="/orders.php?status=4">已收货</a></li>
	</ul>
</div>

<div class="order-wrapper">

<?php if(count($orderList['DataSet']) == 0){ ?>
<div class="tips-null">暂无订单！</div>
<?php } ?>
	<ul>
<?php
foreach($orderList['DataSet'] as $order){
	$cart2List = $OrderProductModel->getAll(array('order_id'=>$order->order_id));

	$sumNumber = $OrderProductModel->get_results_orderSum($order->order_id);
	$commentList = $CommentModel->getAll(array('order_id'=>$order->order_id));
?>
    	<li class="order-list">
        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td colspan="3" class="order-list-number">订单编号:<?php echo $order->order_number;?></td>
                    <!--<td colspan="4" class="order-list-time"><?php echo $order->date_added;?></td>-->
                </tr>
<?php
	$totalPrice = 0;
	foreach($cart2List as $cart){
		$product_price = $cart->product_price;
		$totalPrice += ($cart->shopping_number * $product_price);
?>
                <tr>
                	<td class="order-list-pic" width="65"><a href="product_detail.php?product_id=<?php echo $cart->product_id;?>"><?php renderPic($cart->product_image, 'small', 1, array('w'=>60,'h'=>60), array('cls'=>'shoppingCart-table-Pic02-border','style'=>'height:auto;overflow:hidden'));?></a></td>
                    <td class="order-list-picName"><a href="product_detail.php?product_id=<?php echo $cart->product_id;?>" style="color:#999;font-size: 15px;"><?php echo $cart->product_name;?></a><p><?php if($cart->attribute!=''){  echo "(".$cart->attribute.")";}?></p></td>
                    <td class="order-list-cash" width="80">￥<?php echo number_format($product_price,2);?><p>×<?php echo $cart->shopping_number;?></p></td>
                </tr>

<?php
	}
?>
                <tr>
                	<td class="order-list-total">商品总价：</td>
                    <td class="order-list-price">￥<?php echo number_format($totalPrice,2);?></td>
                    <?php if($order->order_status_id == 0){ ?>
                    	
                    		<td rowspan="3"><input name="" type="submit" value="<?php echo $OrderStatus[$order->order_status_id];?>" onclick="location.href='orders_confirm.php?order_id=<?php echo $order->order_id;?>';" class="order-list-receiptButton" /><a href="orders_info.php?order_id=<?php echo $order->order_id;?>" class="order-detail-go">【订单详情】</a></td>
                    	
                    <?php }else if($order->order_status_id == 1){ ?>
                    	<td rowspan="3"><input name="" type="submit" value="<?php echo $OrderStatus[$order->order_status_id];?>" class="order-list-waitButton" /><a href="orders_info.php?order_id=<?php echo $order->order_id;?>" class="order-detail-go">【订单详情】</a></td>
                    <?php }else if($order->order_status_id == 2){ ?>

                    	<td rowspan="3">
                    		<?php if(VersionModel::isOpen('setWaybill')){ ?>
                    		<input style="margin-right:5px;"  name="" type="submit" value="查看物流" onclick="location.href='check_express.php?express_type=<?php echo $order->express_type;?>&express_number=<?php echo $order->express_number;?>';" class="order-list-waitButton" />
                    		<?php } ?>
                    			   <input name="" type="submit" value="确认收货" onclick="location.href='orders.php?act=confirm&order_id=<?php echo $order->order_id;?>&userid=<?php echo $userid;?>';" class="order-list-receiptButton" style="margin-top:5px;margin-right:5px;" />
                    			   <a href="orders_info.php?order_id=<?php echo $order->order_id;?>" class="order-detail-go">【订单详情】</a></td>
                    <?php }else if($order->order_status_id == 3){ ?>
                    	<td rowspan="3">
                    			<?php if(!count($commentList)){?>
                    				<input name="" type="submit" value="添加评价"  onclick="location.href='comment.php?order_id=<?php echo $order->order_id;?>';" class="order-list-waitButton" />
                    			<?php } ?>
                    			<a href="orders_info.php?order_id=<?php echo $order->order_id;?>" class="order-detail-go">【订单详情】</a>
                    	</td>
                    <?php } ?>
                </tr>
				<?php if($order->coupon){?>
				<tr>
                	<td class="order-list-total">优惠券金额：</td>
                    <td class="order-list-price">-￥<?php echo $re_exp_value = $order->discount_price;?></td>
                </tr>
				<?php }?>

                <tr>
                	<td class="order-list-total">支付金额：</td>
                    <td class="order-list-price">￥<?php echo number_format($order->pay_online - $order->discount_price,2);?></td>
                </tr>
                <tr>
                	<td class="order-list-total">产品数量：</td>
                    <td class="order-list-price02"><?php echo $sumNumber;?></td>
                </tr>
            </table>
        </li>
<?php } ?>

    </ul>
</div>

<?php include TEMPLATE_DIR.'/footer_web.php';?>
<?php include_once('common_footer.php');?>
