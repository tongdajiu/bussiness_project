<?php

define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

require_once SCRIPT_ROOT.'model/UserCouponModel.class.php';
require_once SCRIPT_ROOT . "/lib/log.php";
$logFile 		= SCRIPT_ROOT . '/log/wx/coupon_consume_' . date('Y_m_d',time()) . '.log';
$logHandler		= new CLogFileHandler( $logFile );
Log::Init($logHandler, 1);


$act    = !isset($_REQUEST['act'])    ?  '' : $_REQUEST['act'];
$type   = !isset($_REQUEST['type'])   ?  '' : $_REQUEST['type'];

$user = $_SESSION['userInfo'];
if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=coupon");
	return;
}

switch( $act )
{
	case 'add':
		$UserCouponModel = D( 'UserCoupon' );
		$rs = $UserCouponModel->addRecord( $user->id, 99, $type );

		if ( $rs == -2 )
		{
			$msg = '优惠券不可用';
		}
		else if ( $rs == -1 )
		{
			$msg = '添加有误，获取失败';
		}
		else if ( $rs == -3 )
		{
			$msg = '您已领取该优惠券';
		}
		else
		{
			$msg = '优惠券获取成功';
		}
		
		echo ajaxResponse( $rs, $msg, '' );
	break;

	default:
		include TEMPLATE_DIR.'/coupon_web.php';
}



?>
