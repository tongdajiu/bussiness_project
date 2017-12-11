<form action="?module=wx_coupon" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="add_save">
	<input type="hidden" name="status" value="1">
	<input type="hidden" name='from' value="<?php echo isset($_GET['from']) ? $_GET['from'] : '' ?>">
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">添加微信优惠券</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">

						<li>
							<label class="labelName">优惠券类型：</label>
							<select name="card_type" id="card_type" class="srchField selectField">
								<option value="1">代金券</option>
								<!--
								<option value="0">团购券</option>
								<option value="2">折扣券</option>
								<option value="3">礼品券</option>
								<option value="4">优惠券</option>
								-->
							</select>
							<div class="clear"></div>
						</li>

						<li class="type_warp" >
							<label class="labelName">团购详情:<font style="color:#f00;">*</font></label>
							<input type="text" id="deal_detail" value="" name="deal_detail" class="regTxt" />
							<span style="font-size:10px;">（示例：双人套餐\n -进口红酒一支。\n孜然牛肉一份。）</span>
							<div class="clear"></div>
						</li>

						<div class="type_warp">
							<li>
								<label class="labelName">起用金额:<font style="color:#f00;">*</font></label>
								<input type="text" id="least_cost" value="" name="least_cost" class="regTxt" />
								<span style="font-size:10px;">（表示起用金额（单位为分）,如果无起用门槛则填0。）</span>
								<div class="clear"></div>
							</li>

							<li>
								<label class="labelName">减免金额:<font style="color:#f00;">*</font></label>
								<input type="text" id="reduce_cost" value="" name="reduce_cost" class="regTxt" />
								<span style="font-size:10px;">（表示减免金额。（单位为分））</span>
								<div class="clear"></div>
							</li>
						</div>

						<li class="type_warp" >
							<label class="labelName">打折额度:<font style="color:#f00;">*</font></label>
							<input type="text" id="discount" value="" name="discount" class="regTxt" />
							<span style="font-size:10px;">（表示打折额度（百分比）。填30就是七折。）</span>
							<div class="clear"></div>
						</li>

						<li class="type_warp" >
							<label class="labelName">礼品名称:<font style="color:#f00;">*</font></label>
							<input type="text" id="gift" value="" name="gift" class="regTxt" />
							<span style="font-size:10px;">（填写礼品的名称）</span>
							<div class="clear"></div>
						</li>

						<li class="type_warp" >
							<label class="labelName">优惠详情:<font style="color:#f00;">*</font></label>
							<input type="text" id="default_detail" value="" name="default_detail" class="regTxt" />
							<span style="font-size:10px;">（例如：音乐木盒）</span>
							<div class="clear"></div>
						</li>

						<h3 style="margin:10px 100px;">卡券基础信息字段</h3>

						<li style="height:60px;">
							<label class="labelName">商户logo:<font style="color:#f00;">*</font></label>
							<div class="fileupload noneImg" style="float:left;width:60px;height:60px;margin-right:260px;">
								<div class="fileupload_loading"></div>
								<div class="fileupload_tips">上传<br/>Logo</div>
								<div class="fileupload_img"></div>
								<input id="fileupload" type="file" name="files" title="上传图片" accept="image/gif, image/jpeg, image/png, image/jpg" multiple />
								<input type="hidden" id="logo_url" value="" name="logo_url" class="regTxt" />
							</div>
							 <span style="font-size:10px;">　建议像素为300*300</span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">Code展示类:<font style="color:#f00;">*</font></label>
							<select name="code_type" id="code_type" class="srchField selectField">
								<option value="CODE_TYPE_TEXT">文本</option>
								<!--
								<option value="CODE_TYPE_BARCODE">一维码</option>
								<option value="CODE_TYPE_QRCODE">二维码</option>
								<option value="CODE_TYPE_ONLY_QRCODE">二维码无code显示</option>
								<option value="CODE_TYPE_ONLY_BARCODE">一维码无code显示</option>
								-->
							</select>
							<span style="font-size:10px;"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">商户名字:<font style="color:#f00;">*</font></label>
							<input type="text" id="brand_name" value="" name="brand_name" class="regTxt" />
							<span style="font-size:10px;">　字数上限为12个汉字</span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">卡券名:<font style="color:#f00;">*</font></label>
							<input type="text" id="title" value="" name="title" class="regTxt" />
							<span style="font-size:10px;">（例如：双人套餐100元兑换券）</span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">券名:</label>
							<input type="text" id="sub_title" value="" name="sub_title" class="regTxt" />
							<span style="font-size:10px;">　字数上限为18个汉字（例如：鸳鸯锅底+牛肉1份+土豆一份）</span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">券颜色:<font style="color:#f00;">*</font></label>
							<select name="color" id="color">
								<?php foreach( $arrCouponColor as $key=>$CouponColor ){ ?>
									<option value="<?php echo $key; ?>" style="color:#fff; background:<?php echo $key; ?>"><?php echo $CouponColor; ?></option>
								<?php } ?>
							</select>
							<span class="color_show" style="background:#63b359; width:80px;">　　　　　　</span>
							<span style="font-size:10px;"></span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">卡券使用提醒:<font style="color:#f00;">*</font></label>
							<input type="text" id="notice" value="" name="notice" class="regTxt" />
							<span style="font-size:10px;">　字数上限为16个汉字。（例如：请出示二维码核销卡券）</span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">卡券使用说明:<font style="color:#f00;">*</font></label>
							<input type="text" id="description" value="" name="description" class="regTxt" />
							<span style="font-size:10px;">（例如：不可与其他优惠同享。）</span>
							<div class="clear"></div>
						</li>
