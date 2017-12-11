<div class="content_title">抽奖记录信息管理</div>
<div id="tableheader" style="padding-top:10px">
    	<!--<div class="search">
    	<form action="index.php?module=lottery_log_action" method="get" name="myForm2" >
			<input type="hidden" name="module" value="lottery_log_action">
			<select id="type" name="type">
				<option value="0">全部</option>
        	<input type="submit" value=" 搜索 " style="width:60px;"/>
		</form>
       </div>-->
</div>
<form action="index.php" method="POST" name="myForm" >
    <input type="hidden" name="module" value="lottery_log_action">
    <input type="hidden" name="act" value="">
    <input type="hidden" name="lottery_log_id" value="">
    <input type="hidden" name="activity" value="<?php echo $activity ;?>" />
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>序号</h3></th>
                <th><h3>会员名称</h3></th>
                <th><h3>奖品</h3></th>
                <th><h3>奖品类型</h3></th>
                <th><h3>奖品值(优惠券码)</h3></th>
                <th><h3>抽奖时间</h3></th>
                <th><h3>操作</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=0;
            if ($LotteryInfo['DataSet'] !=null){
            foreach ( $LotteryInfo['DataSet'] as $info ) {
                $i++;
            ?>

            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $info->username;?></td>
                <td><?php echo $info->prize; ?></td>
                <td>
                	<?php echo $PrizeType[$info->prize_type]; ?>
                </td>
                 <td><?php echo $info->prize_val ;?></td>
                 <td>
               		<?php  echo ($info->time !=0) ? date('Y-m-d H:s:m',$info->time) : '--' ;?>
                </td>
                <td>
                	<a href="?module=lottery_log_action&act=del&lottery_log_id=<?php echo $info->lottery_log_id; ?>" onclick="javascript:return window.confirm('确定删除？');">删除</a>
                </td>
            </tr>
            <?php
            }
            }
            ?>
        </tbody>
    </table>
</form>
<div id="tablefooter">
	<div id="tablelocation">
	    <div>
	        <span class="STYLE1">共<?php echo $LotteryInfo['RecordCount']; ?>条纪录，当前第<?php echo $LotteryInfo['CurrentPage']; ?>/<?php echo $LotteryInfo['PageCount']; ?>页，每页<?php echo $LotteryInfo['PageSize']; ?>条纪录</span>
	        <a href="<?php echo $url . $LotteryInfo['First']; ?>">[第一页]</a>
	        <a href="<?php echo $url . $LotteryInfo['Prev']; ?>">[上一页]</a>
	        <a href="<?php echo $url . $LotteryInfo['Next']; ?>">[下一页]</a>
	        <a href="<?php echo $url . $LotteryInfo['Last']; ?>">[最后一页]</a>
	    </div>
	    <div class="page"></div>
	</div>
</div>
<script>
$('#type').change(function(){
$('form[name=myForm2]').submit();
	    });
</script>

</body>
</html>
