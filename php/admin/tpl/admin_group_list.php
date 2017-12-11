<!--<div class="content_title">&nbsp;[<a href="?module=ad&act=add" style="color:red;">添加首页图片</a>]</div>-->
<div class="content_title">管理员组管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="<?php echo $this->nowModel; ?>&act=add">添加管理员组</a>
</div>

<form action="index.php" method="POST" name="myForm" >
   
    <input type="hidden" name="act" value="">
    <input type="hidden" name="status" value="">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>序号</h3></th>
                <th><h3>用户组</h3></th>
                <th><h3>描述</h3></th>
                <th><h3>状态</h3></th>
                <th><h3>操作</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=0;
            foreach ($pager['DataSet'] as $row) {
                $i++
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row->title;?></td>
                <td><?php echo $row->description;?></td>
                <td>
                    <?php
                        switch($row->status){
                            case 1;
                            echo "有效";
                        break;
                            case 0;
                            echo "无效";
                        break;
                    }?>
                </td>
                <td>
                <?php if( $_SESSION['myinfo']->id == 1 ){?>
                	<a href="<?php echo $this->nowModel;?>&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
                	<a href="<?php echo $this->nowModel;?>&act=del&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');" >删除</a>
                <?php } ?>
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
	        <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
	        <a href="<?php echo $this->nowModel .'&page=' . $pager['First']; ?>">[第一页]</a>
	        <a href="<?php echo $this->nowModel .'&page=' . $pager['Prev']; ?>">[上一页]</a>
	        <a href="<?php echo $this->nowModel .'&page=' . $pager['Next']; ?>">[下一页]</a>
	        <a href="<?php echo $this->nowModel .'&page=' . $pager['Last']; ?>">[最后一页]</a>
	    </div>
	    <div class="page"></div>
	</div>
</div>
</body>
</html>