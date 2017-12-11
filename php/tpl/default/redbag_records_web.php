<?php include_once('common_header.php');?>
<style type="text/css">
.find_hd_dl dd img {
	vertical-align: middle;
}

.favorite_con,.serve_list_box {
	margin-top: 5px;
}
</style>

<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="user.php" class="add-nav-L"></a>
    <div class="member-nav-M">中奖纪录</div>
</div>
<?php
if(empty($re_redbag)){
	echo '<p style="text-align:center;margin-top:10px;">还没有中奖纪录</p>';
}else{

foreach( $re_redbag as $row){
	$re_user = $ub->detail($db,$row->userid);
	?>

	<div style="margin-top:10px; border-top:1px solid #e9e9e9;border-bottom: 1px solid #e9e9e9;width: 100%;" >
				<div class="clearfix" style="padding:5px 10px;">

					<span style="float: left;margin-top:10px;width: 30%;display: block;" ><img src="<?php if($re_user->head_image!=null){echo $re_user->head_image;}else{echo "images/game-10.png";} ?>" width="60%"  border="0" style="margin:10px;border-radius:50%;" /></span>
					<dl class="favorite_con" style="margin-top:0px;vertical-align: middle;">
						<dt><span class="clearfix" style="float: left;margin-left: 10px;width: 60%;display: block;line-height: 33px;">名称：<?php echo $re_user->name;?></span></dt>

						<dd><span class="clearfix" style="float: left;margin-left: 10px;width: 60%;display: block;line-height: 33px;">金额：￥<?php echo number_format($row->price/100,2);?></span></dd>
						<dd><span class="clearfix" style="float: left;margin-left: 10px;width: 60%;display: block;line-height: 33px;">时间：<?php echo date('Y-m-d H:i:s',$row->addtime);?></span></dd>

					</dl>

				</div>
	</div>
	<div class="clear"/>

<?php }}?>

<?php include_once('common_footer.php');?>
