<?php
define('HN1', true);
require_once ('./global.php');
VersionModel::checkOpen('storeInfoManagement');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

include "common.php"; //设置只能用微信窗口打开

require_once MODEL_DIR . '/StoreInformationModel.class.php';
require_once MODEL_DIR . '/StoreImagesModel.class.php';

$act = $_REQUEST['act'] == null ? '' : $_REQUEST['act'];

$store_information = new StoreInformationModel($db);
$store_images = new StoreImagesModel($db);

$user = $_SESSION['userInfo'];
if ($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=user.php");
	return;
}

switch ($act) {
	case 'edit' :
		$id = !isset($_GET['id']) ? -1 : intval($_GET['id']);
		if($id > 0)
		{
			$obj = $store_information->get(array('uid'=>$userid,'status'=>1,'id'=>$id));
			$imgList = $store_images->getAll(array('store_id'=>$id,'status'=>1),array('sorting'=>'DESC','id'=>'DESC'));
			include TEMPLATE_DIR.'/store_edit.php';
		}
		else
		{
			redirect("store.php","缺少参数");
			return;
		}
	break;

	case 'edit_save' :
		$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		if(empty($id))
		{
			redirect("store.php","缺少参数id！");
			return;
		}
		$name 		= $_REQUEST['name'] 		== null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$address 	= $_REQUEST['address'] 		== null ? '' : sqlUpdateFilter($_REQUEST['address']);
		$longitude 	= $_REQUEST['longitude'] 	== null ? '' : sqlUpdateFilter($_REQUEST['longitude']);
		$latitude 	= $_REQUEST['latitude'] 	== null ? '' : sqlUpdateFilter($_REQUEST['latitude']);
		$mobile 	= $_REQUEST['mobile'] 		== null ? '' : sqlUpdateFilter($_REQUEST['mobile']);

		if(empty($name))
		{
			redirect("store.php?act=edit&id={$id}","门店名称不为空！");
			return;
		}
		if(empty($address))
		{
			redirect("store.php?act=edit&id={$id}","详细地址不为空！");
			return;
		}
		if(empty($longitude))
		{
			redirect("store.php?act=edit&id={$id}","请选中地图位置！");
			return;
		}
		if(empty($latitude))
		{
			redirect("store.php?act=edit&id={$id}","请选中地图位置！");
			return;
		}
		if(empty($mobile))
		{
			redirect("store.php?act=edit&id={$id}","联系手机不为空！");
			return;
		}

		$data = array(
			'name'		=>	$name,
			'mobile'	=>	$mobile,
			'address'	=>	$address,
			'longitude'	=>	$longitude,
			'latitude'	=>	$latitude,
		);

		if($store_information->modify($data,array('id'=>$id,'uid'=>$userid)) === false)
		{
			redirect("store.php?act=edit&id={$id}","修改失败,系统繁忙!");
			return;
		}

		redirect("store.php","修改成功!");
		return;

	break;

	case 'detail':
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

		if(empty($id))
		{
			redirect("store.php","缺少参数id!");
			return;
		}

		$obj = $store_information->get(array('id'=>$id,'uid'=>$userid,'status'=>1));
		$imgList = $store_images->getAll(array('store_id'=>$obj->id,'status'=>1),array('sorting'=>'DESC','id'=>'DESC'));
		include TEMPLATE_DIR.'/store_web.php';
	break;

	default :
		$store_num = $store_information->getCount(array('uid'=>$userid,'status'=>1));
		if($store_num < 1)
		{
			redirect("user.php","您没有门店,请先联系客服！");
			return;
		}
		if($store_num > 1)
		{
			$storeList = $store_information->getAll(array('uid'=>$userid,'status'=>1));
			include TEMPLATE_DIR.'/store_list_web.php';
		}
		else
		{
			$obj = $store_information->get(array('uid'=>$userid,'status'=>1));
			$imgList = $store_images->getAll(array('store_id'=>$obj->id,'status'=>1),array('sorting'=>'DESC','id'=>'DESC'));

			include TEMPLATE_DIR.'/store_web.php';
		}

	break;
}
?>