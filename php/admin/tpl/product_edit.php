<script src="../res/js/jquery.chained.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("input[name='hot'][value='<?php echo $proList->hot;?>']").attr("checked","checked");
		$("input[name='category_big'][value='<?php echo $proList->category_big;?>']").attr("checked","checked");
		$("#unit").find("option[value='<?php echo $proList->unit;?>']").attr("selected","selected");
		$("#category_id").find("option[value='<?php echo $proList->category_id;?>']").attr("selected","selected");
		$("#category_id2").find("option[value='<?php echo $proList->category_id2;?>']").attr("selected","selected");
	});
</script>
<form action="?module=product_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save">
<input type="hidden" name="product_id" value="<?php echo $proList->product_id;?>">
<input type="hidden" name="image_before" value="<?php echo $proList->image;?>">
<input type="hidden" name="viewed" value="<?php echo $proList->viewed;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">产品信息编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList">

<li>
<label class="labelName">名称:<font style="color:#f00;">*</font></label>
<input type="text" value="<?php echo $proList->name;?>" name="name" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">产品简单描述:<font style="color:#f00;">*</font></label>
<div style="margin-left:212px;" >
<div><textarea style="height:200px;" id="title"  value="" name="title" class="regTxt"><?php echo $proList->title?></textarea></div>
</div>
<div class="clear"></div>
</li>

<li>
<label class="labelName">货号:<font style="color:#f00;">*</font></label>
<input type="text" id="model" value="<?php echo $proList->model;?>" name="model" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">图片</label>
<?php renderPic($proList->image, 'small', 1,array('h'=>100));?>
<input type="hidden" name="old_image" value="<?php echo $proList->image; ?>" />
<input type="file" name="image" /> <font style="color:#f00;">(图片尺寸:620*620)</font>
<div class="clear"></div>
</li>

<li>
<label class="labelName">类型:<font style="color:#f00;">*</font></label>
<select id="category_id" name="category_id">
	  <option value="">--</option>
	  <?php foreach($typeList as $row){?>
	  <option value="<?php echo $row->id;?>" <?php if($proList->category_id == $row->id){echo 'selected';}?>><?php echo $row->name;?></option>
	  <?php }?>
</select>
<select id="category_id2" name="category_id2">
	  <option value="">---</option>
	    <?php foreach($typeList as $row){
	    	$subTypes = $ProductTypeModel->get($arrWhere=array('classid'=>$row->id))?>		 
			   <?php if($subTypes->id !=''){?>
			  <option value="<?php echo $subTypes->id;?>" class="<?php echo $subTypes->classid;?>" <?php if($proList->category_id2 == $subTypes->id){echo 'selected';}?>><?php echo $subTypes->name;?></option>
	    <?php }}?>
</select>
<div class="clear"></div>
</li>

<li>
	<label class="labelName">产品属性:</label>
	<div style="width:665px;margin-left:212px;">
        <ul class="property">
			<?php if(is_array($productAttrList)){
				foreach($productAttrList as $key1=>$attrRowList){
					$attrGroupList = json_decode($attrRowList->attr_group,true);
			?>
        	<li data-attrId="<?php echo $key1;?>" data-exitid="<?php echo $attrRowList->id;?>">
				<?php foreach($attrGroupList as $key2=>$attrGroup){?>
				<p class="property-item" data-id="<?php echo $attrGroup['attr_id'];?>">
					<?php echo $attrGroup['attr_name'];?>:

					<input type="text"  style="border:1px;border-bottom-style:none;border-top-style:none;border-left-style:none;border-right-style:none;" name="attr[<?php echo $key1;?>][<?php echo $attrGroup['attr_id'];?>][attr_value][value]" value="<?php echo $attrGroup['attr_value']['value'];?>">

					<input type="hidden" name="attr_id[<?php echo $key1;?>]" value="<?php echo $attrRowList->id;?>" />
					<input type="hidden" name="attr[<?php echo $key1;?>][<?php echo $attrGroup['attr_id'];?>][attr_name]" value="<?php echo $attrGroup['attr_name'];?>" />
					<input type="hidden" name="attr[<?php echo $key1;?>][<?php echo $attrGroup['attr_id'];?>][attr_id]" value="<?php echo $attrGroup['attr_id'];?>" />
					<input type="hidden" name="attr[<?php echo $key1;?>][<?php echo $attrGroup['attr_id'];?>][attr_value][id]" value="<?php echo $attrGroup['attr_value']['id'];?>" />

				</p>
				<?php }?>
				<div style="clear:both;"></div>
				<p class="property-store">库存:<input type="text" class="edit-input" name="store[<?php echo $key1;?>]" value="<?php echo $attrRowList->store;?>"></p>
				<p class="property-price">价格:<input class="edit-input" type="text" name="money[<?php echo $key1;?>]" value="<?php echo $attrRowList->price;?>"></p>
				<a href="javascript:;" class="edit">编辑</a>
				<a href="javascript:;" class="remove">删除</a>
			</li>
        	<?php }}?>

        </ul>
        <input type="button" class="add-property" value="添加属性" />
    </div>
