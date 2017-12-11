<?php include_once('common_header.php');?>
<link href="res/css/style_wj.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.demo-in-in { width: 320px; margin: 0 auto;}
#bg,#bg2{ display: none; position: fixed;  top: 0%;  left: 0%;  width: 100%; height: 100%;  background:url(images/guide_bg.png);
            z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}
</style>
<!--<script type="text/javascript" src="res/js/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="../res/js/jweixin-1.0.0.js"></script>
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
        link: '<?php echo $site;?>draw_activity.php', // 分享链接
        imgUrl: '<?php echo __IMG__;?>/logo.jpg', // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
            $.post('index.php?act=records&type=1');
        }
    });

    wx.onMenuShareAppMessage({
        title: '<?php echo $gSetting['site_name'];?>', // 分享标题
        desc: '【<?php echo $gSetting['site_name'];?>】推荐给你', // 分享描述
        link: '<?php echo $site;?>draw_activity.php', // 分享链接
        imgUrl: '<?php echo __IMG__;?>/logo.jpg', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () {
            // 用户确认分享后执行的回调函数
            $.post('index.php?act=records&type=1');
        }
    });
});

$(function(){
<?php if($act=='guide'){ ?>
	$("#bg").show();
<?php } ?>
});
//	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
//		WeixinJSBridge.call('hideToolbar');
//	});

(function(){

// var onBridgeReady = function () {
//    var appId = '',
//    imgUrl = 'http://cha.gdbwt.com/images/a6.png';
//    link = "http://cha.gdbwt.com/draw_activity.php?activity_id=<?php //echo $activity_id;?>//&share_user=<?php //echo $openid;?>//&share_name=<?php //echo $name;?>//&suserid=<?php //echo $userid;?>//&mcode=<?php //echo $obj_user->minfo;?>//",
//    title = "<?php //echo $obj->title;?>//",
//    desc = '十月居然抽中一台拍立得！没关系！还有最后一台！帮我抽，你很可能也会中！';
//    // 发送给好友;
//    WeixinJSBridge.on('menu:share:appmessage', function(argv){
//     WeixinJSBridge.invoke('sendAppMessage',{
//         "appid" : appId,
//         "img_url" : imgUrl,
//         "img_width" : "640",
//         "img_height" : "640",
//         "link" : link,
//         "desc" : desc,
//         "title" : title
//     }, function(res) {
//        if(res.err_msg=='send_app_msg:confirm' || res.err_msg=='send_app_msg:ok') {
//        	share_integral()
//         }
//        });
//     });
//    // 分享到朋友圈;
//    WeixinJSBridge.on('menu:share:timeline', function(argv){
//     WeixinJSBridge.invoke('shareTimeline',{
//         "img_url" : imgUrl,
//         "img_width" : "640",
//         "img_height" : "640",
//         "link" : link,
//         "desc" : desc,
//         "title" : title
//         }, function(res) {
//            if(res.err_msg=='share_timeline:ok' || res.err_msg=='share_timeline:confirm') {
//            	share_integral()
//            }
//         });
//     });
//    // 分享到微博;
// };
 if(document.addEventListener){
     document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
 } else if(document.attachEvent){
     document.attachEvent('WeixinJSBridgeReady' , onBridgeReady);
     document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
 }
})();
function hideDiv(){
	document.getElementById('bg').style.display = "none";
}
</script>
<?php include_once('loading.php');?>
<a href="http://mp.weixin.qq.com/s?__biz=MzAwNTMyMzA5Mg==&mid=204371341&idx=1&sn=353e5e87ac5e8fef50b9f6b751dbaa46#rd"><img src="/upfiles/<?php echo $obj->background_image;?>" width="100%"></a>

<div class="bottom_btn">
</div>
		<div class="float_btn" style="text-align:center;">
<?php if($obj->state == 0){
		if(count($numbers)>0){
?>
			<a href="draw_activity.php?act=post&activity_id=<?php echo $obj->id;?>&openid=<?php echo $openid;?>&name=<?php echo $name;?>&share_user=<?php echo $share_user;?>&share_name=<?php echo $share_name?>&userid=<?php echo $userid;?>&suserid=<?php echo $suserid;?>">查看我的抽奖号</a>
<?php
		}else{
?>
			<a href="draw_activity.php?act=post&activity_id=<?php echo $obj->id;?>&openid=<?php echo $openid;?>&name=<?php echo $name;?>&share_user=<?php echo $share_user;?>&share_name=<?php echo $share_name?>&userid=<?php echo $userid;?>&suserid=<?php echo $suserid;?>&title=<?php echo $obj->title;?>">获取我的抽奖号</a>
<?php
		}
}else if($obj->state == 1 && count($numbers)>0){ ?>
			<a href="draw_activity.php?act=post&activity_id=<?php echo $obj->id;?>&openid=<?php echo $openid;?>&name=<?php echo $name;?>&share_user=<?php echo $share_user;?>&share_name=<?php echo $share_name?>&userid=<?php echo $userid;?>&suserid=<?php echo $suserid;?>">活动结束，查看我的抽奖号</a>
<?php }else{ ?>
	  	  <a href="#">活动已结束</a>
<?php } ?>
		</div>
	</div>
<div id="bg" onclick="hideDiv();" style="display: none;">
	<img src="res/images/guide1.png" alt="" style="position:fixed;top:0;right:16px;">
</div>
<?php include_once('common_footer.php');?>
