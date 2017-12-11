<?php
define('HN1', true);
require_once('global.php');
require_once MODEL_DIR . '/UserAddressModel.class.php';

include "common.php";	//设置只能用微信窗口打开

$product_id = intval($_GET['product_id']);

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user","您还未登陆！");
	return;
}

$userAddressModel = new UserAddressModel($db);
$addressList = $userAddressModel->getAll(array('userid'=>$userid),array('id'=>'DESC'));

include TEMPLATE_DIR.'/integral_address_web.php';
?>