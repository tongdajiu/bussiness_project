<?php include_once('common_header.php');?>
<link href="res/css/index2.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery-ui-personalized-1.5.3.packed.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/timeCountDown.js"></script>
<script type="text/javascript">


function promotion(pid,product_id){
	$.ajax({
		url:'promotions_product.php?act=check_num&product_id='+product_id+'&p_id=<?php echo $p_id;?>',
		type:'POST',
		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新购买');
    	},
    	success: function(result){
    	alert(result);
			var a = result.indexOf('<!DOCTYPE');
    		if(a > 0){
    			if(result.substr(0,a) == 'true'){
    				buy_now(product_id);
    			}else if(result.substr(0,a) == 'false'){
    				alert("产品已经告罄，请下次提早抢购！");
    			}
    		}else{
    			location.href = 'cart.php';
    		}
    	}
	});
}

function buy_now(product_id){
	$.ajax({
		url:'cart.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			var a = result.indexOf('<!DOCTYPE');
    		if(a > 0){
    			alert(result.substr(0,a));
    		}else{
    			location.href = 'cart.php';
    		}
    	}
	});
}
function addFavor(product_id){
    $.ajax({
		url:'favorites.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			alert('收藏成功');
    	}
	});
}
</script>
<style type="text/css">
.list-product p span {
	display: inline-block;
	width: 36px;
	height: 26px;
	line-height: 17px;
	color: #ffffff;
	font-size:24px;
	padding-top:20px;
	font-weight: 700;
	text-align: center;
	background: url("/images/bj.jpg") no-repeat;
	background-position:0px 5px;
}
</style>

<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="top-left top-back">后退</a>
	<a href="index.php" class="top-left top-index">首页</a>
    <div class="member-nav-M">今日抢购</div>
</div>

<div class="index-wrapper">
	<div class="list-product">

        <ul>
<?php
foreach($promotionList as $promotion){
	$product = $pb->detail($db,$promotion->product_id);
?>
			<li class="list-productBg02">
				<p class="lefttime">剩余时间：

		<span id="day<?php echo $promotion->id.$promotion->product_id;?>"></span>天<span id="hour<?php echo $promotion->id.$promotion->product_id;?>"></span>小时<span id="mini<?php echo $promotion->id.$promotion->product_id;?>"></span>分<span id="sec<?php echo $promotion->id.$promotion->product_id;?>"></span>秒
		<script>
		var d<?php echo $promotion->id.$promotion->product_id;?> = Date.UTC(<?php echo date("Y",$promotion->end_time);?>,<?php echo date("m",$promotion->end_time);?>,<?php echo date("d",$promotion->end_time);?>,23,59,59);
		var obj<?php echo $promotion->id.$promotion->product_id;?> = {
		sec: document.getElementById("sec<?php echo $promotion->id.$promotion->product_id;?>"),
		mini: document.getElementById("mini<?php echo $promotion->id.$promotion->product_id;?>"),
		hour: document.getElementById("hour<?php echo $promotion->id.$promotion->product_id;?>"),
		day: document.getElementById("day<?php echo $promotion->id.$promotion->product_id;?>")
		}
		fnTimeCountDown(d<?php echo $promotion->id.$promotion->product_id;?>, obj<?php echo $promotion->id.$promotion->product_id;?>);
		</script>

</p>


			</li>
            <li class="list-productBg">
                <div class="list-product-L"><a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><img src="product/small/<?php echo $product->image;?>" alt="" width="200" class="shoppingCart-table-Pic02-border"/></a></div>
                <div class="list-product-R">
                    <a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><p class="list-product-R-tit"><?php echo $product->name;?></p>
                    <?php if($product->hot == 2 && $obj_user->type == 1){ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price;?>元  <span class="list-product-R-value02">原价：<?php echo $product->price_old;?>元</span></p></a>
                    <?php }else{ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price;?>元</p></a>
                    <?php } ?>
                    <br />
                	<a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="promotion(<?php echo $promotion->p_id;?>,<?php echo $product->product_id;?>);" value="立即抢购"/></a>
                	<!--<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="addFavor(<?php echo $product->product_id;?>);" value="加入收藏"/>-->
                </div>
            </li>
<?php } ?>

<?php
foreach($promotionList_next as $promotion2){
	$product = $pb->detail($db,$promotion2->product_id);
?>

			<li class="list-productBg02">
				<p class="lefttime">距离开始时间：

		<span id="day<?php echo $promotion->id.$promotion2->product_id;?>"></span>天<span id="hour<?php echo $promotion->id.$promotion2->product_id;?>"></span>小时<span id="mini<?php echo $promotion->id.$promotion2->product_id;?>"></span>分<span id="sec<?php echo $promotion->id.$promotion2->product_id;?>"></span>秒
		<script>
		var d<?php echo $promotion->id.$promotion->product_id;?> = Date.UTC(<?php echo date("Y",$promotion2->start_time);?>,<?php echo date("m",$promotion2->start_time);?>,<?php echo date("d",$promotion2->start_time);?>,10,00,59);
		var obj<?php echo $promotion->id.$promotion->product_id;?> = {
		sec: document.getElementById("sec<?php echo $promotion->id.$promotion2->product_id;?>"),
		mini: document.getElementById("mini<?php echo $promotion->id.$promotion2->product_id;?>"),
		hour: document.getElementById("hour<?php echo $promotion->id.$promotion2->product_id;?>"),
		day: document.getElementById("day<?php echo $promotion->id.$promotion2->product_id;?>")
		}
		fnTimeCountDown(d<?php echo $promotion->id.$promotion->product_id;?>, obj<?php echo $promotion->id.$promotion->product_id;?>);
		</script>

</p>


			</li>
            <li class="list-productBg">
                <div class="list-product-L"><img src="product/small/<?php echo $product->image;?>" alt="" width="171" class="shoppingCart-table-Pic02-border"/></div>
                <div class="list-product-R">
                    <a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><p class="list-product-R-tit"><?php echo $product->name;?></p>
                    <?php if($product->hot == 2 && $obj_user->type == 1){ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price;?>元  <span class="list-product-R-value02">原价：<?php echo $product->price_old;?>元</span></p></a>
                    <?php }else{ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price_old;?>元</p></a>
                    <?php } ?>
                    <br />
                	<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="promotion(<?php echo $promotion->p_id;?>,<?php echo $product->product_id;?>);" value="立即抢购"/>
                	<!--<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="addFavor(<?php echo $product->product_id;?>);" value="加入收藏"/>-->
                </div>
            </li>
<?php } ?>
        </ul>
    </div>
</div>
<?php include_once('common_footer.php');?>