<?php include_once('common_header.php');?>
<link href="res/css/index.css" rel="stylesheet" type="text/css" />

<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="index.php" class="top-right top-index">首页</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">好友推荐</div>
</div>

<div class="index-wrapper">
	<div style="background-color:#FFF;padding:20px;color:#666;">
		<div style="text-align:center;"><h3>&nbsp;</h3></div>
		<div style="text-align:center;"><h3>&nbsp;</h3></div>
		<div style="text-align:center;"><h3>&nbsp;</h3></div>
		<div style="text-align:center;color:red;font-size:28px">
		<img src="/product/small/<?php echo $adList->image;?>" alt="" width="640"  />
		</div>
		<input name="" type="submit" value="快速关注 " onclick="location.href='login.php?mcode=<?php echo $minfo;?>'" class="add-button" style="display:block;margin:0 auto;" />
		<div style="text-align:center;font-size: 30px;"><h3>只需要轻松点击，即可完成，获取500积分&nbsp;&nbsp;</h3></div>
		<div style="text-align:center;margin-top:30px;width: 100%;">
		<img src="/images/read_qrcode.png" alt="" width="100%"  />
		</div>
		<div class="clear"></div>
	</div>
    <div class="clear"></div>
</div>
<?php include_once('common_footer.php');?>
