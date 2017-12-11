<?php include_once('common_header.php');?>
<link type="text/css" rel="stylesheet" href="js/web.css">
<style type="text/css">
html{padding: 0;margin: 0;}
body{overflow: hidden;background: url("./upfiles/greetcard/<?php echo $obj_card->background;?>") 0 0 no-repeat;margin: 0;padding: 0;background-size:cover}

.egg{margin:45px auto 0 auto;}
.egg ul li{z-index:999;list-style:none}
.eggList{padding-top:10px;position:relative;margin:0 auto;width:237px;padding-left: 0;}
.eggList li{float:left;background:url(./images/redbag/egg_5.png) no-repeat bottom;padding-top:70px;width:237px;height:186px;cursor:pointer;position:relative;margin-left:0px;list-style:none;background-size:237px;}
.eggList li span{position:absolute; width:50px; height:60px; left:15px; top:20px; color:#ff0; font-size:42px; font-weight:bold;background: url("./images/redbag/hongbao.png") 0 0 no-repeat;background-size:50px 43px;text-indent: -9999px;overflow: hidden;}
.eggList li.curr{background:url(./images/redbag/egg_6_.png) no-repeat bottom;padding-top:0;cursor:default;z-index:300;background-size:79px;height:93px}
.eggList li.curr sup{position:absolute;background:url(./images/redbag/img-4.png) no-repeat;width:232px; height:181px;top:-36px;left:-34px;z-index:800;display: none !important;}
.hammer{background:url(./images/redbag/img-9.png) no-repeat;width:74px;height:88px;position:absolute; text-indent:-9999px;z-index:150;left:158px;top:50px;background-size:74px;height:88px;}
.resultTip{position:absolute; padding:6px;z-index:9999; color:#f60; text-align:center;overflow:hidden;display:none;z-index:500;text-indent: -9999px;height:100px;display:none !important}
.resultTip b{font-size:14px;line-height:24px;}

#horse{padding:0;  color: #fff; width: 313px; height:231px;background: url('./upfiles/greetcard/<?php echo $obj_card->text_background;?>') no-repeat center bottom; margin: 0 auto; display:block; z-index: 10; background-size:313px 231px;margin-top: 110px;font-size: 14px;line-height: 1.45;color:#222;text-shadow:0 1 0 rgba(255,255,255,0.6);margin-top:0px !important;p}
#horse p{padding: 0px 30px 0 40px;}
#horse .txt strong{color:#000;display: block;}
#horse .txt strong.r{text-align: right;}
audio{position: absolute;top:-980em;width:30px;right:0;}


#bridge1,#bridge2,#bridge3 {margin-top: 0px;}
#bridge1 .animated ,#bridge2 .animated,#bridge3 .animated{text-align: center;}
#bridge1 .animated img,#bridge2 .animated img,#bridge3 .animated img{width:180px;margin:0 auto;}
#result img{}

#right_word1,#left_word1,#right_word2,#left_word2,#right_word3,#left_word3{display: block;position: absolute;background: #F10100;width:30px;text-align: center;line-height: 30px;font-size: 30px;color:#222;right: 6px;font-weight: bold;top:160px;padding: 9px 12px;text-shadow: -1px -1px 0 #FDFC82, 1px -1px 0 #FDFC82, -1px 1px 0 #FDFC82, 1px 1px 0 #FDFC82;z-index: 1100;display:table;height:210px}
#right_word1 p,#left_word1 p,#right_word2 p,#left_word2 p,#right_word3 p,#left_word3 p{display:table-cell;vertical-align: middle;}
#left_word1,#left_word2,#left_word3{display: table;position: absolute;background: #F10100;width:30px;text-align: center;line-height: 30px;font-size: 30px;color:#222;left: 6px;font-weight: bold;padding: 9px 12px;height:210px;}
</style>
<script type="text/javascript" src="res/js/jweixin-1.0.0.js"></script>
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
    	title: '【一起剪茶包，惊喜天天有】', // 分享标题
    	link: 'http://cha.gdbwt.com/index_blessing_redbag.php?mid=<?php echo $obj->mid;?>&cardid=<?php echo $obj_card->id;?>&openid=<?php echo $_SESSION['userInfo']->openid;?>&minfo=<?php echo $_SESSION['userInfo']->minfo;?>', // 分享链接
    	imgUrl: 'http://cha.gdbwt.com/images/redbag_share.jpg', // 分享图标
    	success: function () {
	        // 用户确认分享后执行的回调函数
			$.post('index.php?act=records&type=1');
	    }
	});

	wx.onMenuShareAppMessage({
    	title: '【一起剪茶包，惊喜天天有】', // 分享标题
    	desc: '红包天天有，一起剪茶包，赶快来看看', // 分享描述
    	link: 'http://cha.gdbwt.com/index_blessing_redbag.php?mid=<?php echo $obj->mid;?>&cardid=<?php echo $obj_card->id;?>&openid=<?php echo $_SESSION['userInfo']->openid;?>&minfo=<?php echo $_SESSION['userInfo']->minfo;?>', // 分享链接
    	imgUrl: 'http://cha.gdbwt.com/images/redbag_share.jpg', // 分享图标
    	type: '', // 分享类型,music、video或link，不填默认为link
    	dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    	success: function () {
	        // 用户确认分享后执行的回调函数
			$.post('index.php?act=records&type=1');
	    }
	});
});
</script>

