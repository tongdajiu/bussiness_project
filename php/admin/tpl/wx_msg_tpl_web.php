<div class="content_title">微信消息模板</div>
<table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
    <thead>
        <tr>
            <th><h3>模板名称</h3></th>
            <th><h3>模板标识</h3></th>
            <th><h3>模板ID</h3></th>
            <th><h3>操作</h3></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $v){ ?>
            <tr>
                <td><?php echo $v->name;?></td>
                <td><?php echo $v->flag;?></td>
                <td><?php echo $v->tpl_id;?></td>
                <td>
                    <a href="?module=wx_msg_tpl&f=<?php echo $v->flag;?>" class="btn btn-green">编辑</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>