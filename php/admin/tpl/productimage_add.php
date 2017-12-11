<script src="../res/js/jquery.autocomplete.js" type="text/javascript"></script>
<link href="../res/css/jquery.autocomplete.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
	$(function(){
		//用户
		$("#productname").autocomplete("../searcharea_product.php", {
		        minChars: 0,
		        max:400,
		        ignorChar:true,
		        setFocus : false,

		        scroll:true,
		        scrollHeight: 220,
		        formatItem: function(row, i, max) {
			        return row.name;
		        },
		        dataType: "json",
		        parse: function(data) {
                    var parsed = [];
                    for (rows in data) {
                        var row = data[rows];
                        if (row) {
                            parsed[parsed.length] = {
                                data: row,
                                result: row.name
                            };
                        }
                    }
                    return parsed;
                }
	    })
	    .result(function(event, data, formatted) {
			if (data)
		    {
		        $("#productId").val(data.product_id);
		        $("#productname").val(data.name);
			}
		});
	});
</script>
<form action="?module=productimage_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="add_save">
<input type="hidden" name="status" value="1">
<input type="hidden" id="product_id" name="product_id" value="<?php echo $obj_product->product_id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">产品图片添加</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label class="labelName">产品:</label>
<div class="regTxt" style="border:0"><?php echo $obj_product->name;?></div>
<!--<input type="text" id="productname" value="<?php echo $obj_product->name;?>" class="regTxt" />-->
<div class="clear"></div>
</li>
<li>
<label class="labelName">图片:<font style="color:#f00;">*</font></label>
<input type="file" name="image" /> <font style="color:#f00;">(图片尺寸:620*620)</font>
<div class="clear"></div>
</li>
<!--<li>
<label class="labelName">用户:<font style="color:#f00;">*</font></label>
<input type="text" id="userid" value="" name="userid" class="regTxt" />
<div class="clear"></div>
</li> -->
  </ul>
   </dd>
    </dl>
   <div class="clear"></div>

  <p style="float:left; padding-left:10%;"></p>
  <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
   </div>
  </div>
  </form>
<script>
$(function(){
	$("#regform").validate({
        rules: {
		   "image": {
			   required: true
		   }
  		}
    });
})
</script>