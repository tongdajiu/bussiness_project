<script type="text/javascript" src="../res/js/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="../res/js/jquery.datepick-zh-CN.js"></script>
<link rel="stylesheet" type="text/css" href="../res/css/jquery.datepick.css" />
<script type="text/javascript">
	$(function(){
		$("#starttime").datepick({showOn:'button',buttonImage:'../res/images/calendar-blue.gif',dateFormat:'yy-mm-dd'});
		$("#endtime").datepick({showOn:'button',buttonImage:'../res/images/calendar-blue.gif',dateFormat:'yy-mm-dd'});
	});
</script>
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

<div class="content_title">
    优惠劵管理
    <a href="?module=coupon_action&act=list" class="content_title_back"><<返回优惠券列表</a>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<th><h3>用户</h3></th>
					<th><h3>优惠券码</h3></th>
					<th><h3>状态</h3></th>
					<th><h3>获取时间</h3></th>
					<th><h3>是否使用</h3></th>
					<th><h3>使用时间</h3></th>
					<th><h3>获得方式</h3></th>
            	</tr>
            </thead>
			<tbody>
				<?php
				$i = 0;
				if( $arrData!=null ){
					foreach ( $arrData as $row ) {
						$i++;
				?>
						<tr>
							<td width="35px"><?php echo $i; ?></td>
							<td><?php echo $row->name; ?></td>
							<td><?php echo $row->coupon_num; ?></td>
							<td><?php echo $row->status == 1 ? '有效' : '无效'; ?></td>
							<td><?php echo date('Y-m-d H:i:s', $row->get_time); ?></td>
							<td><?php echo $row->is_used == 1 ? '已使用' : '未使用';  ?></td>
							<td><?php echo $row->use_time == 0 ? '' : date('Y-m-d',$row->use_time); ?></td>
							<td><?php echo $this->from_type[$row->from]; ?></td>
						</tr>
                <?php } }?>
            </tbody>
        </table>
    </form>

</div>
