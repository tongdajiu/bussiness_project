<div class="content_title">商品标签管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=goods_tag_action&act=add">添加标签</a>
</div>

<form action="index.php" method="POST" name="myForm" >
    <input type="hidden" name="module" value="goods_tag_action">
    <input type="hidden" name="act" value="">
    <input type="hidden" name="status" value="">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>序号</h3></th>
                <th><h3>标题</h3></th>
                <th><h3>图片</h3></th>
                <th><h3>类型</h3></th>
                <th><h3>添加时间</h3></th>
                <th><h3>操作</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=0;
            foreach ($tagList['DataSet'] as $row) {
                $i++;
            ?>

            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row->title;?></td>
                <td>
                <?php if($row->images !=''){?>
                <img src="../upfiles/label/<?php echo $row->images;?>"  width="100">
                <?php }?>
                </td>
                <td><?php echo $HotType[$row->type]; ?></td>

                <td><?php echo  date('Y-m-d H:i:s',$row->add_time);?></td>
                <td>
                	<a href="?module=goods_tag_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
                	<a href="?module=goods_tag_action&act=del&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
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
	        <span class="STYLE1">共<?php echo $tagList['RecordCount']; ?>条纪录，当前第<?php echo $tagList['CurrentPage']; ?>/<?php echo $tagList['PageCount']; ?>页，每页<?php echo $tagList['PageSize']; ?>条纪录</span>
	        <a href="<?php echo $url . $tagList['First']; ?>">[第一页]</a>
	        <a href="<?php echo $url . $tagList['Prev']; ?>">[上一页]</a>
	        <a href="<?php echo $url . $tagList['Next']; ?>">[下一页]</a>
	        <a href="<?php echo $url . $tagList['Last']; ?>">[最后一页]</a>
	    </div>
	    <div class="page"></div>
	</div>
</div>
</body>
</html>





