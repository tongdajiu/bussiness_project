<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">地址管理</div>
	<a class="top_nav_left top_nav_back" href="user.php" title="返回"></a>
</div>

<form action="address.php" method="post" onsubmit="return tgSubmit()">
	<input type="hidden" name="act" value="post" />
	<div class="index-wrapper">
		<div class="add-title"><a href="address.php?act=add"></a></div>
		<div class="add-txt">

			<?php
				if(empty($addressList)){ ?>
					请点击左上角“+添加新地址”创建收货地址。
			<?php
				}
				else
				{
					foreach($addressList as $address)
					{
			?>
						<div class="add-list">
							<label>
								<div>
									<div><?php echo $address->shipping_firstname; ?></div>
									<div><?php echo $address->telephone; ?></div>
									<?php echo $address->address; ?>
								</div>
							</label>
							<a class="add-list-drop" href="address.php?act=del&id=<?php echo $address->id; ?>"><img src="../res/images/delete.png" width="16px"></a>
						</div>
			<?php
					}
				}
			?>
		</div>
	</div>
</form>

<?php include TEMPLATE_DIR.'/footer_web.php'; ?>
<?php include_once('common_footer.php');?>