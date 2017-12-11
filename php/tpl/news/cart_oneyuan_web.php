<?php include_once('common_header.php');?>
<link href="res/css/y-style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	$(function(){
//		var reg = /^(\d{11})$/;
//    	return reg.test(a);

<?php
foreach($cartList as $cart){
?>
$("#buy_number<?php echo $cart->id;?>").change(function(){
	sumTotalPrice();
});
<?php
}
?>
	});
	function minus(nid,price){
		if(parseInt($("#buy_number"+nid).val()) > 1){
			$("#buy_number"+nid).val(parseInt($("#buy_number"+nid).val()) - 1);
			$("#t_count").html(parseInt($("#t_count").text()) - 1);
			caculateTotalPrice(nid,(0-price));
		}
	}
	function plus(nid,price){
		$("#buy_number"+nid).val(parseInt($("#buy_number"+nid).val()) + 1);
		$("#t_count").html(parseInt($("#t_count").text()) + 1);
		caculateTotalPrice(nid,price);
	}

	function caculateTotalPrice(cid,price){
		var tprice = $("#t_price").text();
		tprice = parseFloat(tprice) + price;
		$("#t_price").html(tprice.toFixed(2));
	}

	function sumTotalPrice(){
		var tnumber = 0;
		$(".buy_number").each(function(){
			tnumber += parseInt($(this).val());
		});
		$("#t_count").html(tnumber);
		$("#t_price").html(tnumber.toFixed(2));
	}

	function post_form(){
		var pay_money = $("#t_price").text();
		$("#pay_money").val(pay_money);
		$("#cartform").submit();
	}
</script>
<?php include_once('loading.php');?>
<div class="head-red">
	<span class="logo-style"><a href=""><img src="res/images/return-btn.png" width="23" /></a></span>
    <div class="title-style">购物车</div>
</div>
<form id="cartform" action="orders_oneyuan.php" method="post">
<input type="hidden" name="act" value="prebuy" />
<?php
$total_count = 0;
foreach($cartList as $cart){
	$total_count+=$cart->shopping_number;
	$buy_number = $c2b->get_product_buy_count($db,$cart->product_id,$cart->phase_id);
	$phase = $ppb->detail($db,$cart->phase_id);
?>
			  <input type="hidden" name="ids[]" value="<?php echo $cart->id;?>" />
              <div class="clearfix" style="background:#fff; border-bottom:1px solid #eeeeee;">
	          <div class="shop-detail-box clearfix">
				<a href="">
                   <div class=" shop-car-box clearfix">
                      <div class="product-pic-box">
                            	<img src="product/small/<?php echo $cart->product_image;?>" width="100%">
                            </div>
                      <div class="shop-carcon-box">
                       <p><?php echo $cart->product_name;?>【第<?php echo $cart->phase_id;?>期】</p>
                       <p class="black-color" style="font-size:12px;">剩余<?php echo ($phase->total_amount-$buy_number);?>人次</p>
                       <p class="red-color">¥&nbsp;<?php echo $cart->product_price;?></p>
                       <div class="jjcc clearfix">
                       <a href="#" onclick="javascript:minus(<?php echo $cart->id;?>,1);"><div><span class="clearfix down-j">-</span></div></a>
                         <div class="number_box_style"><input class="buy_number" id="buy_number<?php echo $cart->id;?>" name="shopping_number[]" value="<?php echo $cart->shopping_number;?>" type="text" style="width:33px; height:30px; text-align:center; border:1px solid #ccc;"></div>
                        <a href="#" onclick="javascript:plus(<?php echo $cart->id;?>,1);"><div class="number_box_style"><span class="reduce_style">+</span></div></a>
                        <div class="car-style"><a href="cart_oneyuan.php?act=del&id=<?php echo $cart->id;?>" style="margin-top:40px;"><img src="res/images/shop-car.png" width="23"></a></div>
                      </div>
                      </div>
                   </div>
                </a>

              </div>
              </div>
<?php } ?>
              <div class="clearfix" style="background:#fff; border-bottom:1px solid #eeeeee;">
	          <div class="shop-detail-box clearfix">
				<span style="float:right;">共云购&nbsp;<font class="red-color"><span id="t_count"><?php echo $total_count;?></span>个</font>&nbsp;商品&nbsp;&nbsp;&nbsp;合计金额：<font class="red-color">¥&nbsp;<span id="t_price"><?php echo number_format($total_count,2);?></span></font></span>
				  <input type="hidden" id="pay_money" name="pay_money" value="<?php echo number_format($total_count,2);?>" />
              </div>
              </div>
   <div class="add-bottom" style="float:left; width:100%;">
   <a href="#" onclick="javascript:post_form();"><div class="pay-btn">
   结算</div></a>
   </div>
</form>
<?php include "main_menu.php";?>
<?php include_once('common_footer.php');?>