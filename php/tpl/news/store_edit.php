<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">门店信息编辑</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>
<form action="store.php" method="post">
<input type="hidden" name="act" value="edit_save" />
<input type="hidden" name="id" value="<?php echo $obj->id;?>" />
	<div class="index-wrapper">
		<div class="add-txt">
			<ul class="add-txt-ul">
				<li>
					<p>门店名称：</p>
					<input id="name" name="name" type="text" value="<?php echo $obj->name;?>" class="add-txt-name2" />
				</li>
				<li>
					<p>详细地址：</p>
					<input id="address" name="address" type="text" value="<?php echo $obj->address;?>" class="add-txt-name2" />
				</li>
				<li>
					<p>位置定位：</p>
					<div style="position:relative;width:100%;padding-bottom:100%;">
						<div style="position:absolute;width:100%; height:100%; border: 1px solid gray;" id="container"></div>
						<input type="hidden" value="<?php echo $obj->longitude;?>" name="longitude" id="longitude" />
						<input type="hidden" value="<?php echo $obj->latitude;?>" name="latitude" id="latitude" />
					</div>
				</li>
				<li>
					<p>联系手机：</p>
					<input id="mobile" name="mobile" type="text" value="<?php echo $obj->mobile;?>" class="add-txt-name2" />
				</li>

				<li><span class="add-txt-item">&nbsp;</span><input type="submit" value="修 改" class="add-button" /></li>
			</ul>
		</div>
	</div>
</form>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php global $gSetting;echo $gSetting['baidu_map_keys'];?>"></script>
<script type="text/javascript">
var map = new BMap.Map("container");

map.centerAndZoom(new BMap.Point(<?php echo $obj->longitude;?>, <?php echo $obj->latitude;?>), 19);
map.addOverlay(new BMap.Marker(new BMap.Point(<?php echo $obj->longitude;?>, <?php echo $obj->latitude;?>))); // 创建标注的坐标

map.addControl(new BMap.NavigationControl());
map.addControl(new BMap.ScaleControl());
map.addControl(new BMap.OverviewMapControl());
map.addControl(new BMap.MapTypeControl());

map.addEventListener("click",function(e) {
	document.getElementById("latitude").value = e.point.lat;
	document.getElementById("longitude").value = e.point.lng;
	map.clearOverlays();
	var pointMarker = new BMap.Point(e.point.lng, e.point.lat); // 创建标注的坐标
	var marker = new BMap.Marker(pointMarker);
	map.addOverlay(marker);
});
</script>
<?php include "tpl/footer_web.php";?>
<?php include_once('common_footer.php');?>
