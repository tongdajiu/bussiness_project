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
<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
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
<div class="content_title">产品列表</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=product_action&act=add">添加产品信息</a>
</div>
<div class="search">
    <form action="index.php?module=product_action" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <label>产品类型:</label>
                    <select id="category_id" name="category_id">
                        <option value="0">全部</option>
                        <?php foreach( $re_productTypes as $row ){?>
                            <option value="<?php echo $row->id;?>" <?php if( $category_id == $row->id ){ echo 'selected';}?>><?php echo $row->name;?></option>
                        <?php }?>
                    </select>
                </td>                
                <td>
                    <label>产品名称:</label>
                    <input type="text" name="keys" id="keys" value="<?php echo $keys;?>" placeholder="请输入产品名称" />
                </td>
                <td>
                    <input type="hidden" name="module" value="product_action">
                    <input type="submit" value=" 搜索 " class="btn btn-red" />
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="product_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<th><h3>产品名称</h3></th>
					<th><h3>产品类型</h3></th>					
					<th><h3>货号</h3></th>
					<th><h3>商品图片</h3></th>			
					<th><h3>价格</h3></th>
					<th><h3>市场价</h3></th>
					<th><h3>浏览次数</h3></th>
					<th><h3>商品排序</h3></th>
					<th><h3>产品状态</h3></th>
					<th><h3>库存数</h3></th>
					<th><h3>单位</h3></th>
					<th><h3>上/下架</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
foreach ($productList['DataSet'] as $row) {
	$i++;

?>
				<tr>
					<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->product_id ?>" /> <?php echo $i; ?></label></td>
					<td><?php echo $row->name; ?></td>
					<td><?php echo isset($row->typename) ? $row->typename : ''; ?><?php if(!empty($row)){echo '/'.$row->classname;}?></td>				
					<td><?php echo $row->model; ?></td>
					<td><?php renderPic($row->image, 'small', 1,array('h'=>100));?></td>					
					<td><?php echo $row->price; ?></td>
					<td><?php echo $row->price_old; ?></td>
					<td><?php echo $row->viewed; ?></td>
					<td><?php echo $row->sorting; ?></td>
					<td><?php echo $HotType[$row->hot]; ?></td>
					<td><?php echo $row->inventory; ?></td>
					<td><?php echo $row->unit; ?></td>					
					<td><?php if($row->status==0){ ?><span style="color:#f00;"><?php }  echo $Productstatus[$row->status]; if($row->status==0){ ?></span><?php } ?></td>
					<td style="text-align:left">
						<a href="?module=product_action&act=edit&product_id=<?php echo $row->product_id; ?>" class="btn btn-green">编辑</a>
						<a href="?module=product_action&act=del&product_id=<?php echo $row->product_id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
						<a href="?module=productimage_action&product_id=<?php echo $row->product_id; ?>" class="btn btn-blue">管理产品图片</a>
                        <br />
						<a href="tpl/get_url.php?product_id=<?php echo $row->product_id;?>" class="highslide btn btn-orange" onclick="return hs.htmlExpand( this, {objectType: 'iframe', headingText: '产品链接地址', width: 400, height: 100} )">查看产品链接地址</a>
					</td>
				</tr>
                <?php }?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:300px;">
            <div>
                <a href="javascript://" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return replace();" >删除</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(0);" >上架</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(1);" >下架</a>
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
