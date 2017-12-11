<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=100%;
    initial-scale=0.5;
    maximum-scale=0.5;
    minimum-scale=0.5;
    user-scalable=no;" />

<title>茶园优品</title>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<link href="css/index2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script src="js/jquery.touchslider.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
		WeixinJSBridge.call('hideToolbar');
	});

(function(){

 var onBridgeReady = function () {
    var appId = '',
    imgUrl = 'http://cha.gdbwt.com/product/small/<?php echo $obj->image;?>';
    link = "http://cha.gdbwt.com/product_detail.php?product_id=<?php echo $obj->product_id;?>",
    title = "茶园优品产品推荐：<?php echo $obj->name;?>",
    desc = '这是一条测试数据';
    // 发送给好友;
    WeixinJSBridge.on('menu:share:appmessage', function(argv){
     WeixinJSBridge.invoke('sendAppMessage',{
         "appid" : appId,
         "img_url" : imgUrl,
         "img_width" : "640",
         "img_height" : "640",
         "link" : link,
         "desc" : desc,
         "title" : title
     }, function(res) {
        if(res.err_msg=='send_app_msg:confirm' || res.err_msg=='send_app_msg:ok') {
        	share_integral()
         }
        });
     });
    // 分享到朋友圈;
    WeixinJSBridge.on('menu:share:timeline', function(argv){
     WeixinJSBridge.invoke('shareTimeline',{
         "img_url" : imgUrl,
         "img_width" : "640",
         "img_height" : "640",
         "link" : link,
         "desc" : desc,
         "title" : title
         }, function(res) {
            if(res.err_msg=='share_timeline:ok' || res.err_msg=='share_timeline:confirm') {
            	share_integral()
            }
         });
     });
    // 分享到微博;
 };
 if(document.addEventListener){
     document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
 } else if(document.attachEvent){
     document.attachEvent('WeixinJSBridgeReady' , onBridgeReady);
     document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
 }
})();

function buy_now(product_id){
	var pid = $("#standard").val();
	$.ajax({
		url:'cart.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id+'&price_id='+pid,
		type:'POST',
		dataType: 'html',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			location.href = 'cart.php';
    	}
	});
}

function addcart(product_id){
	var pid = $("#standard").val();
	$.ajax({
		url:'cart.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id+'&price_id='+pid,
		type:'POST',
//		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
    		var a = result.indexOf('<!DOCTYPE');
    		if(a > 0){
    			alert(result.substr(0,a));
    		}else{
    			alert('添加成功');
    		}
    	}
	});
}
function addFavor(product_id){
	var pid = $("#standard").val();
	$.ajax({
	url:'favorites.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
//		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
    		var a = result.indexOf('<!DOCTYPE');
    		if(a > 0){
    			alert(result.substr(0,a));
    		}else{
    			alert('添加成功');
    		}
    	}
	});
}

function change_price(pid,price,price_old){
	$("input[name='price']").each(function(){
		$(this).attr("style","background-color:#fff;");
	});
	$("#price"+pid).attr("style","background-color:#da812d;");
	$("#price_old").html(price_old.toFixed(2));
	$("#price_old_menber").html(price_old.toFixed(2));
	$("#price_menber").html(price);
	$("#standard").val(pid);
}

function share_integral(){
	$.ajax({
		url:'product_detail.php?act=share&userid=<?php echo $userid;?>&product_id=<?php echo $obj->product_id;?>&order_id=<?php echo $order_id;?>',
		type:'POST',
//		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){}
	});
}

function showDIv(){
	document.getElementById('bg').style.display = "block";
}
function hideDiv(){
	document.getElementById('bg').style.display = "none";
}
function showFriendDIv(){
	document.getElementById('bg2').style.display = "block";
}
function hideFriendDIv(){
	document.getElementById('bg2').style.display = "none";
}
</script>
<style type="text/css">
.demo-in-in { width: 620px; margin: 0 auto;}
#bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%; height: 100%;  background:url(images/guide_bg.png);
            z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}
</style>
</head>

<body>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="back"></a>
    <a href="user.php" class="member-nav-R2"></a>
</div>
<section class="demo">
<div class="demo-in">
<div class="demo-in-in">
	<div class="touchslider touchslider-demo">
		<div class="touchslider-viewport" style="width: 620px; height: 620px;overflow: hidden; position: relative; ">
			<div style="width: 100000px; position: absolute; left: 0px; height: 620px;">
				<div class="touchslider-item" style="position: absolute; left: 0px;">
					<img src="product/large/<?php echo $obj->image;?>" width="620px" height="620px" alt="">
				</div>
<?php foreach($imageList as $image){ ?>
				<div class="touchslider-item" style="position: absolute; left: 0px;">
					<img src="upfiles/<?php echo $image->image;?>" width="620px" height="620px" style="overflow:hidden;" alt="">
				</div>
<?php } ?>
			</div>
		</div>
		<div class="touchslider-nav">
			<a class="touchslider-nav-item touchslider-nav-item-current"></a>
<?php for($j=0;$j<count($imageList);$j++){ ?>
			<a class="touchslider-nav-item"></a>
<?php } ?>
		</div>
	</div>
</div>
</div>
</section>
<script>
	$(".touchslider-demo").touchSlider({mouseTouch: true});