<?php include_once('loading.php');?>
<div id="main">
    <div class="egg animated flash" style="" id="egg">
        <ul class="eggList" id="eggList">
            <p class="hammer" id="hammer">锤子</p>
            <li data="1"><span>1</span><sup></sup></li>
            <!--<li data="2"><span>2</span><sup></sup></li>
            <li data="3"><span>3</span><sup></sup></li>-->
        </ul>
    </div>


    <div class="clear" style="clear:both;"></div>


    <div id="bridge" class="animated">
        <div id="horse" class="animated pulse" style="display:table !important">
            <p class="txt" style="display:table-cell;vertical-align:middle;"><strong><?php echo $obj->toname;?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $obj->content;?><strong class="r"><?php echo $obj->name;?></strong></p>
        </div>
    </div>


       <div id="bridge1" class="animated" style="display:none;">
        <div id="horse1" class="animated">
            <?php echo  $data1;?>
        </div>
    </div>
        <div id="bridge2" class="animated" style="display:none;">
        <div id="horse2" class="animated">
            <?php echo  $data1;?>
        </div>
    </div>
        <div id="bridge3" class="animated" style="display:none;">
        <div id="horse3" class="animated">
            <?php echo  $data1;?>
        </div>
    </div>

            <div id="cover_share" style="display:none;">
            <div id="sharehelper" class="weiba-layer-sharehelper"></div>
        </div> <!-- E cover_share -->
        <style type="text/css">
            #cover_share{background: rgba(0, 0, 0, 0.4); height: 100%; overflow: hidden; position: fixed; top: 0;width: 100%;z-index:99999}
            .weiba-layer-sharehelper{ position: fixed; top: 0; right: 0; width: 100%; height: 100%; background: url("./images/redbag/cover_share.png") center top no-repeat; background-size: 100% auto; z-index: 99999;}
        </style>

<span id="playbox" class="btn_music on" onclick="playbox.init(this).play();">
    <audio controls="" autoplay="" loop="" src="upfiles/greetcard/<?php echo $obj_card->music;?>">
        <source src="upfiles/greetcard/<?php echo $obj_card->music;?>" type="audio/mpeg">
        </audio>
</span>
<div style="position:absolute;margin:0 40%;bottom:8%;left:0;width:60%">
        <a href="redbag_records.php"><img src="res/images/redbag/records.png" width="50%"></a>
     </div>
<div id="copy" style="position:absolute;margin:0;bottom:10px;left:0;width:100%">
    <!--<a href="blessing.php?cardid=<?php echo $obj_card->id;?>" class="btn" style="height:40px;line-height:40px;text-decoration:none;color:#fff;background:#c68d47;border-radius:4px;display:block;margin-left:20px;text-align:center;width:120px;text-shadow: 0 1px 0 rgba(0,0,0,0.5)">我要制作一张</a>-->
    <a href="<?php echo $obj_card->footer_url;?>" class="copy" style="position:absolute;right:10px;text-decoration:none;font-size:12px;line-height:40px;top:0;color:black;padding-left:26px;background:url(&#39;./images/redbag/i_horse.png&#39;) left center no-repeat;background-size:25px 30px;"><?php echo $obj_card->footer;?></a>
