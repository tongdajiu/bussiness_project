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
<div class="content_title">管理员操作日志列表</div>

<div class="search">
    <form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <label>类型:</label>
                    <select name="type">
                        <option value="">-----操作类型-----</option>
                        <option value="0" <?php if($type=="0"){echo "selected";}?>><?php echo $action_type[0];?></option>
                        <option value="1" <?php if($type=="1"){echo "selected";}?>><?php echo $action_type[1];?></option>
                        <option value="2" <?php if($type=="2"){echo "selected";}?>><?php echo $action_type[2];?></option>
                        <option value="3" <?php if($type=="3"){echo "selected";}?>><?php echo $action_type[3];?></option>
                        <option value="4" <?php if($type=="4"){echo "selected";}?>><?php echo $action_type[4];?></option>
                        <option value="5" <?php if($type=="5"){echo "selected";}?>><?php echo $action_type[5];?></option>
                        <option value="6" <?php if($type=="6"){echo "selected";}?>><?php echo $action_type[6];?></option>
                        <option value="7" <?php if($type=="7"){echo "selected";}?>><?php echo $action_type[7];?></option>
                    </select>
                </td>
                <td>
                    <label>搜索条件:</label>
                    <select name="condition">
                        <option value="">-请选择搜索条件-</option>
                        <option value="uname" <?php if($condition=="uname"){echo "selected";}?>>管理员账号</option>
                        <option value="name" <?php if($condition=="name"){echo "selected";}?>>管理员名称</option>
                    </select>
                </td>
                <td>
                    <label>搜索内容:</label>
                    <input type="text" name="keys" id="keys" value="<?php echo $keys; ?>" />
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
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<th><h3>管理员账号</h3></th>
					<th><h3>管理员名称</h3></th>
					<th><h3>操作类型</h3></th>
					<th><h3>操作</h3></th>
					<th><h3>操作时间</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
if($pager['DataSet']!= null){
	$i = 0;
foreach ($pager['DataSet'] as $row) {
	$i++;
?>
				<tr>
					<td width="35px"><?php echo $i; ?></td>
					<td><?php echo $row->uname; ?></td>
					<td><?php echo $row->name; ?></td>
					<td><?php echo $action_type[$row->type]; ?></td>
					<td><?php echo $row->optitle; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->add_time); ?></td>
				</tr>
<?php
} }
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
