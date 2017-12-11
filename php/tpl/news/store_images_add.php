<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">门店图册添加</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>
<form action="store_images.php" method="post" enctype="multipart/form-data" onsubmit="return imgsubmit();" >
	<input type="hidden" name="act" value="post" />
	<input type="hidden" name="store_id" value="<?php echo $store_id;?>" />
	<div class="bodyContent">
		<div class="store_img_add">
			<input type="file" name="image" id="img" />
			<div class="store_img_add_tips">
				<img src="../res/images/add.jpg" onclick="img_choose()" />
			</div>
			<div class="store_img_add_main" style="display:none;">
				<img src="" onclick="img_choose()" />
			</div>
		</div>
	</div>
	<input type="submit" value="添 加" class="add-button" style="display:block;margin:20px auto;" />
</form>
<script>

function img_choose(){
	$("#img").trigger('click');
}

var isIE = /msie/i.test(navigator.userAgent) && !window.opera;
function fileChange(target, id) {
	var fileSize = 0;
	var filetypes = [".jpg", ".png", ".jpeg", ".pjpeg"];
	var filepath = target.value;
	var filemaxsize = 1024 * 2; //2M
	if (filepath) {
		var isnext = false;
		var fileend = filepath.substring(filepath.indexOf("."));
		if (filetypes && filetypes.length > 0) {
			for (var i = 0; i < filetypes.length; i++) {
				if (filetypes[i] == fileend) {
					isnext = true;
					break;
				}
			}
		}
		if (!isnext) {
			alert("不接受此文件类型！");
			target.value = "";
			return false;
		}
	} else {
		return false;
	}

	if (isIE && !target.files) {
		var filePath = target.value;
		var fileSystem = new ActiveXObject("Scripting.FileSystemObject");
		if (!fileSystem.FileExists(filePath)) {
			alert("附件不存在，请重新输入！");
			return false;
		}

		var file = fileSystem.GetFile(filePath);
		fileSize = file.Size;
	} else {
		fileSize = target.files[0].size;
	}

	var size = fileSize / 1024;
	if (size > filemaxsize) {
		alert("附件大小不能大于" + filemaxsize / 1024 + "M！");
		target.value = "";
		return false;
	}
	if (size <= 0) {
		alert("附件大小不能为0M！");
		target.value = "";
		return false;
	}
	return true;
}

function imgsubmit(){
	var aval = $("#img").val();

	if(aval=='' || aval==null){
		alert("请选择图片")
		return false;
	}
}

$(function(){
	$("#img").on("change",function(){
		var _this = $(this);
		var addState = fileChange(this);
		if(addState){
			var url = _this.val();
			if (window.createObjectURL != undefined) { // basic
				url = window.createObjectURL(_this.get(0).files[0]);
			} else if (window.URL != undefined) { // mozilla(firefox)
				url = window.URL.createObjectURL(_this.get(0).files[0]);
			} else if (window.webkitURL != undefined) { // webkit or chrome
				url = window.webkitURL.createObjectURL(_this.get(0).files[0]);
			}

			$(".store_img_add_tips").hide();
			$(".store_img_add_main").show()
				.find("img").attr("src",url);
		}else{
			$(".store_img_add_tips").show();
			$(".store_img_add_main").hide();
		}
	})
})
</script>

<?php include "tpl/footer_web.php";?>
<?php include_once('common_footer.php');?>