<!--
						<li>
							<label class="labelName">商品信息:<font style="color:#f00;">*</font></label>
							<input type="text" id="sku" value="" name="sku" class="regTxt" />
							<span style="font-size:10px;">　Json结构 (例如： {"quantity": 500000 })</span>
							<div class="clear"></div>
						</li>
-->
						<li>
							<label class="labelName">卡券库存的数量:<font style="color:#f00;">*</font></label>
							<input type="text" id="quantity" value="" name="quantity" class="regTxt" />
							<span style="font-size:10px;">　上限为100000000</span>
							<div class="clear"></div>
						</li>
<!--
						<li>
							<label class="labelName">使用日期:</label>
							<input type="text" id="date_info" value="" name="date_info" class="regTxt" />
							<span style="font-size:10px;">　Json结构。</span>
							<div class="clear"></div>
						</li>
-->
						<li class="showTime">
							<label class="labelName">使用时间的类型:<font style="color:#f00;">*</font></label>
							<select name="type" id="type" class="srchField selectField">
								<option value="0">固定日期区间</option>
								<option value="1">固定时长（自领取后按天算）</option>
							</select>
							<div class="clear"></div>
						</li>

						<li class="time_type_warp">
							<label class="labelName">起用时间:<font style="color:#f00;">*</font></label>
							<input type="text" id="begin_timestamp" value="" name="begin_timestamp" class="regTxt" onfocus="WdatePicker()" />
							<span style="font-size:10px;">　格式：2016-01-01</span>
							<div class="clear"></div>
						</li>


						<div class="time_type_warp">
							<li>
								<label class="labelName">自领取后多少天内有效:<font style="color:#f00;">*</font></label>
								<input type="text" id="fixed_term" value="" name="fixed_term" class="regTxt" />
								<span style="font-size:10px;"></span>
								<div class="clear"></div>
							</li>

							<li class="showTime">
								<label class="labelName">领取后多少天开始生效:<font style="color:#f00;">*</font></label>
								<input type="text" id="fixed_begin_term" value="" name="fixed_begin_term" class="regTxt" />
								<span style="font-size:10px;"></span>
								<div class="clear"></div>
							</li>
						</div>

						<li class="showTime">
							<label class="labelName">结束时间:<font style="color:#f00;">*</font></label>
							<input type="text" id="end_timestamp" value="" name="end_timestamp" class="regTxt" onfocus="WdatePicker()" />
							<span style="font-size:10px;">　卡券统一过期时间 （格式：2016-01-01）</span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">可领数量:</label>
							<input type="text" id="get_limit" value="1" name="get_limit" class="regTxt" />
							<span style="font-size:10px;">　每人可领券的数量限制</span>
							<div class="clear"></div>
						</li>

						<li>
							<label class="labelName">有效性:<font style="color:#f00;">*</font></label>
							<select name="status" id="status" class="srchField selectField">
								<option value="1">有效</option>
								<option value="0">失效</option>
							</select>

							<div class="clear"></div>
						</li>
					</ul>
				</dd>
			</dl>
			<div class="clear"></div>

			<p style="float:left; padding-left:10%;"></p>
			<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
		</div>
	</div>
</form>
<script src="../res/js/jquery.ui.widget.js"></script>
<script src="../res/js/jquery.iframe-transport.js"></script>
<script src="../res/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
<script>
	$(function(){

		show();
		showTime();
		chooseColor();

		$('#card_type').bind('change',show);
		$('#type').bind('change',showTime);
		$('#color').bind('change',chooseColor);

		function show()
		{
			$key = $('#card_type').val();
			$('.type_warp').hide();
			$('.type_warp').eq($key).show();
		}

		function showTime()
		{
			$key = $('#type').val();
			$('.time_type_warp').hide();
			$('.time_type_warp').eq($key).show();
		}

		function chooseColor()
		{
			$key = $('#color').val();
			var mycss = {
				background: $key,

				margin: '5px 0 0',
				padding: '2px',
				border: '1px solid #999'
			};

			$(".color_show").css(mycss);
		}

		//上传logo
		$('#fileupload').fileupload({
	        autoUpload: true,//是否自动上传
	        url: "/uFile.php",//上传地址
	        dataType: 'json',
	        success: function (data, status){//设置文件上传完毕事件的回调函数
	            //alert(data.data);
	            if(data.code > 0){
	            	$(".fileupload_img").append("<img src='../upfiles/wxcoupon/"+ data.data +"' />");
	            	$(".fileupload_loading,.fileupload_tips").hide();
	            	$("#logo_url").val(data.data);
	            }else{
	            	alert(data.msg);
	            	$(".fileupload_loading").hide();
	            }
	        },
	        error: function() {
	        	alert("图片上传失败，请重试");
	        },
            progressall: function (e, data) {//设置上传进度事件的回调函数
                $(".fileupload_loading").show();
            }
	    });

	    //验证
		$("#regform").validate({
	        rules: {
			   "deal_detail": {
				   required: true
			   },
			   "brand_name": {
				   required: true
			   },
			   "title": {
				   required: true
			   },
			   "begin_timestamp": {
				   required: true
			   },
			   "end_timestamp": {
				   required: true
			   },
			   "sub_title": {
				   required: true
			   },
			   "notice": {
				   required: true
			   },
			   "description": {
				   required: true
			   },
			   "sku": {
				   required: true
			   },
			   "quantity": {
				   required: true
			   },
			   "least_cost": {
				   required: true
			   },
			   "reduce_cost": {
				   required: true
			   },
			   "get_limit": {
				   required: true
			   }
	  		},
	  		submitHandler: function(form){
	  			if($(".fileupload_img img").length>0){
	  				$(form).ajaxSubmit();
	  			}else{
	  				alert("请上传商户logo");
	  			}			
			}
	    });


	});
</script>