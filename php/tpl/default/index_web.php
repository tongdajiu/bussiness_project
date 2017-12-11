<?php include_once('common_header.php');?>

<style>
	.bg_warp{  margin:0 auto; width:100%; max-width: 640px; background: #000; }
	.bg_warp img{ float:left; cursor:pointer; }
	.coupon img:nth-child(1){  width:31.25%; }
	.coupon img:nth-child(2),.coupon img:nth-child(3){  width:34.375%; }	
	.goods img{ width: 50%;  } 
</style>

<script type="text/javascript" src="<?php echo __JS__;?>/swipe.min.js"></script>
<script type="text/javascript" src="<?php echo __JS__;?>/event.js"></script>
<script type="text/javascript" src="<?php echo __JS__;?>/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo __JS__;?>/tween.js"></script>
<script type="text/javascript">
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
    	link: '<?php echo $site;?>', // 分享链接
    	imgUrl: '<?php echo __IMG__;?>/logo.jpg', // 分享图标
    	success: function () {
	        // 用户确认分享后执行的回调函数
			$.post('index.php?act=records&type=1');
	    }
	});

	wx.onMenuShareAppMessage({
    	title: '<?php echo $gSetting['site_name'];?>', // 分享标题
    	desc: '【<?php echo $gSetting['site_name'];?>】推荐给你', // 分享描述
    	link: '<?php echo $site;?>', // 分享链接
    	imgUrl: '<?php echo __IMG__;?>/logo.jpg', // 分享图标
    	type: '', // 分享类型,music、video或link，不填默认为link
    	dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    	success: function () {
	        // 用户确认分享后执行的回调函数
			$.post('index.php?act=records&type=1');
	    }
	});
});

//调用微信二维码扫描接口
function scanQrcode(){
	wx.scanQRCode({
		needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
		scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
		success: function (res) {
			var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
		}
	});
}


$(function(){
	$('.coupon>img').click(function(){
		var coupon_type = $(this).attr('data-val');
		$.ajax({
            type: "post",
            url: "/coupon.php?act=add&type=" + coupon_type,
            dataType: "json",
            success: function(data){
        		alert(data.msg);
            }
         });
		
	})
})

</script>
	<?php include_once('loading.php');?>
	<?php include_once('top_btn_nav.php');?>
	<div class="view">
		<div class='bg_warp'>
			<?php for( $i=1; $i<=5; $i++){ ?>
				<img src='<?php echo HOME_IMG ?>0<?php echo $i; ?>.png' />
			<?php } ?>

			<div class='coupon'>
				<img src='<?php echo HOME_IMG ?>06.png' data-val='2' />
				<img src='<?php echo HOME_IMG ?>07.png' data-val='3' />
				<img src='<?php echo HOME_IMG ?>08.png' data-val='4' />
			</div>

			<a href="/product_detail.php?product_id=1">
					<img src='<?php echo HOME_IMG ?>10.png' />
					<img src='<?php echo HOME_IMG ?>11.png' />
			</a>	

			<a href="/product_detail.php?product_id=5">
				<img src='<?php echo HOME_IMG ?>12.png' />
				<img src='<?php echo HOME_IMG ?>13.png' />
			</a>

			<a href="/product_detail.php?product_id=3">
				<img src='<?php echo HOME_IMG ?>14.png' />
				<img src='<?php echo HOME_IMG ?>15.png' />
			</a>

			<a href="/product_detail.php?product_id=4">
				<img src='<?php echo HOME_IMG ?>16.png' />
				<img src='<?php echo HOME_IMG ?>17.png' />
			</a>

			<a href="/product_detail.php?product_id=2">
				<img src='<?php echo HOME_IMG ?>18.png' />
				<img src='<?php echo HOME_IMG ?>19.png' />
			</a>

			<img src='<?php echo HOME_IMG ?>20.png' />

			<div class="goods">
				<a href="/product_detail.php?product_id=6">
					<img src='<?php echo HOME_IMG ?>21.png' />
				</a>
				
				<a href="/product_detail.php?product_id=7">
					<img src='<?php echo HOME_IMG ?>22.png' />
				</a>
			</div>

			<img src='<?php echo HOME_IMG ?>23.png' />

		</div>


		<?php include_once('footer_web.php');?>

	</div>
	<?php include_once('footer_menu_web_new.php');?>

<?php include_once('common_footer.php');?>
