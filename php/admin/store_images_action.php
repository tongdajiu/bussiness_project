<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('storeAlbumManagement');

$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$store_id 	= !isset ($_REQUEST['store_id']) 	? 0 : intval($_REQUEST['store_id']);

define('nowmodule',"store_images_action");

$StoreInformationModel = D('StoreInformation');
$StoreImagesModel = D('StoreImages');

$obj = $StoreInformationModel->get(array('id'=>$store_id));

switch ($act) 
{
	
	/**************添加**************/
	case 'add':
		include ("tpl/store_images_add.php");
	break;
	
	/**************添加保存**************/
	case 'post' :

		if(empty($store_id))
		{
			redirect('?module=store_information_action',"添加失败,缺少所属门店id!");
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

		if($StoreImagesModel->add($data) === false)
		{
			redirect('?module='.nowmodule."&store_id={$store_id}","添加失败,系统繁忙!");
			return;
		}
		createAdminLog($db,8,"添加门店【".$obj->name."】图册","图片名:{$image}");
		redirect('?module='.nowmodule."&store_id={$store_id}","添加成功!");
		return;

	break;

	/**************编辑**************/
	case 'edit':
		$id = !isset($_GET['id'])  	? 0 :  intval($_GET['id']);

		if(empty($id))
		{
			redirect("?module=".nowmodule."&store_id={$store_id}","ID不能为空!");
			return;
		}
		
		
		$obj = $StoreImagesModel->get(array('id'=>$id));
		include ("tpl/store_images_edit.php");
	break;
	
	/**************编辑保存**************/
	case 'edit_save' :

		if(empty($store_id))
		{
			redirect('?module=store_information_action',"修改失败,缺少所属门店id!");
			return;
		}

		$id = intval($_REQUEST['id']);
		if (empty ($id)) {
			redirect("?module=".nowmodule."&act=edit&store_id={$store_id}&id=" . $id, "ID不能为空");
			return;
		}

		$obj_old = $StoreImagesModel->get(array('id'=>$id));
		$image = $obj_old->image;

		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			//检查图片文件是否存在
			if (file_exists(STORE_IMG_DIR . $image)) {

				unlink(STORE_IMG_DIR . $image);
				unlink(STORE_IMG_DIR."large/" . $image);
				unlink(STORE_IMG_DIR."small/". $image);
			}

			!file_exists(STORE_IMG_DIR) && mkdir(STORE_IMG_DIR, 0777, true);
			!file_exists(STORE_IMG_DIR."large/") && mkdir(STORE_IMG_DIR."large/", 0777, true);
			!file_exists(STORE_IMG_DIR."small/") && mkdir(STORE_IMG_DIR."small/", 0777, true);

			$image = uploadfile("image", STORE_IMG_DIR);

			ResizeImage(STORE_IMG_DIR, STORE_IMG_DIR."large/", $image, "600");
			ResizeImage(STORE_IMG_DIR, STORE_IMG_DIR."small/", $image, "250");
		}

		$sorting 	= $_REQUEST['sorting'] 		== null ? 0 : intval($_REQUEST['sorting']);

		$data = array(
			'image'			=>	$image,
			'sorting'		=>	$sorting
		);

		if($StoreImagesModel->modify($data,array('id'=>$id,'store_id'=>$store_id))=== false)
		{
			redirect('?module='.nowmodule."&act=edit&store_id={$store_id}&id={$id}","修改失败,系统繁忙!");
			return;
		}

		createAdminLog($db,8,"编辑门店【".$obj->name."】图册,图册编号id:{$id}","图片名更新为:{$image}");
		redirect('?module='.nowmodule."&store_id={$store_id}","修改成功!");
		return;
	break;

	/**************更新状态**************/
	case 'update_status' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule, "ID不能为空");
			return;
		}
		$status = intval($_REQUEST['status']);

		if ($StoreImagesModel->modify(array('status'=>$status),array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule."&store_id={$store_id}", "系统忙,操作失败");
			return;
		}

		if ($status == 1) {
			$state = '已审核';
		}else{
			$state = '待审核';
		}

		createAdminLog($db,8,"审核门店【".$obj->name."】图册,图册编号id:".implode(",", $id).'更新状态为'.$state,'更新状态为'.$state);

		redirect('?module=' . nowmodule."&store_id={$store_id}", "操作成功");
		return;

	break;

	/**************删除数据**************/
	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule."&store_id={$store_id}", "您没选中任何条目");
			return;
		}

		$obj_array = $StoreImagesModel->getAll(array('__IN__'=>array('id'=>$id)));

		foreach($obj_array as $image_row)
		{
			$old_images[] = $image_row->image;
		}


		if($StoreImagesModel->delete(array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule."&store_id={$store_id}", "系统忙");
			return;
		}

		if(!empty($old_images)){
			foreach($old_images as $old_image)
			{
				//检查图片文件是否存在
				if (file_exists(STORE_IMG_DIR . $old_image)) {

					unlink(STORE_IMG_DIR . $old_image);
					unlink(STORE_IMG_DIR."large/" . $old_image);
					unlink(STORE_IMG_DIR."small/". $old_image);
				}
			}
		}

		createAdminLog($db,8,"删除门店【".$obj->name."】图册信息,图册编号id:".implode(",", $id));

		redirect('?module=' . nowmodule."&store_id={$store_id}", "操作成功");
		return;

	break;
	
	/**************默认列表页**************/
	default :
		$url = "?module=" . nowmodule."&store_id={$store_id}&page=";

		$strSQL = "SELECT * FROM store_images WHERE store_id={$store_id} ORDER BY sorting DESC,id DESC";
		$pager = $StoreImagesModel->query( $strSQL,false, true, $page, $perpage=40 );
		include "tpl/store_images_list.php";
	break;
}
?>