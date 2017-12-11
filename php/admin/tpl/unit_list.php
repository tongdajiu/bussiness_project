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

<div class="content_title">产品单位信息</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=unit_action&act=add">添加单位</a>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="unit_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<!--<th><h3>排序</h3></th>-->
					<th><h3>名称</h3></th>
					<th><h3>添加时间</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
                <tbody>
                <?php
                $i=0;
                foreach ($unitList['DataSet'] as $row) {
                	$i++;
                ?>
                <tr>
                    <!--<td><?php echo $i; ?></td>-->
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>
                    <td>
                        <a href="?module=unit_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
                        <a href="?module=unit_action&act=del&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
                    </td>
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
                <span class="STYLE1">共<?php echo $unitList['RecordCount']; ?>条纪录，当前第<?php echo $unitList['CurrentPage']; ?>/<?php echo $unitList['PageCount']; ?>页，每页<?php echo $unitList['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $unitList['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $unitList['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $unitList['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $unitList['Last']; ?>">[最后一页]</a>
            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