</li>

<li>
<label class="labelName">产品价格:<font style="color:#f00;">*</font></label>
<input type="text" id="price" value="<?php echo $proList->price;?>" name="price" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">市场价:</label>
<input type="text" id="price_old" value="<?php echo $proList->price_old;?>" name="price_old" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">详细介绍:<font style="color:#f00;">*</font></label>
<div style="margin-left:212px;" >
<script id="editor" type="text/plain" style="width:590px;height:240px;"><?php echo $proList->description?></script>
</div>
<input type="hidden" name="description" value="" id="description" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">排序:</label>
<input type="text" id="sorting" value="<?php echo $proList->sorting;?>" name="sorting" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">产品状态类型:</label>
<?php while(list($key,$var) = each($HotType)){ ?>
<input type="radio" id="hot<?php echo $key;?>" name="hot" value="<?php echo $key;?>" /><label for="hot<?php echo $key;?>">&nbsp;<?php echo $var;?></label>
<?php } ?>
<div class="clear"></div>
</li>

<li>
<label class="labelName">库存:</label>
<input type="text" id="inventory" value="<?php echo $proList->inventory;?>" name="inventory" class="regTxt" />
<div class="clear"></div>
</li>

<li>
    <label class="labelName">上/下架状态:<font style="color:#f00;">*</font></label>
    <input type="radio" name="status" value="1" <?php if($proList->status == 1){echo 'checked="checked"';}?>/>&nbsp;上架&nbsp;&nbsp;
    <input type="radio" name="status" value="0" <?php if($proList->status == 0){echo 'checked="checked"';}?>/>&nbsp;下架&nbsp;&nbsp;
    <div class="clear"></div>
</li>

<li>
<label class="labelName">单位:<font style="color:#f00;">*</font></label>
<select id="unit" name="unit">
<?php foreach($unitList as $unit){ ?>
	<option value="<?php echo $unit->name;?>"><?php echo $unit->name;?></option>
<?php } ?>
</select>
<div class="clear"></div>
</li>

<li>
<label class="labelName">浏览次数:</label>
<input type="text" id="viewed" value="<?php echo $proList->viewed;?>" name="viewed" class="regTxt" />
<div class="clear"></div>
</li>

<li>
<label class="labelName">销售数量:</label>
<input type="text" id="sell_number" value="<?php echo $proList->sell_number;?>" name="sell_number" class="regTxt" />
<div class="clear"></div>
</li>
  </ul>
   </dd>
    </dl>
   <div class="clear"></div>
  <p style="float:left; padding-left:10%;"></p>
  <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" value=" 重置 " /></p>
   </div>
  </div>
  </form>
<!-- 商品属性弹窗 -->

