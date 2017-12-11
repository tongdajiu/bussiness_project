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
    function replace(product_id){
        if(confirm("确定要删除该记录吗?该操作不可恢复!"))
        {
            myForm.method='GET';
            myForm.act.value='del';
            myForm.product_id.value=product_id;
            myForm.submit();
            return true;
        }
        return false;

    }
    function u_status(ustatus,product_id){
        if(confirm("确定修改状态！"))
        {
            myForm.method='GET';
            myForm.act.value='update_status';
            myForm.status.value=ustatus;
            myForm.product_id.value=product_id;
			myForm.submit();
            return true;
        }
        return false;

    }
</SCRIPT>
<div class="content_title">产品图片列表</div>

<?php if($product_id > 0){ ?>
<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="index.php?module=productimage_action&act=add&product_id=<?php echo $product_id;?>">添加图片</a>
</div>
<?php } ?>

<div class="search">
    <form action="index.php?module=productimage_action" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <label>产品名称:</label>
                    <input type="text" name="name" id="name" value="<?php echo $name;?>" placeholder="请输入产品名称" />
                </td>
                <td>
                    <input type="hidden" name="module" value="productimage_action">
                    <input type="submit" value=" 搜索 " class="btn btn-red" />
                </td>

            </tr>
        </table>
    </form>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="productimage_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <input type="hidden" name="product_id" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
            		<th><h3>产品</h3></th>
					<th><h3>图片</h3></th>
					<th><h3>添加时间</h3></th>
					<th><h3>审核状态</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
if($productList['DataSet'] !=null){
foreach ($productList['DataSet'] as $row) {
	$i++;
	$obj_product = $ProductModel->get($arrWhere=array('product_id'=>$row->productId));
?>
				<tr>
					<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $i; ?></label></td>
					<td><?php echo $obj_product->name; ?></td>
					<td><img src="../upfiles/<?php  echo $row->image; ?>" height="100" /></td>
					<td><?php echo date('Y-m-d',$row->addTime); ?></td>
					<td><?php if($row->status==0){ ?><span style="color:#f00;"><?php }  echo $AuditState[$row->status]; if($row->status==0){ ?></span><?php } ?></td>
					<td>
                        <a href="?module=productimage_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
                        <a href="?module=productimage_action&act=del&product_id=<?php echo $row->productId;?>&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
                        </td>
				</tr>
<?php }}  ?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:300px;">
            <div>
                <a href="javascript://" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return replace(<?php echo $product_id;?>);" >删除</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(0,<?php echo $product_id;?>);" >已审核</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(1,<?php echo $product_id;?>);" >待审核</a>
            </div>

        </div>
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $productList['RecordCount']; ?>条纪录，当前第<?php echo $productList['CurrentPage']; ?>/<?php echo $productList['PageCount']; ?>页，每页<?php echo $productList['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $productList['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $productList['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $productList['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $productList['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
