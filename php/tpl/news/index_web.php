<?php include_once('common_header.php');?>
<script type="text/javascript" src="<?php echo __JS__;?>/swipe.min.js"></script>
<script type="text/javascript" src="<?php echo __JS__;?>/event.js"></script>
<script type="text/javascript" src="<?php echo __JS__;?>/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo __JS__;?>/tween.js"></script>
<script type="text/javascript">
wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $wxJsSign['appId']?>', // 必填，公众号的唯一标识
    timestamp: <?php echo $wxJsSign['timestamp'];?>, // 必填，生成签名的时间戳
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
</script>
	<?php include_once('loading.php');?>
	<?php include_once('top_btn_nav.php');?>
	<div class="view">
		<!--<div class="green_nav_bg clearfix">
			<div class="sys-btn"><a href="javascript:scanQrcode();"></a></div
			<div class="message-btn clearfix" ><a href="information.php"></a></div
	        <div class="member-nav-M"><?php echo $site_name ?></div>
		</div>-->

		<div class="index_top" style="background-image:url(../upfiles/adindex/<?php echo $adInfo[0]->images?>);"></div>
<style>
.notice p{display:inline-block;}
</style>
	  <?php if($announcement !=''){
	  	?>
		<div class="notice">
			<div>
				<ul>
				   <?php foreach($announcement as $rd){?>
						<li>
						  <?php if($rd->content =='' && $rd->url !='' ){ ?>
						     <a href="<?php echo $rd->url;?>"><?php echo $rd->title;?></a>
						   <?php }elseif($rd->content =='' && $rd->url =='' ){?>
						   	  <a><?php echo $rd->title;?></a>
						   <?php }elseif($rd->content !='' && $rd->url !='' ){ ?>
						   	  <a href="<?php echo $rd->url;?>"><?php echo $rd->title;?></a>
						   	<?php }else{?>
						      <a href="announcement_detail.php?id=<?php echo $rd->id;?>"><?php echo $rd->title ;?></a>
                          <?php }?>
						</li>
				   <?php }?>
				</ul>
			</div>
		</div>
	  <?php }?>

	    <!--<div class="index-search" onClick="showSearch()"><i></i>在店铺内搜索</div>-->

		<div id='mySwipe' class='swipe indexSwipe'>
			<div class='swipe-wrap'>
			  <?php foreach($lpPics as $list){?>
				<div><a href="<?php echo $list['url']?>" alt=""><img src="../upfiles/adindex/<?php echo $list['images']?>" /></a></div>
	          <?php } ?>
	        </div>
	        <ul class="swiperPager">
			  	<?php foreach($lpPics as $list){?><li></li><?php } ?>
	        </ul>
	    </div>


		<div class="index_class">
				<?php foreach($ptypes as $v){?>
				<?php foreach($catePics[$v->id] as $_pic){ ?>
				<a href="<?php echo $_pic['url'];?>"><div><img src="../upfiles/adindex/<?php echo $_pic['images'];?>" /><span><?php echo $v->name;?></sapn></div></a>
		        <?php }}?>
	    </div>

	    <div class="index-ad" >
	          <?php foreach($adList as $re){?>
	          <div><a href="<?php echo $re->url;?>" alt=""><img src="../upfiles/adindex/<?php  echo $re->images ;?>" /></a></div>
	          <?php }?>
	    </div>

	    <div class="proList">
	    	<h3>
	            <a href="product.php">更多</a>
	        	<i></i>所有商品
	        </h3>
	        <ul class="clearfix">
	        <?php foreach($product as $pt){?>
	        	<li>
	                <a href="product_detail.php?product_id=<?php echo $pt->product_id;?>">
	                    <div class="proList-img">
							<?php renderPic($pt->image); ?>
	                    </div>

	                    <?php if ( $pt->tag_title != '' ){ ?>
		                   	<div class="proList-label">
	                          <?php $rs = $GoodsTag->query("SELECT `images`,`title` FROM `goods_tag` WHERE `id` IN ({$pt->tag_title})"); ?>
							    <?php foreach( $rs as $info ){ ?>
							    	<div class="proList-label-item">
								    	 <?php if($info->images !=''){ ?>
			                   				<img src="../upfiles/label/<?php  echo $info->images;?>"/>
			                   			 <?php }else{ ?>
			                   				<p><?php echo $info->title;?></p>
			                   			 <?php  }?>
		                   			</div>
		                   		<?php  }?>
		                   	</div>
	                   	<?php  }?>
	                    <p class="proList-title"><?php echo $pt->name;?></p>
	                    <div class="proList-info">
	                        <span class="proList-price">￥<?php echo $pt->price;?></span>
	                    </div>
	                </a>
	            </li>
	        <?php }?>
	        </ul>
	    </div>
		<?php include_once('footer_web.php');?>

	</div>
	<?php include_once('footer_menu_web_new.php');?>

	<script>
	$(document).ready(function(){
		//焦点图
	    var elem = document.getElementById('mySwipe');
	    window.mySwipe = Swipe(elem, {
	        startSlide: 0,
	        auto: 3000,
	        continuous: false,
	        disableScroll: false,
	        stopPropagation: true,
	        callback: function (index, element) {},
	        transitionEnd: function (index, element) {
	        	$(".swiperPager li").removeClass("active").eq(mySwipe.getPos()).addClass("active");
	        }
	    });
	    $(".swiperPager li").eq(0).addClass("active");

	    //公告
	   	(function(){
	   		var winWidth = $(".notice div").width();
	   		var ulWidth = 0;
	   		$(".notice ul li").each(function(index,el){
	   			$(el).css("paddingLeft",winWidth);
	   			ulWidth += parseInt($(el).outerWidth(true)) + 35;
	   			console.log(parseInt($(el).outerWidth(true)));
	   		});
	   		$(".notice ul").css("width",ulWidth);
	   	})();
	    var notiveTimer = setInterval(function(){
	    	$(".notice div ul").css({"left":"-=2px"});
	    	if(parseInt($(".notice div ul").css("left")) <= (-1 * $(".notice div ul").width())){
	    		$(".notice div ul").css({"left":0});
	    	}
	    },50);
	});
	</script>

<?php include_once('common_footer.php');?>
