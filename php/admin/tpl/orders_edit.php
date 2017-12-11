<script src="../res/js/jquery.autocomplete.js" type="text/javascript"></script>
<link href="../res/css/jquery.autocomplete.css" type="text/css" rel="stylesheet"/>
<script src="../res/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="../umeditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
	$(function(){
		$("#pay_method").find("option[value='<?php echo $obj->pay_method; ?>']").attr("selected","selected");
		$("#order_status_id").find("option[value='<?php echo $obj->order_status_id; ?>']").attr("selected","selected");
		$("input[name='abolishment_status'][value='<?php echo $obj->abolishment_status; ?>']").attr("checked","checked");
		$("#express_type").find("option[value='<?php echo $obj->express_type; ?>']").attr("selected","selected");
	});
</script>
<form action="?module=orders_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save">
<input type="hidden" name="id" value="<?php echo $obj->order_id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">订单详情</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">订单号:</label><label style="vertical-align: middle;line-height:30px;"><strong><?php echo $obj->order_number; ?></strong></label>
<div class="clear"></div>
</li>
<li>
<label class="labelName">客户:</label><label style="vertical-align: middle;line-height:30px;"><strong><?php echo $obj_customer->name; ?></strong></label>
<div class="clear"></div>
</li>
<li>
<label class="labelName">订单状态:<font style="color:#f00;">*</font></label>
<select id="order_status_id" name="order_status_id">
<?php while(list($key,$val) = each($OrderStatus)){ ?>
	<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
<?php } ?>
</select>
<div class="clear"></div>
</li>
<li>
<label class="labelName">物流类型:</label>
<select id="express_type" name="express_type">
<?php while(list($key,$val) = each($ExpressType)){ ?>
	<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
<?php } ?>
</select>
<div class="clear"></div>
</li>
<li>
<label class="labelName">物流编号:</label>
<input type="text" id="express_number" value="<?php echo $obj->express_number; ?>" name="express_number" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">支付方式:<font style="color:#f00;">*</font></label>
<select id="pay_method" name="pay_method">
<option value="0">无</option>
<?php while(list($key,$val) = each($PayMethod)){ ?>
	<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
<?php } ?>
</select>
<div class="clear"></div>
</li>
<li>
<label class="labelName">联系电话:<font style="color:#f00;">*</font></label>
<input type="text" id="telephone" value="<?php echo $obj->telephone; ?>" name="telephone" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">固定电话:</label>
<input type="text" id="cellphone" value="<?php echo $obj->cellphone; ?>" name="cellphone" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">收货人姓名:<font style="color:#f00;">*</font></label>
<input type="text" id="shipping_firstname" value="<?php echo $obj->shipping_firstname; ?>" name="shipping_firstname" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">详细地址:<font style="color:#f00;">*</font></label>
<input type="text" id="shipping_address_1" value="<?php echo $obj->shipping_address_1; ?>" name="shipping_address_1" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">备用详细地址:</label>
<input type="text" id="shipping_address_2" value="<?php echo $obj->shipping_address_2; ?>" name="shipping_address_2" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">电子邮箱:</label>
<input type="text" id="email" value="<?php echo $obj->email; ?>" name="email" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">邮编:</label>
<input type="text" id="shipping_postcode" value="<?php echo $obj->shipping_postcode; ?>" name="shipping_postcode" class="regTxt" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">发货方式:</label>
<select id="shipping_method" name="shipping_method">
<?php while(list($key,$val) = each($ShippingMtthod)){ ?>
	<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
<?php } ?>
</select>
<div class="clear"></div>
</li>
<li>
<label class="labelName">备注:</label>
<div style="margin-left:212px;" >
<script id="editor" type="text/plain" style="width:590px;height:240px;"><?php echo $obj->remark?></script>
</div>
<input type="hidden" name="remark" value="" id="remark" />
<div class="clear"></div>
</li>
<li>
<label class="labelName">实体店:</label>
<input type="radio" id="status_introduce1" name="status_introduce" value="1" <?php if($obj->status_introduce == 1){echo "checked";}?> /><label for="status_introduce1">是</label>
<input type="radio" id="status_introduce0" name="status_introduce" value="0" <?php if($obj->status_introduce == 0){echo "checked";}?> /><label for="status_introduce0">否</label>
<div class="clear"></div>
</li>
  </ul>
   </dd>
    </dl>
   <div class="clear"></div>
   <div id="tablewrapper">
   		<table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
            		<th><h3>图片</h3></th>
            		<th><h3>名称</h3></th>
            		<th><h3>规格</h3></th>
            		<th><h3>货号</h3></th>
            		<th><h3>价格</h3></th>
            		<th><h3>数量</h3></th>
            		<th><h3>小计</h3></th>
            	</tr>
            </thead>
            <tbody>
<?php
	$i = 0;
	foreach($cartList as $cart){
		$i++;
?>
            	<tr>
					<td><?php echo $i; ?></td>
					<td><?php renderPic($cart->product_image, 'small', 1,array('h'=>100));?></td>
					<td><?php echo $cart->product_name; ?></td>
					<td><?php echo $cart->attribute; ?></td>
					<td><?php echo $cart->model; ?></td>
					<td><?php echo $cart->product_price;?></td>
					<td><?php echo $cart->shopping_number; ?></td>
					<td><?php echo number_format($cart->product_price * $cart->shopping_number,2); ?></td>
				</tr>
<?php
	}
?>
            </tbody>
        </table>
    </div>
  <p style="float:left; padding-left:10%;"></p>
  <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
   </div>
  </div>
  </form>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.all.min.js"> </script>
<script language="javascript">
	var ue = UE.getEditor('editor');
	window.onload=function(){
		var btn_next=document.getElementById("btn_next");
		var mycontent=document.getElementById("remark");
		btn_next.onclick=function(){
			mycontent.value=ue.getContent();
			return true;
		}
	}
</script>
<script type="text/javascript">
    $().ready(function(){
		$("#btn_next").click(function(){

			regform.remark.value=UM.getEditor('myEditor1').getContent();
			//regform.submit();
			return true;
		});

		jQuery.validator.addMethod("tel", function(value, element) {
		    var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+$/;
		    return this.optional(element) || (tel.test(value));
		}, "请输入正确的电话号码");
		jQuery.validator.addMethod("phone", function(value, element) {
		    var tel = /^(\-[0-9]{1,4})?$|(^(13[0-9]|15[0|3|6|7|8|9]|18[8|9])\d{8}$)/;
		    return this.optional(element) || (tel.test(value));
		}, "请输入正确的手机号码");
		jQuery.validator.addMethod("zipCode", function(value, element) {
		    var tel = /^[1-9]\d{5}(?!\d)$/;
		    return this.optional(element) || (tel.test(value));
		}, "请输入正确的邮政编码");
		$("#regform").validate({
	        rules: {
			   "telephone": {
				   required: true,
				   phone: true
			   },
			   "cellphone": {
				   tel: true
			   },
			   "shipping_firstname": {
				   required: true
			   },
			   "shipping_address_1": {
				   required: true
			   },
			   "email": {
				   email: true
			   },
			   "shipping_postcode": {
				   zipCode: true
			   }
	  		}
	    });
    });
</script>