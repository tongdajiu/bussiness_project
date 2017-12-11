<?php include_once('common_header.php');?>
<link href="res/css/index.css" rel="stylesheet" type="text/css" />
<link href="res/css/rateit.css" rel="stylesheet" type="text/css">
<script src="res/js/jquery.rateit.js" type="text/javascript"></script>
<script type="text/javascript">
$('#star').raty();
</script>
<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="user.php" class="add-nav-L"></a>
    <div class="member-nav-M">订单评价信息</div>
</div>

<div class="order-wrapper">
    <div class="confirmOrder-list">
        <ul>
<?php
foreach($cartList as $cart){
	$comment = $ib->detail_order_product($db,$order_id,$cart->product_id);
?>
			<li class="confirmOrder-table">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td rowspan="2" class="order-list-pic"><img src="product/small/<?php echo $cart->product_image;?>" alt="" width="110" height="110" class="shoppingCart-table-Pic02-border"/></td>
                        <td width="80%" colspan="2" class="comment-list-picName">
                        	<?php echo $cart->product_name;?>：
                        	<?php for($i=0;$i<$comment->score;$i++){ ?>
                    			<img src="res/images/list02_13.png" alt="" width="24" height="24" />
							<?php } ?>
							<span style="font-size:24px;color:#666;"><?php echo $Score[$comment->score];?></span>
                        </td>
                        <td class="order-list-cash"></td>
                    </tr>
                    <tr>
                        <td class="order-list-quantity">
                        	<table>
                        		<tr>
                        			<td>
                        				<div style="font-size:30px;color:#666;"><?php echo $comment->comment;?></div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>
                        				<div class="list02-pic-appraisal-txt-R-time" style="font-size:26px;"><?php echo date('Y-m-d H:i:s',$comment->addtime);?></div>
                        			</td>
                        		</tr>
                        	</table>
                        </td>
                    </tr>
                </table>
            </li>
<?php } ?>
        </ul>
    </div>
</div>
<?php include_once('common_footer.php');?>
