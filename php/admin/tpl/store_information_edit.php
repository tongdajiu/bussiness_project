<link href="../res/js/highslide/highslide.css" rel="stylesheet" type="text/css" />
<style>
	.highslide-footer{height:60px;}
	.highslide-footer ul{text-align:center;padding:10px 0;}
	.highslide-footer ul li{display:inline-block;}
	.highslide-footer .continue{display:block;border:1px solid #C4CCCC;border-right:1px solid #AEB7B4;padding:6px 12px;font-weight:bold;font-size:14px;color:#333;background:#F8EFAE;background:-webkit-gradient(linear,0 0,0 bottom,from(#F8EFAE),to(#F1D557));background:-moz-linear-gradient(#F8EFAE,#F1D557);background:linear-gradient(#F8EFAE,#F1D557);filter:progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#F8EFAE,endColorStr=#F1D557);-webkit-box-shadow:1px 1px 3px #6F7777;cursor:pointer}
</style>
<script type="text/javascript" src="../res/js/highslide/highslide-full.js"></script>
<script type="text/javascript">
hs.skin.contentWrapper='<div class="highslide-header"></div>'+
		'<div class="highslide-body"></div>'+
		'<div class="highslide-footer"><div><ul>'+
			'<li>'+
				'<a href="#" title="确定" class="continue" onclick="getUid()">'+
				'<span>确定</span></a>'+
			'</li>'+
			'<li class="highslide-close">'+
				'<a href="#" title="关闭" class="continue" onclick="return hs.close(this)">'+
				'<span>关闭</span></a>'+
			'</li>'+
			'</ul><span class="highslide-resize" title="{hs.lang.resizeTitle}"><span></span></span>'+
		'</div></div>';
hs.showCredits = 0;
hs.padToMinWidth = true;
hs.preserveContent = false;
hs.graphicsDir = '../res/js/highslide/graphics/';
hs.outlineType = 'rounded-white';
//hs.wrapperClassName = 'draggable-header';
hs.align = 'center';
hs.Expander.prototype.onAfterGetContent = function (sender) {
   // get the controlbar
   var ul = sender.content.getElementsByTagName("ul")[0];

   // create a list item
   var li = document.createElement("li");
   ul.appendChild(li);

   // create an anchor
   var a = document.createElement("a");
   a.href = "javascript:getUid()";

}
function getUid(){
	var uid = $("#highsIframe").contents().find("input[type='radio']:checked").val();
	var name = $("#highsIframe").contents().find("input[type='radio']:checked").parents("td").next().text();
	var openid = $("#highsIframe").contents().find("input[type='radio']:checked").parent().find("span").text()
	if(uid >=0){
		$("#uid").val(uid);
		$(".uidName").html("【"+openid+"】"+name);
		hs.close()
	}
}
</script>
<form action="?module=store_information_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save">
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">编辑门店资料</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">门店名称:<font style="color:#f00;">*</font></label>
<input type="text" value="<?php echo $obj->name;?>" name="name" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">详细地址:<font style="color:#f00;">*</font></label>
<input type="text" id="address" value="<?php echo $obj->address;?>" name="address" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">位置定位:</label>
<input id="areaSearch" type="hidden" value="搜索" style="cursor: pointer" />
<div style="width:400px; height:400px; border: 1px solid gray;" id="container"></div>

<div id="Div1">
	<div>
		<div class="sel_container"><strong id="curCity"></strong><a id="curCityText" href="javascript:void(0)"></a></div>
		<div class="map_popup" id="cityList" style="display: none;">
			<div class="popup_main">
				<div class="title">城市列表</div>
				<div class="cityList" id="citylist_container"></div>
				<button id="popup_close"></button>
			</div>
		</div>
	</div>
</div>

</li>

<li>
<label class="labelName">经度:<font style="color:#f00;">*</font></label>
<input type="text" id="longitude" value="<?php echo $obj->longitude;?>" readonly name="longitude" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">纬度:<font style="color:#f00;">*</font></label>
<input type="text" id="latitude" value="<?php echo $obj->latitude;?>" readonly name="latitude" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">联系手机:<font style="color:#f00;">*</font></label>
<input type="text" id="mobile" value="<?php echo $obj->mobile;?>" name="mobile" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">负责人:<font style="color:#f00;">*</font></label>
<input type="hidden" id="uid" value="<?php echo $obj->uid;?>" name="uid" class="regTxt" />
<span class="uidName">【<?php echo $user_obj->openid;?>】<?php echo $user_obj->name;?></span>
<a href="search_user.php" class="highslide" onclick="return hs.htmlExpand( this, {objectType: 'iframe',  width: 550, height: 550, color:'red'} )">选择负责人</a>
<div class="clear"></div>
</li>

</ul>
</dd>
</dl>
<div class="clear"></div>
<p style="float:left; padding-left:10%;"></p>
<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue"  value=" 清空 " /></p>
</div>
</div>
</form>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php global $gSetting;echo $gSetting['baidu_map_keys'];?>"></script>
<script type="text/javascript">
var map = new BMap.Map("container");

map.centerAndZoom(new BMap.Point(<?php echo $obj->longitude;?>, <?php echo $obj->latitude;?>), 19);
map.addOverlay(new BMap.Marker(new BMap.Point(<?php echo $obj->longitude;?>, <?php echo $obj->latitude;?>))); // 创建标注的坐标

map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

map.addEventListener("click",function(e) {
	document.getElementById("latitude").value = e.point.lat;
	document.getElementById("longitude").value = e.point.lng;
	map.clearOverlays();
	var pointMarker = new BMap.Point(e.point.lng, e.point.lat); // 创建标注的坐标
	var marker = new BMap.Marker(pointMarker);
	map.addOverlay(marker);
});
</script>
<script>
$(function(){
	jQuery.validator.addMethod("telphone", function(value, element) {
	    var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$|(^(13[0-9]|15[0|3|6|7|8|9]|18[8|9])\d{8}$)/;
	    return this.optional(element) || (tel.test(value));
	}, "请填写正确的联系方式.");
	$("#regform").validate({
        rules: {
		   "name": {required: true},
		   "address": {required: true},
		   "mobile": {required: true,telphone: true}
  		}
    });
})
</script>