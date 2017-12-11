<?php
define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$statusMap = array(1=>0, 2=>1, 3=>2, 4=>3);
$status = (isset($_GET['status']) && in_array($_GET['status'], array_keys($statusMap))) ? intval($_GET['status']) : -1;

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=agent_orders_new");
	return;
}

include_once(MODEL_DIR.'/OrderModel.class.php');
include_once(MODEL_DIR.'/UserChainModel.class.php');
$Order = new OrderModel($db, 'orders');
$UserChain = new UserChainModel($db, 'user_connection');

$orderList = array();
$subUserIds = $UserChain->getDownUids($userid);
if(!empty($subUserIds)){
	$orderNos = array();
	$orderCond = array('__IN__'=>array('customer_id'=>array_keys($subUserIds)));
	($status != -1) && $orderCond['order_status_id'] = $statusMap[$status];
	$orderList = $Order->gets($orderCond, array('addtime'=>'desc', 'order_id'=>'desc'));
	foreach($orderList['DataSet'] as $_k => $_o){
		$orderList['DataSet'][$_k]->user_level = $subUserIds[$_o->customer_id]['level'];
		$orderNos[] = $_o->order_number;
	}
	if(!empty($orderNos)){
		$orderUsers = $Order->getUsers($orderNos);
		foreach($orderList['DataSet'] as $_k => $_o){
			$orderList['DataSet'][$_k]->name = $orderUsers[$_o->order_number]['name'];
		}
	}
}
$statusText = array(0=>'待付款', 1=>'待发货', 2=>'待收货', 3=>'已收货');

include TEMPLATE_DIR.'/agent_orders_new_web.php';
?>