<div class="content_title">
    分销商【<?php echo $agent->name;?>】下线的消费记录
    <a href="?module=agent_info_action" class="content_title_back"><<返回分销商列表</a>
</div>

<div id="tablewrapper">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>订单号</h3></th>
                <th><h3>下单者(下线级别)</h3></th>
                <th><h3>金额</h3></th>
                <th><h3>时间</h3></th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($pager['DataSet'])){ ?>
            <tr>
                <td colspan="4" align="center">没有相关记录</td>
            </tr>
        <?php }else{ ?>
            <?php foreach($pager['DataSet'] as $_record){ ?>
                <tr>
                    <td><?php echo $_record->order_num;?></td>
                    <td><?php echo $subUsers[$_record->userid]->name;?><?php if($subUsers[$_record->userid]->name) echo '('.$_record->user_level.'级)';?></td>
                    <td>￥<?php echo $_record->money;?></td>
                    <td><?php echo date('Y-m-d H:i:s', $_record->addtime);?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>

    <div id="tablefooter">
        <?php if(!empty($pager['DataSet'])){ ?>
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $pager['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $pager['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $pager['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $pager['Last']; ?>">[最后一页]</a>
            </div>
            <div class="page"></div>
        </div>
        <?php } ?>
    </div>
</div>