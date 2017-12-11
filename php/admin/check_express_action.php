<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('setWaybill');
include_once(LOGISTIC_DIR.'/Logistics.class.php');
require_once LOGISTIC_DIR.'/express.php';

define('nowmodule',"check_express_action");

global $ExpressType;
global $gSetting;

$act = !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$express_type = @$_REQUEST['express_type'] == null ? '' : $_REQUEST['express_type'];
$express_number = @($_REQUEST['express_number'] == null || trim($_REQUEST['express_number']) == '请输入物流编号')  ? '' : trim($_REQUEST['express_number']);
$result = null;


$express = new Express();	//实例化
$express = $express->setInterface($gSetting['logistics_interface']);	//设置物流接口
$express->setCodeId($gSetting['express_code_id']);	//设置物流身份授权id

switch ($act) {
	case 'detail' :		
		$result = $express->getExpress($express_type,$express_number);
		
		header('Content-type: text/html; charset=utf-8');
		
		include ("tpl/check_express_web.php");
	break;
	
	case 'search':
		if($express_type == '' || $express_number == '')
		{
			redirect('?module=' . nowmodule, "请输入搜索条件");
			return;
		}
		
		$result = $express->getExpress($express_type,$express_number);
		include "tpl/check_express_list.php";
	break;
	
	default:
		include "tpl/check_express_list.php";
	break;
}
?>