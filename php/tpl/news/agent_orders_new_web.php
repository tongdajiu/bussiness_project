<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">店铺管理</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>


<div class="order_state">
	<ul>
		<li <?php if($status==-1){echo 'class="active"';}?>><a href="/agent_orders_new.php">全部</a></li>
		<li <?php if($status==1){echo 'class="active"';}?>><a href="/agent_orders_new.php?status=1">待付款</a></li>
		<li <?php if($status==2){echo 'class="active"';}?>><a href="/agent_orders_new.php?status=2">待发货</a></li>
		<li <?php if($status==3){echo 'class="active"';}?>><a href="/agent_orders_new.php?status=3">待收货</a></li>
		<li <?php if($status==4){echo 'class="active"';}?>><a href="/agent_orders_new.php?status=4">已收货</a></li>
	</ul>
</div>


<div class="product-wrap">
    <div class="product show">
        <?php if(empty($orderList['DataSet'])){ ?>
            <div class="tips-null">没有相关订单</div>
        <?php }else{ ?>
            <?php foreach($orderList['DataSet'] as $_order){ ?>
                <div class="table-bg order-list">
                    <table>
                        <tr>
                            <td class="item">订单号：<?php echo $_order->order_number;?></td>
                            <td>下单时间：<?php echo date('Y-m-d H:i:s', $_order->addtime);?></td>
                        </tr>
                        <tr>
                            <td class="item">下单人：<?php echo $_order->name;?></td>
                            <td>下单人等级：<?php echo $_order->user_level;?></td>
                        </tr>
                        <tr>
                            <td>状态：<?php echo $statusText[$_order->order_status_id];?></td>
                            <td>金额：￥<?php echo $_order->all_price;?></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<?php include_once('common_footer.php');?>