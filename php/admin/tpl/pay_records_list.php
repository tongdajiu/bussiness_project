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
<div class="content_title">消费记录管理</div>

<div class="search">
    <form action="index.php?module=pay_records_action" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <label>搜索条件:</label>
                    <select name="condition">
                        <option value="">-请选择搜索条件-</option>
                        <option value="username" <?php if($condition=="username"){echo "selected";}?>>用户名称</option>
                        <option value="order_num" <?php if($condition=="order_num"){echo "selected";}?>>订单号</option>
                    </select>
                </td>
                <td>
                    <label>搜索内容:</label>
                    <input type="text" name="keys" id="keys" value="<?php echo $keys; ?>" placeholder="请输入搜索内容" />
                </td>
                <td>
                    <input type="hidden" name="module" value="pay_records_action">
                    <input type="submit" value=" 搜索 " class="btn btn-red" />
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="pay_records_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<!--<th><h3>类型</h3></th>-->
					<th><h3>用户</h3></th>
					<th><h3>订单号</h3></th>
					<th><h3>金额</h3></th>
					<th><h3>添加时间</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
    $i = 0;
    if($payrecordsList['DataSet']!=null){
        foreach ($payrecordsList['DataSet'] as $row) {
    	   $i++;
?>
			<tr>
				<td> <?php echo $i; ?></td>
				<!--<td><?php echo $row->type; ?></td>-->
				<td><?php echo $row->username; ?></td>
				<td><?php echo $row->order_num; ?></td>
				<td><?php echo number_format($row->money,2); ?></td>
				<td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>
			</tr>
<?php  
        }
    }
    else
    {    
?>
    <tr>
        <td colspan="5">您的记录为空</td>
    </tr>
<?php        
     }
?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:300px;">


        </div>
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $payrecordsList['RecordCount']; ?>条纪录，当前第<?php echo $payrecordsList['CurrentPage']; ?>/<?php echo $payrecordsList['PageCount']; ?>页，每页<?php echo $payrecordsList['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $payrecordsList['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $payrecordsList['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $payrecordsList['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $payrecordsList['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
