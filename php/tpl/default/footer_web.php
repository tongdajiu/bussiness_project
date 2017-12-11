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