<SCRIPT language=JavaScript>
    function selectCheckBox(type){
        var checkBoxs = document.getElementsByName("id[]");
        var state = false;
        switch(type){
            case 0:
                state = false;
                break;
            case 1:
                state = true;
                break;
        }
        for(var i = 0,len = checkBoxs.length; i < len; i++){
            var item = checkBoxs[i];
            item.checked = state;
        }
    }
    function unselectAll(){
        var obj = document.fom.elements;
        for (var i=0;i<obj.length;i++){
            if (obj[i].name == "id[]"){
                if (obj[i].checked==true) obj[i].checked = false;
                else obj[i].checked = true;
            }
        }
    }
    function replace(){
        if(confirm("确定要删除该记录吗?该操作不可恢复!"))
        {
            myForm.method='GET';
            myForm.act.value='del';
            myForm.submit();
            return true;
        }
        return false;

    }
    function u_status(ustatus){
        if(confirm("确定修改状态！"))
        {
            myForm.method='GET';
            myForm.act.value='update_status';
            myForm.status.value=ustatus;
			myForm.submit();
            return true;
        }
        return false;

    }
</SCRIPT>
<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>


<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="<?php echo $url."&act=excel_out";?>">导出筛选订单Excel</a>
</div>
<div class="content_title content_title_tab">
	<a href="index.php?module=<?php echo nowmodule;?>&order_type=0" <?php if($order_type == 0){ echo "class='active'";}?> >全部订单</a>
	<a href="index.php?module=<?php echo nowmodule;?>&order_type=1" <?php if($order_type == 1){ echo "class='active'";}?>>待发货订单</a>
	<a href="index.php?module=<?php echo nowmodule;?>&order_type=2" <?php if($order_type == 2){ echo "class='active'";}?>>已发货订单</a>
	<a href="index.php?module=<?php echo nowmodule;?>&order_type=3" <?php if($order_type == 3){ echo "class='active'";}?>>待确认订单</a>
	<a href="index.php?module=<?php echo nowmodule;?>&order_type=4" <?php if($order_type == 4){ echo "class='active'";}?>>已确认订单</a>
</div>
<div class="search">
    <form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
        <table>
            <tr>           
                <td>
                    <label>搜索条件:</label>
                    <select name="condition">
                        <option value="">-请选择搜索条件-</option>
                        <option value="order_number" <?php if($condition=="order_number"){echo "selected";}?>>订单号</option>
                        <option value="phone" <?php if($condition=="phone"){echo "selected";}?>>手机号码</option>
                        <option value="receiver" <?php if($condition=="receiver"){echo "selected";}?>>收货人</option>
                        <option value="customer" <?php if($condition=="customer"){echo "selected";}?>>顾客</option>
                    </select>
                </td>
                <td>
                    <label>搜索内容:</label>
                    <input type="text" name="keys" id="keys" value="<?php echo $keys;?>" placeholder="请输入搜索内容" />
                </td>
                <td>
                    <label>开始时间:</label>
                    <input type="text" name="starttime" id="starttime" value="<?php echo $start_time;?>" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\');}'})" />
                </td>
                <td>
                    <label>结束时间:</label>
                    <input type="text" name="endtime" id="endtime" value="<?php echo $end_time;?>" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime\');}'})" />
                </td>
                <td>
                	<input type="hidden" name="order_type" value="<?php echo $order_type;?>" />
                    <input type="hidden" name="module" value="<?php echo nowmodule;?>">
                    <input type="submit" value=" 搜索 " class="btn btn-red" />
                </td>

            </tr>
        </table>
    </form>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="<?php echo nowmodule;?>">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
            		<th><h3>订单号</h3></th>
					<th><h3>顾客</h3></th>
					<th><h3>手机号码</h3></th>
					<th><h3>收货人</h3></th>
					<th><h3>物流编号</h3></th>
					<th><h3>状态</h3></th>
					<th><h3>总积分</h3></th>
					<th><h3>订单创建时间</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
if($pager['DataSet']!= null){
foreach ($pager['DataSet'] as $row) {
	$i++;
?>
				<tr>
					<td width="35px"><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $i; ?></td>
					<td><a href="?module=<?php echo nowmodule;?>&act=detail&id=<?php echo $row->id; ?>" style="color:green;"><?php echo $row->order_number;?></a></td>
					<td><?php echo $row->customer; ?></td>
					<td><?php echo $row->phone; ?></td>
					<td><?php echo $row->receiver; ?></td>
					<td>
						<?php if(VersionModel::isOpen('setWaybill')){ ?>
							<a class="link" href="?module=check_express_action&act=detail&express_type=<?php echo $row->express_type; ?>&express_number=<?php echo $row->express_number; ?>">
								<?php echo $row->express_number; ?>
							</a>
						<?php }else{ ?>
							<?php echo $row->express_number; ?>
						<?php } ?>
					</td>
					<td>
					<?php
						if($row->delivery_status == 0){echo "等待发货";}
						if($row->delivery_status == 1 && $row->receiving_state == 0){echo "已发货";}
						if($row->delivery_status == 1 && $row->receiving_state == 1){echo "已确认";}
					?>
					</td>
					<td><?php echo $row->all_integral; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->create_time); ?></td>
					<td>
						<a href="?module=<?php echo nowmodule;?>&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
						<?php   if($row->delivery_status == 0 && $row->user_del == 0 ) { ?><a href="?module=<?php echo nowmodule;?>&act=deliver&id=<?php echo $row->id;?>" class="btn btn-blue">发货</a><?php }?>
						<?php   if($row->delivery_status == 1 && $row->receiving_state == 0 && $row->user_del == 0) { ?><a href="?module=<?php echo nowmodule;?>&act=confirm&order_id=<?php echo $row->id;?>" class="btn btn-orange" onclick="javascript:return window.confirm('是否确认订单?该操作不可恢复！');">确认订单</a><?php }?>
						<a href="?module=<?php echo nowmodule;?>&act=print&order_id=<?php echo $row->id;?>" class="btn btn-purple" target="_black">单据打印</a>
					</td>
				</tr>
                <?php
}}
?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $pager['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $pager['Prev']; ?>">[上一页]</a>
                <select name="page" style="width:40px" onchange="javascript:location.href='index.php?module=integral_orders_action&page='+this.options[this.selectedIndex].value+'&order_type=<?php echo $order_type;?>&condition=<?php echo $condition;?>&keys=<?php echo $keys;?>';">
					<?php for($p=1;$p<=$pager['PageCount'];$p++){?>
					<option value="<?php echo $p;?>" <?php if($page==$p){echo "selected";}?>><?php echo $p;?></option>
					<?php }?>
				</select>
                <a href="<?php echo $url . $pager['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $pager['Last']; ?>">[最后一页]</a>
            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
