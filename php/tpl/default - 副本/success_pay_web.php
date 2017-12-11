<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="list-nav">
	<a href="index.php" class="top-left top-index">首页</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">支付成功</div>
</div>

<div class="order-wrapper">
	<div style="background-color:#FFF;padding:20px;color:#666;">
		<div style="text-align:center;font-size:28px;"><h3>支付成功！</h3></div>
		<!--
		<div style="text-align:center;color:red;font-size:28px;"><h3>马上点击下面分享到朋友圈，<br/>就可获得100积分</h3></div>
		-->
        <div class="clear"></div>
    </div>
	<div style="background-color:#FFF;padding:20px;color:#666;">
		<div style="text-align:center;font-size:28px;">
			<input name="" type="submit" onclick="location.href='index.php'" class="u02-button-y" value="继续购买" />
	<input name="" type="submit" onclick="location.href='orders.php'" class="u02-button-y" value="查看订单" />
		</div>
        <div class="clear"></div>
    </div>
    <div class="confirmOrder-list">
<?php
foreach($carts as $cart){
?>
        <ul>
            <li class="confirmOrder-table">
            <a href="product_detail.php?product_id=<?php echo $cart->product_id;?>&order_id=<?php echo $cart->order_id; ?>&share=1">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td rowspan="2" class="order-list-pic" width="65"><a href="product_detail.php?product_id=<?php echo $cart->product_id;?>&order_id=<?php echo $cart->order_id; ?>&share=1"><img src="product/small/<?php echo $cart->product_image;?>" alt="" class="shoppingCart-table-Pic02-border"/></a></td>
                        <td rowspan="2" colspan="2" class="order-list-picName" width="175"><a href="product_detail.php?product_id=<?php echo $cart->product_id;?>&order_id=<?php echo $cart->order_id; ?>&share=1"><?php echo $cart->product_name;?></a></td>
                        <td class="order-list-cash"></td>
                    </tr>
                    <tr>
                        <td class="order-list-quantity">×<?php echo $cart->shopping_number;?></td>
                    </tr>
                </table></a>
            </li>
        </ul>
<?php
}
?>
    </div>
</div>
<?php include "tpl/footer_web.php";?>

<?php include_once('common_footer.php');?>
