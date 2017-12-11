<?php
define('HN1', true);
require_once('./global.php');
include "common.php";	//设置只能用微信窗口打开

$product_id = $_GET['product_id'] == null ? -1 : intval($_GET['product_id']);

$ProductModel = D('Product');
$obj = $ProductModel->get(array('product_id'=>$product_id),array('description'));

include TEMPLATE_DIR.'/product_description_web.php';
?>