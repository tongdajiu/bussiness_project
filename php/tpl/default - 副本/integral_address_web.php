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
	<div class="top_nav_title">地址管理</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>
<form action="integral_orders_confirm.php" method="post" onsubmit="return tgSubmit()">
	<input type="hidden" id="address_id" name="address_id" value="<?php if(count($addressList) > 0){echo $addressList[0]->id;}?>" />
	<input type="hidden" name="product_id" value="<?php echo $product_id;?>" />
	<div class="index-wrapper">
		<div class="add-txt">
			<?php
			$i = 0;
			foreach($addressList as $address){
				$alladdress = <<<EOF
<div class="add-list">
	<label>
		<input type="radio" name="addressId" value="{$address->id}" />
		<div><div>{$address->shipping_firstname}</div><div>{$address->telephone}</div>{$address->address}</div>
	</label>
</div>
EOF;
				echo $alladdress;
			}
			?>
			<?php if(!$addressList){ ?>
				<div style="text-align:center;margin-top:100px;">没有收货地址？请点击</br><a style="font-size:32px;" href="address_add.php">添加地址</a></div>
			<?php } ?>
			<ul class="add-txt-ul">
				<li><span class="add-txt-item">&nbsp;</span><input name="" type="submit" value="确 认" class="add-button" /></li>
			</ul>
		</div>
	</div>
</form>

<script type="text/javascript">
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
</script>
<?php include "tpl/footer_web.php"; ?>
<?php include_once('common_footer.php');?>
