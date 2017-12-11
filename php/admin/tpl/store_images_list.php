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
    function replace(store_id){
        if(confirm("确定要删除该记录吗?该操作不可恢复!"))
        {
            myForm.method='GET';
            myForm.act.value='del';
            myForm.store_id.value=store_id;
            myForm.submit();
            return true;
        }
        return false;

    }
    function u_status(ustatus,store_id){
        if(confirm("确定修改状态！"))
        {
            myForm.method='GET';
            myForm.act.value='update_status';
            myForm.status.value=ustatus;
             myForm.store_id.value=store_id;
			myForm.submit();
            return true;
        }
        return false;

    }
</SCRIPT>
<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<div class="content_title">门店【<?php echo isset($obj->name) ? $obj->name : '';?>】的图册列表</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=<?php echo nowmodule;?>&act=add&store_id=<?php echo $store_id;?>">添加门店图册</a>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="<?php echo nowmodule;?>">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <input type="hidden" name="store_id" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<th><h3>图片</h3></th>
					<th><h3>排序</h3></th>
					<th><h3>状态</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
foreach ($pager['DataSet'] as $row) {
	$i++;
?>
				<tr>
					<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $i; ?></label></td>
					<td><?php renderPic($row->image, 'small', 4,array('h'=>100)); ?></td>
					<td><?php echo $row->sorting; ?></td>
					<td><?php echo $row->status == 1 ? '启用' : '禁用'; ?></td>
					<td>
						<a href="?module=<?php echo nowmodule;?>&act=edit&store_id=<?php echo $store_id;?>&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
						<a href="?module=<?php echo nowmodule;?>&act=del&store_id=<?php echo $store_id;?>&id[]=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
					</td>
				</tr>
                <?php
}
?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:300px;">
            <div>
                <a href="javascript:;" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
                <a href="javascript:;" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
                <a href="javascript:;" onclick="return replace(<?php echo $store_id;?>);" >删除</a>&nbsp;|&nbsp;
                <a href="javascript:;" onclick="return u_status(1,<?php echo $store_id;?>);" >启用</a>&nbsp;|&nbsp;
                <a href="javascript:;" onclick="return u_status(0,<?php echo $store_id;?>);" >禁用</a>
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
