<?php
define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
include "common.php";	//设置只能用微信窗口打开

$CommentModel = M('comment');
$OrderModel = D('Order');
$OrderProductModel = D('OrderProduct');

$order_id = $_REQUEST['order_id'] == null ? 0 : $_REQUEST['order_id'];

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=comment_info");
	return;
}

$obj_order = $OrderModel->get(array('order_id'=>$order_id));
$cartList = $OrderProductModel->getAll(array('order_id'=>$order_id));

include TEMPLATE_DIR.'/comment_info_web.php';
?>