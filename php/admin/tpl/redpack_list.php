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

<div class="content_title">红包活动管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=redpack&act=add">添加红包活动</a>
</div>

<div id="tablewrapper">
	<form action="index.php" method="POST" name="myForm" >
		<input type="hidden" name="module" value="redpack">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="status" value="">
		<table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
			<thead>
				<tr>
					<th><h3>ID</h3></th>
					<th><h3>活动名称</h3></th>
					<th><h3>红包金额</h3></th>
					<th><h3>发放数量</h3></th>
					<th><h3>创建时间</h3></th>
					<th><h3>生效时间</h3></th>
					<th><h3>失效时间</h3></th>
					<th><h3>有效性</h3></th>
					<th><h3>操作</h3></th>
				</tr>
			</thead>

			<tbody>
			 <?php if($pager['DataSet'] !=null){?>
				<?php foreach ($pager['DataSet'] as $row) { ?>
					<tr>
						<td><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $row->id ?></label></td>
						<td><?php echo $row->act_name; ?></td>
						<td><?php echo ($title=$row->total_amount)/100; ?>元</td>
						<td><?php echo $title=$row->count; ?></td>
						<td><?php echo date("Y-m-d H:s:m",$row->add_time); ?></td>
						<td><?php echo date("Y-m-d H:s:m",$row->start_time); ?></td>
						<td><?php echo date("Y-m-d H:s:m",$row->end_time); ?></td>
						<td><?php echo $row->status == 0 ? '无效' : '有效'; ?></td>
						<td>
							<a href="?module=redpack_logs&id=<?php echo $row->id; ?>" class="btn btn-blue">领取记录</a>
							<a href="?module=redpack&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
							<!-- | <a href="?module=redpackt&act=del&id=<?php echo $row->id; ?>" onclick="javascript:return window.confirm('确定删除？');">删除</a> -->
						</td>
					</tr>
				<?php } }?>
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
				<span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
				<a href="<?php echo '?module=redpack&page=' . $pager['First']; ?>">[第一页]</a>
				<a href="<?php echo '?module=redpack&page=' . $pager['Prev']; ?>">[上一页]</a>
				<a href="<?php echo '?module=redpack&page=' . $pager['Next']; ?>">[下一页]</a>
				<a href="<?php echo '?module=redpack&page=' . $pager['Last']; ?>">[最后一页]</a>
			</div>
			<div class="page"></div>
		</div>
	</div>
</div>
