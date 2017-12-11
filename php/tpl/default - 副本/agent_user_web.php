<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<!--<div class="list-nav">
	<a href="index.php" class="top-left top-index">首页</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
	<div class="member-nav-M">店铺管理</div>
</div>-->
<a href="javascript:window.history.back(-1);" class="top_btn_back"></a>
<div class="view">
	<div class="header_bg"></div>
    <ul class="shop_header">
        <li class="shop_header_logo">
            <div class="shop_header_logo_img"><img src="<?php echo $obj_user->head_image;?>" onerror="this.onerror=null;this.src='../res/images/default_small.png'" /></div>
            <span><?php echo empty($shop_info->name) ? '我的店铺' : $shop_info->name;?></span>
        </li>
        <li><a href="product.php">
            <p><?php echo $productCount;?></p>
            全部商品
        </a></li>
        <li><a href="">
            <p><?php echo $newPCount;?></p>
            新上商品
        </a></li>
        <li><a href="user.php">
            <p class="shop_header_member"></p>
            会员中心
        </a></li>
    </ul>
	<div class="wdzh_box">
		<div class="wdzh_con">
			<div class="price_pic">
				<ul>
					<li>
						<span class="price_title">当月营业额<br /><font class="number_style"><?php echo number_format($all_price,2);?></font></span>
					</li>
					<?php if(VersionModel::isOpen('distributorWalletManagement')){ ?>
					<a href="agent_commission.php">
						<li>
							<span class="price_title">当月佣金额<br /><font class="number_style"><?php echo number_format($commission,6);?></font></span>
						</li>
					</a>
					<?php } ?>
					<a href="agent_attention.php">
						<li>
							<span class="price_title">我的客户数<br /><font class="number_style"><?php echo $lowerUserCount;?></font></span>
						</li>
					</a>
				</ul>
			</div>
			<div class="my_dd">
				<a href="agent_orders_new.php">
					<dl>
						<dd>查看全部已购宝贝</dd>
						<h1>我的订单</h1>
					</dl>
				</a>
			</div>
			<div class="wdzh_listh">
				<a href="agent_orders_new.php?status=1">
					<div class="wdzh_list_con">
						 <span class="wdzh_list_tu"></span>
							待付款
					</div>
				</a>
				<a href="agent_orders_new.php?status=2">
					<div class="wdzh_list_con">
						 <span class="wdzh_list_tu2"></span>
							待发货
					</div>
				</a>
				<a href="agent_orders_new.php?status=3">
					<div class="wdzh_list_con">
						 <span class="wdzh_list_tu3"></span>
							待收货
					</div>
				</a>
				<a href="agent_orders_new.php?status=4">
					<div class="wdzh_list_con">
						 <span class="wdzh_list_tu4">已收货
					</div>
				</a>
			</div>
			<div class="wdzh_morelist">
				<?php if(VersionModel::isOpen('distributorWalletManagement')){ ?>
				<div class="morelist_box morelist_box1">
					<a href="agent_commission.php">
						<dl>
							<dd class="more_list_jt"></dd>
							<dd class="more_list_name">营收详情</dd>
						</dl>
					</a>
				</div>
				<?php } ?>
				<div class="morelist_box morelist_box2">
					<a href="agent_rule.php">
						<dl>
							<dd class="more_list_jt"></dd>
							<dd class="more_list_name">分销规则</dd>
						</dl>
					</a>
				</div>
				<?php if(VersionModel::isOpen('distributorSubordinateAttention')){ ?>
				<div class="morelist_box morelist_box3">
					<a href="agent_attention.php">
						<dl>
							<dd class="more_list_jt"></dd>
							<dd class="more_list_name">我的客户关注情况</dd>
						</dl>
					</a>
				</div>
				<?php } ?>

				<?php if(VersionModel::isOpen('distributorSubordinateGoodsView') && false){ ?>
				<div class="morelist_box morelist_box4">
					<a href="agent_visit_product.php">
						<dl>
							<dd class="more_list_jt"></dd>
							<dd class="more_list_name">客户浏览产品记录</dd>
						</dl>
					</a>
				</div>
				<?php } ?>

				<div class="morelist_box morelist_box5">
					<a href="shop_edit.php?myself">
						<dl>
							<dd class="more_list_jt"></dd>
							<dd class="more_list_name">编辑分享</dd>
						</dl>
					</a>
				</div>

				<?php if(VersionModel::isOpen('distributorQRCodeApply')){ ?>
				<div class="morelist_box morelist_box6">
					<?php if($applicationInfo->status == null ){ ?>
						<a onclick="application()"  >
							<dl>
								<dd class="more_list_jt"></dd>
								<dd class="more_list_name">申请分销二维码权限</dd>
							</dl>
						</a>
					<?php }elseif( $applicationInfo->status == 0 ){ ?>
							<dl>
								<dd class="more_list_jt"></dd>
								<dd class="more_list_name">信息审核中....</dd>
							</dl>
					<?php }else{ ?>
						<a href="javascript:;" data-src="<?php echo $imgPath; ?>" id="show">
							<dl>
								<dd class="more_list_jt"></dd>
								<dd class="more_list_name">二维码</dd>
							</dl>
						</a>
					<?php } ?>
				</div>
				<?php } ?>

			</div>
		</div>
	</div>
	<?php include TEMPLATE_DIR.'/footer_web.php';?>
</div>
<script>
	$(function(){
		$(".morelist_box6 a#show").on("click",function(){
			var imgSrc = $(this).attr("data-src");
			//$("body").append('<div class="qrcode" style="position:fixed;top:0;right:0;bottom:0;left:0;z-index:9999;background-color:rgba(0,0,0,0.6);"><img src="'+imgSrc+'" style="position:absolute;top:50%;left:50%;width:60%;height:auto;transform:translateX(-50%) translateY(-50%);" /></div>');
			$("body").append('<div class="qrcode" style="position:fixed;top:0;right:0;bottom:0;left:0;z-index:9999;background:url(../res/images/ajax-loader-85.gif) no-repeat center center;background-size:30px 30px;background-color:rgba(0,0,0,0.6);"><div style="display:table;width:100%;height:100%;"><div style="display:table-cell;text-align:center;vertical-align:middle;"><img src="'+imgSrc+'" style="display:inline-block;width:60%;height:auto;" /></div></div></div>');
			return false;
		});
		$(document).delegate(".qrcode","click",function(){
			$(".qrcode").hide();
		});
	});

	function application()
	{
		$.ajax({
			url:"distributor_application.php",
			success:function(data){
				if ( data == 0 )
				{
					alert('您的信息已存在');
				}
				else
				{
					alert('信息提交成功！！正在审核中....');
					window.location.reload();
				}
			}
		})
	}
</script>
<?php include_once('common_footer.php');?>