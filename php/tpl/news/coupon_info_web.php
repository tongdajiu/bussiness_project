<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery.lightbox_me.js"></script>
<script type="text/javascript">
function gives(exp_value,df){
	$("#exp_value").val(exp_value);
<?php if($connections!=null){?>
	if(df!=0){
	$('#give_friend').lightbox_me({
        centered: true,
        onLoad: function() {}
    });
    e.preventDefault();
  	}
	<?php }?>
}
</script>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">优惠券管理</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="index-wrapper">
	<div class="u02-line">
        <div class="u02-txt-L">
          <p class="add-txt01"><?php echo $user->name?>，欢迎你</p>
          <p class="u02-txt03">你的优惠券：<font color="#f60"><?php echo $couponList == null ? 0 : count($couponList);?></font> 张</p>
        </div>


      <!--<div class="u02-txt-R" style="width:auto;"><input name="" type="submit" value="激活优惠券" class="u02-button-y" onclick="location.href='coupon.php'" style="width:auto;" /></div>-->

    </div>

    <div class="clear"></div>

   	<dl style="margin:15px;">
   		<?php if ( $couponList != null ){ ?>
			<?php foreach( $couponList as $coupon ){ ?>
				<dd style="height:45px; line-height:20px;padding:5px; border:1px dashed <?php echo $coupon->enable == 1 ? '#31bd80' : '#f00' ?>; margin-bottom:10px;">
					<strong><?php echo $coupon->name; ?></strong>
					<p>
						有效期：<?php echo date('Y-m-d',$coupon->valid_stime) .  ' -- ' . date('Y-m-d',$coupon->valid_etime); ?>　
						<?php
						if($coupon->used){
							echo '<span style="color:#f60">已使用</span>';
						}elseif($coupon->enable == 1){
							echo '<span style="color:green">可使用</span>';
						}else{
							echo '<span style="color:#f60">已失效</span>';
						}
						?>
					</p>

				</dd>
			<?php } ?>
		<?php }else{ ?>
			<dd class="tips-null">暂无优惠券</dd>
		<?php } ?>
    </dl>
</div>

<!--
<div  style="color:#666;margin: 10px; width: 90%; border-radius:8px; box-shadow:0 1px 3px rgba(0, 0, 0, 0.2);background-color: #FFFFFF;letter-spacing: 2px;padding: 5px;
font-size: 14px;text-align:center;">点击有效优惠券可赠给(被)邀请人 对方购物时可直接使用 每次购物仅可使用1张</div>
-->

<?php include TEMPLATE_DIR.'/footer_web.php';?>

<div id="give_friend" style="display: none;background: #eef2f7;width: 80%;">
	<form action="coupon_info.php?act=give_friends" method="POST">
		<input type="hidden" id="exp_value" name="exp_value" value="" />
		<input type="hidden" id="give_userid" name="give_userid" value="<?php echo $obj_user->id;?>" />
		<div class="add-txt">
		<div style="text-align:left;height:40px;border-bottom:#aeafb1 1px solid;"><span style="margin-left:20px;font-size:15px;font-weight:bold;">优惠卷赠送</span></div>
<?php
foreach($connections as $connection){
	$obj_users = $ub->detail($db,$connection);
	$username = $obj_users->name;
	if($username=='')
		$username ="匿名";

?>
			<div style="text-align:left;margin-left:20px;"><input type="radio" style="width:13px;height:13px;" id="user<?php echo $connection;?>" name="userid" value="<?php echo $connection;?>" /><label style="font-size:17px;margin-left: 14px;" for="user<?php echo $connection;?>"><?php echo $username;?></label></div>
<?php } ?>
    		<input name="" type="submit" value="赠送一张" class="add-button" style="display:block;margin:0 auto;" />
    	</div>
	</form>
</div>
<?php include_once('common_footer.php');?>
