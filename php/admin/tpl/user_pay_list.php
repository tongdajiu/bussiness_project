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
<div id="tableheader" style="padding-top:10px">
	<div class="search">
    	<form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
    		<select name="type">
    			<option value="">-类型-</option>
    			<?php while(list($key,$var) = each($UserPayType)){ ?>
    			<option value="<?php echo $key; ?>" <?php if($type == $key){echo "selected";}?>><?php echo $var;?></option>
    			<?php } ?>
    		</select>
			<input type="text" name="name" id="name" value="<?php if($name!=''){echo $name;}else{echo "请输入姓名";}?>" onfocus="if (value =='请输入姓名'){value =''}" onblur="if (value ==''){value='请输入姓名'}" style="width:120px;color:green"/>
			<input type="hidden" name="module" value="<?php echo nowmodule;?>">
        	<input type="submit" value=" 搜索 " style="width:60px;"/>
		</form>
    </div>
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
					<th><h3>类型</h3></th>
					<th><h3>充值会员卡卡号</h3></th>
					<th><h3>支付金额</h3></th>
					<th><h3>用户</h3></th>
					<th><h3>流水号</h3></th>
					<th><h3>支付状态</h3></th>
					<th><h3>订单号</h3></th>
					<th><h3>添加时间</h3></th>
					<th><h3>状态</h3></th>
					<!--<th><h3>操作</h3></th>-->
            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
if($pager['DataSet'] != null){
foreach ($pager['DataSet'] as $row) {
	$i++;
	$obj_user = $ub->detail($db,$row->userid);
?>
				<tr>
					<td width="35px"><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $i; ?></td>
					<td><?php echo $UserPayType[$row->type]; ?></td>
					<td><?php echo $row->cash_num; ?></td>
					<td><?php echo $row->payment; ?></td>
					<td><?php echo $obj_user->name; ?></td>
					<td><?php echo $row->card_number; ?></td>
					<td><?php if($row->status==0){ ?><span style="color:#f00;"><?php }  echo $PayStatus[$row->pay_status]; if($row->pay_status==0){ ?></span><?php } ?></td>
					<td><?php echo $row->order_number; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>
					<td><?php if($row->status==0){ ?><span style="color:#f00;"><?php }  echo $AuditState[$row->status]; if($row->status==0){ ?></span><?php } ?></td>
					<!--<td><a href="?module=<?php echo nowmodule_;?>&act=edit&id=<?php echo $row->id; ?>" style="color:#f00;">编辑</a> | <a href="?module=<?php echo nowmodule;?>&act=del&id[]=<?php echo $row->id; ?>" onclick="javascript:return window.confirm('确定删除？');">删除</a></td> -->
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
                <a href="javascript://" onclick="return replace();" >删除</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(0);" >已审核</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(1);" >待审核</a>
            </div>

        </div>
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $pager['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $pager['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $pager['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $pager['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
