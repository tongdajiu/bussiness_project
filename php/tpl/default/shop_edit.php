<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">店铺信息编辑</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<form action="shop_info.php?myself" method="post" enctype="multipart/form-data"  >
<div class="index-wrapper">

    <div class="add-txt">

    <ul class="add-txt-ul">
		<li><span class="add-txt-item">店铺名称</span><input id="name" name="name" type="text" value="<?php echo $shop_info->name;?>" class="add-txt-name" placeholder="<?php echo $user->name;?>"/></li>
		<li><span class="add-txt-item">店铺Logo</span>
			<div class="add-txt-width-box">
			<input id="icon" name="icon" type="file" value="" onchange="fileChange(this);"/>
			<br/>
			<?php renderPic($shop_info->icon, $sizetype='small', $type='logo', $size=array(), $info=array('style'=>"width:200px;height:200px;"), $echo=true) ?>
			<input type="hidden" name="old_icon" value="<?php echo $shop_info->icon;?>" />
			</div>
		</li>

		<li><span class="add-txt-item">&nbsp;</span><input type="submit" value="保 存" class="add-button" /></li>
	</ul>

    </div>
</div>
</form>
<script type="text/javascript">
var isIE = /msie/i.test(navigator.userAgent) && !window.opera;
function fileChange(target,id) {
var fileSize = 0;
var filetypes =[".jpg",".png",".jpeg",".pjpeg"];
var filepath = target.value;
var filemaxsize = 1024*2;//2M
if(filepath){
var isnext = false;
var fileend = filepath.substring(filepath.indexOf("."));
if(filetypes && filetypes.length>0){
for(var i =0; i<filetypes.length;i++){
if(filetypes[i]==fileend){
isnext = true;
break;
}
}
}
if(!isnext){
alert("不接受此文件类型！");
target.value ="";
return false;
}
}else{
return false;
}
if (isIE && !target.files) {
var filePath = target.value;
var fileSystem = new ActiveXObject("Scripting.FileSystemObject");
if(!fileSystem.FileExists(filePath)){
alert("附件不存在，请重新输入！");
return false;
}
var file = fileSystem.GetFile (filePath);
fileSize = file.Size;
} else {
fileSize = target.files[0].size;
}

var size = fileSize / 1024;
if(size>filemaxsize){
alert("附件大小不能大于"+filemaxsize/1024+"M！");
target.value ="";
return false;
}
if(size<=0){
alert("附件大小不能为0M！");
target.value ="";
return false;
}
}
</script>
<?php include "footer_web.php";?>
<?php include_once('common_footer.php');?>