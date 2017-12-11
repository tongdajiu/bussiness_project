<div id="mainCol" class="clearfix">
	<div class="regInfo">
		<div class="content_title">积分订单详情</div>
		<dl class="ott">
			<dd>
				<ul class="ottList">
					<li>
					<label class="labelName">订单号:</label><label style="font-size:16px;"><strong><?php echo $obj->order_number; ?></strong></label>
					<div class="clear"></div>
					</li>
					<li>
					<label class="labelName">顾客:</label><label style="font-size:16px;"><strong><?php echo $obj->customer; ?></strong></label>
					<div class="clear"></div>
					</li>
					<li>
					<label class="labelName">状态:</label><label style="font-size:16px;">
					<strong><?php
						if($obj->delivery_status == 0){echo "等待发货";}
						if($obj->delivery_status == 1 && $obj->receiving_state == 0){echo "已发货";}
						if($obj->delivery_status == 1 && $obj->receiving_state == 1){echo "已确认";}
					?></strong></label>
					<div class="clear"></div>
					</li>



					<li>
					<label class="labelName">联系电话:</label><label style="font-size:16px;"><strong><?php echo $obj->phone; ?></strong></label>
					<div class="clear"></div>
					</li>


					<li>
					<label class="labelName">收货人姓名:</label><label style="font-size:16px;"><strong><?php echo $obj->receiver; ?></strong></label>
					<div class="clear"></div>
					</li>


					<li>
					<label class="labelName">收货地址:</label><label style="font-size:16px;"><strong><?php echo $obj->address; ?></strong></label>
					<div class="clear"></div>
					</li>
					<li>
					<label class="labelName">订单创建时间:</label><label style="font-size:16px;"><strong><?php echo date('Y-m-d H:i:s',$obj->create_time); ?></strong></label>
					<div class="clear"></div>
					</li>


					<?php if($obj->delivery_status == 1){ ?>
					<li>
					<label class="labelName">物流类型:</label><label style="font-size:16px;"><strong><?php echo $ExpressType[$obj->express_type]; ?></strong></label>
					<div class="clear"></div>
					</li>
					<li id="express_number">
					<label class="labelName">物流编号:</label><label style="font-size:16px;"><strong><?php echo $obj->express_number; ?></strong></label>
					<div class="clear"></div>
					</li>
					<li>
					<label class="labelName">订单发货时间:</label><label style="font-size:16px;"><strong><?php echo date('Y-m-d H:i:s',$obj->delivery_time); ?></strong></label>
					<div class="clear"></div>
					</li>
					<?php }?>

					<?php if($obj->receiving_state == 1){ ?>
					<li>
					<label class="labelName">确认订单时间:</label><label style="font-size:16px;"><strong><?php echo date('Y-m-d H:i:s',$obj->receiving_time); ?></strong></label>
					<div class="clear"></div>
					</li>
					<?php } ?>


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

  	<p class="continue" style="text-align:center;"><input type="button" class="continue" value=" 返回 " onclick="javascript:window.history.go(-1);"/></p>
   </div>
</div>
<script>
$(function(){
	if("<?php echo $ExpressType[$obj->express_type]; ?>"=="自取"){
		$("#express_number").hide();
	}else{
		$("#express_number").show();
	}
});
</script>