<style>
.regInfo ul.property{width:665px;padding:0;}
.regInfo ul.property li{position:relative;border:1px dashed #7F99BE;padding:5px;margin-bottom:10px;}
.property input{width:80px;margin-left:5px;text-align:center;padding:3px 4px;border: 1px solid #CCC;}
.regInfo ul.property li a.remove{position:absolute;right:0px;top:30px;width:50px;height:30px;text-align:center;line-height:30px;background:#ddd;color:#333;font-size:12px;}
.regInfo ul.property li a.edit{position:absolute;right:0px;top:0px;width:50px;height:30px;text-align:center;line-height:30px;background:#7F99BE;color:#fff;font-size:12px;}
.property-item{float:left;width:140px;padding:2px 0;}
.property-price,.property-store{display:inline-block;width:140px;padding:2px 0;}
.confirm-popup{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.4);z-index:1001}
.cp-main{position:absolute;top:40px;left:50%;width:320px;margin-left:-160px;background:#fff}
.cp-main h3{background:#7F99BE;padding:10px;color:#fff;font-weight:normal;}
.cp-txt{padding:20px;font-size:14px}
.cp-txt span.cp-time{padding:0 5px;color:red}
.cp-btn{padding:10px;background:#eff3f8;text-align:right}
.property-popup-title{padding:15px;font-size:16px;font-family:"Microsoft YaHei";color:#333;background:#e4e9ee;margin:0}
.property-edit a{margin:0 5px}
.property-popup{padding:20px}
.property-popup li{list-style:none;padding-bottom:10px}
.property-popup li label{margin-top:-5px}
.property-popup .property-itme{display:inline-block;width:60px}
.property-popup li select{width:180px}
.property-popup li input{width:20px}
.property-popup-btn.continue{height:50px;padding:0 20px;text-align:center}
</style>
<form id="confirm-popup">
<div class="confirm-popup" style="display:none;">
    <div class="cp-main" style="width:330px;margin-left:-165px;">
    	<h3 class="property-popup-title">编辑商品属性</h3>
        <ul class="property-popup">

        	<?php foreach($attrList as $attrRow){ ?>
        	<li>
                <label><input type="checkbox" data-id="<?php echo $attrRow->attr_id;?>" data-value="<?php echo $attrRow->attr_name; ?>"  class="" />
                <span class="property-itme" ><?php echo $attrRow->attr_name; ?></span></label>
                <select class="property_value">
                	<?php
                		$attr_valueList = explode("\r\n", trim($attrRow->attr_value));
                		foreach($attr_valueList as $attr_row){ ?>
                			<option value="<?php echo $attr_row?>"><?php echo $attr_row;?></option>
                	<?php }?>
                </select>
            </li>
        	<?php } ?>
        </ul>
        <p class="continue property-popup-btn">
        	<a href="javascript:;" class="continue btn-success btn btn-blue">保存</a>
        	<a href="javascript:;" class="continue btn-cancel btn">取消</a>
        </p>
    </div>
</div>
</form>
<script type="text/javascript">
	//商品属性
	$(function(){
		if($(".property li").length == 0){
			$("#inventory").parents("li").show();
		}else{
			$("#inventory").parents("li").hide();
		}

		//打开弹窗-新增
		$(".add-property").click(function(){
			$("#confirm-popup")[0].reset();
			$(".confirm-popup").fadeIn(200).attr("data-state",0);
		});

		//打开弹窗-编辑
		$(document).delegate(".property a.edit","click",function(){
			$("#confirm-popup")[0].reset();
			var _this = $(this).parents(".property li");
			$(".confirm-popup").fadeIn(200).attr({"data-state":1,"data-attrid":$(_this).attr("data-attrid")});
			_this.find(".property-item").each(function(index,element){
				var tempId = $(element).attr("data-id");
				var tempVal = $(element).find("input[type='text']").val();
				$(".property-popup label input").each(function(index2,element2){
					var tempId2 = $(element2).attr("data-id");
					if(tempId2 == tempId){
						$(element2).prop("checked","checked");
						$(element2).parents("label").next().find("option").each(function(index3,element3){
							if($(element3).val() == tempVal){
								$(element3).attr("selected","selected");
							}
						});

					}
				});
			});

		});

		//关闭
		$(".property-popup-btn .btn-cancel").click(function(){
			$(".confirm-popup").fadeOut(200);
		});

		//删除
		$(document).delegate(".property a.remove","click",function(){
			//
			if(!$(this).parent().hasClass("pageNew")){
				$(".property").parent().append("<input type='hidden' name='del_ids[]' value='"+$(this).parent().attr("data-exitid")+"' />");
			}
			$(this).parents(".property li").remove();

			//当没有商品属性是显示下面的库存
			if($(".property li").length == 0){
				$("#inventory").parents("li").show();
			}
		});

		//添加、修改
		$(".property-popup-btn .btn-success").click(function(){
			if($(".confirm-popup").attr("data-state")==0){
				var pHtml="";
				var choseItem="",choseItemed="";
				if($(".property li").length>0){
					var row = parseInt($(".property li").last().attr("data-attrid"))+1;
				}else{
					var row = 0;
				}
				if($(".confirm-popup input:checked").length==0){
					alert("请选择商品属性");
					return false;
				}
				for(var i = 0;i<$(".property-popup li").length;i++){
					if($(".property-popup li").eq(i).find("input:checkbox").is(":checked")){
						var aid = $(".property-popup li").eq(i).find("input:checkbox").attr("data-id"),
							attrName =$(".property-popup li").eq(i).find("span.property-itme").html(),
							aindex = $(".property-popup li").eq(i).find(".property_value").prop("selectedIndex"),
							attrValue = $(".property-popup li").eq(i).find(".property_value").val();
							pHtml += '<p class="property-item" data-id="'+aid+'">'+$(".property-popup li").eq(i).find("span.property-itme").html()+':<input type="text" readonly style="border:none;" name="attr['+row+']['+ aid +'][attr_value][value]" value="'+attrValue+'"/><input type="hidden" name="attr['+row+']['+ aid +'][attr_name]" value="'+attrName+'"/><input type="hidden" name="attr['+row+']['+ aid +'][attr_id]" value="'+aid+'"/><input type="hidden" name="attr['+row+']['+ aid +'][attr_value][id]" value="'+aindex+'"/></p>'


						choseItem += $(".property-popup li").eq(i).find(".property_value").val();
					}
				};
				for(var j=0;j<$(".property li").length;j++){
					choseItemed="";
					for(var k=0;k<$(".property li").eq(j).find("p.property-item").length;k++){
						choseItemed += $(".property li").eq(j).find("p.property-item input:text").eq(k).val();
					}
					if(choseItem == choseItemed){
						alert("商品属性已存在");
						return false;
					}
				}
				var ali = '<li class="pageNew" data-attrId="'+row+'">'+pHtml+'<div style="clear:both;"></div><p class="property-store">库存:<input type="text" class="edit-input" name="store['+row+']" value="1"></p><p class="property-price">价格:<input class="edit-input" type="text" name="money['+row+']" value="1"></p><a href="javascript:;" class="edit">编辑</a><a href="javascript:;" class="remove">删除</a></li>';
				$(".property").append(ali);
				$(".confirm-popup").fadeOut();

				//隐藏下面的库存
				$("#inventory").parents("li").hide();
			}else{
				var pHtml = '',choseItem = '';
				var attrId = $(".confirm-popup").attr("data-attrid");

				$(".property li").each(function(index2,element2){
					var exitid = $(element2).attr("data-exitid");
					if($(element2).attr("data-attrid") == attrId){

						for(var i = 0;i<$(".property-popup li").length;i++){
							if($(".property-popup li").eq(i).find("input:checkbox").is(":checked")){
								var row = attrId,
									aid = $(".property-popup li").eq(i).find("input[type='checkbox']").attr("data-id"),
									attrName =$(".property-popup li").eq(i).find("span.property-itme").html(),
									aindex = $(".property-popup li").eq(i).find(".property_value").prop("selectedIndex"),
									attrValue = $(".property-popup li").eq(i).find(".property_value").val();
									pHtml += '<p class="property-item" data-id="'+aid+'">'+$(".property-popup li").eq(i).find("span.property-itme").html()+':<input type="text" readonly style="border:none;" name="attr['+row+']['+ aid +'][attr_value][value]" value="'+attrValue+'"/><input type="hidden" name="attr_id['+attrId+']" value="'+exitid+'"><input type="hidden" name="attr['+row+']['+ aid +'][attr_name]" value="'+attrName+'"/><input type="hidden" name="attr['+row+']['+ aid +'][attr_id]" value="'+aid+'"/><input type="hidden" name="attr['+row+']['+ aid +'][attr_value][id]" value="'+aindex+'"/></p>'


								choseItem += $(".property-popup li").eq(i).find(".property_value").val();
							}
						};
						if(!choseItem){
							$(element2).find("a.remove").trigger("click");
						}
					}

				})

				for(var j=0;j<$(".property li").length;j++){
					choseItemed="";
					for(var k=0;k<$(".property li").eq(j).find("p.property-item").length;k++){
						choseItemed += $(".property li").eq(j).find("p.property-item input:text").eq(k).val();
					}
					if(choseItem == choseItemed){
						alert("商品属性已存在");
						return false;
					}
				}

				$(".property li").each(function(index2,element2){
					if($(element2).attr("data-attrid") == attrId){
						$(element2).find(".property-item").remove();
						$(element2).prepend(pHtml);
					}
				});
				$(".confirm-popup").fadeOut(200);



			}
		});
	});
</script>

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
	$("#category_id2").chained("#category_id"); /* or $("#series").chainedTo("#mark"); */
</script>
<script type="text/javascript">
    $().ready(function(){
		$("#btn_next").click(function(){
			if(UM.getEditor('myEditor2').getContent() == "" ){
				if($("#myEditor2").parents(".edui-container").parent().find("label.error").length == 0){
					$("#myEditor2").parents(".edui-container").parent().append("<label for=\"\" class=\"error\">不能为空.</label>");
				}
				return false;
			}else{
				regform.description.value=UM.getEditor('myEditor2').getContent();
				$("#myEditor2").parents(".edui-container").next("label.error").remove();
				return true;
			}
		});

		$("#regform").validate({
	        rules: {
			   "name": {
				   required: true
			   },
			   "title": {
				   required: true
			   },
			   "model": {
				   required: true
			   },
			   "price": {
				   required: true,				 
				   number:true
			   },
			   "price_old": {				   
				   number:true
			   },
			   "inventory": {
				   digits:true
			   },
			   "integral": {
				   digits:true				   
			   },
			   "category_id": {
				   required: true
			   },
			   "sorting": {
				   required: true,
				   number: true
			   },
			   "viewed": {
				   digits:true
			   },
			   "sell_number": {
				   digits:true
			   }
	  		}
	    });
    });
</script>