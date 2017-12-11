<?php include_once('common_header.php');?>
<script>
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

        if (!loaded && (tScroll >= dHeight-wHeight) && <?php echo ($pager['PageCount'] - 1);?> > 0) {
            $("#progressIndicator").show();
            index++;
            cmu++;
            fmu++;
            page++;
            if (index >= <?php echo ($pager['PageCount'] - 1);?>) loaded = true;

            $.get("ajaxtpl/ajax_shop_product.php?myself<?php if($name != ''){echo '&name='.$name;} if($sell){echo '&sell';}if($cnum){echo '&cnum';}if($m == 'up'){echo '&m=up';} if($m == 'down'){echo '&m=down';}?>&page="+page,
            function(data) {
            	$(".proList").append(data);
                $("#progressIndicator").hide()
            })
        }
    };
    $(window).scroll(show);
});
</script>

<?php include_once('loading.php');?>
<div class="top_nav top_nav_2">
	<div class="shop_product_search">
    	<form action="shop_product.php" method="get">
			<input type="hidden" name="myself" value="true"/>
    		<input type="search" placeholder="请输入关键字" name="name" value="<?php echo $name;?>" />
    	</form>
    </div>
	<a class="top_nav_left top_nav_back_white" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="shop-sort">
	<a href="shop_product.php?myself&sell<?php if($name != ''){echo '&name='.$name;} ?>">销量</a>
	<?php if($m == '' || $m == 'down'){ ?>
	<a href="shop_product.php?myself&m=up<?php if($name != ''){echo '&name='.$name;} ?>">
	<?php }else{ ?>
	<a href="shop_product.php?myself&m=down<?php if($name != ''){echo '&name='.$name;} ?>">
	<?php } ?>价格<img class="sort-icon" src="../res/images/price-jt.png" /></a>
	<a href="shop_product.php?myself&cnum<?php if($name != ''){echo '&name='.$name;} ?>">评论数</a>
</div>
<div class="proList">
    <ul class="clearfix">

		<?php if($pager['DataSet'] != null){
			foreach($pager['DataSet'] as $row){
		?>
    	<li>
    		<a href="product_detail.php?product_id=<?php echo $row->product_id;?>">
            <div class="proList-img"><?php renderPic($row->image, $sizetype='small', $type='product', $size=array(), $info=array(), $echo=true) ?></div>
            <p class="proList-title"><?php echo $row->name;?></p>
            <div class="proList-info">
                <span class="proList-price">￥<?php echo $row->price;?></span>
                <p class="proList-sell"><span>评价(<?php echo $row->comment_num;?>)</span>
                <span>已售(<?php echo $row->sell_number;?>)</span></p>
                <a href="shop_product.php?myself&act=post&pid=<?php echo $row->product_id;?><?php if($name != ''){echo '&name='.$name;}?>" class="proList-add">添加</a>
            </div>
            </a>
        </li>
		<?php } } ?>
    </ul>
</div>
<div id="comments"></div>
<div class="clearfix"></div>
<div id="progressIndicator">
	<img width="85" height="85" src="res/images/ajax-loader-85.gif" alt=""> <span id="scrollStats"></span>
</div>
<?php include_once('footer_web.php');?>
<?php include_once('common_footer.php');?>