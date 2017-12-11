<?php
define('HN1', true);
require_once ('./global.php');
VersionModel::checkOpen('integralExchange');

include "common.php"; //设置只能用微信窗口打开

require_once MODEL_DIR . '/IntegralProductModel.class.php';
require_once MODEL_DIR . '/UserModel.class.php';

$integral_product = new IntegralProductModel($db);
$userModel = new UserModel($db);

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user","您还未登陆！");
	return;
}

$product_id = $_GET['product_id'] 	== null ? -1 : intval($_GET['product_id']);
$act 		= !isset($_REQUEST['act'])	? '' : $_REQUEST['act'];

$user_obj = $userModel->get(array('id'=>$userid,'status'=>1));

if(empty($user_obj))
{
	redirect("login.php?dir=user","您的账号被封,请联系客服！");
	return;
}

switch ($act) {
	default :
		$obj = $integral_product->get(array('id'=>$product_id,'status'=>1));
		if(empty($obj))
		{
			redirect("integral_orders.php", "该商品已经下架，无法查看！");
			return;
		}
		break;
}
include TEMPLATE_DIR.'/integral_product_detail_web.php';
?>