<?php

define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$user = $_SESSION['userInfo'];
if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=user");
	return;
}

// 获取用户信息
$UserModel = D('User',$db);
$obj_user = $UserModel->get(array('id'=>$userid));

//----更新微信信息----
if($obj_user->name != null && $obj_user->name!='')
{
	$username = $obj_user->name;
}
else
{
	$wxUserInfo = get_userinfo($access_token,$obj_user->openid);

	if ( is_array($wxUserInfo) )
	{
		$username = $wxUserInfo['nickname'];
		$arrParam = array(
			'name' 			=> $wxUserInfo['nickname'],
			'sex' 			=> intval($wxUserInfo['sex']),
			'head_image'	=> $wxUserInfo['headimgurl'],
			'is_attention'  => 1
		);
		$arrWhere = array( 'id' => $userid );
		$UserModel->modify($arrParam, $arrWhere);
	}
}


//已发货订单
$OrderModel = D('Order',$db);
$onway_orders = $OrderModel->getCount(array('customer_id'=>$userid,'order_status_id'=>2,'user_del'=>array('<>',2) ));	//已发货订单


// 查找未评价的订单
$un_comment_orders = $OrderModel->getResultsNotComment($userid);

$product_count = 0;
if ( $un_comment_orders != null )
{
	foreach($un_comment_orders as $obj)
	{
		$OrderProdcutModel 	= D('OrderProduct');
		$OrderProdcuts 		= $OrderProdcutModel->getCount( array('order_id'=>$obj->order_id) );
		$product_count += count($OrderProdcuts);
	}
}


include TEMPLATE_DIR.'/user_web.php';
?>
