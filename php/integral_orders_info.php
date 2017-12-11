<?php
define('HN1', true);
require_once('./global.php');
VersionModel::checkOpen('integralExchangeManagement');
require_once MODEL_DIR . '/UserModel.class.php';

include "common.php";	//设置只能用微信窗口打开
$userModel 				= new UserModel($db);
$integralOrders 		= M('integral_orders');
$integralOrdersDetail 	= M('integral_orders_detail');

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

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

$orders_obj = $integralOrders->get(array('id'=>$order_id,'customer_id' => $userid,'user_del' => 0));
if(empty($orders_obj))
{
	redirect("integral_orders.php","找不到该订单！");
	return;
}

$orders_details = $integralOrdersDetail->getAll(array('userid'=>$userid,'integral_orders_id'=>$orders_obj->id));
if(empty($orders_details))
{
	redirect("integral_orders.php","找不到该订单！");
	return;
}


include TEMPLATE_DIR.'/integral_orders_info_web.php';

?>