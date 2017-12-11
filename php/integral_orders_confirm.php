<?php
define('HN1', true);
require_once('./global.php');
VersionModel::checkOpen('integralExchangeManagement');
require_once MODEL_DIR . '/IntegralProductModel.class.php';
require_once MODEL_DIR . '/UserAddressModel.class.php';
require_once MODEL_DIR . '/UserModel.class.php';

include "common.php";	//设置只能用微信窗口打开

$userAddressModel = new UserAddressModel($db);
$integralProductModel = new IntegralProductModel($db);
$userModel = new UserModel($db);

$addressId = isset($_REQUEST['addressId']) ? intval($_REQUEST['addressId']) : 0;
$product_id = isset($_REQUEST['product_id']) ? intval($_REQUEST['product_id']) : 0;

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user","您还未登陆！");
	return;
}

$user_obj = $userModel->get(array('id'=>$userid,'status'=>1));

if(empty($user_obj))
{
	redirect("login.php?dir=user","您的账号被封,请联系客服！");
	return;
}

$address = $userAddressModel->get(array('id'=>$addressId,'userid'=>$userid));
if(empty($address))
{
	redirect("integral_address.php?product_id={$product_id}","收货地址错误,请勿违法操作");
	return;
}
$obj = $integralProductModel->get(array('id'=>$product_id,'status'=>1,'__NOTIN__'=>array('inventory' => 0)));
if(empty($obj))
{
	redirect("integral_product.php","商品已下架或库存不足！");
	return;
}

include TEMPLATE_DIR.'/integral_orders_confirm_web.php';
?>