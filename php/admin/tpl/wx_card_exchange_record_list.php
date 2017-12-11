<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../res/js/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="../res/js/jquery.datepick-zh-CN.js"></script>
<link rel="stylesheet" type="text/css" href="../res/css/jquery.datepick.css" />

<SCRIPT language=JavaScript>
    function selectCheckBox(type){
        var checkBoxs = document.getElementsByName("id[]");
        var state = false;
        switch(type){
            case 0:
                state = false;
                break;
            case 1:
                state = true;
                break;
        }
        for(var i = 0,len = checkBoxs.length; i < len; i++){
            var item = checkBoxs[i];
            item.checked = state;
        }
    }
    function unselectAll(){
        var obj = document.fom.elements;
        for (var i=0;i<obj.length;i++){
            if (obj[i].name == "id[]"){
                if (obj[i].checked==true) obj[i].checked = false;
                else obj[i].checked = true;
            }
        }
    }
    function replace(){
        if(confirm("确定要删除该记录吗?该操作不可恢复!"))
        {
            myForm.method='GET';
            myForm.act.value='del';
            myForm.submit();
            return true;
        }
        return false;

    }
    function u_status(ustatus){
        if(confirm("确定修改状态！"))
        {
            myForm.method='GET';
            myForm.act.value='update_status';
            myForm.status.value=ustatus;
myForm.submit();
            return true;
        }
        return false;

    }
</SCRIPT>
<div class="content_title">卡券兑换记录</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="wx_card_exchange_record_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
            		<!--
					<th><h3>用户ID</h3></th>
            		-->
					<th><h3>用户名称</h3></th>
					<th><h3>微信卡券ID</h3></th>
					<!--
					<th><h3>优惠券ID</h3></th>
					-->
					<th><h3>优惠券编号</h3></th>
					<th><h3>面值</h3></th>
					<th><h3>微信卡券序列号</h3></th>
					<th><h3>兑换时间</h3></th>

            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
foreach ($cardList['DataSet'] as $row) {
	$re_user = $UserModel->get(array('id'=>$row->user_id));
	$re_coupon = $CouponModel->get(array('id'=>$row->coupon_id));
	$i++;
?>
				<tr>
				<!--
					<td width="35px"><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $row->id ?></td>
				-->
					<td width="35px"><?php echo $i;?></td>
					<!--
					<td><?php echo $row->user_id; ?></td>
					-->
					<td><?php echo $re_user->name; ?></td>
					<td><?php echo $row->card_id; ?></td>
					<!--
					<td><?php echo $row->coupon_id; ?></td>
					-->
					<td><?php echo $re_coupon->card_number; ?></td>
					<td><?php echo $row->reduce_cost; ?></td>
					<td><?php echo $row->wx_code; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$row->addtime); ?></td>


				</tr>
<?php
}
?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
    <!--
        <div id="tablenav" style="width:300px;">
            <div>
                <a href="javascript://" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return replace();" >删除</a>
            </div>

        </div>
    -->
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $cardList['RecordCount']; ?>条记录，当前第<?php echo $cardList['CurrentPage']; ?>/<?php echo $cardList['PageCount']; ?>页，每页<?php echo $cardList['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $cardList['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $cardList['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $cardList['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $cardList['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
