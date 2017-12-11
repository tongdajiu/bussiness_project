<!--    电子商务管理的订单的打印    -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单-<?php echo $obj_order->order_number; ?></title>
<style type="text/css">
body{font-size:18px;}
</style>
<style type="text/css" media="print">
.noprint{display : none }
</style>
</head>
<body>
<script>
function show()
{
window.print();
}
</script>
	<table width="650px" style="table-layout:fixed;">
		<colgroup>
			<col style="width:15%;"></col>
			<col></col>
			<col></col>
			<col style="width:40%;"></col>
		</colgroup>
		<tr>
			<td colspan="4" >
				<div class="noprint">
                   <a href="javascript:window.print();">[Print]</a>
                </div>
			</td>
		 </tr>
		 <tbody>
		 	<tr>
                <td  colspan="4" align="center" style="margin-left: 230px;font-size: 17px;">
                	<h2><?php echo $gSetting['site_name'];?></h2>
              	</td>
            </tr>

		 	<tr style="height:15px;">
                <td  colspan="4" style="white-space: nowrap;overflow: hidden;">-----------------------------------------------------------------------------------------------------</td>
            </tr>
			<tr>
				<td align="right" style="width:80px;">
					姓&nbsp;&nbsp;&nbsp;&nbsp;名：
				</td>
				<td>
					<?php echo $obj->receiver; ?>
				</td>
				<td  align="right" style="width:150px;"></td>
				<td style="float:right;margin-right: 10px;">
					联系方式：<?php echo $obj->phone; ?>
				</td>
			</tr>
			<tr>
				<td  align="right">
			     	订&nbsp;单&nbsp;号：
				</td>
				<td>
					<?php echo $obj->order_number; ?>
				</td>
				<td  align="right" style="width:150px;"></td>
				<td style="float:right;margin-right: 29px;">订购日期：<?php echo date("Y-m-d",$obj->create_time); ?></td>
			</tr>
			<tr>
				<td  align="right" valign="top">
					详细地址：
				</td>
				<td colspan="3">
                	<?php echo $obj->address; ?>
				</td>
			</tr>
			<tr style="height:15px;">
                <td  colspan="4" style="white-space: nowrap;overflow: hidden;">-----------------------------------------------------------------------------------------------------</td>
            </tr>
            <tr>
				<td colspan="4">
					<table width="100%">
            			<tr align="center">
            				<td align="left">名称</td>
            				<td>数量</td>
            				<td style="float: right;">兑换价</td>
            				<td style="text-align: right;">小计</td>
            			</tr>
<?php
foreach ($obj_details as $obj_detail) {
?>
						<tr>
							<td><?php echo $obj_detail->product_name; ?></td>
							<td align="center"><?php echo $obj_detail->shipping_number; ?></td>
							<td  align="right" style="text-align: right;"><?php echo $obj_detail->product_integral; ?>积分</td>
							<td  align="right"><?php echo $obj_detail->product_integral*$obj_detail->shipping_number; ?>积分</td>
						</tr>
<?php
}
?>
						<tr>
							<td colspan="4" align="right" valign="top"><b>合计:</b></td>
							<td align="right"><?php echo $obj->all_integral; ?>&nbsp;&nbsp;积分</td>
						</tr>
						<tr>
						    <td colspan="4" align="right" valign="top"><b>实收:</b></td>
							<td align="right"><?php echo $obj->all_integral;?>&nbsp;&nbsp;积分</td>
						</tr>
            		</table>
            	</td>
            </tr>
            <tr style="height:15px;">
                <td  colspan="4" style="white-space: nowrap;overflow: hidden;">-----------------------------------------------------------------------------------------------------</td>
            </tr>
            <tr>
            	<td colspan="2" align="left"></td>
            	<td align="right"></td>
            	<td valign="top">
            	</td>
            </tr>
		</tbody>
	</table>
</body>
</html>