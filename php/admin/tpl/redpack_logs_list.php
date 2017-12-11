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


<div id="tablewrapper">
	<div class="content_title">红包领取记录管理&nbsp;[<a href="?module=redpack" style="color:red;">返回红包活动</a>]</div>

	<form action="index.php" method="POST" name="myForm" >
		<input type="hidden" name="module" value="redpack_logs">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="status" value="">
		<table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
			<thead>
				<tr>
					<th><h3>ID</h3></th>
					<th><h3>获取金额</h3></th>
					<th><h3>获取时间</h3></th>
					<th><h3>来源</h3></th>
					<th><h3>用户ID</h3></th>
					<th><h3>用户openid</h3></th>
				</tr>
			</thead>

			<tbody>
			 <?php if($pager['DataSet'] !=null){?>	
				<?php foreach ($pager['DataSet'] as $row) { ?>
					<tr>
						<td><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $row->id ?></td>
						<td><?php echo $row->total_amount/100; ?>元</td>
						<td><?php echo date("Y-m-d",$row->get_time); ?></td>
						<td><?php echo $this->from[$row->get_from]; ?></td>
						<td><?php echo $row->user_id; ?></td>
						<td><?php echo $row->user_openid; ?></td>
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
				<a href="<?php echo '?module=redpack_logs&id='.$id.'&page=' . $pager['First']; ?>">[第一页]</a>
				<a href="<?php echo '?module=redpack_logs&id='.$id.'&page=' . $pager['Prev']; ?>">[上一页]</a>
				<a href="<?php echo '?module=redpack_logs&id='.$id.'&page=' . $pager['Next']; ?>">[下一页]</a>
				<a href="<?php echo '?module=redpack_logs&id='.$id.'&page=' . $pager['Last']; ?>">[最后一页]</a>
			</div>
			<div class="page"></div>
		</div>
	</div>
</div>
