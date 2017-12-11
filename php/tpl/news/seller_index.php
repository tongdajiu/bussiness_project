<?php include_once('common_header.php');?>
<link href="../res/css/skinStyle.css" rel="stylesheet" type="text/css" />
<link href="../res/css/index3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../res/js/event.js"></script>
<script type="text/javascript" src="../res/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="../res/js/tween.js"></script>
<script src="../res/js/jquery.touchslider.js"></script>
<script type="text/javascript">
wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $app_info['appid']?>', // 必填，公众号的唯一标识
    timestamp: <?php echo $timestamp;?>, // 必填，生成签名的时间戳
    nonceStr: '<?php echo $noncestr;?>', // 必填，生成签名的随机串
    signature: '<?php echo $signature;?>',// 必填，签名，见附录1
    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','scanQRCode'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});
wx.ready(function(){
	wx.onMenuShareTimeline({
    	title: '<?php echo $title;?>', // 分享标题
    	link: '<?php echo $site;?>index.php?minfo=<?php echo $obj_user->minfo;?>', // 分享链接
    	imgUrl: 'http://cha.gdbwt.com/images/logo.jpg', // 分享图标
    	success: function () {
	        // 用户确认分享后执行的回调函数
			$.post('index.php?act=records&type=1');
	    }
	});

	wx.onMenuShareAppMessage({
    	title: '<?php echo $title;?>', // 分享标题
    	desc: '【茶园优品】推荐给你', // 分享描述
    	link: '<?php echo $site;?>index.php?minfo=<?php echo $obj_user->minfo;?>', // 分享链接
    	imgUrl: 'http://cha.gdbwt.com/images/logo.jpg', // 分享图标
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
</script>

<?php include_once('loading.php');?>

	<div class="list-nav">
        <a href="javascript:window.history.back(-1);" class="back">后退</a>
	    <a href="index.php" class="top-left top-index">首页</a>
        <div class="member-nav-M">店铺主页</div>
    </div>

	<div class="seller-top">
    	<div>
        	<div class="seller-tx"><img src="../res/images/touxiang.jpg" /></div>
            <br />
            <span class="seller-name">淘竹马（帅气的鸿仔）</span>
        </div>
    </div>

    <div class="index-pro">
    	<h3>
            <a href="#">更多</a>
        	<i></i>所有商品
        </h3>
        <ul class="clearfix">
        	<li>
                <a href="#">
                    <div class="index-pro-img"><img src="../res/images/index-pro.jpg" /></div>
                    <p class="index-pro-title">儿童益智早教玩具 宝宝手动游玩过家家玩具</p>
                    <div class="index-pro-info">
                        <span class="index-pro-price">￥55</span>
                        <i class="index-pro-car"></i>
                    </div>
                </a>
            </li>
        	<li>
                <a href="#">
                    <div class="index-pro-img"><img src="../res/images/index-pro.jpg" /></div>
                    <p class="index-pro-title">儿童益智早教玩具 宝宝手动游玩过家家玩具</p>
                    <div class="index-pro-info">
                        <span class="index-pro-price">￥55</span>
                        <i class="index-pro-car"></i>
                    </div>
                </a>
            </li>
        	<li>
                <a href="#">
                    <div class="index-pro-img"><img src="../res/images/index-pro.jpg" /></div>
                    <p class="index-pro-title">儿童益智早教玩具 宝宝手动游玩过家家玩具</p>
                    <div class="index-pro-info">
                        <span class="index-pro-price">￥55</span>
                        <i class="index-pro-car"></i>
                    </div>
                </a>
            </li>
        	<li>
                <a href="#">
                    <div class="index-pro-img"><img src="../res/images/index-pro.jpg" /></div>
                    <p class="index-pro-title">儿童益智早教玩具 宝宝手动游玩过家家玩具</p>
                    <div class="index-pro-info">
                        <span class="index-pro-price">￥55</span>
                        <i class="index-pro-car"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <div class="footer">
    	<a href="#">店铺主页</a>
    	<a href="#">会员中心</a>
    	<a href="#">申请</a>
    </div>

<?php include_once('common_footer.php');?>
