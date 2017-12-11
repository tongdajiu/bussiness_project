<?php include_once('common_header.php');?>
	<style type="text/css">
		.hide{display:none;}
	</style>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="../res/js/jquery.lightbox_me.js"></script>
<script type="text/javascript" src="../res/js/swipe.min.js"></script>
<script type="text/javascript" src="../res/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="res/js/proAttr.js"></script>
<script type="text/javascript">


wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $app_info['appid']?>', // 必填，公众号的唯一标识
    timestamp: <?php echo $timestamp;?>, // 必填，生成签名的时间戳
    nonceStr: '<?php echo $noncestr;?>', // 必填，生成签名的随机串
    signature: '<?php echo $signature;?>',// 必填，签名，见附录1
    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});

wx.ready(function(){
	wx.onMenuShareTimeline({
    	title: '<?php echo $title;?>', // 分享标题
    	link: '<?php echo $site;?>product_detail.php?product_id=<?php echo $obj->product_id;?>&minfo=<?php echo $obj_user->minfo;?>', // 分享链接
    	imgUrl: '<?php echo $site;?>product/small/<?php echo $obj->image;?>', // 分享图标
	});

	wx.onMenuShareAppMessage({
    	title: '<?php echo $title;?>', // 分享标题
    	desc: '推荐给你【<?php echo $gSetting['site_name'];?>】', // 分享描述
    	link: '<?php echo $site;?>product_detail.php?product_id=<?php echo $obj->product_id;?>&minfo=<?php echo $obj_user->minfo;?>', // 分享链接
    	imgUrl: '<?php echo $site;?>product/small/<?php echo $obj->image;?>', // 分享图标
    	type: '', // 分享类型,music、video或link，不填默认为link
    	dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
	});
});
//选择购买方式
var skuWay = "cart";
function fn_skuWay(way){
	skuWay = way;
	$(".popup_sku").fadeIn(100,function(){
		maxProNum = <?php echo $obj->inventory;?>;		//商品库存
		//商品属性
		<?php if($attrList != null){ ?>
			 proAttrlist = <?php echo json_encode($arrMoney) ?>;
		<?php } ?>
		$(".popup_sku_main").addClass("active");
	});
}
//关闭sku
function skuClose(){
	$(".popup_sku_main").removeClass("active");
	setTimeout(function(){
		$(".popup_sku").fadeOut(100);
	},400);
}

//立即购买
function buy_now(product_id){
	if((!!attrCheck()) && ($(".sku-item").length>0)){
		alert(attrCheck());
		return false;
	}
	var pid = $("#standard").val();
	var shopping_number = 1;
	if(product_id == <?php echo $obj->product_id;?>){
		shopping_number = $("#buy_number<?php echo $obj->product_id;?>").val();
	}
	$.ajax({
		url:'cart.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id+'&standard='+myNowProAttr+"&shopping_number="+shopping_number+"&fastbuy=1",
		type:'POST',
		dataType: 'html',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			switch(result){
				case '-2':
					alert('添加到购物车失败！');
					break;
				case '-3':
					alert('该商品没有此属性！');
					break;
				case '-4':
					alert('库存不够,请减少数量！');
					break;
				default:
					location.href = '/order_address.php?cart_ids='+result;
					break;
			}
    	}
	});
}
//加入购物车
function addcart(product_id){
	if((!!attrCheck()) && ($(".sku-item").length>0)){
		alert(attrCheck());
		return false;
	}
	var pid = $("#standard").val();
	var shopping_number = 1;
	if(product_id == <?php echo $obj->product_id;?>){
		shopping_number = $("#buy_number<?php echo $obj->product_id;?>").val();
	}
	var url = 'cart.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id+'&standard='+myNowProAttr+"&shopping_number="+shopping_number;
	$.ajax({
		url:url,
		type:'POST',
//		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			switch(result){
				case '-1':
					alert('该商品已在购物车中！');
					break;
				case '-2':
					alert('添加到购物车失败！');
					break;
				case '-3':
					alert('该商品没有此属性！');
					break;
				case '-4':
					alert('该商品没有此属性！');
					break;
				case '-5':
					alert('非法操作');
					break;
				default:
					skuClose();
					$('#give_friend').lightbox_me({
						centered: true,
						onLoad: function () {
						}
					});
					break;
			}
    	}
	});
}
//sku确定
function sku_confirm(product_id){
	if(skuWay == "cart"){
		addcart(product_id)
	}else{
		buy_now(product_id)
	}
}

function minus(nid,qproduct){
	if(qproduct==3){
		alert("该商品只允许限购一个！");
	}else if(parseInt($("#buy_number"+nid).val()) > 1){
		$("#buy_number"+nid).val(parseInt($("#buy_number"+nid).val()) - 1);
		numChange(nid,qproduct);
	}
}

