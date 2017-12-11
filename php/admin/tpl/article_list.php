<div class="content_title">文章信息管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=article_action&act=add">添加文章信息</a>
</div>

<form action="index.php" method="POST" name="myForm" >
    <input type="hidden" name="module" value="article_action">
    <input type="hidden" name="act" value="">
    <input type="hidden" name="status" value="">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>序号</h3></th>
                <th><h3>标题</h3></th>
                <th><h3>所属分类</h3></th>                
                <th><h3>所属类型</h3></th>                
                <th><h3>编辑时间</h3></th>
                <th><h3>状态</h3></th>
                <th><h3>操作</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=0;
            foreach ($articleList['DataSet'] as $row) {
                $i++;
            ?>

            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row->title;?></td>
                <td><?php echo $row->category_name;?></td>
                <td><?php echo $row->channel_name;?></td>
                <td><?php echo date('Y-m-d H:i:s',$row->addtime) ;?></td>
                <td>
                    <?php
                    switch($row->status){
                        case 0;
                            echo "禁用";
                            break;
                        case 1;
                            echo "开启";
                            break;
                    }?>
                </td>
                <td>
                	<a href="?module=article_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
                	<a href="?module=article_action&act=del&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
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
	        <span class="STYLE1">共<?php echo $articleList['RecordCount']; ?>条纪录，当前第<?php echo $articleList['CurrentPage']; ?>/<?php echo $articleList['PageCount']; ?>页，每页<?php echo $articleList['PageSize']; ?>条纪录</span>
	        <a href="<?php echo $url . $articleList['First']; ?>">[第一页]</a>
	        <a href="<?php echo $url . $articleList['Prev']; ?>">[上一页]</a>
	        <a href="<?php echo $url . $articleList['Next']; ?>">[下一页]</a>
	        <a href="<?php echo $url . $articleList['Last']; ?>">[最后一页]</a>
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





