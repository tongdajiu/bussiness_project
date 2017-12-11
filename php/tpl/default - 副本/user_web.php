<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<?php include_once('loading.php');?>

<div class="member-info">
	<div class="member_head_img">
		<img src="<?php echo $obj_user->head_image;?>" />
	</div>
	<div class="member_info_main">
		<h3><?php echo $obj_user->name;?></h3>
		<p>我的邀请码：<?php echo $obj_user->minfo;?></p>
	</div>
</div>

<!-- <div class="member-info2">
	<p>被邀请人：<font><?php echo $recommend_user;?></font>人</p>
	<p>配送中订单：<font><?php echo $onway_orders;?></font>件</p>
	<p>待评价商品：<font><?php echo $product_count;?></font>件</p>
</div> -->

<div class="member-list">
    <ul>
        <li class="member_order"><a href="orders.php"><i></i>全部订单</a></li>
    </ul>
    <div class="wdzh_listh">
        <a href="orders.php?status=1">
            <div class="wdzh_list_con">
                 <span class="wdzh_list_tu"></span>待付款
            </div>
        </a>
        <a href="orders.php?status=2">
            <div class="wdzh_list_con">
                 <span class="wdzh_list_tu2"></span>待发货
            </div>
        </a>
        <a href="orders.php?status=3">
            <div class="wdzh_list_con">
                 <span class="wdzh_list_tu3"></span>待收货
            </div>
        </a>
        <a href="orders.php?status=4">
            <div class="wdzh_list_con">
                 <span class="wdzh_list_tu4"></span>已收货
            </div>
        </a>
    </div>

    <ul>
        <!-- <li class="member_cart"><a href="cart.php"><i></i>购物车</a></li> -->
        <!--<li class="member_pin"><a href="pin_list.php"><i></i>团购订单</a></li>-->
    	<?php if(VersionModel::isOpen('integralExchangeManagement')){ ?>
    	<li class="member_integralOrder"><a href="integral_orders.php"><i></i>积分兑换订单</a></li>
    	<li class="member_integral"><a href="integral.php"><i></i>积分管理</a></li>
    	<?php } ?>
        <li class="member_coupon"><a href="coupon_info.php"><i></i>优惠券</a></li>
        <li class="member_payRecord"><a href="pay_records.php"><i></i>消费记录</a></li>
    </ul>
    <ul>
        <?php if(!empty($obj_ai)){?>
            <li class="member_mystore"><a href="shop.php"><i></i>我的小店</a></li>
        <?php } ?>
    	<li class="member_agent">
    		 <?php if(!empty($obj_ai)){?>
                <a href="agent_user.php"><i></i>分销管理</a>
             <?php } elseif(!empty($obj_ad) && $obj_ad->author_status == 0){?>
                <a href="javascript:;"><i></i>审核中</a>
             <?php }else{?>
                <a href="agent_application.php?act=add"><i></i>申请分销</a>
             <?php }?>
    	</li>
        <li class="member_withdrawals">
            <?php if(VersionModel::isOpen('distributorWithdrawDeposit') && ($obj_user->type == 1024)){ ?>
            <a href="distributor_money.php"><i></i>提现</a>
            <?php   }?>
        </li>
        <?php if(VersionModel::isOpen('storeInfoManagement') && ($store_num > 0)){ ?>
        <li class="member_store">
            <a href="store.php"><i></i>门店资料</a>
        </li>
        <?php } ?>
    </ul>
    <ul>
    	<li class="member_info"><a href="user_info.php"><i></i>个人信息</a></li>
    	<li class="member_address"><a href="address.php?show=2"><i></i>地址管理</a></li>
    	<li class="member_favorites"><a href="favorites.php"><i></i>收藏夹</a></li>
    </ul>
    <ul>
    	<!--<li class="member_lottery"><a href="lottery.php"><i></i>抽奖</a></li>-->
    </ul>
</div>

<?php include TEMPLATE_DIR.'/footer_web.php';?>
<?php include_once('common_footer.php');?>
<?php include_once('footer_menu_web_new.php');?>
