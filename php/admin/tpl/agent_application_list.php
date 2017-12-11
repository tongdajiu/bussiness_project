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

<link href="../res/js/highslide/highslide.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript"
	src="../res/js/highslide/highslide-full.packed.js"></script>
<script type="text/javascript">
hs.showCredits = 0;
hs.padToMinWidth = true;
hs.preserveContent = false;
hs.graphicsDir = '../res/js/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>

<div class="content_title">分销商申请信息</div>

<div class="search">
	<form action="index.php?module=agent_application" method="GET"
		name="myForm2">
		<table>
			<tr>
				<td><select name="condition">
						<option value="">请选择</option>
						<option value="name"
							<?php if($condition=="name"){echo "selected";}?>>真实姓名</option>
						<option value="tel"
							<?php if($condition=="tel"){echo "selected";}?>>手机号码</option>
						<option value="number"
							<?php if($condition=="number"){echo "selected";}?>>身份证号码</option>
						<option value="email"
							<?php if($condition=="email"){echo "selected";}?>>邮箱</option>
				</select></td>
				<td><input type="text" id="keys" name="keys"
					value="<?php echo $keys ?>" /></td>
				<td><input type="hidden" name="module"
					value="agent_application_action"> <input type="submit" value=" 搜索 "
					class="btn btn-red" /></td>

			</tr>
		</table>
	</form>
</div>

<div id="tablewrapper">
	<form action="index.php" method="POST" name="myForm">
		<input type="hidden" name="module" value="agent_application"> <input
			type="hidden" name="act" value=""> <input type="hidden" name="status"
			value="">
		<table cellpadding="0" cellspacing="0" border="0" id="table"
			class="tinytable">
			<thead>
				<tr>
					<th><h3>序号</h3></th>
					<th><h3>真实姓名</h3></th>
					<th><h3>手机号码</h3></th>
					<th><h3>身份证号码</h3></th>
					<th><h3>邮箱</h3></th>
					<th><h3>认证状态</h3></th>
					<th><h3>申请时间</h3></th>
					<th><h3>操作</h3></th>
				</tr>
			</thead>
			<tbody>
<?php
$i = 0;
foreach ( $applicationList ['DataSet'] as $row ) {
	$i ++;
	?>
<tr>
					<td><label><input name="id[]" type="checkbox" class="STYLE2"
							value=""><?php echo $i; ?></label></td>
					<td><?php echo $row->name; ?></td>
					<td><?php echo $row->mobile; ?></td>
					<td><?php echo $row->id_number; ?></td>
					<td><?php echo $row->email; ?></td>
					<td><?php echo $agent_application_status[$row->author_status]; ?></td>
					<td><?php echo date('Y-m-d',$row->addTime); ?></td>
					<td>
                        <a
						href="?module=agent_application_action&act=ustatus&id=<?php echo $row->id; ?>"
						class="btn btn-blue">审核</a>
<a
						href="?module=agent_application_action&act=edit&id=<?php echo $row->id; ?>"
						class="btn btn-green">编辑</a> <a
						href="?module=agent_application_action&act=del&id=<?php echo $row->id; ?>"
					</td>
				</tr>
                <?php
}
?>
            </tbody>
		</table>
	</form>

	<div id="tablefooter">
		<div id="tablenav" style="width: 500px;">
			<div>
				<a href="javascript://" onclick="selectCheckBox(1);">全选</a>&nbsp;|&nbsp;
				<a href="javascript://" onclick="selectCheckBox(0);">全不选</a>&nbsp;|&nbsp;
				<a href="javascript://" onclick="return replace();">删除</a>
			</div>
		</div>
		<div id="tablelocation">
			<div>
				<span class="STYLE1">共<?php echo $applicationList['RecordCount']; ?>条纪录，当前第<?php echo $applicationList['CurrentPage']; ?>/<?php echo $applicationList['PageCount']; ?>页，每页<?php echo $applicationList['PageSize']; ?>条纪录</span>
				<a href="<?php echo $url . $applicationList['First']; ?>">[第一页]</a>
				<a href="<?php echo $url . $applicationList['Prev']; ?>">[上一页]</a> <a
					href="<?php echo $url . $applicationList['Next']; ?>">[下一页]</a> <a
					href="<?php echo $url . $applicationList['Last']; ?>">[最后一页]</a>

			</div>
			<div class="page"></div>
		</div>
	</div>
</div>
