<?php

define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$OrderModel = D('Order');
$OrderProductModel = D('OrderProduct');
$CommentModel = M('comment');


$order_id = $_REQUEST['order_id'] == null ? 0 : $_REQUEST['order_id'];

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=comment");
	return;
}

$obj_order = $OrderModel->get(array('order_id'=>$order_id));
$cartList = $OrderProductModel->getAll(array('order_id'=>$order_id));

if($_POST){
	$product_id = array();
	$score = array();
	$comment = array();

	$order_id = $_REQUEST['order_id'] == null ? 0 : $_REQUEST['order_id'];
	$userid = $_REQUEST['userid'] == null ? 0 : $_REQUEST['userid'];
	$product_id = $_REQUEST['product_id'];
//	$score = $_REQUEST['score'];
	$comment = $_REQUEST['comment'];

	$comments = $CommentModel->getAll(array('order_id'=>$order_id));


	// 添加评论
	$obj_order = $OrderModel->get(array('order_id'=>$order_id));
		
	$i = 0;
	foreach($product_id as $pid)
	{	
		$arrParam = array(
				'order_id' => $order_id,
				'order_number' => $obj_order->order_number,
				'product_id' => $pid,
				'customer_id'=>$userid,
				'shipping_firstname'=>$obj_order->shipping_firstname,
				'addtime'=>time(),
				'comment'=>$comment[$i]
		);
		
		$CommentModel->add($arrParam);
		$i++;
	}
	
	
	redirect("orders.php","评价成功");
	return;
}
include TEMPLATE_DIR.'/comment_web.php';
?>