function plus(nid,qproduct){
	if(qproduct==3){
		alert("该商品只允许限购一个！");
	}else{
		if($("#buy_number"+nid).val() == maxProNum){
			return false;
		}
		$("#buy_number"+nid).val(parseInt($("#buy_number"+nid).val()) + 1);
		numChange(nid,qproduct);
	}
}

function numChange(nid,qproduct){
	if(parseInt($("#buy_number"+nid).val()) != $("#buy_number"+nid).val()){
		alert("商品数量需为正整数");
		$("#buy_number"+nid).val(1);
	}

	if(parseInt($("#buy_number"+nid).val()) > maxProNum){
		$("#buy_number"+nid).val(maxProNum);
	}else if(parseInt($("#buy_number"+nid).val()) <= 0){
		$("#buy_number"+nid).val(1);
	}


}

function hide_give_friend(){
	$("#give_friend").hide();
	$(".lb_overlay.js_lb_overlay").remove();
}

function addFavor(product_id){
        var pid = $("#standard").val();
        $("#change").html('<div style="width:100%;height:100%;background:url(<?php echo __IMG__;?>/ajax-loader-85.gif) no-repeat center center;background-size:30px auto;background-color:#f7f7f7;"></div>');
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
                    //alert('收藏成功');
                    $("#change").html("").attr({"href":"javascript:delFavor(<?php echo $obj->product_id;?>);","class":"fav_state2"});
                    $(".fav-tips").html('收藏成功').stop().fadeIn();
                    setTimeout(function(){
                    	$(".fav-tips").stop().fadeOut();
                    },1500);
                }
            }
        });
}

