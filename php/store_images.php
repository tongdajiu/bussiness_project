<?php
define('HN1', true);
require_once ('./global.php');
VersionModel::checkOpen('storeAlbumManagement');
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
	case 'add':
		$store_id = !isset($_GET['store_id']) ? 0 : intval($_GET['store_id']);

		if(empty($store_id))
		{
			redirect("store.php","缺少参数");
			return;
		}

		include TEMPLATE_DIR.'/store_images_add.php';
	break;

	case 'post':
		$store_id = !isset($_REQUEST['store_id']) ? 0 : intval($_REQUEST['store_id']);

		if(empty($store_id))
		{
			redirect("store.php","缺少参数");
			return;
		}

		$image = "";
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			!file_exists(STORE_IMG_DIR) && mkdir(STORE_IMG_DIR, 0777, true);
			!file_exists(STORE_IMG_DIR."large/") && mkdir(STORE_IMG_DIR."large/", 0777, true);
			!file_exists(STORE_IMG_DIR."small/") && mkdir(STORE_IMG_DIR."small/", 0777, true);

			$image = uploadfile("image", STORE_IMG_DIR);
			ResizeImage(STORE_IMG_DIR, STORE_IMG_DIR."large/", $image, "600");
			ResizeImage(STORE_IMG_DIR, STORE_IMG_DIR."small/", $image, "250");

		}
		$sorting 	= $_REQUEST['sorting'] 		== null ? 0 : intval($_REQUEST['sorting']);

		$data = array(
			'store_id'		=>	$store_id,
			'image'			=>	$image,
			'sorting'		=>	$sorting,
			'status'		=>	1,
			'create_time'	=>	time()
		);

		if($store_images->add($data) === false)
		{
			redirect("store_images.php?store_id={$store_id}","添加失败,系统繁忙!");
			return;
		}
		redirect("store_images.php?store_id={$store_id}","添加成功!");
		return;

	break;

	case 'del' :
		$store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;

		if(empty($store_id))
		{
			redirect("store.php","缺少门店参数id");
			return;
		}
		$id = intval($_REQUEST['id']);
		if (empty ($id)) {
			redirect("store_images.php?store_id={$store_id}", "缺少参数id");
			return;
		}

		$obj = $store_images->get(array('id'=>$id));
		$old_images = $obj->image;

		if($store_images->delete(array('id'=>$id,'store_id'=>$store_id)) === false)
		{
			redirect("store_images.php?store_id={$store_id}", "删除失败,系统忙");
			return;
		}

		if(!empty($old_images)){

			//检查图片文件是否存在
			if (file_exists(STORE_IMG_DIR . $old_image)) {
				unlink(STORE_IMG_DIR . $old_image);
				unlink(STORE_IMG_DIR."large/" . $old_image);
				unlink(STORE_IMG_DIR."small/". $old_image);
			}

		}

		redirect("store_images.php?store_id={$store_id}", "删除成功");
		return;

	break;

	default :
		$store_id = !isset($_GET['store_id']) ? -1 : intval($_GET['store_id']);
		$imgList = $store_images->getAll(array('store_id'=>$store_id,'status'=>1),array('sorting'=>'DESC','id'=>'DESC'));

		include TEMPLATE_DIR.'/store_images_web.php';

	break;
}
?>