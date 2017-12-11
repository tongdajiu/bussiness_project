<div class="content_title">
    分销商【<?php echo $agent->name;?>】的佣金记录
    <a href="?module=agent_info_action" class="content_title_back"><<返回分销商列表</a>
</div>

<div id="tablewrapper">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>时间</h3></th>
                <th><h3>金额</h3></th>
                <th><h3>订单号</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pager['DataSet'] as $row) { ?>
                <tr>
                    <td><?php echo date('Y-m-d H:i:s', $row->time);?></td>
                    <td><?php echo $row->money;?></td>
                    <td><?php echo $row->order_no;?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div id="tablefooter">
        <div id="tablefooter">
            <div id="tablelocation">
                <div>
                    <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
                    <a href="<?php echo $pageUrl.$pager['First']; ?>">[第一页]</a>
                    <a href="<?php echo $pageUrl.$pager['Prev']; ?>">[上一页]</a>
                    <a href="<?php echo $pageUrl.$pager['Next']; ?>">[下一页]</a>
                    <a href="<?php echo $pageUrl.$pager['Last']; ?>">[最后一页]</a>
                </div>
                <div class="page"></div>
            </div>
        </div>
    </div>
</div>