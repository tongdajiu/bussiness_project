<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
	<div class="top_nav">
		<div class="top_nav_title">确认订单</div>
		<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
	</div>

	<form action="integral_orders.php" method="post">
		<input type="hidden" name="act" value="confirm" />
		<div class="order-wrapper">
			<?php if(!empty($address)){ ?>
		    <div class="confirmOrder-Receipt clearfix">
		        <div class="confirmOrder-Receipt-L"></div>
		        <div class="confirmOrder-Receipt-R">
		            <input type="hidden" name="addressId" value="<?php echo $address->id;?>" />
		            <p class="confirmOrder-Receipt-R-txt01">收货人：<?php echo $address->shipping_firstname;?><span class="confirmOrder-Receipt-R-txt02"><?php echo $address->telephone;?></span></p>
		            <p class="confirmOrder-Receipt-R-txt03">收货地址：<?php echo $address->address;?></p>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <?php } ?>
		    <!--<div class="confirmOrder-list">
		        <ul>
		            <li class="confirmOrder-table">
		                <table border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tbody>
		                    <tr>
		                    	<input type="hidden" name="product_id" value="<?php echo $obj->id;?>" />
		                        <td rowspan="2" class="order-list-pic"><?php renderPic($obj->image, 'small', 5, array('w'=>55,'h'=>55), array('cls'=>'shoppingCart-table-Pic02-border'));?></td>
		                        <td rowspan="2" colspan="2" class="order-list-picName"><?php echo $obj->name;?></td>
		                        <td class="order-list-cash" width="40%">兑换积分：<?php echo $obj->integral;?></td>
		                    </tr>
		                    <tr>
		                        <td class="order-list-quantity" style="text-align: right;">×1</td>
		                    </tr>
		                    </tbody>
		                </table>
		            </li>
		        </ul>
		    </div>-->

		    <div style="margin:0 10px;">
		    	<input type="hidden" name="product_id" value="<?php echo $obj->id;?>" />
			   	<table border="0" cellpadding="0" cellspacing="0" width="100%">
				    <tr>
				    	<td class="order-list-pic" width="65"><?php renderPic($obj->image, 'small', 5, array('w'=>55,'h'=>55), array('cls'=>'shoppingCart-table-Pic02-border'));?></td>
				        <td class="order-list-picName"><?php echo $obj->name;?></td>
				        <td class="order-list-cash" width="80"><?php echo $obj->integral;?>积分<p>×1</p></td>
				    </tr>
			    </table>
			</div>

		    <div class="confirmOrderTxt">
		        消耗：<span id="pay_money" style="font-size:17px;color:red;"><?php echo $obj->integral;?></span> 积分<br />
		        剩余：<span id="pay_money" style="font-size:17px;color:red;"><?php echo $user_obj->integral-$obj->integral;?></span> 积分<br />
		    </div>
		</div>
		<div class="clear"></div>
	    <!--<div style="text-align:center;">
	    	<input name="" type="submit" value="确 认" class="add-button" /></li>
	    </div>-->

	    <table border="0" cellpadding="0" cellspacing="0" class="index-foot" style="width:100%;position:fixed;bottom:0px;" >
	        <tr>
	            <td class="confirmOrdert-foot-L">共计 <?php echo $obj->integral;?></span> 积分</td>
	            <td class="shoppingCart-foot-R"><input name="" type="submit" class="shoppingCart-foot-R-button" value="确 定" /></td>
	        </tr>
	    </table>
    </form>
</div>
<?php include_once('common_footer.php');?>