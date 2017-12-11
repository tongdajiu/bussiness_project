<?php include_once('common_header.php');?>
<script type="text/javascript" src="../res/js/jweixin-1.0.0.js"></script>
<script language="javascript">
wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $wxJsSign['appId']?>', // 必填，公众号的唯一标识
    timestamp: '<?php echo $wxJsSign['timestamp'];?>', // 必填，生成签名的时间戳
    nonceStr: '<?php echo $wxJsSign['nonceStr'];?>', // 必填，生成签名的随机串
    signature: '<?php echo $wxJsSign['signature'];?>',// 必填，签名，见附录1
    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','scanQRCode'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});
wx.ready(function(){
    wx.onMenuShareTimeline({
        title: '<?php echo $gSetting['site_name'];?>', // 分享标题
        link: '<?php echo $site;?>shop.php?minfo=<?php echo $user->minfo;?>', // 分享链接
        imgUrl: '<?php echo __IMG__;?>/logo.jpg', // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
            $.post('index.php?act=records&type=1');
        }
    });

    wx.onMenuShareAppMessage({
        title: '<?php echo $gSetting['site_name'];?>', // 分享标题
        desc: '【<?php echo $gSetting['site_name'];?>】推荐给你', // 分享描述
        link: '<?php echo $site;?>shop.php?minfo=<?php echo $user->minfo;?>', // 分享链接
        imgUrl: '<?php echo __IMG__;?>/logo.jpg', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () {
            // 用户确认分享后执行的回调函数
            $.post('index.php?act=records&type=1');
        }
    });
});

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
            $.get("ajaxtpl/ajax_shop.php?o<?php if($sell){echo '&sell';}if($cnum){echo '&cnum';}if($m == 'up'){echo '&m=up';} if($m == 'down'){echo '&m=down';}?>&page="+page,
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
    
    <!-- <a href="javascript:window.history.back(-1);" class="top_btn_back"></a> -->

	<div class="header_bg"></div>
    <ul class="shop_header">
        <li class="shop_header_logo">
            <div class="shop_header_logo_img"><?php renderPic($shop_info->icon, $sizetype='small', $type='logo', $size=array(), $info=array(), $echo=true) ?></div>
            <span><?php echo $shopName;?></span>
        </li>
        <li><a href="product.php">
            <p><?php echo $productCount;?></p>
            全部商品
        </a></li>
        <li><a href="product.php?t=new">
            <p><?php echo $newPCount;?></p>
            新上商品
        </a></li>
        <li><a href="user.php">
            <p class="shop_header_member"></p>
            会员中心
        </a></li>
    </ul>
    <div class="clear"></div>
	<!-- <div class="shop-sort">
		<a href="shop.php?sell">销量</a>
		<?php if($m == '' || $m == 'down'){ ?>
		<a href="shop.php?m=up">
		<?php }else{ ?>
		<a href="shop.php?m=down">
		<?php } ?>价格<img class="sort-icon" src="../res/images/price-jt.png" /></a>
		<a href="shop.php?cnum">评论数</a>
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
                    <!-- <p class="proList-sell"><span>评价(<?php echo $row->comment_num;?>)</span>
                    <span>已售(<?php echo $row->sell_number;?>)</span></p> -->
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
<?php include_once('footer_menu_web_new.php');?>