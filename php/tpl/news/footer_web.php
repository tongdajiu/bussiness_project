<div class="footer">
	<?php if($_SESSION['userInfo']->type==1024){?>
		<?php if(!$hideBotShop){ ?>
			<a href="shop.php">店铺主页</a>
		<?php } ?>
	<?php }else{?>
		<?php
		$AgentApply = D('AgentApplication',$db);
		$agentApply   = $AgentApply->get(array('userid'=>$userid));
		if(empty($agentApply)){
		?>
			<a href="agent_application.php">申请</a>
		<?php } ?>
	<?php }?>
	<a href="user.php">会员中心</a>
</div>

<script>
	$(function(){
		footerFixed();
	});
	function footerFixed(){
		var bodyHeight = $("body").outerHeight(true),
			winHeight = $(window).outerHeight(true);

		if(winHeight > bodyHeight){
			// $(".view").css("min-height",winHeight);
			// $(".footer").css({
			// 	"position":"fixed",
			// 	"bottom":"20px",
			// 	"left":"0",
			// 	"width":"100%"
			// });
			$("body,.view").css({
				"height": winHeight,
				"position": "relative"
			});
			$(".footer").css({
				"position":"absolute",
				"bottom":"20px",
				"left":"0",
				"width":"100%"
			});
		}
	}
</script>