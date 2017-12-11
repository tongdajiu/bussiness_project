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
<div class="content_title">产品属性列表</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=attribute_action&act=add">添加产品属性</a>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="attribute_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<th><h3>属性名称</h3></th>
					<th><h3>属性值</h3></th>
					<th><h3>排序</h3></th>
					<th><h3>操作</h3></th>
	            </tr>
            </thead>
			<tbody>
				<?php
                if ( $attributeList['DataSet'] != null ){
				$i = 0;
				foreach ($attributeList['DataSet'] as $row) {
						$i++;
				?>
				<tr>
					<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->attr_id ?>" /> <?php echo $i; ?></label></td>
					<td><?php echo $row->attr_name; ?></td>
					<td><?php echo $row->attr_value; ?></td>
					<td><?php echo $row->sorting; ?></td>
					<td>
						<a href="?module=attribute_action&act=edit&attr_id=<?php echo $row->attr_id; ?>" class="btn btn-green">编辑</a>
						<a href="?module=attribute_action&act=del&attr_id=<?php echo $row->attr_id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
					</td>
				</tr>
                <?php }}?>
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
                <span class="STYLE1">共<?php echo $attributeList['RecordCount']; ?>条纪录，当前第<?php echo $attributeList['CurrentPage']; ?>/<?php echo $attributeList['PageCount']; ?>页，每页<?php echo $attributeList['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $attributeList['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $attributeList['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $attributeList['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $attributeList['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
