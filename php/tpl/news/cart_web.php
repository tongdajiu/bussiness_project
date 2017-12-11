<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript">
	//编辑
	function carEdit(){
		$(".car_edit").hide();
		$(".car_finish").show();
	}
	function carFinish(){
		$(".car_edit").show();
		$(".car_finish").hide();
	}

	//选择
	function show_buy_img(cid){
		if($("#buy_type"+cid).val() == 1){
			$("#buy_img"+cid).parent().addClass("active");
		}else{
			$("#buy_img"+cid).parent().removeClass("active");
		}
	}
	function cart_buy(cid,price){
		if($("#buy"+cid).prop("checked")){
			$("#buy_type"+cid).val(0);
			show_buy_img(cid);
			$("#buy"+cid).removeProp("checked");
		}else{
			$("#buy_type"+cid).val(1);
			show_buy_img(cid);
			$("#buy"+cid).prop("checked","checked");
		}
		setTotalPrice();
	}

	//数量加减
	function minus(nid,qproduct,price){
		if(qproduct==3){
			alert("该商品只允许限购一个！");
		}else if(parseInt($("#buy_number"+nid).val()) > 1){
			numChange(nid,qproduct,price,"minus");
		}
	}
	function plus(nid,qproduct,price){
		if(qproduct==3){
			alert("该商品只允许限购一个！");
		}else{
			numChange(nid,qproduct,price,"plus");
		}
	}
	function numChange(nid,qproduct,price,operation){
		if(parseInt($("#buy_number"+nid).val()) != $("#buy_number"+nid).val()){
			alert("商品数量需为正整数");
			$("#buy_number"+nid).val(1);
		}
		if(parseInt($("#buy_number"+nid).val()) <= 0){
			$("#buy_number"+nid).val(1);
		}
		var abuy_number = parseInt($("#buy_number"+nid).val());
		if(operation == "plus"){
			abuy_number++;
		}else if(operation == "minus"){
			abuy_number--;
		}	
		$.ajax({
			url:'cart.php?act=inventory&cart_id='+nid+'&buy_number='+abuy_number,
			type:'POST',
	//		dataType: 'string',
			error: function(){
	     		alert('请求超时，请重新添加');
	    	},
	    	success: function(result){
				if(result == '-1'){
					alert("缺少参数");
				}else if(result == '-2'){
					alert("没有这条购物车信息");
				}else if(result == '-3'){
					alert("商品已不存在");
				}else if(result == '-4'){
					alert("购买数量超出库存");
					$("#buy_number"+nid).val($("#proInfo"+nid).attr("data-shoppingnum"));
				}else if(result == '-5'){
					alert("商品规格发生变动，请重新添加");
				}else{
					$("#buy_number"+nid).val(abuy_number);
					$("#shopping_number"+nid).val(abuy_number);
					$("#number"+nid).html((abuy_number * price).toFixed(2));

					$("#proInfo"+nid).attr({"data-num":abuy_number});
					$("#proInfo"+nid).attr("data-shoppingnum",abuy_number);
					$("#proInfo"+nid).parents(".shoppingCart-Bg").find("span.pro_num_show").html(abuy_number);
					setTotalPrice();
				}
	    	}
		});

		
	}


	// function caculateTotalPrice(){
	// 	var tprice = 0;
	// 	$(".shoppingCart-Bg input[type='checkbox']").each(function(index,element){
	// 		if($(element).attr("checked")){
	// 			tprice += parseInt($(element).parents(".shoppingCart-Bg").find("input.quantity_txt").val());
	// 		}
	// 	});
	// 	$("#t_price").html(tprice.toFixed(2));
	// 	$("#all_price").val(tprice.toFixed(2));
	// }

	//总价
	function setTotalPrice(){
		var price = 0, num = 0, tprice = 0;
		$(".shoppingCart-Bg input[type='checkbox']").each(function(index,element){
			if($(element).prop("checked")){
				price = $(element).parents(".shoppingCart-Bg").find(".proInfo").attr("data-price");
				num = $(element).parents(".shoppingCart-Bg").find(".proInfo").attr("data-num");
				tprice += num * price;
			}
		});
		// var tprice = $("#t_price").text();
		// if($("#buy"+cid).attr("checked")){
		// 	tprice = parseFloat(tprice) + ($("#buy_number"+cid).val() * price);
		// }else{
		// 	tprice = parseFloat(tprice) - ($("#buy_number"+cid).val() * price);
		// }
		$("#t_price").html(tprice.toFixed(2));
	}

	$(function(){
		//全选
		$(".shoppingCart-foot-L").click(function(){
			if($(this).attr("data-check")==1){
				$(".shoppingCart-foot-L").attr("data-check",0);
				$(".shoppingCart-foot-L").removeClass("active");
				for(var i = 0;i<$(".shoppingCart-checkbox").length;i++){
					if($(".shoppingCart-checkbox").eq(i).hasClass("active")){
						$(".shoppingCart-checkbox").eq(i).find("i").trigger("click");
					}
				}
			}else{
				$(".shoppingCart-foot-L").attr("data-check",1);
				$(".shoppingCart-foot-L").addClass("active");
				for(var i = 0;i<$(".shoppingCart-checkbox").length;i++){
					if(!$(".shoppingCart-checkbox").eq(i).hasClass("active")){
						$(".shoppingCart-checkbox").eq(i).find("i").trigger("click");
					}
				}
			}
		});
	})
