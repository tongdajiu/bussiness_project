<div class="content_title">
    用户【<?php echo $user->name;?>】的<?php echo $isUpUser?'上线':'下线';?>会员
    <a href="javascript:history.back()" class="content_title_back"><<返回</a>
</div>

<div id="tablewrapper">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>会员ID</h3></th>
                <th><h3>会员</h3></th>
                <th><h3>等级</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($users)){ ?>
                <tr>
                    <td colspan="4" align="center">没有相关会员</td>
                </tr>
            <?php }else{ ?>
                <?php foreach($users as $_u){ ?>
                    <tr>
                        <td><?php echo $_u['uid'];?></td>
                        <td><?php echo $_u['info']->name;?></td>
                        <td><?php echo $_u['level'];?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>