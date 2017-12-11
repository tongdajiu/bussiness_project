
	<!--右下角菜单-->
	<div class="right_bottom_nav">
		<?php if(!empty($gSetting['service_third_url'])){ ?><a href="<?php echo $gSetting['service_third_url'];?>" class="r_b_nav_service"></a><?php } ?>
		<?php if( ! $hideIndexIcon ) {?>
			<a href="index.php" class="r_b_nav_index"></a>
		<?php }?>
		<!--<a href="user.php" class="r_b_nav_member"></a>-->
		<!--<?php if( ! $hideCartIcon ) {?>
		<a href="cart.php" class="r_b_nav_cart"></a>
		<?php }?>-->
		<a href="javascript:;" class="r_b_nav_gotop" style="display:none;"></a>
	</div>

	<script>
		$(function(){
			$(window).scroll(function(){
				$(window).scrollTop()>100 ? $(".r_b_nav_gotop").show() : $(".r_b_nav_gotop").hide();
			});

			$(".r_b_nav_gotop").click(function(){
				$("html,body").animate({scrollTop:0},300);
			});
		});
	</script>

	</body>
</html>