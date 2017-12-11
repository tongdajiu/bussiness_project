<div style="clear:both;height:50px;"></div>
<!--<div class="menu-foot2">
	<div class="menu-foot-button"><a href="index.php" class="<?php if(strpos($_SERVER['PHP_SELF'],'index')){ echo 'menu-foot-index-f';}else{echo 'menu-foot-index';}?>"></a></div>
	<div class="menu-foot-button"><a href="product.php" class="<?php if(strpos($_SERVER['PHP_SELF'],'product')){ echo 'menu-foot-class-f';}else{echo 'menu-foot-class';}?>"></a></div>
	<div class="menu-foot-button"><a href="cart.php" class="<?php if(strpos($_SERVER['PHP_SELF'],'cart')){ echo 'menu-foot-cart-f';}else{echo 'menu-foot-cart';}?>"></a></div>
	<div class="menu-foot-button"><a href="user.php" class="<?php if(strpos($_SERVER['PHP_SELF'],'user')){ echo 'menu-foot-user-f';}else{echo 'menu-foot-user';}?>"></a></div>
</div>-->
<div class="index-nav">
	<ul>
		<li><a href="index.php" class="index-nav-index <?php if(strpos($_SERVER['PHP_SELF'],'index')){ echo 'active';}?>"></a></li>
		<li><a href="product.php" class="index-nav-allPro <?php if(strpos($_SERVER['PHP_SELF'],'product')){ echo 'active';}?>"></a></li>
		<li><a href="cart.php" class="index-nav-car <?php if(strpos($_SERVER['PHP_SELF'],'cart')){ echo 'active';}?>"><span><?php echo $cart_num ;?></span></a></li>
		<li><a href="article.php" class="index-nav-article <?php if(strpos($_SERVER['PHP_SELF'],'article')){ echo 'active';}?>"></a></li>
		<li><a href="user.php" class="index-nav-member <?php if(strpos($_SERVER['PHP_SELF'],'user')){ echo 'active';}?>"></a></li>
	</ul>
</div>
<script>
	$(function(){
		$(".index-nav ul li a span").text()=="" ? $(".index-nav ul li a span").hide() :$(".index-nav ul li a span").show();
	})
</script>