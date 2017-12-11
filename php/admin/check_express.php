<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');
VersionModel::checkOpen('setWaybill');
include_once(LOGISTIC_DIR.'/Logistics.class.php');
require_once LOGISTIC_DIR.'/express.php';

$express_type = $_REQUEST['express_type'] == null ? '' : $_REQUEST['express_type'];
$express_number = $_REQUEST['express_number'] == null ? '' : $_REQUEST['express_number'];

global $gSetting;

$express = new Express();	//实例化				
$express = $express->setInterface($gSetting['logistics_interface']);	//设置物流接口
$express->setCodeId($gSetting['express_code_id']);	//设置物流身份授权id
$result = $express->getExpress($express_type,$express_number);

header('Content-type: text/html; charset=utf-8');
?>

