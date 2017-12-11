<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>
<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="top-left top-back">后退</a>
    <div class="member-nav-M">分销订单记录</div>
</div>

<div class="index-wrapper"  style="
    padding: 15px 0 60px 0;
">
	<div class="u-txt">
   	  <p class="add-txt01"><?php echo $obj_user->name;?>，欢迎您</p>

    </div>

    <div class="clear"></div>

    <div class="integral-wrapper">
    	<div class="integral-Record" id="tabs">

        	<div class="clear"></div>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1">
                <tr>
                    <td class="integral-title"> 订单号</td>
                	<td class="integral-title">用户</td>
                    <td class="integral-title" width="30%">金额</td>
                    <td class="integral-title">时间</td>
                </tr>

<?php
foreach ($orderList as $row) {
	$obj = $ub->detail($db,$row->customer_id);
?>
                <tr>
                    <td class="integral-txt"><a href="orders_info.php?order_id=<?php echo $row->order_id;?>"><?php echo $row->order_number;?></a></td>
                   	<td class="integral-txt"><?php echo $obj->name?></td>
                   	<td class="integral-txt" ><?php echo "￥ ".number_format($row->all_price,2);?></td>
                    <td class="integral-txt" ><?php echo date("Y-m-d H:i:s",$row->addtime);?></td>
                </tr>
             <?php }?>
            </table>
        </div>
    </div>
</div>
<?php include "footer_web.php"; ?>
<?php include_once('common_footer.php');?>
