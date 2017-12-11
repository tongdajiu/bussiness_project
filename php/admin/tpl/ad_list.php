<div class="content_title">首页图片管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=ad_action&act=add">添加首页图片</a>
</div>

<div class="search">
    <form action="index.php?module=ad_action" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <select id="type" name="type">
                        <option value="0">全部</option>
                        <option value="1" <?php if($type==1){ echo 'selected';}?>>首页广告图</option>
                        <option value="2" <?php if($type==2){ echo 'selected';}?>>首页主推图</option>
                        <option value="3" <?php if($type==3){ echo 'selected';}?>>分类</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="module" value="ad_action">
                    <input type="submit" value=" 搜索 " class="btn btn-red" />
                </td>

            </tr>
        </table>
    </form>
</div>

<form action="index.php" method="POST" name="myForm" >
    <input type="hidden" name="module" value="ad_action">
    <input type="hidden" name="act" value="">
    <input type="hidden" name="status" value="">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>序号</h3></th>
                <th><h3>标题</h3></th>
                <th><h3>图片</h3></th>
                <th><h3>一级类型</h3></th>
                <th><h3>二级类型</h3></th>
                <th><h3>链接</h3></th>
                <th><h3>状态</h3></th>
                <th><h3>操作</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=0;
            foreach ($adList['DataSet'] as $row) {
            $i++;
            ?>

            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row->title;?></td>
                <td>
                <?php if($row->images !=0) {?>
                          <img src="../upfiles/adindex/<?php echo $row->images;?>"  width="100">
                <?php }?>
                </td>
                <td>
                    <?php
                    switch($row->type){
                        case 1;
                            echo "首页主推图";
                            break;
                        case 2;
                            echo "首页滚动图";
                            break;
                        case 3;
                            echo "分类";
                            break;
                        case 4;
                            echo "首页广告图";
                            break;
                    }?>
                 </td>
                 <td>
                 <?php echo $row->typeclass == 0 ? '无' : $productType[$row->typeclass]->name;?>
                 </td>
                 <td><?php echo $row->url;?></td>

                 <td>
                    <?php
                        switch($row->status){
                            case 0;
                            echo "禁用";
                        break;
                            case 1;
                            echo "启用";
                        break;
                    }?>
                 </td>
                 <td>
                	<a href="?module=ad_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
                	<a href="?module=ad_action&act=del&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
                 </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</form>
<div id="tablefooter">
	<div id="tablelocation">
	    <div>
	        <span class="STYLE1">共<?php echo $adList['RecordCount']; ?>条纪录，当前第<?php echo $adList['CurrentPage']; ?>/<?php echo $adList['PageCount']; ?>页，每页<?php echo $adList['PageSize']; ?>条纪录</span>
	        <a href="<?php echo $url . $adList['First']; ?>">[第一页]</a>
	        <a href="<?php echo $url . $adList['Prev']; ?>">[上一页]</a>
	        <a href="<?php echo $url . $adList['Next']; ?>">[下一页]</a>
	        <a href="<?php echo $url . $adList['Last']; ?>">[最后一页]</a>
	    </div>
	    <div class="page"></div>
	</div>
</div>
<script>
	$('#type').change(function(){
		$('form[name="myForm2"]').submit();
	})
</script>
</body>
</html>