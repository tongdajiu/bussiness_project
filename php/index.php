<?php
define('HN1', true);

require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开
require_once MODEL_DIR . '/GoodsTagModel.class.php';

$minfo =!isset($_REQUEST['minfo'])  ?  '': $_REQUEST['minfo'];
$from  =!isset($_REQUEST['from'])   ?  '': $_REQUEST['from'];
$i     =!isset($_REQUEST['i'])      ?  -1: $_REQUEST['i'];
$act   =!isset($_REQUEST['act'])    ?  '': $_REQUEST['act'];
$isappinstalled =!isset($_REQUEST['isappinstalled']) ;

if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=index&minfo=".$minfo);
	return;
}

$GoodsTag = new GoodsTagModel($db);

//微信分享脚本
$wxJsTicket 	= $objWX->getJsTicket();
$wxShareCBUrl 	= $site;
$wxJsSign 		= $objWX->getJsSign($wxShareCBUrl);

$User 			= M( 'user', $db );
$obj_user 		= $User->get(array('id'=>$userid));


$ProductModel = D( 'Product', $db );	// 获取首页商品信息
$product = $ProductModel->getNewList();

$hideIndexIcon = true;

$botNavCur['index'] = 'active';

define(  'HOME_IMG',  '/tpl/default/skin/default/images/index/' );

include TEMPLATE_DIR.'/index_web.php';
?>