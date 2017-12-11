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

<div class="content_title">优惠劵管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=coupon_action&act=add">添加优惠劵</a>
</div>
<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<th><h3>优惠劵名称</h3></th>
					<th><h3>类型</h3></th>
					<th><h3>体验面值</h3></th>
					<th><h3>使用时间</h3></th>
					<th><h3>激活状态</h3></th>
					<th><h3>添加时间</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
				<?php
				$i = 0;
				if($pager['DataSet']!=null){
				foreach ($pager['DataSet'] as $row) {
					$i++;
				?>
					<tr>
						<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $i; ?></label></td>
						<td><?php echo $row->name; ?></td>
						<td><?php echo $this->coupon_type[$row->type]; ?></td>
						<td>
							<?php if ( $row->type == 0 ){ ?>
								满 <?php echo $row->max_use ?> 减 <?php echo $row->discount ?> 元
							<?php }else{ ?>
								购买商品立减 <?php echo $row->discount ?> 元
							<?php } ?>
						</td>
						<td>
							<?php
								if ( $row->vaild_type == 1 )
								{
									echo  "用户拿到优惠券之日起 <strong>" . $row->vaild_date  . "</strong> 天内有效";
								}
								else
								{
									echo date('Y-m-d',$row->start_time) . ' 至 ' . date('Y-m-d',$row->end_time);
								}
							?>
						</td>
						<td><?php echo $row->status == 0 ? '失效' : '有效' ?></td>
						<td><?php echo date('Y-m-d H:i:s',$row->create_time); ?></td>
						<td>
							<a href="?module=coupon_action&act=use&cid=<?php echo $row->id; ?>" class="btn btn-blue">优惠券发放情况</a>
							<a href="?module=coupon_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
							<a href="?module=coupon_action&act=del&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
						</td>
					</tr>
                <?php } }?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:300px;">
            <div>
                <a href="javascript://" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return replace();" >删除</a>&nbsp;|&nbsp;
               <!-- <a href="javascript://" onclick="return u_status(1);" >激活</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return u_status(0);" >未激活</a>-->
            </div>

        </div>
        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
                <a href="<?php echo $this->nowModel .'&page=' . $pager['First']; ?>">[第一页]</a>
                <a href="<?php echo $this->nowModel .'&page=' .  $pager['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $this->nowModel .'&page=' .  $pager['Next']; ?>">[下一页]</a>
                <a href="<?php echo $this->nowModel .'&page=' .  $pager['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
