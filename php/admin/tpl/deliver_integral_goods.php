<script src="../res/js/jquery.autocomplete.js" type="text/javascript"></script>
<link href="../res/css/jquery.autocomplete.css" type="text/css" rel="stylesheet"/>
<script src="../res/js/jquery.chained.min.js"></script>

<script type="text/javascript">
	$(function(){
		$("#express_type").find("option[value='<?php echo $obj->express_type; ?>']").attr("selected","selected");
	});
</script>
<form action="?module=integral_orders_action" id="regform" class="cmxform" method="post">
    <input type="hidden" name="act" value="deliver_save">
    <input type="hidden" name="id" value="<?php echo $obj->id;?>">
    <div id="mainCol" class="clearfix">
        <div class="regInfo">
            <div class="content_title">发货</div>
            <dl class="ott">
                <dd>
                    <ul class="ottList">
                        <li>
                            <label class="labelName">订单号:</label><label style="font-size:16px;"><strong><?php echo $obj->order_number; ?></strong></label>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label class="labelName">收货人:</label><label style="font-size:16px;"><strong><?php echo $obj->receiver; ?></strong></label>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label class="labelName">收货地址:</label><label style="font-size:16px;"><strong><?php echo $obj->address; ?></strong></label>
                            <div class="clear"></div>
                        </li>
                        <li>
                        	<label class="labelName">订单当前状态:</label><label style="font-size:16px;"><strong><?php
                        		if($obj->delivery_status == 0){echo "等待发货";}
								if($obj->delivery_status == 1 && $obj->receiving_state == 0){echo "已发货";}
								if($obj->delivery_status == 1 && $obj->receiving_state == 1){echo "已确认";}
                        	?></strong></label>
                            <div class="clear"></div>
                        </li>
                        <li>
							<label class="labelName">订单创建时间:</label><label style="font-size:16px;"><strong><?php echo date('Y-m-d H:i:s',$obj->create_time); ?></strong></label>
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
                        <li id="express_number">
                            <label class="labelName">物流编号:</label>
                            <input type="text" name="express_number" value="" class="regTxt" />
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
			        		<th><h3>兑换积分</h3></th>
			        		<th><h3>数量</h3></th>
			        		<th><h3>小计</h3></th>
			        	</tr>
                    </thead>
                    <tbody>
                       <?php
						$i = 0;
						foreach ($obj_details as $obj_detail) {
							$i++;
						?>
				        	<tr>
								<td><?php echo $i; ?></td>
								<td><?php renderPic($obj_detail->product_image, 'small', 5, array('h'=>100)); ?></td>
								<td><?php echo $obj_detail->product_name; ?></td>
								<td><?php echo $obj_detail->product_integral; ?></td>
								<td><?php echo $obj_detail->shipping_number; ?></td>
								<td><?php echo  $obj_detail->product_integral*$obj_detail->shipping_number ;?></td>
							</tr>
						<?php
						}
						?>
                        </tbody>
                    </table>
                </div>
            <p style="float:left; padding-left:10%;"></p>
            <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" value=" 重置 " /></p>
        </div>
    </div>
</form>
<script>
$(function(){
	changeExpressType();
	$("#express_type").change(changeExpressType);
});
function changeExpressType(){
	if($("#express_type").val()=="ziqu"){
		$("#express_number").hide();
	}else{
		$("#express_number").show();
	}
}
</script>