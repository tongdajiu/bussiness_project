<?php

define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

require_once MODEL_DIR . '/GoodsTagModel.class.php';
$minfo       = !isset($_REQUEST['minfo'])  	 ? '' : $_REQUEST['minfo'];
$page        = !isset($_GET['page'])  		 ? 1  : intval($_GET['page']);
$category_id = !isset($_GET['category_id'])  ? -1 : intval($_GET['category_id']);
$hot         = !isset($_GET['hot'])  		 ? -1 : intval($_GET['hot']);
$id          = !isset ($_GET['product_id'])  ? 0  : intval($_GET['product_id']);

$type 	 = '';
if ( isset($_GET['t']) )
{
	$type 	 = in_array(trim($_GET['t']), array('new')) ? trim($_GET['t']) : '';	
}

$user 		 = $_SESSION['userInfo'];

if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=product&minfo=".$minfo."&category_id=".$category_id);
	return;
}

$goodstag 			= new GoodsTagModel($db);

$ProductTypeModel 	= D('ProductType', $db);
$re_productTypes 	= $ProductTypeModel->getList( 0 );				// 父分类列表
$productType 		= $ProductTypeModel->getInfo($category_id);		// 分类信息

$ProductModel 		= D('Product', $db);
switch($type){
	case 'new':
		$cond = array('status'=>1);
		($category_id > 0) && $cond['category_id'] = $category_id;
		$productList = $ProductModel->gets($cond, '`product_id` DESC', $page, 10);
		break;
	default:
		$productList = $ProductModel->getList( $category_id, $page, 10 );
		break;
}

$UserModel 			= M('user',$db);
$obj_user 			= $UserModel->get( array('id'=>$userid) );

$botNavCur['products'] = 'active';

include TEMPLATE_DIR.'/product_web_new.php';

?>
