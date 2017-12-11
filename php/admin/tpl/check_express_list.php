<div class="content_title">物流进度查看</div>

<div class="search">
    <form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
        <input type="hidden" name="act" value="search" />
        <table>
            <tr>
                <td>
                    <label>物流类型:</label>
                    <select name="express_type" style="width:200px;">
						<?php foreach($ExpressType as $key=>$row){?>
						<option value="<?php echo $key == 'ziqu' ? '' : $key;?>"><?php echo $row == '自取' ? '请选择物流类型' : $row;?></option>
						<?php } ?>
					</select>
                </td>
                <td>
                    <label>物流编号:</label>
                    <input type="text" name="express_number" id="express_number" placeholder="请输入物流编号" />
                </td>
                <td>
                    <input type="hidden" name="module" value="<?php echo nowmodule;?>">
                    <input type="submit" value=" 搜索 " class="btn btn-red" />
                </td>

            </tr>
        </table>
    </form>
</div>

<?php if($result['data']!=null){?>
<div id="tablewrapper">
   
	<table>
		<tr>
			<td style="padding-left:20px;padding-top:10px">物流类型：<span style="color:#f00;font-weight:bold;"><?php echo $ExpressType[$express_type];?></span></td>
		</tr>
		<tr>
			<td style="padding-left:20px;padding-top:10px">物流单号：<span style="color:#f00;font-weight:bold;"><?php echo $express_number;?></span></td>
		</tr>
	<?php
	
		foreach($result['data'] as $rs){ ?>
		<tr>
			<td style="padding-left:20px;padding-top:10px"><?php echo $rs['time']."  ".$rs['context'];?></td>
		</tr>
	<?php }  ?>
	</table>
    
</div>
<?php }else{ ?>
<labal style="font-size:16px;color:red;"><?php echo $result['reason']; ?></labal>
<?php } ?>