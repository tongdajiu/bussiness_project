<?php
/**
 * 分销商佣金
 */
define('HN1', true);
require_once('global.php');
VersionModel::checkOpen('distributorWalletManagement');
include "common.php";	//设置只能用微信窗口打开

$user = getCurSessionUser('agent_commission');

$time = time();
$curYear = date('Y', $time);
$curMonth = date('m', $time);
$years = range($curYear-1, $curYear);
$months = range(1, 12);

$speYear = isset($_GET['year']) ? intval($_GET['year']) : $curYear;
$speMonth = isset($_GET['month']) ? intval($_GET['month']) : $curMonth;

$selYear = array($speYear=>' selected');
$selMonth = array($speMonth=>' selected');

include_once(MODEL_DIR.'/CommissionModel.class.php');
$Commission = new CommissionModel($db, 'commission_log');

$arrCond = array();
$arrCond[] = 'user_id='.$user->id." AND `order_no`<>'' AND `order_no`<>'0'";
if(($speYear > 0) && ($speMonth > 0)){
    $arrCond[] = 'time>='.getCurMonthFirstDay($speYear.'-'.$speMonth);
    $arrCond[] = 'time<='.(getCurMonthLastDay($speYear.'-'.$speMonth)+86400-1);
}

$list = $Commission->getAll(implode(' AND ', $arrCond), array('time'=>'desc'));
$userList = array();
if(!empty($list)){
    $uids = array();
    $orderNos = array();
    foreach($list as $v){
        $uids[] = $v->user_id;
        $orderNos[] = $v->order_no;
    }
    if(!empty($orderNos)){
        include_once(MODEL_DIR.'/OrderModel.class.php');
        $Order = new OrderModel($db);
        $userRs = $Order->getUsers($orderNos);
        if(!empty($userRs)){
            foreach($userRs as $_u){
                $userList[$_u['order_number']] = $_u;
            }
        }
    }
}

include TEMPLATE_DIR.'/agent_commission_web.php';