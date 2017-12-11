<?php
define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$CouponModel = D('Coupon');
$UserModel   = D('User');
$UserConnectionModel = M('user_connection');
$UserCouponModel = D('UserCoupon');



$act = !isset($_REQUEST['act']) ? '' : $_REQUEST['act'];



$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=coupon_info");
	return;
}
//echo $userid;
switch($act)
{
	case 'give_friends':
		give_friends($db);
	break;

	default:
		$couponList = $UserCouponModel->getUserCouponList($user->id);
	break;
}

// function give_friends($db){
// // 	$ib = new couponBean();

// 	$exp_value = $_REQUEST['exp_value'] == null ? 0 : $_REQUEST['exp_value'];
// 	$userid =  $_REQUEST['userid'] == null ? 0 : $_REQUEST['userid'];
// 	$give_userid =  $_REQUEST['give_userid'] == null ? 0 : $_REQUEST['give_userid'];

// 	// 取一条优惠劵记录(电子优惠劵)，将用户ID修改成赠送者ID
// 	$arrWhere = array(
// 			'give_userid'=>$give_userid,
// 			'exp_value'  =>$exp_value
// 	);
// 	$obj_coupon = $CouponModel->get($arrWhere);
	
// 	$data=array(
// 		'id'=>$userid,
//    'give_userid'=>$give_userid
// 	);
// 	$CouponModel->modify($data,array($obj_coupon->id));

// 	redirect('coupon_info.php','赠送成功');
// 	return;
// }

include TEMPLATE_DIR.'/coupon_info_web.php';
?>