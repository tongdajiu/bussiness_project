
<div class="content_title">分销商提现信息管理</div>
<form action="distributor_money_action.php" method="POST" name="myForm" >
    <input type="hidden" name="module" value="distributor_money_action">
    <input type="hidden" name="act" value="">
    <input type="hidden" name="status" value="">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>序号</h3></th>
                <th><h3>姓名</h3></th>
                <th><h3>电话</h3></th>
                <th><h3>身份证</h3></th>
                <th><h3>申请金额</h3></th>
                <th><h3>提现方式</h3></th>
                <th><h3>提现账号</h3></th>
                <th><h3>申请时间</h3></th>
                <th><h3>状态</h3></th>
                <th><h3>通过时间</h3></th>
                <th><h3>审核人</h3></th>
                <th><h3>打款状态</h3></th>
                <th><h3>打款时间</h3></th>
                <th><h3>操作</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=0;
            foreach ($distributorList['DataSet'] as $row) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row->name;?></td>
                <td><?php echo $row->mobile;?></td>
                <td><?php echo $row->id_number;?></td>
                <td><?php echo $row->d_money;?></td>                
                <td>
                <?php if($row->pay_method !=0){?>
                	<?php echo $Transfers[$row->pay_method]; ?>
                <?php }?>
                </td>        
                <td><?php echo $row->account_number; ?></td>
                <td><?php echo ($row->add_time !=0) ? date('Y-m-d H:i:s',$row->add_time): '--' ; ?></td>
                <td>
                    <?php
                        switch($row->status){
                            case 0;
                            echo "未审核";
                        break;
                            case 1;
                            echo "审核通过";
                        break;
                            case 2;
                            echo "审核不通过";
                        break;
                    }?>
                </td>
                <td><?php if($row->status !=0) echo date('Y-m-d H:i:s',$row->through_time);?></td>
                <td><?php echo $row->username;?></td>
                <td>
                <?php
                        switch($row->play_type){
                            case 0;
                            echo "未打款";
                        break;
                            case 1;
                            echo "已打款";
                        break;
                    }?>
                </td>
                <td><?php if($row->play_type !=0) echo date('Y-m-d H:i:s',$row->play_time);?></td>

                <td>
                	<a href="?module=distributor_money_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">
                        <?php echo ($row->status == 0) ? '审核' : '详情';?>
                    </a>
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
	        <span class="STYLE1">共<?php echo $distributorList['RecordCount']; ?>条纪录，当前第<?php echo $distributorList['CurrentPage']; ?>/<?php echo $distributorList['PageCount']; ?>页，每页<?php echo $distributorList['PageSize']; ?>条纪录</span>
	        <a href="<?php echo $url . $distributorList['First']; ?>">[第一页]</a>
	        <a href="<?php echo $url . $distributorList['Prev']; ?>">[上一页]</a>
	        <a href="<?php echo $url . $distributorList['Next']; ?>">[下一页]</a>
	        <a href="<?php echo $url . $distributorList['Last']; ?>">[最后一页]</a>
	    </div>
	    <div class="page"></div>
	</div>
</div>
</body>
</html>
