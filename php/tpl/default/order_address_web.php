<?php include_once('common_header.php');?>

<script type="text/javascript">
	$(function(){
	    $('.add-list input:radio').change(function(){
	    	var _this = $(this);
			if(_this.is(":checked")){
				$('.add-list').removeClass("active");
				_this.parents(".add-list").addClass("active");
			}
	    })
	});
</script>


<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">收货地址</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<form action="order_address.php" method="post" onsubmit="return tgSubmit()">
	
	<input type="hidden" name="act" value="post" />
	<input type="hidden" name="cart_ids" value="<?php echo $cart_ids?>" />
	<input type="hidden" name="userid" value="<?php echo $userid;?>" />
	<div class="index-wrapper">
		<div class="add-title"><a href="address.php?act=add&cart_ids=<?php echo $cart_ids;?>"></a></div>
		<div class="add-txt">

			<?php
			if ( $addressList != null )
			{
				$selInputType = $cart_ids>0 ? 'radio' : 'hidden';
				$i = 0;
				foreach($addressList as $address)
				{	
			?>
				<div class="add-list">
					<label>
						<input type="<?php echo $selInputType ?>" name="addressId" value="<?php echo $address->id ?>" />
						<div>
							<div><?php echo $address->shipping_firstname; ?></div>
							<div><?php echo $address->telephone; ?></div>
							<?php echo $address->address; ?>
						</div>
					</label>
					<a class="add-list-drop" href="order_address.php?act=del&cart_ids=<?php echo $cart_ids .'&id[]=' . $address->id ?>"><img src="../res/images/delete.png" width="16px"></a>
				</div>
			<?php
				}
			}
			?>

			<?php if($cart_ids){?>
				<ul class="add-txt-ul">
					<!-- <li><span class="add-txt-item">收据联(选填)</span><input id="invoice" name="invoice" type="text" value="" class="add-txt-name" placeholder="请填写个人或单位名称"/></li> -->
					<li><span class="add-txt-item">订单留言(选填)</span><input id="remark" name="remark" type="text" value="" class="add-txt-name" placeholder="请填写订单留言"/></li>
					<li><span class="add-txt-item">&nbsp;</span><input name="" type="submit" value="确 认" class="add-button" /></li>
				</ul>
			<?php }elseif(!$addressList){ ?>
				请点击左上角“+添加新地址”创建收货地址。
			<?php } ?>
		</div>
	</div>
</form>

<script type="text/javascript">
	function isInt(a){
		var reg = /^(\d{11})$/;
		return reg.test(a);
	}

	<?php if($cart_ids>0){ ?>
	function tgSubmit(){
		var radios = $(":radio[name='addressId']");
		if(radios[0]){
			var seled = false;
			radios.each(function(){
				if($(this).is(":checked")){
					seled = true;
					return;
				}
			});
			if(!seled){
				alert("请选择地址");
				return false;
			}
		}else{
			alert("请先添加地址");
			return false;
		}
		return true;
	}
	<?php } ?>
</script>
<?php include "footer_web.php"; ?>
<?php include_once('common_footer.php');?>