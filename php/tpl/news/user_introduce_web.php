<?php include_once('common_header.php');?>
<script type="text/javascript" src="../res/js/jweixin-1.0.0.js"></script>
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
    	title: '<?php echo $site_name;?>', // 分享标题
    	link: '<?php echo $site;?>login.php?minfo=<?php echo $obj_user->minfo;?>', // 分享链接
    	imgUrl: '<?php echo $site;?>res/images/logo.jpg', // 分享图标
	});

	wx.onMenuShareAppMessage({
    	title: '<?php echo $site_name;?>', // 分享标题
    	desc: '<?php echo $gSetting['site_desc'];?>', // 分享描述
    	link: '<?php echo $site;?>login.php?minfo=<?php echo $obj_user->minfo;?>', // 分享链接
    	imgUrl: '<?php echo $site;?>res/images/logo.jpg', // 分享图标
    	type: 'link', // 分享类型,music、video或link，不填默认为link
    	dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
	});
});
</script>

<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="index.php" class="top-left top-index">首页</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">推荐好友</div>
</div>

<div class="index-wrapper">
	<div style="background-color:#FFF;padding:20px;color:#666;">
		<div style="text-align:center;"><h3>&nbsp;</h3></div>
		<div style="text-align:center;"><h3>&nbsp;</h3></div>
		<div style="text-align:center;"><h3>&nbsp;</h3></div>
		<div style="text-align:center;"><h3>&nbsp;</h3></div>
		<div style="text-align:center;color:red;font-size:14px"><h3>点击右上角微信发送给好友功能，好友注册成功将可获得积分!</h3></div>
	</div>
    <div class="clear"></div>
</div>

<?php include "tpl/footer_web.php";?>
<?php include_once('common_footer.php');?>
