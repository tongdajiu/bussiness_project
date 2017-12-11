<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">积分兑换订单</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="order-wrapper">
<?php if(count($integralOrdersList) == 0){ ?>
<div class="tips-null">暂无订单！</div>
<?php } ?>
	<ul>
		<?php
			foreach($integralOrdersList as $order){
				$order_details = $integralOrdersDetail->getAll(array('userid'=>$userid,'integral_orders_id'=>$order->id));
		?>
    	<li class="order-list">
        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td colspan="3" class="order-list-number">订单编号:<?php echo $order->order_number;?></td>
                    <!--<td colspan="4" class="order-list-time"><?php echo date('Y-m-d H:i:s',$order->create_time);?></td>-->
                </tr>

		<?php foreach($order_details as $order_detail){ ?>
                <tr>
                	<td class="order-list-pic" width="65"><a href="integral_product_detail.php?product_id=<?php echo $order_detail->product_id;?>"><?php renderPic($order_detail->product_image, 'small', 5, array('w'=>60,'h'=>60), array('cls'=>'shoppingCart-table-Pic02-border','style'=>'height:auto;overflow:hidden'));?></a></td>
                    <td class="order-list-picName"<a href="integral_product_detail.php?product_id=<?php echo $order_detail->product_id;?>" style="color:#999;font-size: 15px;"><?php echo $order_detail->product_name;?>×<?php echo $order_detail->shipping_number;?></a></td>
                    <td class="order-list-cash" width="80"><?php echo $order_detail->product_integral;?>积分</td>
                </tr>
		<?php } ?>

                <tr>
                	<td class="order-list-total">兑换总价：</td>
                    <td class="order-list-price"><?php echo $order->all_integral;?><font color="#999">&nbsp;&nbsp;积分</font></td>

                    <?php if($order->delivery_status == 0){ ?>
                    	<td rowspan="3" colspan="2"><input type="button" value="等待发货" class="order-list-waitButton" /><a href="integral_orders_info.php?id=<?php echo $order->id;?>" class="order-detail-go">【订单详情】</a></td>
                    <?php }else if($order->delivery_status == 1){ ?>
                    	<td rowspan="3">

                    		<?php if(VersionModel::isOpen('setWaybill')){
                    				if($order->receiving_state == 0){
                    		?>
                    			<input style="margin-right:5px;"  name="" type="button" value="查看物流" onclick="location.href='check_express.php?express_type=<?php echo $order->express_type;?>&express_number=<?php echo $order->express_number;?>';" class="order-list-waitButton" />
                    		<?php } } ?>
							<?php if($order->receiving_state == 0){ ?>
								<a href="integral_orders.php?act=receiving&id=<?php echo $order->id;?>" onclick="javascript:return window.confirm('是否确认收货?该操作不可恢复！');" class="order-list-receiptButton" style="margin-top:5px;margin-right:5px;">确认收货</a>
            			   	<?php } ?>
            			   	<?php if($order->receiving_state == 1){ ?>
            			   		<a href="integral_orders.php?act=del&id=<?php echo $order->id;?>" onclick="javascript:return window.confirm('是否删除该订单?该操作不可恢复！');" class="order-list-receiptButton" style="margin-top:5px;margin-right:5px;" />删除订单</a>
            			   	<?php } ?>
            			   	<a href="integral_orders_info.php?id=<?php echo $order->id;?>" class="order-detail-go">【订单详情】</a></td>
                    <?php } ?>
                </tr>

                <tr>
                	<td class="order-list-total">支付积分：</td>
                    <td class="order-list-price"><?php echo $order->all_integral;?><font color="#999">&nbsp;&nbsp;积分</font></td>
                </tr>
                <tr>
                	<td class="order-list-total">产品数量：</td>
                    <td class="order-list-price02">1</td>
                </tr>
            </table>
        </li>
<?php } ?>
    </ul>
</div>
<?php include TEMPLATE_DIR.'/footer_web.php';?>
<?php include_once('common_footer.php');?>