<?php
define('HN1', true);
require_once('./global.php');
VersionModel::checkOpen('integralExchange');
require_once MODEL_DIR . '/IntegralProductModel.class.php';

include "common.php";	//设置只能用微信窗口打开

$integral_product = new IntegralProductModel($db);

$page = !isset($_GET['page'])  ? 1 : intval($_GET['page']);
$id   = !isset ($_GET['product_id'])  ? 0 : intval($_GET['product_id']);

$user = $_SESSION['userInfo'];

if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user");
	return;
}

$productList = $integral_product->gets(array('status'=>1),array('sorting'=>'DESC','id'=>'DESC'),$page,6);
include TEMPLATE_DIR.'/integral_product_web.php';
?>