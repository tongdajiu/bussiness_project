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
<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<div class="content_title">积分兑换商品信息列表</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=<?php echo nowmodule;?>&act=add">添加兑换商品信息</a>
</div>

<div class="search">
    <form action="index.php?module=<?php echo nowmodule;?>" method="get" name="myForm2" >
        <table>
            <tr>
                <td>
                    <label>积分商品名称:</label>
                    <input type="text" name="keys" id="keys" value="<?php echo $keys ?>" placeholder="请输入积分商品名称" />
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
            		<th width="80px"><h3>积分商品id</h3></th>
					<th><h3>积分商品名称</h3></th>
					<th><h3>商品图片</h3></th>
					<th><h3>库存</h3></th>
					<th><h3>兑换积分</h3></th>
					<th><h3>状态</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php

foreach ($pager['DataSet'] as $row) {

?>
				<tr>
					<td align="left"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /><?php echo $row->id ?></label></td>
					<td><?php echo $row->name; ?></td>
					<td><?php renderPic($row->image, 'small', 5,array('h'=>100)); ?></td>
					<td><?php echo $row->inventory; ?></td>
					<td><?php echo $row->integral; ?></td>
					<td><?php echo $row->status == 1 ? '上架' : '下架'; ?></td>
					<td>
						<a href="?module=<?php echo nowmodule;?>&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
						<a href="?module=<?php echo nowmodule;?>&act=del&id[]=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
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
                <a href="javascript://" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return replace();" >删除</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(1);" >上架</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(0);" >下架</a>
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
