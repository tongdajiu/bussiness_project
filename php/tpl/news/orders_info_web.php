<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>

<!--<div class="list-nav">
	<a href="index.php" class="top-left top-index">首页</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">订单信息</div>
</div>-->
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">订单详情</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>
<div class="order-wrapper">
	<div class="confirmOrder-Receipt">
    	<div class="confirmOrder-Receipt-L"></div>
        <div class="confirmOrder-Receipt-R" style="line-height:30px;">
        	<p class="confirmOrder-Receipt-R-txt01">收货人：<?php echo $obj_order->shipping_firstname;?><span class="confirmOrder-Receipt-R-txt02"><?php echo $obj_order->telephone;?></span></p>
            <p class="confirmOrder-Receipt-R-txt03">收货地址：<?php echo $obj_order->shipping_address_1;?></p>
        </div>
        <div class="clear"></div>
    </div>

    <!--<div class="confirmOrder-list">
        <ul>
		<?php
		$sum_price = 0;
		foreach($carts as $cart){
			$sum_price += $cart->shopping_number * $cart->product_price;
			if($obj_order->order_status_id==3){

		$order_info="&order_id=".$cart->order_id;
			}else{
		$order_info="";

			}
		?>
		   <a href="product_detail.php?product_id=<?php echo $cart->product_id;?><?php echo $order_info; ?>&share=1" >
		            <li class="confirmOrder-table">
		                <table border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tr>
		                        <td rowspan="2" class="order-list-pic" width="65px"><img src="product/small/<?php echo $cart->product_image;?>" alt="" width="55" height="55" class="shoppingCart-table-Pic02-border"/></td>
		                        <td rowspan="2" colspan="2" class="order-list-picName" style="padding-right:6px;"  width="175px"><?php echo $cart->product_name;?></td>
		                        <td class="order-list-cash">￥<?php echo number_format($cart->product_price,2);?></td>
		                    </tr>
		                    <tr>
		                        <td class="order-list-quantity">×<?php echo $cart->shopping_number;?></td>
		                    </tr>
		                </table>
		            </li>
		            </a>
		<?php } ?>
        </ul>
    </div>-->

    <div style="margin:0 10px;">
	   	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	        <?php
			$sum_price = 0;
			foreach($carts as $cart){
				$sum_price += $cart->shopping_number * $cart->product_price;
				if($obj_order->order_status_id==3){

			$order_info="&order_id=".$cart->order_id;
				}else{
			$order_info="";

				}
			?>
		    <tr>
		    	<td class="order-list-pic" width="65"><a href="product_detail.php?product_id=<?php echo $cart->product_id;?><?php echo $order_info; ?>&share=1" ><?php renderPic($cart->product_image, 'small', 1,array('w'=>55),array('cls'=>"shoppingCart-table-Pic02-border"));?></a></td>
		        <td class="order-list-picName"><a href="product_detail.php?product_id=<?php echo $cart->product_id;?><?php echo $order_info; ?>&share=1" ><?php echo $cart->product_name;?><?php if($cart->attribute!=''){  echo "(".$cart->attribute.")";}?></a></td>
		        <td class="order-list-cash" width="80">￥<?php echo number_format($cart->product_price,2);?><p>×<?php echo $cart->shopping_number;?></p></td>
		    </tr>
	        <?php } ?>
	    </table>
    </div>


    <div class="confirmOrderTxt">
        商品合计：<strong><?php echo number_format($sum_price,2);?></strong> 元<br />

        <?php if( $coupon_info != "" ){ ?>
		       	该订单使用了: <strong><?php echo $coupon_info->name; ?></strong>　优惠了 <strong><?php echo $coupon_info->discount; ?></strong> 元<br />
		<?php }?>

		<?php if($obj_order->discount_price > 0){?>
		       共抵消费用: <strong><?php echo number_format($obj_order->discount_price,2);?></strong> 元<br />
		<?php }?>

        支付金额：<strong><?php echo number_format($obj_order->pay_online - $obj_order->discount_price,2);?></strong> 元
    </div>

</div>
<?php include_once('common_footer.php');?>