<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title"><?php echo $obj->name;?></div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="bodyContent">
	<h3 class="title_l_b"><i></i>门店信息<a href="store.php?act=edit&id=<?php echo $obj->id;?>" >编辑</a></h3>
	<ul class="add-txt-ul">
		<li><span class="add-txt-item2">门店名称：</span><?php echo $obj->name;?></li>
		<li><span class="add-txt-item2">详细地址：</span><?php echo $obj->address;?></li>
		<li><span class="add-txt-item2">联系电话：</span><?php echo $obj->mobile;?></li>
	</ul>

	<h3 class="title_l_b"><i></i>门店位置</h3>
	<div style="position:relative;width:100%;padding-bottom:60%;">
		<div style="position:absolute;width:100%; height:100%; border-bottom: 1px solid gray;" id="container"></div>
		<input type="hidden" value="<?php echo $obj->longitude;?>" name="longitude" id="longitude" />
		<input type="hidden" value="<?php echo $obj->latitude;?>" name="latitude" id="latitude" />
	</div>
	<div style="height:30px;"></div>
	<h3 class="title_l_b"><i></i>门店图片<a href="store_images.php?store_id=<?php echo $obj->id;?>" >编辑</a></h3>
	<div class="show_store_img">
		<?php if(!empty($imgList)){
				foreach($imgList as $row){
			 		renderPic($row->image, 'small', 4);
			 	}
			}else{ ?>
			<p>暂无门店图片，快去<a class="padding5 skinColor" href="store_images.php?store_id=<?php echo $obj->id;?>" >添加</a>吧</p>
		<?php	} ?>
	</div>

</div>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php global $gSetting;echo $gSetting['baidu_map_keys'];?>"></script>
<script type="text/javascript">
var map = new BMap.Map("container");

map.centerAndZoom(new BMap.Point(<?php echo $obj->longitude;?>, <?php echo $obj->latitude;?>), 19);
map.addOverlay(new BMap.Marker(new BMap.Point(<?php echo $obj->longitude;?>, <?php echo $obj->latitude;?>))); // 创建标注的坐标

map.addControl(new BMap.NavigationControl());
map.addControl(new BMap.ScaleControl());
map.addControl(new BMap.OverviewMapControl());
map.addControl(new BMap.MapTypeControl());

</script>
<?php include "tpl/footer_web.php";?>
<?php include_once('common_footer.php');?>
