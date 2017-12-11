	<div id="loading">
		<div class="loader-inner ball-triangle-path">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
	<script>
	window.onload = function(){
		document.getElementById("loading").style.display="none";
	}
	$(function(){
		setTimeout(function(){
			$("#loading").hide();
		},800);
	})
	</script>