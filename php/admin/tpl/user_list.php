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
<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
<div class="content_title">用户信息管理</div>

<div class="t_r_btn">
	<a class="btn btn-big btn-blue" href="index.php?module=user_action&act=update_info">更新用户信息</a>
	<a class="btn btn-big btn-blue" href="<?php echo $url."&act=excel_out";?>">会员导出Excel</a>
</div>

<div class="search">
	<form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
		<table>
			<tr>
				<td style="display:none">
					<label>会员类型:</label>
					<select name="type">
						<option value="">-会员类型-</option>
						<?php
						while(list($key, $val) = each($UserType)){
						?>
						<option value="<?php echo $key;?>" <?php if($type == $key){echo "selected";}?>><?php echo $val;?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td>
					<label>用户来源:</label>
					<select name="add_type">
						<option value="">-用户来源-</option>
						<?php
						while(list($key, $val) = each($addType)){
						?>
						<option value="<?php echo $key;?>" <?php if($add_type == $key){echo "selected";}?>><?php echo $val;?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td>
					<label>姓名:</label>
					<input type="text" name="name" class="labelName" value="<?php echo $name; ?>" placeholder="请输入姓名" />
				</td>
				<td>
					<label>邀请码:</label>
					<input type="text" name="minfo" id="minfo" value="<?php echo $minfo;?>" placeholder="邀请码搜索" />
				</td>
				<td>
					<label>开始时间:</label>
					<input type="text" name="starttime" id="starttime" value="<?php echo $start_time; ?>" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\');}'})" placeholder="开始时间" />
				</td>
				<td>
					<label>结束时间:</label>
					<input type="text" name="endtime" id="endtime" value="<?php echo $end_time; ?>" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime\');}'})" placeholder="结束时间" />
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
					<th><h3>openId</h3></th>
					<th><h3>姓名</h3></th>
					<th><h3>邀请码</h3></th>
					<th><h3>添加时间</h3></th>
					<th><h3>用户来源</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
	$i = 0;
	if ( is_array($pager['DataSet']) ){
		foreach ($pager['DataSet'] as $row) {
			$i++;
?>
			<tr>
				<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $i ?></label></td>
				<td><?php echo $row->openid; ?></td>
				<td><?php echo $row->name; ?></td>
				<td><?php echo $row->minfo; ?></td>
				<td><?php echo date('Y-m-d H:i:s',$row->addTime); ?></td>
				<td><?php echo $addType[$row->add_type]; ?></td>
				<td>
					<a href="?module=<?php echo nowmodule;?>&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
					<a href="?module=<?php echo nowmodule;?>&act=del&id[]=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
				</td>
			</tr>
<?php
		}
	}	
	else
	{ 
?>
		<tr>
			<td colspan='10'>您的记录为空</td>
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
                <a href="javascript://" onclick="return replace();" >删除</a>
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