</script>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">购物车</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
	<?php if($cartList!=null){ ?>
		<a href="javascript:carEdit();" class="top_nav_right top_nav_blue car_edit">编辑</a>
		<a href="javascript:carFinish();" class="top_nav_right top_nav_blue car_finish" style="display:none;">完成</a>
	<?php } ?>
</div>

<form action="cart.php" method="post">
<input type="hidden" name="act" value="post" />
<input type="hidden" name="userid" value="<?php echo $userid;?>" />
<div class="index-wrapper" style="padding: 10px 0 10px 0;">
        <ul>
		 <?php if($cartList==null){ ?>
			<div class="shoppingCart-none">你的购物车暂无商品</div>
		<?php
		}else{
			$sum_price 	= 0;
			$ii			= 0;

			foreach($cartList as $cart)
			{
				$ii++;
				$obj_product = $ProductModel->get( array('product_id'=>$cart->product_id) );

				if($obj_product != null)
				{
					if($obj_product->hot == 2 && $obj_user->type == 1)
					{
						$sum_price += ($cart->product_price * $cart->shopping_number);
					}
					else
					{
						$sum_price += ($cart->product_price * $cart->shopping_number);
					}
				}
		?>
            <li class="shoppingCart-Bg">
            	<input type="hidden" id="buy_type<?php echo $cart->id;?>" value="1" />
            	<input type="hidden" id="shopping_number<?php echo $cart->id;?>" name="shopping_number[]" value="<?php echo $cart->shopping_number;?>" />

            	<input type="hidden" id="new_price" name="new_price" value="444" />
            	<div class="shoppingCart-margin">
	            	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="shoppingCart-table">
	                	<tr>
	                    	<td rowspan="2" width="30">
	                    	<?php if($obj_product != null){ ?>
	                    		<div style="display:none;"><input type="checkbox" id="buy<?php echo $cart->id;?>" name="cart_id[]" value="<?php echo $cart->id ?>" checked="checked" /></div>
	                    	<?php } ?>
	                    		<a class="shoppingCart-checkbox active" href="javascript:cart_buy(<?php echo $cart->id;?>,<?php if($obj_product->hot == 2 && $obj_user->type == 1){echo number_format($cart->product_price,2);}else{echo number_format($cart->product_price,2);}?>);"><i class="checkbox_img" id="buy_img<?php echo $cart->id;?>"></i></a>
	                    	</td>
	                        <td rowspan="2" width="70" class="proInfo" id="proInfo<?php echo $cart->id;?>" data-shoppingNum="<?php echo $cart->shopping_number;?>" data-num="<?php echo $cart->shopping_number;?>" data-price="<?php echo number_format($cart->product_price,2);?>">
	                     	   <a href="product_detail.php?product_id=<?php echo $cart->product_id;?>"><?php renderPic($cart->product_image, 'small', 1, array('w'=>60,'h'=>60), array('cls'=>'shoppingCart-table-Pic02-border'));?></a>
	                        </td>
	                        <td><?php echo $cart->product_name;?><?php if($cart->attribute) echo '('.$cart->attribute.')';?></td>
	                        <td align="right" width="80" class="car_edit">
								<?php if($obj_product->hot == 2 && $obj_user->type == 1){ ?>
			                    	<font color="#f60">￥<?php echo number_format($cart->product_price,2);?></font>
			                    <?php }else{ ?>
			                    	<font color="#f60">￥<?php echo number_format($cart->product_price,2);?></font>
			                    <?php } ?>
	                        </td>
	                        <td width="80" align="right" class="car_finish" style="display:none;"><a href="cart.php?act=del&id=<?php echo $cart->id;?>" onclick="javascript:return window.confirm('确定删除？');"><img src="res/images/shoppingCart_07.png" alt="" width="15" height="16" /></a></td>
	                    </tr>
	                    <tr>
	                        <td align="right" colspan="2" class="car_edit">
	                        	× <span class="pro_num_show"><?php echo $cart->shopping_number;?></span>
	                        </td>
	                        <td colspan="2" style="display:none;" class="car_finish">
	                        	<?php if($obj_product != null){ ?>
	                        		<div class="quantity" style="float:right;">
										<a class="quantity_minus" <?php if($cart->product_type==2){echo "disabled='disabled'";}?> href="javascript:minus(<?php echo $cart->id;?>,<?php echo $obj_product->hot;?>,<?php if($obj_product->hot == 2 && $obj_user->type == 1){echo $cart->product_price;}else{echo $cart->product_price;}?>);">-</a>
										<input class="quantity_txt" id="buy_number<?php echo $cart->id;?>" class="shoppingCart-table-R-number"onChange="numChange(<?php echo $cart->id;?>,<?php echo $obj_product->hot;?>,<?php if($obj_product->hot == 2 && $obj_user->type == 1){echo $cart->product_price;}else{echo $cart->product_price;}?>)" value="<?php echo $cart->shopping_number;?>" />
										<a class="quantity_plus" <?php if($cart->product_type==2){echo "disabled='disabled'";}?> href="javascript:plus(<?php echo $cart->id;?>,<?php echo $obj_product->hot;?>,<?php if($obj_product->hot == 2 && $obj_user->type == 1){echo $cart->product_price;}else{echo $cart->product_price;}?>);">+</a>
									</div>
	                        	<?php }else{ echo '商品已下架';} ?>
	                        </td>
	                    </tr>
	                </table>
	            </div>
            </li>
	<?php } ?>
<?php } ?>

<?php if( isset($ii) && $ii>2 ){ ?>
	<div style="height: 30px;"/>
<?php } ?>
        </ul>
    </div>
	<?php if(!empty($cartList)){ ?>
    <div class="shoppingCart-foot">
		<input type="hidden"  id="all_price" name="all_price" value="<?php echo $sum_price; ?>" />
		<div class="shoppingCart-foot-L active" data-check="1">总金额：<font color="#f60"><span id="t_price" class="shoppingCart-foot-L-money"><?php echo number_format($sum_price,2); ?></span>元</font></div>
    	<div class="shoppingCart-foot-R"><input name="submit" type="submit" class="shoppingCart-foot-R-button" value="结 算" /></div>
	</div>
	<?php } ?>
</div>
</form>
<?php include_once('common_footer.php');?>