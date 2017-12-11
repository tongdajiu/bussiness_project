<?php include_once('common_header.php');?>
<meta name="viewport" content="width=100%; initial-scale=0.5; maximum-scale=0.5; minimum-scale=0.5; user-scalable=no;">
<link href="res/css/index2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery.faragoImageAccordion.js"></script>
<script type="text/javascript">
$(function() {
	$("#imageAccordion").imageAccordion({
        imageSpeed: "fast",
        titleSpeed: "slow"
    });
    $("a.link_ajaxLoadIA").click(function() {
        var $this = $(this);
        var $ia = $("#imageAccordion");
        $ia.html("Loading...");
        $ia.load($this.attr("href") + "?abc=" + Math.random(), {
            cache: false
        },
        function() {
            $ia.imageAccordion({
                imageSpeed: "fast",
                titleSpeed: "slow"
            })
        });
        return false
    });
    var $trigger = $("#accordionMenu ul li.mainType");
    $trigger.hover(function() {
        $trigger.removeClass("hover");
        $("div.subList").hide();
        $(this).addClass("hover").find("div.subList").show()
    },
    function() {
        $trigger.removeClass("hover");
        $("div.subList").hide()
    });
    var loaded = false;
    var index = 0;
    var cmu = 2;
    var fmu = 1;
    var page = 1;
    function show() {
        var hght = $("#body").height();
        var top = $(window).scrollTop();
        if (!loaded && (parseInt(hght / cmu) * fmu < top) && <?php echo ($productList['PageCount'] - 1);?> > 0) {
            $("#progressIndicator").show();
            index++;
            cmu++;
            fmu++;
            page++;
            if (index >= <?php echo ($productList['PageCount'] - 1);?>) loaded = true;
            $.get("ajaxtpl/ajax_product.php?category_id=<?php echo $category_id;?>&page="+page,
            function(data) {
                if (index == 1) $("#comments").html(data);
                else $("#comments").after(data);
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

function buy_now(product_id){
	$.ajax({
		url:'cart.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			var a = result.indexOf('<!DOCTYPE');
    		if(a > 0){
    			alert(result.substr(0,a));
    		}else{
    			var time=$("#time").val();
				if(!time){
					time=='1';
				}
    			time=Number(time)+Number(1);
    			$("#time").val(parseInt($("#time").val()) + 1);
            	$("#buynum11").html(time);
            	alert('添加购物车成功');
    		}
    	}
	});
}
function addFavor(product_id){
    $.ajax({
		url:'favorites.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
		dataType: 'string',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			alert('收藏成功');
    	}
	});
}
</script>
<?php include_once('loading.php');?>

<div class="list-nav">
	<div class="nav02">
    	<ul>
            <li><a href="#"><img src="res/images/list_02.png" alt="" width="193" height="79" /></a>
            	<div class="drop">
                	<dl>
                    	<?php foreach($re_productTypes as $row){?>
                        	<dt><a href="product.php?category_id=<?php echo $row->id;?>"><?php echo $row->name;?></a></dt>
                    	<?php }?>
                    </dl>
                </div>
           	</li>
         </ul>
     </div>

    <a href="user.php" class="member-nav-R2"></a>
</div>

<div class="index-wrapper">
	<div class="list-product">
        <ul>
<?php foreach($productList['DataSet'] as $product){ ?>
            <li class="list-productBg">
                <div class="list-product-L" onclick="javascript:location.href='product_detail.php?product_id=<?php echo $product->product_id;?>'"><?php renderPic($product->image, 'middle', 1, array('w'=>171,'h'=>171), array('cls'=>'shoppingCart-table-Pic02-border'));?></div>
                <div class="list-product-R">
                    <a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><p class="list-product-R-tit"><?php if(mb_strlen($product->name,'utf-8')>12){ echo mb_substr($product->name,0,12,'utf-8'),'...';}else{ echo $product->name;};?></p>
                    <?php if($product->hot == 2 && $obj_user != null && $obj_user->type == 1){ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price;?>元  <span class="list-product-R-value02">原价：<?php echo $product->price_old;?>元</span></p></a>
                    <?php }else{ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price;?>元</p></a>
                    <?php } ?>
                    <br />
                	<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="buy_now(<?php echo $product->product_id;?>);" value="加入购物车"/>
                	<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="addFavor(<?php echo $product->product_id;?>);" value="加入收藏"/>
                </div>
            </li>
<?php } ?>
        </ul>
    </div>
     <div id="comments"></div>
	<div id="progressIndicator" style="text-align: center; display: none;">
		<img width="85" height="85" src="res/images/ajax-loader-85.gif" alt=""> <span id="scrollStats" style="font-size: 70%; width: 80px; text-align: center; position: absolute; bottom: 25px; left: 2px;"></span>
	</div>
    <div class="list-button">
    	<a href="orders.php"><div class="list-items"></div></a>
    	<span><img class="buynum" src="res/images/buynum.png"></span><span id="buynum11" class="buynum1"></span>
        <a href="cart.php"><div class="list-cart"></div></a>
    </div>
</div>
<input type="hidden" id="time" name="time" value="<?php echo count($cartList);?>">
<script>
$(".drop").hide();
$(".nav02 ul li").hover(function () {
$(this).find(".drop").slideToggle(200);
});
</script>
<?php include_once('common_footer.php');?>
