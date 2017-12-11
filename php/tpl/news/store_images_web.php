<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">门店图册管理</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>
<div class="bodyContent">
	<ul class="store_img_list">
		<?php if(!empty($imgList)){
			foreach($imgList as $row){
		?>
		<li>
			<?php renderPic($row->image, 'small', 4); ?>
			<a href="store_images.php?act=del&store_id=<?php echo $store_id;?>&id=<?php echo $row->id;?>" onclick="javascript:return window.confirm('确定删除？');">删除</a>
		</li>
		<?php } } ?>
		<li><a style="height:100%;" href="store_images.php?act=add&store_id=<?php echo $store_id;?>" ><img src="../res/images/add.jpg" /></a></li>
	</ul>
</div>
<?php include "tpl/footer_web.php";?>
<?php include_once('common_footer.php');?>