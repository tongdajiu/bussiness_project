<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
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
<div class="content_title">用户浏览记录管理</div>

<div class="search">
    <form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <label>姓名:</label>
                    <input type="text" name="name" id="name" value="<?php echo $name ?>" placeholder="请输入姓名" />
                </td>
                <td>
                    <label>产品:</label>
                    <input type="text" name="productname" id="productname" value="<?php echo $productname;?>" placeholder="请输入产品" />
                </td>
                <td>
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
            		<th><h3>序号</h3></th>
					<th><h3>姓名</h3></th>
					<th><h3>产品名称</h3></th>
					<th><h3>添加时间</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
foreach ($pager['DataSet'] as $row) {
	$i++;
?>
				<tr>
					<td width="35px"><?php echo $row->id ?></td>
					<td><?php echo isset($row->username) ? $row->username : ''; ?></td>
					<td><?php echo isset($row->product_name) ? $row->product_name : ''; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>
				</tr>
<?php
}
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
                <a href="<?php echo $url . $pager['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $pager['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
