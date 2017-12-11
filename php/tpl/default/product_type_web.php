<?php include_once('common_header.php');?>
<style type="text/css">
*{margin:0; padding:0;}
body{
	font-family:"Microsoft yahei" !important;
	-webkit-tap-highlight-color:rgba(0, 0, 0 , 0);
	background-color:#fff;
	font-size:12px;
	color:#666;
}
img{border:none;}
 ul{ list-style:none;}
a{text-decoration:none; color:#666;}
.header_bg{ width:320px; height:122px; background:url(images/header_bg.png) no-repeat; background-size:320px 122px;}
.header_bg,.wdzh_box{ margin:0 auto;}
.wdzh_box{width:320px; overflow:hidden;}
.list-style{ margin-top:5px;}
</style>

<?php include_once('loading.php');?>
	<div class="wdzh_box">
		<div class="list-style"><a href="<?php echo $ad_index_list[4]->url; ?>"><img src="../product/small/<?php echo $ad_index_list[4]->image; ?>" width="320" height="81" /></a></div>
		<div class="list-style"><a href="<?php echo $ad_index_list[5]->url; ?>"><img src="../product/small/<?php echo $ad_index_list[5]->image; ?>" width="320" height="81" /></a></div>
		<!--
		<div class="list-style"><a href="<?php echo $ad_index_list[6]->url; ?>"><img src="../product/small/<?php echo $ad_index_list[6]->image; ?>" width="320" height="81" /></a></div>
		-->

	</div>
<?php include_once('common_footer.php');?>
