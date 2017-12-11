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
<div class="content_title">用户推荐关系信息</div>

<div class="search">
    <form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <label>姓名:</label>
                    <input type="text" name="name" id="name" value="<?php echo $name ?>" placeholder="请输入姓名" />
                </td>
                <td>
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
            		<th><h3>编号id</h3></th>
					<th><h3>当前用户</h3></th>
					<th><h3>邀请人</h3></th>
					<th><h3>邀请码</h3></th>
					<th><h3>关系产生时间</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
if($pager['DataSet'] != null){
foreach ($pager['DataSet'] as $row) {	
?>
				<tr>
					<td width="35px"><?php echo $row->id; ?></td>
					<td><?php echo $row->username; ?></td>
					<td><?php echo $row->fuser; ?></td>
					<td><?php echo $row->minfo; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>
					<td><a href="?module=<?php echo nowmodule;?>&act=del&id[]=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a></td>
				</tr>
                <?php } } ?>
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
