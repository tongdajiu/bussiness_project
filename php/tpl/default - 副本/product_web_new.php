<?php include_once('common_header.php');?>
<style>
	body{background:#fff;}
</style>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
		WeixinJSBridge.call('hideToolbar');
	});

(function(){

 var onBridgeReady = function () {
    var appId = '',
    imgUrl = '<?php echo $site.__IMG__;?>/images/logo.jpg';
    link = "<?php echo $site;?>product.php?minfo=<?php echo $obj_user->minfo;?>",
    title = "<?php echo $site_name;?>",
    desc = '<?php echo $gSetting['site_desc'];?>';
    // 发送给好友;
    WeixinJSBridge.on('menu:share:appmessage', function(argv){
     WeixinJSBridge.invoke('sendAppMessage',{
         "appid" : appId,
         "img_url" : imgUrl,
         "img_width" : "640",
         "img_height" : "640",
         "link" : link,
         "desc" : desc,
         "title" : title
     }, function(res) {
        if(res.err_msg=='send_app_msg:confirm' || res.err_msg=='send_app_msg:ok') {
        	share_integral()
         }
        });
     });
    // 分享到朋友圈;
    WeixinJSBridge.on('menu:share:timeline', function(argv){
     WeixinJSBridge.invoke('shareTimeline',{
         "img_url" : imgUrl,
         "img_width" : "640",
         "img_height" : "640",
         "link" : link,
         "desc" : desc,
         "title" : title
         }, function(res) {
            if(res.err_msg=='share_timeline:ok' || res.err_msg=='share_timeline:confirm') {
            	share_integral()
            }
         });
     });
    // 分享到微博;
 };
 if(document.addEventListener){
     document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
 } else if(document.attachEvent){
     document.attachEvent('WeixinJSBridgeReady' , onBridgeReady);
     document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
 }
})();
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
        if (!loaded && (tScroll >= dHeight-wHeight) && <?php echo ($productList['PageCount'] - 1);?> > 0) {
            $("#progressIndicator").show();
            index++;
            cmu++;
            fmu++;
            page++;
            if (index >= <?php echo ($productList['PageCount'] - 1);?>) loaded = true;
            $.get("ajaxtpl/ajax_product_new.php?category_id=<?php echo $category_id;?>&t=<?php echo $type;?>&page="+page,
            function(data) {
                $(".proList ul").append(data);
                $("#progressIndicator").hide()
            })
        }
    };
    $(window).scroll(show);

    var time=$("#time").val();
	if(!time){
		time=='1';
	}
	$("#buynum11").html(time);
});

</script>
<?php include_once('loading.php');?>
<div class="view">
	<div class="top_nav">

		<div class="top_nav_title">
		<?php if($category_id == -1){
			echo "全部商品";
		}else{
			echo $productType->name;
		} ?>
		</div>

		<a class="top_nav_left top_nav_class" href="javascript:showside('right','.side_pro');" title="商品分类"></a>
	</div>

	<div class="proList">
		<ul class="clearfix">
			<?php foreach($productList['DataSet'] as $product){ ?>
	    	<li>
		    	<a href="product_detail.php?product_id=<?php echo $product->product_id;?>">
		            <div class="proList-img">
						<?php renderPic($product->image, 'small', 1, array(), array('cls'=>'product_02-Pic-color02'));?>
		            </div>

		            <?php if ( $product->tag_title != '' ){ ?>
	                   	<div class="proList-label">
	                        <?php  $rs = $goodstag->query("SELECT `images`,`title` FROM `goods_tag` WHERE `id` IN ($product->tag_title)");?>
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

		            <p class="proList-title"><?php if(mb_strlen($product->name,'utf-8')>18){ echo mb_substr($product->name,0,18,'utf-8'),'...';}else{ echo $product->name;};?></p>
		            <div class="proList-info">
		                <span class="proList-price">￥<?php echo number_format($product->price,2);?><?php echo $product->brand;?></span>
		            </div>
		        </a>
	    	</li>
			<?php } ?>
	    </ul>
		<div id="progressIndicator">
			<img width="85" height="85" src="res/images/ajax-loader-85.gif" alt=""> <span id="scrollStats"></span>
		</div>
	</div>

	<?php include_once('footer_web.php');?>
</div>

<div class="side_menu side_pro">
	<div class="side_main">
		<ul class="side_menu_ul">
			<li><a href="product.php">全部</a></li>
			<?php foreach($re_productTypes as $row){?>
		    	<li><a href="product.php?category_id=<?php echo $row->id;?>"><?php echo $row->name;?></a></li>
			<?php }?>
		</ul>
	</div>
	<div class="side_blank" onClick="hideside('right','.side_pro')"></div>
</div>

<script>
	function showside(direction,el)
	{
		direction == "left" ? direction="moveleft" : direction="moveright";
		$("body").css("overflow","hidden");
		$(el).fadeIn(30,function(){
			$(el).addClass(direction);
			$(".view").addClass(direction);
			$(".view,.right_bottom_nav,.footer_memu").addClass("blur2");
		});
	}

	function hideside(direction,el)
	{
		direction == "left" ? direction="moveleft" : direction="moveright";

		$(el).removeClass(direction);
		$(".view").removeClass(direction);
		$(".view,.right_bottom_nav,.footer_memu").removeClass("blur2");
		setTimeout(function(){
			$(el).hide();
			$("body").css("overflow","auto");
		},400);
	}
</script>

<?php include_once('common_footer.php');?>
<?php include_once('footer_menu_web_new.php');?>
