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
<div class="content_title">订单评价管理</div>

<div class="search">
    <form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
        <table>
            <tr>          
                <td>
                    <label>搜索条件:</label>
                    <select name="condition">
                        <option value="">-请选择搜索条件-</option>
                        <option value="order_number" <?php if($condition=="order_number"){echo "selected";}?>>订单号</option>
                        <option value="shipping_firstname" <?php if($condition=="shipping_firstname"){echo "selected";}?>>收货人</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="keys" id="keys" value="<?php echo $keys ?>" placehoder="请输入搜索内容" />
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
					<th><h3>编号id</h3></th>
					<th><h3>订单号</h3></th>
					<th><h3>商品</h3></th>
					<th><h3>客户</h3></th>
					<th><h3>收货人</h3></th>
					<th><h3>添加时间</h3></th>
					<th><h3>评价内容</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
if(!empty($pager['DataSet'])){
foreach ($pager['DataSet'] as $row) {	
?>
				<tr>
					<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $row->id ?></label></td>
					<td><?php echo $row->order_number; ?></td>
					<td><?php echo isset($row->product_name) ? $row->product_name : ''; ?></td>
					<td><?php echo isset($row->username) ? $row->username : ''; ?></td>
					<td><?php echo $row->shipping_firstname; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>
					<td><?php echo $row->comment; ?></td>
					<td><a href="?module=<?php echo nowmodule;?>&act=del&id[]=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a></td>
				</tr>
                <?php
} }
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
