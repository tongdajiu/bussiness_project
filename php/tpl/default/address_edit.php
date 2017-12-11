<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="back">后退</a>
    <div class="member-nav-M">地址管理</div>
</div>
<form action="address.php" method="post"   onsubmit="return tgSubmit()">
<?php if($pin_id > 0){ ?>
<input type="hidden" name="act" value="pin" />
<input type="hidden" name="pin_id" value="<?php echo $pin_id;?>" />
<input type="hidden" id="address_id" name="address_id" value="<?php if(count($addressList) > 0){echo $addressList[0]->id;}?>" />
<input type="hidden" name="pin_type" value="<?php echo $pin_type;?>" />
<?php }else{ ?>
<input type="hidden" name="act" value="post" />
<input type="hidden" id="address_id" name="address_id" value="" />
<?php }?>
<input type="hidden" name="cart_ids" value="<?php echo $cart_ids?>" />
<input type="hidden" name="userid" value="<?php echo $userid;?>" />
<div class="index-wrapper">
	<div class="add-title"><a href="address_add.php?pin_id=<?php echo $pin_id;?>&cart_ids=<?php echo $cart_ids;?>&pin_type=<?php echo $pin_type;?>"></a></div>
    <div class="add-txt">
    	<div class="add-list">
			<a href="address_add" class="add-list-edit">
				<div><div>测试昵称</div><div>13000000011</div>山西省晋城市沁水县测试我的地址</div>
			</a>
			<a href="#" class="add-list-drop"></a>
		</div>
    	<div class="add-list">
			<a href="address_add" class="add-list-edit">
				<div><div>测试昵称</div><div>13000000011</div>山西省晋城市沁水县测试我的地址</div>
			</a>
			<a href="#" class="add-list-drop"></a>
		</div>
    	<div class="add-list">
			<a href="address_add" class="add-list-edit">
				<div><div>测试昵称</div><div>13000000011</div>山西省晋城市沁水县测试我的地址</div>
			</a>
			<a href="#" class="add-list-drop"></a>
		</div>
    </div>
</div>
</form>
<?php include "tpl/footer_web.php"; ?>
<?php include_once('common_footer.php');?>
