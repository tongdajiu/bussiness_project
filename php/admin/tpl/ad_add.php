<script>
var picWidth = 0,picHeight = 0;
$(function(){
  picWidth = $(this).find("option:selected").attr("data-imgWidth");
  picHeight = $(this).find("option:selected").attr("data-imgHeight");
  $("#type_tips .ottTips").html("请选择信息类型");
	$("#type").on("change", function(){
		($(type).val() == "3") ? $("#typeclass").show() : $("#typeclass").hide();
    var width = $(this).find("option:selected").attr("data-imgWidth");
    var height = $(this).find("option:selected").attr("data-imgHeight");
    picWidth = width, picHeight = height;
    if(width==0 && height==0){
      $("#type_tips .ottTips").html("请选择信息类型");
    }else{
      $("#type_tips .ottTips").html("请上传图片,尺寸如"+ width +" * "+height);
    }
    $("#id-input-file-3").val("");
	});

  $(document).delegate("#id-input-file-3","change",function(){
    var _this = $(this);
    var url = _this.val();
    var width = picWidth, height = picHeight;
    if (window.createObjectURL != undefined) { // basic
      url = window.createObjectURL(_this.get(0).files[0]);
    } else if (window.URL != undefined) { // mozilla(firefox)
      url = window.URL.createObjectURL(_this.get(0).files[0]);
    } else if (window.webkitURL != undefined) { // webkit or chrome
      url = window.webkitURL.createObjectURL(_this.get(0).files[0]);
    }
    var img = new Image();
    img.src = url;
    img.onload=function(){
      if(width==0 && height==0){
        _this.val("");
        alert("请选择信息类型");
        return false;
      }else if(img.width!=width && img.height != height){
        _this.val("");
        alert("请上传尺寸为 "+ width +" * "+ height +" 的图片");
        return false;
      }
    };
  });

});
</script>

<form action="?module=ad_action" id="regform" class="cmxform"
	method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="add_save" /> <input
		type="hidden" name="status" value="1" /> <input type="hidden"
		name="type" value="512" />
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">首页图片添加</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li><label class="labelName">标题:<font style="color: #f00;">*</font></label>
							<input type="text" id="form-field-icon-1" value="" name="title"
							class="regTxt" />
							<div class="clear"></div></li>
						<li><label class="labelName">链接:<font style="color: #f00;">*</font></label>
							<input type="text" id="form-field-1" placeholder="" name="url"
							class="regTxt" />
							<div class="clear"></div></li>
						<li><label class="labelName">信息类型:<font style="color: #f00;">*</font></label>
							<select id="type" name="type">
								<option data-imgWidth="0" data-imgHeight="0" value="">--</option>
								<option data-imgWidth="640" data-imgHeight="430" value="1"
									<?php if($obj['type']== 1){echo "selected";}?>>首页主推图</option>
								<option data-imgWidth="640" data-imgHeight="320" value="2"
									<?php if($obj['type']== 2){echo "selected";}?>>首页滚动图</option>
								<option data-imgWidth="172" data-imgHeight="47" value="3"
									<?php if($obj['type']== 3){echo "selected";}?>>分类</option>
								<option data-imgWidth="640" data-imgHeight="320" value="4"
									<?php if($obj['type']== 4){echo "selected";}?>>首页广告图</option>
						</select> <select id="typeclass" name="typeclass"
							style="display: none">
								<option value="">--</option>
        <?php foreach($productType as $pt){?>
        <option value="<?php echo $pt->id;?>"><?php echo $pt->name;?></option>
        <?php }?>
</select> <br />
							<div class="clear"></div></li>
						<li><label class="labelName">状态:</label> <select id="state"
							name="status" class="select" style="WIDTH: 100PX;">
								<option value="0"
									<?php if($obj['status']== 0){echo "selected";}?>>禁用</option>
								<option value="1"
									<?php if($obj['status']== 1){echo "selected";}?>>启用</option>
						</select>
							<div class="clear"></div></li>
						<li><label class="labelName">请上传图片：<font style="color: #f00;">*</font></label>
							<input multiple type="file" id="id-input-file-3" name="images"
							accept="image/gif, image/jpeg, image/png, image/jpg" />
							<div id="type_tips">
								<p class="ottTips"></p>
							</div>
							<div class="clear"></div></li>


					</ul>
				</dd>
			</dl>
			<div class="clear"></div>
			<p style="float: left; padding-left: 10%;"></p>
			<p class="continue">
				<input type="submit" class="continue" id="btn_next" value=" 确定 " /><input
					type="reset" class="continue" id="btn_next" value=" 重置 " />
			</p>
		</div>
	</div>
</form>
<script>
$(function(){
	$("#regform").validate({
        rules: {
		   "title": {
			   required: true
		   },
		   "url": {
			   required: true,
			   url: true
		   },
		   "type": {
			   required: true
		   },
		   "images": {
			   required: true
		   }
  		}
    });
})
</script>