<?php include_once('common_header.php');?>
<link href="res/css/rateit.css" rel="stylesheet" type="text/css">
<script src="res/js/jquery.rateit.js" type="text/javascript"></script>
<script type="text/javascript">
$('#star').raty();
</script>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">订单评价</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<form action="" method="post">
<input type="hidden" name="order_id" value="<?php echo $order_id;?>" />
<input type="hidden" name="userid" value="<?php echo $userid;?>" />
<div class="order-wrapper">
    <div class="confirmOrder-list">
        <ul>
		<?php
		foreach($cartList as $cart){
		?>
			<input type="hidden" name="product_id[]" value="<?php echo $cart->product_id;?>" />
            <li class="confirmOrder-table" style="margin-bottom:20px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="order-list-pic comment-list-picName" style="vertical-align:bottom;"><?php renderPic($cart->product_image, 'small', 1, array('w'=>60,'h'=>60));?></td>
                        <td class="order-list-cash" style="text-align:left;"><?php echo $cart->product_name;?></td>
                    </tr>

                    <tr>
                        <td class="order-list-quantity" colspan="2" style="text-align:left;">
                        	<span  style="margin-left: 10PX;font-size: 14PX;margin-top: 5PX;">评语：</span><br/>
                        	<div style="margin:5px 12px;"><textarea name="comment[]" style="font-size:14px;color:#666;width:100%;line-height:23px;height:115px;padding:5px;box-sizing:border-box;"></textarea></div>
                        </td>
                    </tr>
                </table>
            </li>
		<?php } ?>
        </ul>
        <div style="text-align:center;"><input name="" type="submit" class="add-button" value="确 定" /></div>

    </div>
</div>
</form>
<?php include_once('common_footer.php');?>
