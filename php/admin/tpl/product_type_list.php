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
<link href="../res/js/highslide/highslide.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../res/js/highslide/highslide-full.packed.js"></script>
<script type="text/javascript">
hs.showCredits = 0;
hs.padToMinWidth = true;
hs.preserveContent = false;
hs.graphicsDir = '../res/js/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<div class="content_title">产品类型信息</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=product_type_action&act=add">添加产品类型</a>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="product_type_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>					
					<th><h3>父类</h3></th>
					<th><h3>名称</h3></th>
					<th><h3>商品数</h3></th>
					<th><h3>排序</h3></th>
					<th><h3>操作</h3></th>
	            </tr>
            </thead>
			<tbody>
<?php
$i = 0;
	foreach ($typeList['DataSet'] as $row) {
	 	$obj_father = $ProductTypeModel->get($arrWhere=array('id'=>$row->classid));
$i++;
?>
				<tr>
					<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $i; ?></label></td>
					<td><?php echo isset($obj_father->name) ? $obj_father->name : ''; ?></td>
					<td>
						<?php if (count($ProductTypeModel->getList($row->id))> 0) { ?>
							<a class="link" href="?module=product_type_action&classid=<?php echo $row->id; ?>"><?php echo $row->name;?></a>
						<?php }else{ ?>
							<?php echo $row->name;?>
						<?php } ?>
					</td>
					<td><?php echo $row->num; ?></td>
					<td><?php echo $row->sorting; ?></td>
					<td>
						<?php if($classid == 0){ ?>
						<a href="?module=product_type_action&act=add&classid=<?php echo $row->id; ?>" class="btn btn-blue">添加子类型</a>
						<?php } ?>
						<a href="?module=product_type_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
						<a href="tpl/get_url.php?category_id=<?php echo $row->id;?>" class="highslide btn btn-orange" onclick="return hs.htmlExpand( this, {objectType: 'iframe', headingText: '产品类型链接地址', width: 400, height: 100} )">查看产品类型链接地址</a>
						<a href="?module=product_type_action&act=del&id=<?php echo $row->id; ?>" onclick="javascript:return window.confirm('确定删除？');" class="btn btn-red">删除</a>
                    </td>
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
                <span class="STYLE1">共<?php echo $typeList['RecordCount']; ?>条纪录，当前第<?php echo $typeList['CurrentPage']; ?>/<?php echo $typeList['PageCount']; ?>页，每页<?php echo $typeList['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $typeList['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $typeList['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $typeList['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $typeList['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
