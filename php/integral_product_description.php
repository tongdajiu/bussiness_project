<?php
define('HN1', true);
require_once('./global.php');
VersionModel::checkOpen('integralExchange');

include "common.php";	//设置只能用微信窗口打开

require_once MODEL_DIR . '/IntegralProductModel.class.php';
$integral_product = new IntegralProductModel($db);

$product_id = $_GET['product_id'] == null ? -1 : intval($_GET['product_id']);

$obj = $integral_product->get(array('id'=>$product_id));

include TEMPLATE_DIR.'/integral_product_description_web.php';
?>