//收藏
function delFavor(product_id){
    var pid = $("#standard").val();
    $("#change").html('<div style="width:100%;height:100%;background:url(<?php echo __IMG__;?>/ajax-loader-85.gif) no-repeat center center;background-size:30px auto;background-color:#f7f7f7;"></div>');
    $.ajax({
        url:'favorites.php?act=del&userid=<?php echo $userid;?>&product_id='+product_id,
        type:'POST',
        //		dataType: 'string',
        error: function(){
            alert('请求超时，请重新删除');
        },
        success: function(result){
            var a = result.indexOf('<!DOCTYPE');
            if(a > 0){
                alert(result.substr(0,a));
            }else{
                //alert('取消成功');
                $("#change").html("").attr({"href":"javascript:addFavor(<?php echo $obj->product_id;?>);","class":"fav_state1"});
                $(".fav-tips").html('取消成功').stop().fadeIn();
                setTimeout(function(){
                	$(".fav-tips").stop().fadeOut();
                },1500);
            }
        }
    });
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

function showDIv(obj){
	document.getElementById(obj).style.display = "block";
}
function hideDiv(obj){
	document.getElementById(obj).style.display = "none";
}
</script>
<?php include_once('loading.php');?>
<?php include_once('top_btn_nav.php');?>
<a href="javascript:window.history.back(-1);" class="top_btn_back"></a>

<div class="view">
	<div id='mySwipe' class='swipe'>
		<div class='swipe-wrap'>
			<div><?php renderPic($obj->image, 'big', 1, array('w'=>60,'h'=>60));?></div>
			<?php foreach($imageList as $image){ ?>
			<div><?php renderPic($image->image, 'big', 3); ?></div>
			<?php } ?>
		</div>
        <ul class="swiperPager">
        	<li class="active"></li><?php foreach($imageList as $image){ ?><li></li><?php } ?>
        </ul>
	</div>

    <div class="list02-pic-txt">
    	<!-- <p class="list02-pic-txt_02"><?php echo $obj->title;?></p> -->
    	<div class="pro_title">
    		<p><?php echo $obj->name;?></p>
    		<a id="join-shop" href="javascript:;" title="加入小店" class="<?php if($isSell) echo 'hide';?>"></a>
			<a id="out-shop" href="javascript:;" title="已在小店" class="active <?php if(!$isSell) echo 'hide';?>"></a>
    	</div>

		<div class="sku-list">
			<dl class="proPrice" style="width:100%;">
				<dd class="sku-new-price" data-price="<?php echo $priceRange;?>" data-store="<?php echo $store;?>">
					<span style="font-size:18px;color:#f60;" id="conprice">￥<?php echo $priceRange;?></span>
					<?php if($pBargain['discount']){ ?><i class="pro_label" id="pdiscount"><?php echo $pBargain['discount'];?>折</i><?php } ?>
				</dd>
			</dl>
			<dl class="proPrice" style="clear:both;">
				<dt>市场价：</dt>
				<dd data-price="<?php echo number_format($obj->price_old,2);?>">
					<font style="font-size:12px;color:#999;text-decoration: line-through;">￥<span id="price_old_menber"><?php echo number_format($obj->price_old,2);?></span></font>
				</dd>
			</dl>
			<dl class="proPrice" style="text-align:right;">
				<dd style="font-size:14px;padding-right:5px;">库存 <?php echo $store;?></dd>
			</dl>
		</div>
    </div>

	<?php if(empty($attrList) && !empty($pBargain)){ ?>
	<div class="active_timeOut" id="con-retime">
		<span id="prtime"></span>，价格将恢复<?php echo $pBargain['oprice'];?>元
	</div>
	<?php } ?>

    <ul class="pro_rowItem">
 		<li class="pro_share"><a href="javascript:showDIv('bg2');"><div class="pro_rowItem_txt">分享到朋友圈</div></a></li>
        <li class="pro_code">
        	<?php if(VersionModel::isOpen('qrcodeGoodsUser')){?>
    			<a href="javascript:showDIv('bg');"><div class="pro_rowItem_txt">查看二维码</div></a>
    		<?php }?>
 		</li>
 	</ul>

	<div class="pro_tab">
		<div class="pro_tab_title">
			<a href="product_description.php?product_id=<?php echo $obj->product_id;?>">商品详情</a>
			<a href="comment_product.php?product_id=<?php echo $obj->product_id;?>">商品评价(<?php echo count($commentList);?>)</a>
		</div>
		<div class="pro_tab_ajaxMain"></div>
	</div>
	<script>
		var xhr;
		$(function(){
			$(".pro_tab_title a").click(function(){
				if(!!xhr){
					xhr.abort()
				}

				$(".pro_tab_title a").removeClass("active");
				$(this).addClass("active");
				var url = $(this).attr("href");
				$(".pro_tab_ajaxMain").html('<div class="pro_ajax_loading"><img src="../res/images/ajax-loader-85.gif" alt="加载中" /></div>');
				xhr = $.ajax({
					url: url,
					type: "GET",
					success: function(data){
						$(".pro_tab_ajaxMain").html("").append(data);
					}
				})
				return false;
			});
			$(".pro_tab_title a").eq(0).trigger("click");
		})
	</script>
	<?php include TEMPLATE_DIR.'/footer_web.php';?>

</div>

<div class="pro_bottom_bar">
	<div class="fav_btn">
		<?php if($rs == null){ ?>
	    <a href="javascript:addFavor(<?php echo $obj->product_id;?>);" id="change" title="加入收藏-" class="fav_state1"></a>
	    <?php }else{ ?>
	    <a href="javascript:delFavor(<?php echo $obj->product_id;?>);" id="change" title="取消收藏" class="fav_state2"></a>
	    <?php } ?>
	</div>

	<div class="outofstock" style="<?php if($obj->inventory == 0){?>display:block;<?php }else{ ?>display:none;<?php } ?>">
		缺货
	</div>

	<div class="hasstock" style="<?php if($obj->inventory == 0){?>display:none;<?php }else{ ?>display:block;<?php } ?>">
        <div class="hasstock_buy"><a href="javascript:fn_skuWay('buyNow')">立即购买</a></div>
        <div class="hasstock_car"><a href="javascript:fn_skuWay('cart')">加入购物车</a></div>
    </div>
</div>
<div class="popup_sku">
	<div class="popup_sku_bg" onclick="skuClose()"></div>
	<div class="popup_sku_main">
		<div class="sku_pro_info">
			<?php renderPic($obj->image, 'big', 1, array('w'=>60,'h'=>60));?>
			<div>
				<p><?php echo $obj->name;?></p>
				<font style="color:#f60;">￥<span id="price_new" style="font-size:18px;color:#f60;"><?php echo $priceRange;?></span></font>
	            <span class="hidden" style="text-decoration:line-through;color:#999;">￥<font id="pro_oprice"></font></span>
	            <i id="pro_discount" class="hidden"></i>
			</div>
			<a class="sku_close" title="关闭" href="javascript:skuClose();"></a>
		</div>
		<div id="active_timeOut" class="active_timeOut hidden"></div>
		<div class="sku_items">
			<?php if ( $attrList != null ){ ?>
				<?php foreach($attr_names as $key=>$attr_name){ ?>
					<dl class="proSku sku-item">
						<dt data-id="<?php echo $key;?>"><?php echo $attr_name;?>：</dt>
						<dd>
							<ul class="property_select">
							<?php foreach($attr_values[$key] as $aid=>$attr_value){?>
								<li data-aid="<?php echo $aid;?>"><?php echo $attr_value;?></li>
							<?php }?>
							</ul>
							<input type="hidden" name="" />
						</dd>
					</dl>
				<?php  } ?>
			<?php  } ?>

			<dl class="proSku proSku_quantity">
				<dt>数量：</dt>
				<dd>
					<div class="quantity">
						<a class="quantity_minus" href="javascript:minus(<?php echo $obj->product_id;?>,<?php echo $obj->hot;?>);">-</a>
						<input class="quantity_txt" id="buy_number<?php echo $obj->product_id;?>" class="shoppingCart-table-R-number" value="1" onChange="numChange(<?php echo $obj->product_id;?>,<?php echo $obj->hot;?>);" />
						<a class="quantity_plus" href="javascript:plus(<?php echo $obj->product_id;?>,<?php echo $obj->hot;?>);">+</a>
					</div>
				</dd>
				<dd class="proSku_stock">库存：<font id="store_menber"><?php echo $store;?></font></dd>
			</dl>

			<div class="sku_buy">
				<a href="javascript:;" style="display:none;">确认</a>
				<a href="javascript:sku_confirm(<?php echo $obj->product_id;?>);" class="canChoose">确认</a>
			</div>
		</div>
	</div>
</div>
<div style="height:41px;"></div>



<div id="bg" onclick="hideDiv('bg');" style="background-image:url(../res/images/ajax-loader-85.gif);background-position:center 40%;background-repeat:no-repeat;background-size:10% auto;">
	<img src="showQrcode.php?act=product&product_id=<?php echo $obj->product_id;?>" alt="" style="display:block;width:60%;margin:40% auto 0;">
</div><!--二维码-->

<div id="bg2" onclick="hideDiv('bg2');" style="display: none;">
	<img src="res/images/guide_firend.png" alt="" style="position:fixed;top:0;right:16px;">
</div><!--分享-->

<div class="fav-tips"></div><!--收藏提示-->

<div id="give_friend">
	<div class="give_friend_tips">
		<span>已成功添加至购物车</span>
	</div>
	<div class="give_friend_btn">
		<a href="javascript:hide_give_friend()" class="give_friend_btn1">再逛逛</a>
		<a href="cart.php" class="give_friend_btn2">去结算</a>
	</div>
</div><!--添加购物车提示-->

<script>
	$(document).ready(function(){
		//焦点图
	    var elem = document.getElementById('mySwipe');
	    window.mySwipe = Swipe(elem, {
	        startSlide: 0,
	        auto: 3000,
	        continuous: false,
	        disableScroll: false,
	        stopPropagation: true,
	        callback: function (index, element) {},
	        transitionEnd: function (index, element) {
	        	$(".swiperPager li").removeClass("active").eq(mySwipe.getPos()).addClass("active");
	        }
	    });

	    //没有规格时隐藏
		var skuNum = <?php echo count($attrList) ?>;
		if(skuNum == 1 && $(".list02-standardButton").val()==""){
			$(".list02-standardButton").parents("dl.list02-pic-txt_03").hide();
		}

		$("#join-shop").on("click", function(){
			<?php if($isAgent){ ?>shopOP(true);<?php }else{ ?>alert("分销商才能添加商品");<?php } ?>
		});
		$("#out-shop").on("click", function(){
			shopOP(false);
		});

		<?php if(empty($attrList) && !empty($pBargain)){ ?>
		timeCounter(<?php echo $pBargain['rtime'];?>);
		<?php } ?>
	});

	function shopOP(join){
		var url = "/product_detail.php?act=";
		url += join ? "shop" : "unshop";
		var data = {"id":<?php echo $obj->product_id;?>};
		$.post(url , data, function(r){
			if(r.state == 1){
				if(join){//添加
					$("#join-shop").hide();
					$("#out-shop").show();
				}else{//删除
					$("#join-shop").show();
					$("#out-shop").hide();
				}
			}else{
				alert(r.msg);
			}
		}, "json");
	}

	function timeCounter(time){
		if(time == 0){
			$("#conprice").html("￥<?php echo $pBargain['oprice'];?>");
			$("#pdiscount").hide();
			$("#con-retime").hide();
		}else{
			var pdrTime = time;
			var pdrDay = Math.floor(pdrTime/86400);//天数
			pdrTime = pdrTime%86400;
			var pdrHour = Math.floor(pdrTime/3600);//时
			pdrTime = pdrTime%3600;
			var pdrMinute = Math.floor(pdrTime/60);//分
			var pdrSecond = parseInt(pdrTime%60);//秒
			$("#prtime").html("剩<span>"+pdrDay+"</span>天<span>"+pdrHour+"</span>小时<span>"+pdrMinute+"</span>分<span>"+pdrSecond+"</span>秒");
			time--;
			setTimeout(function(){timeCounter(time)}, 1000);
		}
	}
</script>
<?php include_once('common_footer.php');?>