<?php include_once('common_header.php');?>
<script type="text/javascript" src="../res/js/jweixin-1.0.0.js"></script>
<script language="javascript">
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
            $.get("ajaxtpl/ajax_shop_edit.php?<?php if($myself){echo 'myself';}else{echo 'o';} if($sell){echo '&sell';}if($cnum){echo '&cnum';}if($m == 'up'){echo '&m=up';} if($m == 'down'){echo '&m=down';}?>&page="+page,
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
	<div class="top_btn_nav">
		<a href="shop_product.php?myself" class="top_btn_add"></a>
		<?php if($myself){?>
		<a href="shop_edit.php?myself&act=edit" class="top_btn_edit"></a>
		<?php }?>
		<a href="javascript:window.history.back(-1);" class="top_btn_back"></a>
	</div>

	<!-- <div class="header_bg">
		<div class="img_radius"><?php renderPic($shop_info->icon, $sizetype='small', $type='logo', $size=array(), $info=array(), $echo=true) ?></div>
		<p style="color:#666;text-align:center;"><?php echo empty($shop_info->name) ? '我的店铺' : $shop_info->name;?></p>
	</div> -->
    <div class="header_bg"></div>
    <ul class="shop_header">
        <li class="shop_header_logo">
            <div class="shop_header_logo_img"><?php renderPic($shop_info->icon, $sizetype='small', $type='logo', $size=array(), $info=array(), $echo=true) ?></div>
            <span><?php echo empty($shop_info->name) ? '我的店铺' : $shop_info->name;?></span>
        </li>
        <li><a href="#">
            <p>3</p>
            全部商品
        </a></li>
        <li><a href="#">
            <p>0</p>
            新上商品
        </a></li>
        <li><a href="#">
            <p class="shop_header_member"></p>
            会员中心
        </a></li>
    </ul>
	<!-- <div class="shop-sort">
		<a href="shop_edit.php?sell<?php if($myself){ echo '&myself'; } ?>">销量</a>
		<?php if($m == '' || $m == 'down'){ ?>
		<a href="shop_edit.php?m=up<?php if($myself){ echo '&myself'; } ?>">
		<?php }else{ ?>
		<a href="shop_edit.php?m=down<?php if($myself){ echo '&myself'; } ?>">
		<?php } ?>价格<img class="sort-icon" src="../res/images/price-jt.png" /></a>
		<a href="shop_edit.php?cnum<?php if($myself){ echo '&myself'; } ?>">评论数</a>
	</div> -->
	<div class="proList">
        <ul class="clearfix">

        	<?php if($pager['DataSet'] != null){
				foreach($pager['DataSet'] as $row){
			?>
        	<li>
        		<a href="product_detail.php?product_id=<?php echo $row->product_id;?>">
                <div class="proList-img"><?php renderPic($row->image, 'big', 'product') ?></div>
                <p class="proList-title"><?php echo $row->name;?></p>
                <div class="proList-info">
                    <span class="proList-price">￥<?php echo $row->price;?></span>
                    <p class="proList-sell"><span>评价(<?php echo $row->comment_num;?>)</span>
                    <span>已售(<?php echo $row->sell_number;?>)</span></p>
                    <?php if($myself){?>
                    <a href="shop_product.php?myself&act=del&id=<?php echo $row->id;?>" class="proList-remove">删除</a>
                	<?php } ?>
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