<div class="content_title">管理员信息管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=<?php echo $this->nowModel;?>&act=add">添加管理员</a>
</div>

<form action="index.php" method="POST" name="myForm" >
    <input type="hidden" name="module" value="<?php echo $this->nowModel;?>">
    <input type="hidden" name="act" value="">
    <input type="hidden" name="status" value="">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>序号</h3></th>
                <th><h3>账号</h3></th>
                <th><h3>管理员名称</h3></th>
                <th><h3>添加时间</h3></th>
                <th><h3>最后登陆时间</h3></th>
                <th><h3>最后登陆的IP</h3></th>
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
                <td><?php echo $row->username;?></td>
                <td><?php echo $row->name;?></td>
                <td><?php if($row->add_time) echo date('Y-m-d H:i:s',$row->add_time); ?></td>
                <td><?php echo ($row->last_login_time!=0 ) ? date('Y-m-d H:i:s',$row->last_login_time): '--' ; ?></td>
                <td><?php echo $row->last_ip;?></td>
                <td><?php echo $row->status == 1 ? '有效' : '无效'; ?></td>
                <td>
                             
                <a href="?module=<?php echo $this->nowModel; ?>&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
                <?php if($row->is_del == 1 && $_SESSION['myinfo']->id == 1 ){?>	
                	<a href="?module=<?php echo $this->nowModel; ?>&act=del&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');" >删除</a>
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
	        <a href="<?php echo '?module=' . $this->nowModel . '&page=' . $pager['First']; ?>">[第一页]</a>
	        <a href="<?php echo '?module=' . $this->nowModel . '&page=' . $pager['Prev']; ?>">[上一页]</a>
	        <a href="<?php echo '?module=' . $this->nowModel . '&page=' . $pager['Next']; ?>">[下一页]</a>
	        <a href="<?php echo '?module=' . $this->nowModel . '&page=' . $pager['Last']; ?>">[最后一页]</a>
	    </div>
	    <div class="page"></div>
	</div>
</div>
</body>
</html>