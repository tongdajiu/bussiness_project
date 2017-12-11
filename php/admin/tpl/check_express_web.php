<table>
<tr>
	<td style="padding-left:20px;padding-top:10px">物流类型：<span style="color:#f00;font-weight:bold;"><?php echo $ExpressType[$express_type];?></span></td>
</tr>
<tr>
	<td style="padding-left:20px;padding-top:10px">物流单号：<span style="color:#f00;font-weight:bold;"><?php echo $express_number;?></span></td>
</tr>
<?php foreach($result['data'] as $rs){ ?>
	<tr>
		<td style="padding-left:20px;padding-top:10px"><?php echo $rs['time']."  ".$rs['context'];?></td>
	</tr>
<?php } ?>
</table>
<?php
if(empty($result['data']))
{
	echo "<p style='margin-top:30px;margin-left:100px;'><font color='red' size='5'>{$result['reason']}</font></p>";
}
?>
<p class="continue"><input type="button" onclick="javascript:history.back();" class="continue" value=" 返回 "></p>