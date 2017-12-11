<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
require_once MODEL_DIR . '/AdminModel.class.php';


$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$type 		= !isset ($_REQUEST['type']) 		? -1 : $_REQUEST['type'];
$condition 	= !isset ($_REQUEST['condition']) 	? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 		= !isset ($_REQUEST['keys']) 		? '' : sqlUpdateFilter($_REQUEST['keys']);

define('nowmodule', "admin_log_action");

$url = "?module=" . nowmodule;

$admin_log = new AdminModel($db,'admin_log');

$action_type = array(
	'登录',
	'用户管理',
	'订单管理',
	'产品管理',
	'微信公众平台设置',
	'设置管理',
	'文章管理',
	'分销商管理',
	'门店资料管理',
	'活动促销'
);

switch ($act) {

	default :

		$strSQL = "select * from admin_log where 1=1";

		if($type > -1 && $type !='' )
		{
			$strSQL .= " and `type`={$type}";
			$url = $url . "&type={$type}";
		}

		if($condition == 'uname' && $keys != '')
		{
			$strSQL .= " and `uname` like '%{$keys}%'";
			$url = $url . "&condition=$condition&keys=$keys";
		}

		if($condition == 'name' && $keys != '')
		{
			$strSQL .= " and `name` like '%{$keys}%'";
			$url = $url . "&condition=$condition&keys=$keys";
		}

		$url = $url . "&page=";

		$strSQL .= " order by id desc";

		$pager = get_pager_data($db, $strSQL, $page,40);
		include "tpl/admin_log_list.php";
	break;
}
?>