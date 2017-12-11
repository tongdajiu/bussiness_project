<?php include_once('common_header.php');?>
<link href="res/css/style5.css" rel="stylesheet" type="text/css" />
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
    	title: '茶园优品-摇一摇', // 分享标题
    	link: '<?php echo $site.'shake_index.php'; ?>', // 分享链接
    	imgUrl: '<?php echo $site.'images/y-y-09.png';?>', // 分享图标
	});

	wx.onMenuShareAppMessage({
    	title: '茶园优品-摇一摇', // 分享标题
    	desc: '茶园优品-摇一摇获取优惠大奖', // 分享描述
    	link: '<?php echo $site.'shake_index.php'; ?>', // 分享链接
    	imgUrl: '<?php echo $site.'images/y-y-09.png';?>', // 分享图标
    	type: '', // 分享类型,music、video或link，不填默认为link
    	dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
	});
});
$(function(){
	var audio = document.createElement('audio');
	audio.src = 'mp3/shake_match.mp3';//这里放音乐的地址
	audio.autoplay = 'autoplay';
	document.body.appendChild(audio);

	$("#introduceDiv").find("img").each(function(){
		$(this).attr("style","width:95%;margin:10px;");
	});
});
</script>
<style>
	.bg-box{ background:url(images/y-y-08.png) no-repeat; background-size:100%;text-align:center; }
</style>
<div class="navs_nav_bg">
	<span class="return_btn"><a href="/shake_index.php?shake_id=<?php echo $shake_id;?>"><img src="res/images/y-y-06.png" width="50%"  style="vertical-align:middle;"/></a></span>
    <span class="nav_title_style">摇一摇</span>
</div>
<div class="bg-box" style="padding-left:10px;padding-right:10px;height:530px; ">
	<p style="padding-top:1.5em; font-size:1.5em;color:#7a097b; font-weight:bold;">亲！您今天的机会已经用完</p>
     <div style="margin-top: 60px;"> <p style="font-size:1.5em;padding-top:0.3em; font-weight:normal; color:#5e5d5e;">请明天再来哟～</p></div>
     <div style="margin-top: 60px;"><a href="./coupon_info.php" style="font-size:1.75em;padding-top:0.3em; font-weight:normal; color:yellow; ">查看优惠券</a></div>

<!--<div style="padding-top:20px;"> <img src="upfiles/<?php echo $prize_get->image;?>" width="50%"style=" display:block; margin:0 auto; " />

        <h2 style="font-size:1em; font-weight:normal; line-height:3em; text-align:center;"><?php echo $prize_get->name;?></h2></div>
        <h2 style="font-size:1em; font-weight:normal; line-height:3em; text-align:center;">编号：<?php echo $prize_get->prize_no;?></h2></div>
		<div id="introduceDiv" style="padding-left:10px;padding-right:10px;color:#111;"> <?php echo $prize_get->introduce;?></div>-->
</div>
<?php include_once('common_footer.php');?>
