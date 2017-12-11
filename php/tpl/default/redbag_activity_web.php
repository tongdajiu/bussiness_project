<?php include_once('common_header.php');?>
<style type="text/css">
*{ margin:0; padding:0; font-family:"微软雅黑"}
</style>
<script type="text/javascript">
$(function(){
<?php if($act=='guide'){ ?>
	$("#bg").show();
<?php } ?>
});
function hideDiv(){
	document.getElementById('bg').style.display = "none";
}
</script>
<?php include_once('loading.php');?>
<div style="height:1px;overflow:hidden;">
    <img src="http://cha.gdbwt.com/images/logo.jpg" />
</div>
	<div style="width:320px; height:auto; margin:0 auto;">
		<div><img src="res/images/hb-01.png" /></div>
		<div style="background:url(images/hb-02.png) no-repeat; width:320px; height:243px;">
			<div style="text-align:center;"><img src="res/images/hb-04.png" /></div>
			<div style="font-size:40px; color:#FF0000; text-align:center;"><font style="font-size:30px;"><?php echo $redbagPrize[$obj->prize]?></font></div>
		</div>
		<div><img src="res/images/hb-03.png" border="0" usemap="#Map" />
<map name="Map" id="Map">
	<area shape="rect" coords="15,10,304,61" href="redbag_prize.php?activity_id=<?php echo $activity_id;?>&openid=<?php echo $openid;?>" style="outline:none;" />
	<area shape="rect" coords="14,72,306,124" href="#" style="outline:none;" />
</map></div>
</div>
<div id="bg" onclick="hideDiv();" style="display: none;">
	<img src="res/images/guide.png" alt="" style="position:fixed;top:0;right:16px;">
</div>
<?php include_once('common_footer.php');?>