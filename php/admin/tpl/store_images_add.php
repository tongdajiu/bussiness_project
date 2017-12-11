<form action="?module=store_images_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="post">
<input type="hidden" name="store_id" value="<?php echo $store_id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">添加门店图册</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">图片:<font style="color:#f00;">*</font></label>
<input type="file" id="image" name="image" class="regTxt" onchange="fileChange(this);" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">排序:<font style="color:#f00;">*</font></label>
<input type="text" id="sorting" value="0" name="sorting" class="regTxt" />
<div class="clear"></div>
</li>
<li>

</ul>
</dd>
</dl>
<div class="clear"></div>
<p style="float:left; padding-left:10%;"></p>
<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue"  value=" 重置 " /></p>
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