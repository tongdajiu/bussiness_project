<?php
define('HN1', true);
require_once('./global.php');
include "common.php";	//设置只能用微信窗口打开

$UserCouponModel = D('UserCoupon');
$OrderModel = D('Order');
$UserModel = D('User');
$OrderProductModel = D('OrderProduct');

$order_id = $_GET['order_id'] == null ? -1 : intval($_GET['order_id']);
$yunfei="0";//判断商品总费用少于150则加上20运费

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user");
	return;
}

$address = null;

$obj_order 	 	= $OrderModel->get(array('order_id'=>$order_id));
$obj_user 	 	= $UserModel->get(array('id'=>$userid));
$carts 		 	= $OrderProductModel->getAll(array('order_id'=>$order_id));

$coupon_list 	= $UserCouponModel->getUserCouponList( $user->id, 1);

$coupon_info 	= '';
$coupon_num     = '';

if ( $obj_order->coupon != '' )
{
	$strSQL 		= "SELECT c.`name`, c.`discount`,uc.`coupon_num` FROM `".T('coupon')."` AS c, `".T('user_coupon')."` AS uc WHERE c.`id`=uc.`coupon_id` AND uc.`coupon_num`={$obj_order->coupon}";
	$coupon_info 	= $UserCouponModel->query( $strSQL, true );
	$coupon_num     = $coupon_info->coupon_num;
}

include TEMPLATE_DIR.'/orders_confirm_web.php';
?>