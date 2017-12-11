<?php
define('HN1', true);
require_once('./global.php');
include "common.php";	//设置只能用微信窗口打开

$act = !isset($_REQUEST['act']) ? '' : $_REQUEST['act'];

$FavoritesModel = M('favorites');
$ProductModel = D('Product');

$user = $_SESSION['userInfo'];

if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=favorites","您还未登陆！");
	return;
}

switch($act)
{
	case 'add' :
		$product_id = $_REQUEST['product_id'] == null ? 0 : intval($_REQUEST['product_id']);
		
		$obj = $FavoritesModel->get(array('userid'=>$userid,'product_id'=>$product_id));
		
		if(!empty($obj))
		{
			echo "已收藏";
			return;
		}
		
		$arrParam = array(
			'status'	=>	1,
			'type'		=>	1,
			'userid'	=>	$userid,
			'addtime'	=>	time(),
			'product_id'=>	$product_id
		);
		$rs = $FavoritesModel->add($arrParam);
		var_dump($rs);
		exit;
	break;

	case 'del':
		$id = array();
		$id = $_REQUEST['id'];

		$product_id = $_REQUEST['product_id'] == null ? 0 : intval($_REQUEST['product_id']);
		if(!empty($id))
		{
			$FavoritesModel->delete(array('__IN__'=>array('id'=>$id)));
		}
		else
		{
			$FavoritesModel->delete(array('userid'=>$userid,'product_id'=>$product_id));
		}
	break;

	default:
		$favoriteList =  $FavoritesModel->getAll(array('userid'=>$userid));
		include TEMPLATE_DIR.'/favorites_web.php';
	break;
}
?>
