<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('goodsCollect');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$status 	= !isset ($_GET['status']) 			? -1 : intval($_GET['status']);
$type 		= !isset ($_GET['type']) 			? -1 : intval($_GET['type']);
$userid 	= !isset ($_GET['userid']) 			? 0 : intval($_GET['userid']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];

$FavoritesModel = D('Favorites');
$UserModel      = D('User');
$ProductModel   = D('Product');
$favoritesList = $FavoritesModel->query( "SELECT f.`id`,f.`status`,f.`type`,f.`addtime`,(SELECT `name` FROM `user` WHERE `id`=f.`userid`) AS username, (SELECT `name` FROM `product` WHERE `product_id`=f.`product_id`) AS productname FROM favorites AS f ORDER BY `addtime` desc ",false, true, $page, $perpage=20 );

$url = "?module=favorites_action";
if ($status != '') {
	$url = $url . "&status=" . $status;
}
if ($type != '') {
	$url = $url . "&type=" . $type;
}
if ($userid != '') {
	$url = $url . "&userid=" . $userid;
}
$url = $url . "&page=";



include "tpl/favorites_list.php";
?>