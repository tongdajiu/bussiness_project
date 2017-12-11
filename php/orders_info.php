<?php
define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
include "common.php";	//设置只能用微信窗口打开

$UserCouponModel = D('UserCoupon');
$OrderModel = D('Order');
$UserModel = D('User');
$OrderProductModel = D('OrderProduct');

$order_id = $_GET['order_id'] == null ? -1 : intval($_GET['order_id']);
$user = $_SESSION['userInfo'];

if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=orders_info");
	return;
}

$obj_order = $OrderModel->get(array('order_id'=>$order_id));
$obj_user = $UserModel->get(array('id'=>$userid));
$carts = $OrderProductModel->getAll(array('order_id'=>$order_id));

$coupon_list 	= $UserCouponModel->getUserCouponList( $_SESSION['userInfo']->id );
$coupon_info 	= '';

if ( $obj_order->coupon != '' )
{
	$strSQL 		= "SELECT c.`name`, c.`discount` FROM `".T('coupon')."` AS c, `".T('user_coupon')."` AS uc WHERE c.`id`=uc.`coupon_id` AND uc.`coupon_num`={$obj_order->coupon}";
	$coupon_info 	= $UserCouponModel->query( $strSQL, true );
}

include TEMPLATE_DIR.'/orders_info_web.php';
?>