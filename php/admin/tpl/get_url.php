<?php
define('HN1', true);
require_once('../../global.php');
$product_id 	=	!isset($_REQUEST['product_id']) 	? 0 : $_REQUEST['product_id'];
$info_id 		=	!isset($_REQUEST['info_id']) 		? 0 : $_REQUEST['info_id'];
$promotions_id 	=	!isset($_REQUEST['promotions_id']) 	? 0 : $_REQUEST['promotions_id'];
$pin_id 		=	!isset($_REQUEST['pin_id']) 		? 0 : $_REQUEST['pin_id'];
$category_id    =   !isset ($_REQUEST['category_id']) 	? 0 : ($_REQUEST['category_id']);
if($product_id > 0){
	echo $site."product_detail.php?product_id=".$product_id;
}
if($info_id > 0){
	echo $site."information_detail.php?id=".$info_id;
}
if($promotions_id > 0){
	echo $site."promotions_product.php?p_id=".$promotions_id;
}
if($pin_id > 0){
	echo $site."pin_details_new.php?pin_id=".$pin_id;
}
if($category_id > 0){
	echo $site."product.php?category_id=".$category_id;
}
?>
