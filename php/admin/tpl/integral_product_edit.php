<form action="?module=integral_product_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save" />
<input type="hidden" name="id" value="<?php echo $obj->id;?>" />
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">编辑积分商品信息</div>
 <dl class="ott">
<dd>
<ul class="ottList">

<li>
<label class="labelName">积分商品名称:<font style="color:#f00;">*</font></label>
<input type="text" name="name" class="regTxt" value="<?php echo $obj->name;?>" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">商品图片:</label>
<input type="file" id="image" name="image" class="regTxt" onchange="fileChange(this);" />
<p style="clear:both;padding-left:212px;"><?php renderPic($obj->image, 'small', 5,array('h'=>150));?></p>
<div class="clear"></div>
</li>

<li>
<label class="labelName">库存:<font style="color:#f00;">*</font></label>
<input type="text" id="inventory" value="<?php echo $obj->inventory;?>" name="inventory" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">兑换积分（取整数）:<font style="color:#f00;">*</font></label>
<input type="text" id="integral" value="<?php echo $obj->integral;?>" name="integral" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">商品详情:</label>
<div style="margin-left:212px;"><script id="editor" type="text/plain" style="width:500px;height:240px;"><?php echo $obj->description;?></script></div>
<input type="hidden" id="description" value="" name="description" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">排序:<font style="color:#f00;">*</font></label>
<input type="text" id="sorting" value="<?php echo $obj->sorting;?>" name="sorting" class="regTxt" />
<div class="clear"></div>
</li>


</ul>
</dd>
</dl>
<div class="clear"></div>
<p style="float:left; padding-left:10%;"></p>
<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue"  value=" 重置 " /></p>
</div>
</div>
</form>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.all.min.js"> </script>
<script language="javascript">
	var ue = UE.getEditor('editor');
	window.onload=function(){
		var btn_next=document.getElementById("btn_next");
		var mycontent=document.getElementById("description");
		btn_next.onclick=function(){
			mycontent.value=ue.getContent();
			return true;
		}
	}
</script>
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
<script>
$(function(){
	$("#regform").validate({
        rules: {
		   "name": {required: true},
		   "inventory": {
			   required: true,
			   digits:true 
				},
		   "integral": {
			   required: true,
			   digits:true 
			},
		   "sorting": {
			   required: true,
			   digits:true 
			}
  		},
  		messages: {
  			"name": {required: "必填"},
 		   "inventory": {
 			   required: "必填",
 			   digits:"只能输入整数" 
 				},
 		   "integral": {
 			  required: "必填",
			  digits:"只能输入整数" 
 			},
 		   "sorting": {
 			  required: "必填",
			   digits:"只能输入整数" 
 			}
	    }
    });
})
</script>