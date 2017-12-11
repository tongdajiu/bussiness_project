<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/main.js"></script>
<link href="res/css/style5.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">




            var SHAKE_THRESHOLD = 3000;
            var last_update = 0;
            var x = y = z = last_x = last_y = last_z = 0;
            function init() {
                if (window.DeviceMotionEvent) {
                    window.addEventListener('devicemotion', deviceMotionHandler, false);
                } else {
                    alert('not support mobile event');
                }
            }
            function deviceMotionHandler(eventData) {
                var acceleration = eventData.accelerationIncludingGravity;
                var curTime = new Date().getTime();
                if ((curTime - last_update) > 100) {
                    var diffTime = curTime - last_update;
                    last_update = curTime;
                    x = acceleration.x;
                    y = acceleration.y;
                    z = acceleration.z;
                    var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;

                    if (speed > SHAKE_THRESHOLD) {
                        var audio = document.createElement('audio');
						audio.src = 'mp3/5018.mp3';//这里放音乐的地址
						audio.autoplay = 'autoplay';
						document.body.appendChild(audio);
                        setTimeout(function(){location.href="shake_prize.php?shop_id=<?php echo $shop_id;?>&shake_id=<?php echo $shake_id;?>";},3000);
						window.removeEventListener('devicemotion', deviceMotionHandler, false);


                    }
                    last_x = x;
                    last_y = y;
                    last_z = z;

                }
            }
        </script>
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
</script>
        <img src="res/images/y-y.png" width="100%" />
        <img src="res/images/y-y-02.png" width="100%"/>
<!--<div style="text-align:center;margin-top:20px;"><p style="font-size:1.25em;padding-top:0.3em; font-weight:bold; color:#7a097b;">活动时间：<?php echo date('Y-m-d',$obj_activity->starttime)." 至 ".date('Y-m-d',$obj_activity->endtime)?></p></div>
-->
<?php include_once('common_footer.php');?>