<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<script src="../res/js/jquery.autocomplete.js" type="text/javascript"></script>
<link href="../res/css/jquery.autocomplete.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
	$(function(){
		// 用户
		$("#user").autocomplete("../searcharea_user.php", { 	            
		        minChars: 0,
		        max:400,
		        ignorChar:true,
		        setFocus : false,		        
		        		        
		        scroll:true,
		        scrollHeight: 220,	
		        formatItem: function(row, i, max) {			        		        
			        return row.user;
		        },
		        dataType: "json",
		        parse: function(data) {
                    var parsed = [];                    
                    for (rows in data) {
                        var row = data[rows];
                        if (row) {                            
                            parsed[parsed.length] = {
                                data: row,
                                result: row.user
                            };
                        }
                    }
                    return parsed;
                }	        
	    })
	    .result(function(event, data, formatted) {
			if (data)
		    {
		        $("#userid").val(data.id);
		        $("#user").val(data.name);
			}
		});
	});
</script>
<form action="?module=user_pay_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">  
<input type="hidden" name="act" value="post">
<input type="hidden" name="status" value="1">
<input type="hidden" id="userid" name="userid" value="">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">添加</div>
 <dl class="ott">
<dd>
<ul class="ottList"> 
<li> 
<label id="name">选择分类<font style="color:#f00;">*</font></label> 
<select name="type" id="type" class="srchField selectField">
<?php
while(list($key,$var) = each($UserPayType)){
?>
<option value="<?php echo $key;?>"><?php echo $var;?></option>
<?php
}
?>
</select>
<div class="clear"></div> 
</li> 
<li> 
<label id="name">会员卡卡号:<font style="color:#f00;">*</font></label> 
<input type="text" id="cash_num" value="" name="cash_num" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">支付金额:<font style="color:#f00;">*</font></label> 
<input type="text" id="payment" value="" name="payment" class="regTxt" /> 
<div class="clear"></div> 
</li> 
<li> 
<label id="name">用户:<font style="color:#f00;">*</font></label> 
<input type="text" id="user" value="" class="regTxt" /> 
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