</div> <!-- E copy -->

</div>
<script type="text/javascript" src="res/js/playbox.js"></script>
<script type="text/javascript" src="res/js/snow2.js"></script>

<script type="text/javascript">

playbox.init("playbox");

function horse() {
    $('#horse').show().addClass('fadeInDownBig').delay(1200).queue(function(next){

        $(this).removeClass('fadeInDownBig');
        next();
        $(this).addClass('pulse');
        //$("#egg").show();
    });

    $('#egg').show().addClass('fadeInRightBig').delay(1000).queue(function(next){

        $(this).removeClass('fadeInRightBig');
        next();
        $(this).addClass('flash');
    });
}

horse();
createSnow('', 20);

document.ontouchstart = function() {
    $("#cover_share").hide();
};
var id_err=0;
$(".eggList li").click(function() {
    $(this).children("span").hide();
    var _this = $(this);
    if(_this.hasClass("curr")){
        return false;
    }
    $(".hammer").css({"top":_this.position().top-55,"left":_this.position().left+185});
    $(".hammer").animate({
        "top":_this.position().top-25,
        "left":_this.position().left+35
    },30,function(){
        _this.addClass("curr"); //蛋碎效果
        _this.find("sup").show(); //金花四溅
        $(".hammer").show();

        $("#bridge").hide();

        var id = _this.attr('data');
        var numbers = [1,2,3];
        numbers.forEach(function(value, index) {
            if(value==id) {
                $("#bridge"+id).show();
            } else {
                $("#bridge"+value).hide();
            }
        });
        if(id==1) {
        }
		//$rand_number
        $('#horse'+id).show().addClass('fadeInDownBig').delay(100).queue(function(next){
			id_err++;
            $(this).removeClass('fadeInDownBig');
            next();
            $(this).addClass('pulse');


			//feng add
			$.post("ajaxtpl/egg_redbag.php?pn=<?php echo $rand_number;?>&openid=<?php echo $openid;?>", function(data) {
				if (data==-1)
					alert("请关注茶园优品服务号后登录参与活动;您当前操作纯属无效！");
				if (data==-2)
					alert("您的抽奖次数已满，感谢参与！");
			});

			if(id_err==3){
				alert("很遗憾，您三次机会都没有砸到奖品！");
			}
        });

        $('#left_word'+id).show().addClass('fadeInLeftBig').delay(2000).queue(function(next){
            $(this).removeClass('fadeInLeftBig');
            next();
            //$(this).addClass('wobble');
        });

        $('#right_word'+id).show().addClass('fadeInRightBig').delay(1000).queue(function(next){
            $(this).removeClass('fadeInRightBig');
            next();
            //$(this).addClass('wobble');
        });
    });
    //eggClick($(this));
});

$(".eggList li").hover(function() {
    var posL = $(this).position().left + $(this).width();
    $("#hammer").show().css('left', posL);
})

</script>

<div id="footer"> </div>

<script>
(function(){

 var onBridgeReady = function () {
    //网络链接
    var no_wifi_play_music = './images/redbag/xinnianxiyangyang.mp3';

    WeixinJSBridge.invoke('getNetworkType',{},
        function(e){

            if(e.err_msg == 'network_type:wifi') {
                playbox.init("playbox");
                $("#audio").attr('autoplay', 'autoplay');
            } else if (e.err_msg == 'network_type:wwan') {
                if(no_wifi_play_music) {
                    playbox.init("playbox");
                    $("#source").attr('src', no_wifi_play_music);
                    //$("#audio").attr('autoplay', 'autoplay');
                }
            }
    });

 };
 if(document.addEventListener){
     document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
 } else if(document.attachEvent){
     document.attachEvent('WeixinJSBridgeReady' , onBridgeReady);
     document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
 }
})();
</script>

<?php include_once('common_footer.php');?>