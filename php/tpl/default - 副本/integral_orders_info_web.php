<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
	<div class="top_nav">
		<div class="top_nav_title">积分订单信息</div>
		<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
	</div>
		<div class="order-wrapper">
			<?php if(!empty($orders_obj)){ ?>
		    <div class="confirmOrder-Receipt clearfix">
		        <div class="confirmOrder-Receipt-L"></div>
		        <div class="confirmOrder-Receipt-R">
		            <p class="confirmOrder-Receipt-R-txt01">收货人：<?php echo $orders_obj->receiver;?><span class="confirmOrder-Receipt-R-txt02"><?php echo $orders_obj->phone;?></span></p>
		            <p class="confirmOrder-Receipt-R-txt03">收货地址：<?php echo $orders_obj->address;?></p>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <?php } ?>
		    <!--<div class="confirmOrder-list">
		        <ul>
		        	<?php foreach($orders_details as $order_detail){ ?>
					<a href="integral_product_detail.php?product_id=<?php echo $order_detail->product_id;?>">
		            <li class="confirmOrder-table">
		                <table border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tbody>
		                    <tr>

		                        <td rowspan="2" class="order-list-pic"><?php renderPic($order_detail->product_image, 'small', 5, array('w'=>55,'h'=>55), array('cls'=>'shoppingCart-table-Pic02-border'));?></td>
		                        <td rowspan="2" colspan="2" class="order-list-picName"><?php echo $order_detail->product_name;?></td>
		                        <td class="order-list-cash" width="40%">兑换积分：<?php echo $order_detail->product_integral;?></td>
		                    </tr>
		                    <tr>
		                        <td class="order-list-quantity" style="text-align: right;">×<?php echo $order_detail->shipping_number;?></td>
		                    </tr>
		                    </tbody>
		                </table>
		            </li>
					</a>
					<?php } ?>
		        </ul>
		    </div>-->

		    <div style="margin:0 10px;">
		    	<?php foreach($orders_details as $order_detail){ ?>
		    	<a href="integral_product_detail.php?product_id=<?php echo $order_detail->product_id;?>">
			   	<table border="0" cellpadding="0" cellspacing="0" width="100%">
				    <tr>
				    	<td class="order-list-pic" width="65"><?php renderPic($order_detail->product_image, 'small', 5, array('w'=>55,'h'=>55), array('cls'=>'shoppingCart-table-Pic02-border'));?></td>
				        <td class="order-list-picName"><?php echo $order_detail->product_name;?></td>
				        <td class="order-list-cash" width="80"><?php echo $order_detail->product_integral;?>积分<p>×<?php echo $order_detail->shipping_number;?></p></td>
				    </tr>
			    </table>
			    </a>
			    <?php } ?>
			</div>

		    <div class="confirmOrderTxt">
		        总积分：<span id="pay_money" style="font-size:17px;color:red;"><?php echo $orders_obj->all_integral;?></span> 积分<br />
		        支付积分：<span id="pay_money" style="font-size:17px;color:red;"><?php echo $orders_obj->all_integral;?></span> 积分<br />
		    </div>
		</div>
</div>
<?php include_once('common_footer.php');?>