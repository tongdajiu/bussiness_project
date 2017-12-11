<?php include_once('common_header.php');?>
<script type="text/javascript">
$(function(){
	$("input[name='pay_method'][value='1']").attr("checked","checked");
	$("input[name='pay_method'][value='2']").attr("disabled","disabled");

	$("#coupon_use").change(function(){
		$("#less_money").html(parseInt($("#coupon_use").find("option:selected").val()).toFixed(2));
		$("#pay_money").html((parseFloat($("#sum_price").val()) - parseFloat($("#coupon_use").find("option:selected").attr('data-price'))).toFixed(2));
		$("#pay_money_total").html((parseFloat($("#sum_price").val()) - parseFloat($("#coupon_use").find("option:selected").attr('data-price'))).toFixed(2));
	});
});

function pay_order(price)
{
	if ( $("#coupon_use").length > 0 )
	{
		var coupon_id = $("#coupon_use").find("option:selected").val();
	}
	else
	{
		var coupon_id = '';
	}

    location.href = "<?php echo $gSetting['wx_pay_dir'];?>pay.php?oid=<?php echo $order_id;?>&coupon_id=" + coupon_id;
}
</script>

<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">确认订单</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="order-wrapper">
    <div class="confirmOrder-Receipt clearfix">
        <div class="confirmOrder-Receipt-L"></div>
        <div class="confirmOrder-Receipt-R" style="line-height:30px;">
            <?php if(empty($address)){ ?>
                <p class="confirmOrder-Receipt-R-txt01">收货人：<?php echo $obj_order->shipping_firstname;?><span class="confirmOrder-Receipt-R-txt02"><?php echo $obj_order->telephone;?></span></p>
                <p class="confirmOrder-Receipt-R-txt03">收货地址：<?php echo $obj_order->shipping_address_1;?></p>
            <?php }else{ ?>
                <input type="hidden" name="addressId" value="<?php echo $address->id;?>" />
                <p class="confirmOrder-Receipt-R-txt01">收货人：<?php echo $address->shipping_firstname;?><span class="confirmOrder-Receipt-R-txt02"><?php echo $address->telephone;?></span></p>
                <p class="confirmOrder-Receipt-R-txt03">收货地址：<?php echo $address->address;?></p>
            <?php } ?>
        </div>
        <div class="clear"></div>
    </div>

    <div style="margin:0 10px;">
	   	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	        <?php
	        $sum_price = 0;

	        foreach($carts as $cart) {
	            $sum_price += ($cart->shopping_number * $cart->product_price);
	        ?>
		    <tr>
		    	<td class="order-list-pic" width="65"><?php renderPic($cart->product_image, 'small', 1, array('w'=>55,'h'=>55), array('cls'=>'shoppingCart-table-Pic02-border'));?></td>
		        <td class="order-list-picName"><?php echo $cart->product_name;?><?php if($cart->attribute) echo '('.$cart->attribute.')';?></td>
		        <td class="order-list-cash" width="80">￥<?php echo number_format($cart->product_price,2);?><p>×<?php echo $cart->shopping_number;?></p></td>
		    </tr>
	        <?php
	            $sum_price = $sum_price*$important_var['discount'];
	        }
	        ?>
	    </table>
    </div>

    <div class="confirmOrderTxt">
<?php
    if($obj_user->integral > floor($sum_price*100)){
        $integral_used = floor($sum_price*100);
    }else{
        $integral_used = $obj_user->integral;
    }
    if($sum_price < 50){
        $yunfei = 10;
    }else{
        $yunfei=0;
    }

//todo 暂时取消运费，支付测试完后恢复
$yunfei=0;

?>
       商品合计: <strong><?php echo number_format($sum_price,2);?></strong> 元<br />

<?php if($yunfei>0){?>
       配送费用: <strong><?php echo number_format($yunfei,2);?></strong> 元<br />
<?php }?>


<?php if( $coupon_info != "" ){ ?>
       	该订单使用了 <strong><?php echo $coupon_info->name; ?></strong> 优惠了 <strong><?php echo $coupon_info->discount; ?></strong> 元 <br />
<?php }?>

<?php if($obj_order->discount_price > 0){?>
       共抵消费用: <strong><?php echo number_format($obj_order->discount_price,2);?></strong> 元<br />
<?php }?>

	<?php if ( $obj_order->is_new == 1 && $coupon_list != null ){ ?>
		使用优惠券:
		 <select id="coupon_use" name="coupon_use" style="display:inline-block;vertical-align:text-bottom;font-size:12px;color:#333;padding:1px 0;">
			<option value="0" data-price="0">-</option>
			<?php foreach ( $coupon_list as $coupon ){
						if ( $coupon->enable == 1 ){
			?>
		 		<option value="<?php echo $coupon->coupon_num ?>" data-price="<?php echo $coupon->discount ?>" ><?php echo $coupon->name ?></option>
		 	<?php }} ?>
		 </select>
		 <br />
	<?php } ?>



        <!--折扣金额：-<span id="less_money">0.00</span>  元<br />-->
       <input type="hidden" id="sum_price" value="<?php echo ($sum_price+$yunfei);?>" />
        应付金额：<span id="pay_money"><strong><?php echo number_format(($sum_price+$yunfei-$obj_order->discount_price),2);?></strong></span> 元<br />
       <table>
       <tr>
           <td style="vertical-align:top; font-size:14px; display:none">支付方式：<td>
           <td style="display:inline-block;vertical-align:text-bottom;font-size:12px;color:#333;padding:1px 0;display:none">
            <select name="pay_method" style="padding:1px 0;">
                <?php while(list($key,$var) = each($PayMethod)){ ?>
                    <option value="<?php echo $key;?>"><?php echo $var;?></option>
                <?php } ?>
            </select>
            </td>
        </tr>
        </table>
        </div>
    </div>
    <table border="0" cellpadding="0" cellspacing="0" class="index-foot" style="width:100%;position:fixed;bottom:0px;" >
        <tr>
            <!--<td class="confirmOrdert-foot-L">共计<?php echo count($carts);?>件商品，￥<?php echo number_format($sum_price,2);?>元<br />本次可获得积分<?php echo $sum_price;?>分</td>-->
            <td class="confirmOrdert-foot-L">共计<?php echo count($carts);?>件商品，￥<span id="pay_money_total"><?php echo number_format(($sum_price+$yunfei-$obj_order->discount_price),2);?></span>元<br /><!--本次可获得积分<?php echo floor($sum_price);?>分--></td>
            <td class="shoppingCart-foot-R">
            <input name="" type="submit" onclick="pay_order(<?php echo ($sum_price+$yunfei-$obj_order->discount_price);?>);" class="shoppingCart-foot-R-button" value="确 定" /></td>
        </tr>
    </table>
</div>
<?php include_once('common_footer.php');?>