</script>
<div class="index-wrapper">
	<!--<div class="index-wrapper">
		<div class="list02-pic"><img src="product/large/<?php echo $obj->image;?>" alt="" width="70%"/>
	</div>
	-->
    <div class="list02-pic-txt">

    	<input type="hidden" id="standard" value="" />
    	<p class="list02-pic-txt_01"><?php echo $obj->name;?><span class="list02-pic-look" style="line-height:25px;">已售（<?php echo $obj->sell_number;?>)</span></p></p>
    	<!--布局问题-->
    	<td style="font-size: 20px;"><?php echo $obj->title;?></td>
    	<?php if($obj->hot == 2 && $obj_user->type == 1){ ?>
    	<p class="list02-pic-txt_02">价格：<span id="price_menber"><?php echo number_format($obj->price,2);?></span>元<span class="list02-pic-value">原价：<span id="price_old_menber"><?php echo number_format($obj->price_old,2);?></span>元</span>
    	<?php }else{ ?>

    	<p class="list02-pic-txt_02">价格：<span id="price_old"><?php echo number_format($obj->price_old,2);?></span>元
    	<?php } ?>
    	<span class="list02-pic-look">浏览（<?php echo $obj->viewed;?>)</span></p>
    	<p class="list02-pic-txt_03">规格：
			<?php foreach($priceList as $price){ ?>
				<input id="price<?php echo $price->id;?>" name="price" type="submit" value="<?php echo $price->standard;?>" class="list02-standardButton" onclick="change_price(<?php echo $price->id;?>,<?php echo $price->price;?>,<?php echo $price->price_old;?>);" <?php if($obj->standard == $price->standard){echo "style=\"background-color:#da812d;\"";} ?> />
			<?php } ?>

		</p>
    </div>

    <ul class="listview3 bg_white product_share mb10">
        <li><a href="product_description.php?product_id=<?php echo $obj->product_id;?>" rel="external"><p><span style="float: right;padding-right:35px; font-size:25px; color:#F00">建议wifi下使用</span>商品详情</p></a></li>
        <li><a href="comment_product.php?product_id=<?php echo $obj->product_id;?>" rel="external"><p><span style="color:#000;">商品评价(<?php echo count($commentList);?>)</span></p></a></li>
 		<li style="background:none !important;">
 			<div class="list02-pic-intro-line">
 			<!--<input id="list02-pic-intro-line01" name="" type="submit" class="list02-pic-intro-line01-txt "  onclick="addFavor(28);" value="加入收藏">-->
        		<div class="list02-pic-intro-line01"><a href="javascript:addFavor(<?php echo $obj->product_id;?>);"><div class="list02-pic-intro-line01-txt" >加入收藏</div></a></div>
            	<div class="list02-pic-intro-line02"><a href="javascript:showFriendDIv();"><div class="list02-pic-intro-line02-txt">分享到朋友圈</div></a></div>
        	</div>
 		</li>
 	</ul>
    <h3>&nbsp;&nbsp;更多热销产品：</h3>
    <div class="list-product">
        <ul>
<?php foreach($similar_products as $product){

	?>
            <li class="list-productBg">
                <div class="list-product-L"><img src="product/small/<?php echo $product->image;?>" alt="" width="160" height="110" class="shoppingCart-table-Pic02-border"/></div>
                <div class="list-product-R">
                    <a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><p class="list-product-R-tit"><?php echo $product->name;?></p>
                    <?php if($product->hot == 2 && $obj_user->type == 1){ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price;?>元  <span class="list-product-R-value02">原价：<?php echo $product->price_old;?>元</span></p></a>
                    <?php }else{ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price_old;?>元</p></a>
                    <?php } ?>
                    <br />
                	<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button"  <?php if($obj->inventory == 0){echo "disabled='disabled'" ;}  ?>
                	onclick="addcart(<?php echo $product->product_id;?>);" <?php if($obj->inventory == 0){ ?>style="background-color:#ababab" value="缺货"<?php } else{?>value="加入购物车"<?php }?>/>
                	<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="addFavor(<?php echo $product->product_id;?>);" value="加入收藏"/>
                </div>
            </li>
<?php } ?>
        </ul>
    </div>

    <div class="list02-pic-button">
    	<div class="list02-pic-button_01" <?php if($obj->inventory == 0){?>style="background-color:#ababab"<?php }?>><a <?php if($obj->inventory == 0){?>href="#"<?php } else{?>href="javascript:buy_now(<?php echo $obj->product_id;?>);"<?php }?>><div class="list02-pic-button_01-txt" <?php if($obj->inventory == 0){?>style="background:no-repeat left center;"<?php }?>><?php if($obj->inventory == 0){echo "缺货";}else {echo "立即购买";}?></div></a></div>
        <div class="list02-pic-button_02"><?php if($obj->inventory == 0){?><a href="#"><?php }else{?><a href="javascript:addcart(<?php echo $obj->product_id;?>);"><?php }?><div class="list02-pic-button_02-txt">加入购物车</div></a></div>
        <div class="list02-pic-button_03"><a href="cart.php"><img src="images/list02_12.png" alt="" width="65" height="80" /></a></div>
    </div>
</div>
<div class="index-foot">
	<div class="index-foot-nav"><a href="index.php">商城首页</a>
	<span class="index-foot-nav-line">|</span><a href="list_art.php?id=2">联系我们</a>
	<span class="index-foot-nav-line">|</span><a href="user.php">会员中心</a>
    <div class="index-foot-logo"></div>
    </div>
</div>
<div id="bg" onclick="hideDiv();">
	<img src="images/guide.png" alt="" style="position:fixed;top:0;right:16px;">
</div>
<div id="bg2" onclick="hideFriendDIv();" style="display: none;">
	<img src="images/guide_firend.png" alt="" style="position:fixed;top:0;right:16px;">
</div>
</body>
</html>
