<?php include_once('common_header.php');?>
<script type="text/javascript">
$(function() {
    var loaded = false;
    var index = 0;
    var cmu = 2;
    var fmu = 1;
    var page = 1;
    function show() {
    	var wHeight = parseInt($(window).height());
    	var dHeight = parseInt($(document).height());
    	var tScroll = parseInt($(document).scrollTop());
        if (!loaded && (tScroll >= dHeight-wHeight) && <?php echo ($productList['PageCount'] - 1);?> > 0) {
            $("#progressIndicator").show();
            index++;
            cmu++;
            fmu++;
            page++;
            if (index >= <?php echo ($productList['PageCount'] - 1);?>) loaded = true;
            $.get("ajaxtpl/ajax_integral_product.php?page="+page,
            function(data) {
            	console.log(data)
                $(".proList ul").append(data);
                $("#progressIndicator").hide()
            })
        }
    };
    $(window).scroll(show);
});
</script>

<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">积分商品</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="proList">
	<?php if(count($productList['DataSet']) == 0){ ?>
	<div class="tips-null">暂无商品！</div>
	<?php }else{ ?>
	<ul class="clearfix">
		<?php foreach($productList['DataSet'] as $product){ ?>
    	<li>
	    	<a href="integral_product_detail.php?product_id=<?php echo $product->id;?>">
	            <div class="proList-img">
					<?php renderPic($product->image, 'small', 5, array(), array('cls'=>'product_02-Pic-color02'));?>
	            </div>
	            <p class="proList-title"><?php if(mb_strlen($product->name,'utf-8')>18){ echo mb_substr($product->name,0,18,'utf-8'),'...';}else{ echo $product->name;};?></p>
	            <div class="proList-info">
	                <span class="proList-price">积分:<?php echo $product->integral;?></span>
	            </div>
	        </a>
    	</li>
		<?php } ?>
    </ul>
	<div id="progressIndicator">
		<img width="85" height="85" src="res/images/ajax-loader-85.gif" alt=""> <span id="scrollStats"></span>
	</div>
	<?php } ?>
</div>

<?php include_once('common_footer.php');?>
<?php include_once('footer_menu_web_new.php');?>
