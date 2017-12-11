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
<div class="content_title">用户收藏管理</div>
<div id="tableheader" style="padding-top:10px">
	<!--<div class="search">
    	<form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
			<select name="type">
			<?php while(list($key,$var) = each($FavoritesType)){ ?>
				<option value="<?php echo $key; ?>"><?php echo $var; ?></option>
			<?php } ?>
			</select>
			<input type="hidden" name="module" value="<?php echo nowmodule;?>">
        	<input type="submit" value=" 搜索 " style="width:60px;"/>
		</form>
    </div>-->
</div>
<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="favorites_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<!--<th><h3>类型</h3></th>-->
					<th><h3>用户</h3></th>
					<th><h3>商品</h3></th>
					<th><h3>添加时间</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
    $i = 0;
    if ( is_array($favoritesList['DataSet'] ))
    {
        foreach ($favoritesList['DataSet'] as $row) {
	    $i++;
?>
				<tr>
					<td><?php echo $i;?></td>
					<!--<td><?php echo $FavoritesType[$row->type]; ?></td>-->
					<td><?php echo $row->username; ?></td>
					<td><?php echo $row->productname; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>

				</tr>
<?php
        }
    }
    else
    {
?>
        <tr>
            <td colspan="4">您的记录为空</td>
        </tr>
<?php        
    }
?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:300px;">

        </div>
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $favoritesList['RecordCount']; ?>条纪录，当前第<?php echo $favoritesList['CurrentPage']; ?>/<?php echo $favoritesList['PageCount']; ?>页，每页<?php echo $favoritesList['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $favoritesList['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $favoritesList['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $favoritesList['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $favoritesList['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
