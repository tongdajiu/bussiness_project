<?php
!defined('HN1') && exit('Access Denied.');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once MODEL_DIR . '/LotteryLogModel.class.php';
$page      =! isset($_GET['page'])         ?  1 :  intval($_GET['page']);
$status    =! isset($_GET['status'])       ? -1 :  intval($_GET['status']);
$type      =! isset($_GET['type'])         ? '' :  intval($_GET['type']);
$user_id   =! isset($_GET['user_id'])      ? 0  :  intval($_GET['user_id']);
$act       =! isset($_REQUEST['act'])      ? "list" : $_REQUEST['act'];


include_once(  LIB_DIR . '/GameModel.class.php');
$Lottery_Log = GameFactoryModel::create('All');


/**********列表显示**********/
$activity=! isset($_REQUEST['activity']) ? '' : $_REQUEST['activity'];

$LotteryInfo = $Lottery_Log-> getGameLogList( $page,$activity,TRUE );


$url = "?module=lottery_log_action";


if($activity!=''){
	$url = $url."&activity=".$activity;
}

$url = $url."&page=";




/********删除处理*******/
switch($act){
	case 'del':
		$lottery_log_id =$_REQUEST['lottery_log_id']  == null ? '' : $_REQUEST['lottery_log_id'];
		$rd  = $Lottery_Log->delGameLog( $arrWhere =array('lottery_log_id'=>$lottery_log_id) );
		redirect('?module=lottery_action_new',"删除成功！");
		return;
		break;

	default:


include "tpl/lottery_log_web.php";
}

?>