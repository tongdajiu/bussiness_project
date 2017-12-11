<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');



$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$type 		= !isset ($_GET['type']) 			? 0 : intval($_GET['type']);
$userid 	= !isset ($_GET['userid']) 			? 0 : intval($_GET['userid']);
$status 	= !isset ($_GET['status']) 			? -1 : intval($_GET['status']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$condition 	= !isset ($_REQUEST['condition']) 	? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 		= !isset ($_REQUEST['keys']) 		? '' : sqlUpdateFilter($_REQUEST['keys']);

$PayRecordsModel = M('pay_records');
$UserModel       = D('User');


$url = "?module=pay_records_action";
$sql = "select p.*,u.name as username from ".T('pay_records')." as p left join ".T('user')." as u on p.userid=u.id where 1=1";

if(!empty($keys)){
	switch($condition){
		case 'username':
			$sql .= " and name like '%{$keys}%'";
			break;

		case 'order_num':
			$sql .= " and order_num ='{$keys}'";
			break;
	}
	$url .=  "&condition=$condition&keys=$keys&page=";
}

$sql .=" order by addtime desc";


$url =$url. "&page=";
$payrecordsList = $PayRecordsModel->query($sql,false, true, $page, $perpage=20 );
include "tpl/pay_records_list.php";
?>
