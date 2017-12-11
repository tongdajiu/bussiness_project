<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="../res/js/jquery.lightbox_me.js"></script>
<script type="text/javascript" src="../res/js/swipe.min.js"></script>
<script type="test/javascript" src="res/js/jquery.1.10.2.min.js"></script>
<?php include_once('loading.php');?>

<a href="javascript:window.history.back(-1);" class="top_btn_back"></a>

<div class="view">
	<div id='mySwipe' class='swipe'>
		<div class='swipe-wrap'>
			<div><?php renderPic($obj->image, 'big', 5, array('w'=>60,'h'=>60));?></div>
		</div>
	</div>
    <div class="list02-pic-txt">
    	<div class="pro_title">
    		<p><?php echo $obj->name;?></p>
    	</div>   	
    	<!-- <p class="list02-pic-txt_01"><?php echo $obj->name;?></p> -->
		<div class="sku-list">
			<dl class="list02-pic-txt_03">
				<dl class="proPrice" style="width:100%;">
				<dt>兑换价：</dt>
				<dd class="sku-price">
                	<font style="color:#f00;"><span id="price_menber"><?php echo $obj->integral;?></span></font>&nbsp;&nbsp;积分
				</dd>
			</dl>
			<dl class="list02-pic-txt_03" >
				<dl class="proPrice" style="width:100%;">
				<dt>库存：</dt>
				<dd class="sku-price">
                	<span id="store_menber"><?php echo $obj->inventory;?></span>
				</dd>
			</dl>
		</div>
    </div>

    <div class="pro_tab">
		<div class="pro_tab_title pro_tab_integral">
			<a href="integral_product_description.php?product_id=<?php echo $obj->id;?>">商品详情</a>
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
	<?php include "tpl/footer_web.php"; ?>
</div>


<div class="pro_bottom_bar">
    <div class="hasstock_buy" style="width:100%;" >
		<?php if($obj->inventory < 1){ ?>
			<a href="javascript:;" style="background-color:#ababab">缺货</a>
		<?php }elseif($user_obj->integral < $obj->integral){ ?>
			<a href="javascript:;" style="background-color:#ababab">积分不足</a>
		<?php }else{ ?>
	        <a href="integral_address.php?product_id=<?php echo $obj->id;?>">立即购买</a>
	    <?php } ?>
    </div>
</div>
<div style="height:41px;"></div>

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
	        transitionEnd: function (index, element) {}
	    });
	});
</script>
<?php include_once('common_footer.php');?>




