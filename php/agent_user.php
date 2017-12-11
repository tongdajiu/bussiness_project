<?php
define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

require_once(MODEL_DIR.'/OrderModel.class.php');
require_once(MODEL_DIR.'/CommissionModel.class.php');
require_once(MODEL_DIR.'/UserChainModel.class.php');


$UserModel = D('User');
$Order      = new OrderModel($db);
$Commission = new CommissionModel($db, 'commission_log');
$UserChain  = new UserChainModel($db, 'user_connection');
$DistributorApplicationModel  = D('DistributorApplication');
$user = getCurSessionUser('agent_user');
$userid = $user->id;
$arrWhere = array(
'userid'=>$userid
);

$applicationInfo  = $DistributorApplicationModel->get($arrWhere);
$curDate = date('Y-m-d', time());
$startTime = getCurMonthFirstDay($curDate);
$endTime = getCurMonthLastDay($curDate)+86400-1;


$obj_user = $UserModel->get(array('id'=>$userid));


$all_price = $Order->getSubordinateTotalAmount($userid, 3, array('start'=>$startTime, 'end'=>$endTime), true);
$commission = $Commission->getTotalAmount($userid, array('start'=>$startTime, 'end'=>$endTime));
$lowerUserCount = $UserChain->getSubordinateCount($userid);

$minfo = $db->get_var("select u.minfo from `user` as u,agent_application as aga,agent_info as agi where u.id=agi.userid and aga.author_status=1 and u.type=1024 and u.id=".$userid);
if(!empty($minfo))
{
	$imgPath = AGENT_QRCODE_DIR."{$userid}.png";
}
else
{
	$imgPath = '';
}

$Product = M('product');
$productCount = $Product->getCount(array('status'=>1));
//todo 新品数量
$newPCount = min($productCount, 20);

include TEMPLATE_DIR.'/agent_user_web.php';
?>