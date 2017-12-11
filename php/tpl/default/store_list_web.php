<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">门店列表</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>
<div class="add-txt">
	<h3 class="title_l_b"><i></i>您有以下<span class="skinColor padding5"><?php echo $store_num ?></span>个门店：</h3>
	<div class="store_list">
		<?php
		if(!empty($storeList)){
			foreach($storeList as $row){
		?>
			<a href="store.php?act=detail&id=<?php echo $row->id; ?>"><?php echo $row->name;?></a>
		<?php } } ?>
	</div>
</div>
<?php include "tpl/footer_web.php";?>
<?php include_once('common_footer.php');?>
