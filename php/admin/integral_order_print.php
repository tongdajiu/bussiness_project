<?php
!defined('HN1') && exit ('Access Denied.');
require_once ('../global.php');
VersionModel::checkOpen('integralExchangeManagement');

$integralOrders 		= M('integral_orders');
$integralOrdersDetail 	= M('integral_orders_detail');


$order_id = !isset ($_GET['order_id']) ? 0 : intval($_GET['order_id']);

define('nowmodule',"integral_orders_action");

$rebackUrl = '?module='.nowmodule;
empty($order_id) && redirect($rebackUrl, '参数错误');

$sql = "select io.*,u.name as customer from integral_orders as io left join user as u on io.customer_id=u.id where io.id={$order_id}";
$obj = $integralOrders->query($sql,true);

empty($obj) && redirect($rebackUrl, "订单不存在!");

$obj_details = $integralOrdersDetail->getAll(array('integral_orders_id'=>$obj->id));

empty($obj_details) && redirect($rebackUrl, '订单的商品详情不存在');


include ("tpl/integral_order_print_web.php");
?>