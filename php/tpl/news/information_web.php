<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<?php include "head_index.php";?>

<div class="index-wrapper">
    <ul class="message-list">
	<?php
	foreach ($infoList as $row) {
	?>
        <li>
            <a href="information_detail.php?id=<?php echo $row->id;?>">
            	<p class="list-product-R-tit"><?php echo $row->title?></p>
            	<p class="list-product-R-value"><?php echo date("Y-m-d H:i:s",$row->addtime);?></p>
            </a>
        </li>
	<?php }?>
    </ul>
</div>
<?php include_once('common_footer.php');?>
