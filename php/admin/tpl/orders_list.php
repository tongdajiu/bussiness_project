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

<link href="../res/js/highslide/highslide.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../res/js/highslide/highslide-full.packed.js"></script>
<script type="text/javascript">
hs.showCredits = 0;
hs.padToMinWidth = true;
hs.preserveContent = false;
hs.graphicsDir = '../js/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>

<div class="t_r_btn">
	<a class="btn btn-big btn-blue" href="<?php echo $url."&act=excel_out";?>">订单导出Excel</a>
</div>

<div class="content_title content_title_tab">
	<a href="index.php?module=orders_action" <?php if($order_status_id == -1){ echo "class='active'";}?> >全部订单</a>
	<a href="index.php?module=orders_action&order_status_id=0" <?php if($order_status_id == 0){ echo "class='active'";}?>>待付款订单</a>
	<a href="index.php?module=orders_action&order_status_id=1" <?php if($order_status_id == 1){ echo "class='active'";}?>>待发货订单</a>
	<a href="index.php?module=orders_action&order_status_id=2" <?php if($order_status_id == 2){ echo "class='active'";}?>>已发货订单</a>
	<a href="index.php?module=orders_action&order_status_id=3" <?php if($order_status_id == 3){ echo "class='active'";}?>>已确认订单</a>
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
						<option value="shipping_firstname" <?php if($condition=="shipping_firstname"){echo "selected";}?>>收货人</option>
						<option value="username" <?php if($condition=="username"){echo "selected";}?>>客户</option>
					</select>
                </td>
                <td>
                    <label>搜索内容:</label>
                    <input type="text" name="keys" id="keys" value="<?php echo $keys?>" placeholder="请输入搜索内容" />
                </td>
                <td>
                    <label>结算状态:</label>
                    <select name="settled_status">
						<option value="">结算状态</option>
						<option value="0" <?php if($settledStatus == 0){ echo "selected";} ?>>未结算</option>
						<option value="1" <?php if($settledStatus == 1){ echo "selected";} ?>>已结算</option>
					</select>
                </td>
                <td>
                    <label>开始时间:</label>
                    <input type="text" name="starttime" id="starttime" value="<?php echo $start_time;?>" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\');}'})"  placeholder="开始时间" />
                </td>
                <td>
                    <label>结束时间:</label>
                    <input type="text" name="endtime" id="endtime" value="<?php echo $end_time;?>" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime\');}'})" placeholder="结束时间" />
                </td>
                <td>
                    <input type="hidden" name="order_status_id" value="<?php echo $order_status_id;?>" />
                    <input type="hidden" name="module" value="<?php echo nowmodule;?>" />
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
            		<th><h3>编号id</h3></th>
            		<th><h3>订单号</h3></th>     
					<th><h3>顾客</h3></th>
					<th><h3>手机号码</h3></th>
					<th><h3>收货人</h3></th>
					<th><h3>快递单号</h3></th>
					<th><h3>收货方式</h3></th>
					<th><h3>订单状态</h3></th>
					<th><h3>付款方式</h3></th>
					<th><h3>结算状态</h3></th>
					<th><h3>实收金额</h3></th>
					<th><h3>订单创建时间</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
if($pager['DataSet']!= null){
foreach ($pager['DataSet'] as $row) {
?>
				<tr>
					<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->order_id ?>" /> <?php echo $row->order_id ?></label></td>
					<td><?php echo $row->order_number; if($row->status_introduce == 1){echo "<span style=\"color:red;font-weight:bold;\">[实体]</span>";}?></td>
					<td><?php echo $row->customer; ?></td>
					<td><?php echo $row->telephone; ?><br/><?php echo $row->cellphone; ?></td>
					<td><?php echo $row->shipping_firstname; ?></td>
					<td>
						<?php if(VersionModel::isOpen('setWaybill')){ ?>
							<a href="?module=check_express_action&act=detail&express_type=<?php echo $row->express_type; ?>&express_number=<?php echo $row->express_number; ?>">
								<?php echo $row->express_number; ?>
							</a>
						<?php }else{ ?>
							<?php echo $row->express_number; ?>
						<?php } ?>
					</td>
					<td><?php echo $ShippingMtthod[$row->shipping_method]; ?></td>
					<td><?php echo $OrderStatus[$row->order_status_id]; ?></td>
					<td><?php echo isset($PayMethod[$row->pay_method]) ? $PayMethod[$row->pay_method] : ''; ?></td>
					<td><?php echo $row->settled ? '已结算' : '未结算';?></td>
					<td><?php echo $row->pay_online; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>
					<td>
						<a href="?module=<?php echo nowmodule;?>&act=edit&id=<?php echo $row->order_id; ?>" class="btn btn-green">详情</a>
						<?php if(VersionModel::isOpen('distributorWalletManagement') && ($row->settled == 0) && ($row->order_status_id == 3) && isset($settlement[$row->customer_id]) && $settlement[$row->customer_id]){ ?><a href="?module=<?php echo nowmodule;?>&act=balance&id=<?php echo $row->order_id;?>" onclick="javascript:return window.confirm('确定要进行结算，给上线用户佣金吗？')" class="btn">结算</a><?php } ?>
						<?php   if($row->order_status_id==0 && $row->user_del == 0) { ?><a href="?module=<?php echo nowmodule;?>&act=del&id[]=<?php echo $row->order_id; ?>" onclick="javascript:return window.confirm('确定删除？');" class="btn btn-red">删除</a><?php }?>
						<?php   if($row->order_status_id==1 && $row->pay_method==5 && $row->user_del == 0 ) { ?><a href="?module=<?php echo nowmodule;?>&act=del&id[]=<?php echo $row->order_id; ?>" onclick="javascript:return window.confirm('确定删除？');" class="btn btn-red">删除</a> |<?php }?>
						<a href="?module=<?php echo nowmodule;?>&act=order_print&order_id=<?php echo $row->order_id;?>" target="_black" class="btn btn-blue">单据打印</a>
					</td>
				</tr>
                <?php
					}}
				?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:300px;">
            <div>
                <a href="javascript://" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return replace();" >删除</a>
            </div>

        </div>
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $pager['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $pager['Prev']; ?>">[上一页]</a>
                <select name="page" style="width:40px" onchange="javascript:location.href='index.php?module=orders_action&page='+this.options[this.selectedIndex].value+'&order_type=<?php echo $order_type;?>&condition=<?php echo $condition;?>&keys=<?php echo $keys;?>';">
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
