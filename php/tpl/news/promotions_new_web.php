<?php include_once('common_header.php');?>
<link href="res/css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>

<?php include_once('loading.php');?>
<?php include "head_index.php";?>

<div class="index-wrapper">
	<div class="list-product">
        <ul>
<?php
foreach ($promotionsList as $row) {
?>
            <li class="list-productBg">
                <div class="list-product-R">
                <tr>
                 <td><a href="promotions_product.php?p_id=<?php echo $row->id;?>"><p class="list-product-R-tit"><?php echo $row->title?></p></a></td>
                  <td><p class="list-product-R-value">时间：<?php echo date("Y-m-d",$row->start_time);?> 至 <?php echo date("Y-m-d",$row->end_time);?></p></td>
                    </tr>
                </div>
            </li>
<?php }?>
        </ul>
    </div>
</div>
<?php include_once('common_footer.php');?>