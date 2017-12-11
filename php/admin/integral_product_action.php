<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('integralExchange');

$id 		= !isset($_GET['id'])  			? 0 :  intval($_GET['id']);
$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];

define('nowmodule',"integral_product_action");

$IntegralProductModel = D('IntegralProduct');

switch ($act) {
	
	/********添加保存*********/
	case 'add':
		include ("tpl/integral_product_add.php");
	break;
	
	/***********添加保存***********/
	case 'post' :

		$image = "";
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {

			!file_exists(INTEGRAL_PRODUCT_IMG_DIR) && mkdir(INTEGRAL_PRODUCT_IMG_DIR, 0777, true);
			!file_exists(INTEGRAL_PRODUCT_IMG_DIR."large/") && mkdir(INTEGRAL_PRODUCT_IMG_DIR."large/", 0777, true);
			!file_exists(INTEGRAL_PRODUCT_IMG_DIR."small/") && mkdir(INTEGRAL_PRODUCT_IMG_DIR."small/", 0777, true);

			$image = uploadfile("image", INTEGRAL_PRODUCT_IMG_DIR);
			ResizeImage(INTEGRAL_PRODUCT_IMG_DIR, INTEGRAL_PRODUCT_IMG_DIR."large/", $image, "600");
			ResizeImage(INTEGRAL_PRODUCT_IMG_DIR, INTEGRAL_PRODUCT_IMG_DIR."small/", $image, "250");

		}

		$name 		= $_REQUEST['name'] 		== null ? '' : trim($_REQUEST['name']);
		$inventory 	= $_REQUEST['inventory'] 	== null ? 0 : intval($_REQUEST['inventory']);
		$integral 	= $_REQUEST['integral'] 	== null ? 0 : intval($_REQUEST['integral']);
		$description = $_REQUEST['description'] == null ? '' : $_REQUEST['description'];
		$sorting = $_REQUEST['sorting'] 		== null ? 0 : intval($_REQUEST['sorting']);

		$data = array(
			'name'			=>	$name,
			'image'			=>	$image,
			'inventory'		=>	$inventory,
			'integral'		=>	$integral,
			'description'	=>	$description,
			'status'		=>	1,
			'sorting'		=>	$sorting
		);

		if($IntegralProductModel->add($data) === false)
		{
			redirect('?module='.nowmodule,"添加失败,系统繁忙!");
			return;
		}
		createAdminLog($db,9,"添加积分商品【".$name."】");
		redirect('?module='.nowmodule,"添加成功!");
		return;

	break;
	
	case 'edit':
		$obj = $IntegralProductModel->get(array('id'=>$id));
		include ("tpl/integral_product_edit.php");
	break;

	case 'edit_save' :

		$id = intval($_REQUEST['id']);
		if (empty ($id)) {
			redirect("?module=".nowmodule_."&act=edit&id=" . $id, "ID不能为空");
			return;
		}

		$obj_old = $IntegralProductModel->get(array('id'=>$id));
		$image = $obj_old->image;

		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			//检查图片文件是否存在
			if (file_exists(INTEGRAL_PRODUCT_IMG_DIR . $image)) {

				unlink(INTEGRAL_PRODUCT_IMG_DIR . $image);
				unlink(INTEGRAL_PRODUCT_IMG_DIR."large/" . $image);
				unlink(INTEGRAL_PRODUCT_IMG_DIR."small/". $image);
			}

			!file_exists(INTEGRAL_PRODUCT_IMG_DIR) && mkdir(INTEGRAL_PRODUCT_IMG_DIR, 0777, true);
			!file_exists(INTEGRAL_PRODUCT_IMG_DIR."large/") && mkdir(INTEGRAL_PRODUCT_IMG_DIR."large/", 0777, true);
			!file_exists(INTEGRAL_PRODUCT_IMG_DIR."small/") && mkdir(INTEGRAL_PRODUCT_IMG_DIR."small/", 0777, true);

			$image = uploadfile("image", INTEGRAL_PRODUCT_IMG_DIR);

			ResizeImage(INTEGRAL_PRODUCT_IMG_DIR, INTEGRAL_PRODUCT_IMG_DIR."large/", $image, "600");
			ResizeImage(INTEGRAL_PRODUCT_IMG_DIR, INTEGRAL_PRODUCT_IMG_DIR."small/", $image, "250");
		}

		$name 		= $_REQUEST['name'] 		== null ? '' : trim($_REQUEST['name']);
		$inventory 	= $_REQUEST['inventory'] 	== null ? 0 : intval($_REQUEST['inventory']);
		$integral 	= $_REQUEST['integral'] 	== null ? 0 : intval($_REQUEST['integral']);
		$description = $_REQUEST['description'] == null ? '' : $_REQUEST['description'];
		$sorting = $_REQUEST['sorting'] 		== null ? 0 : intval($_REQUEST['sorting']);

		$data = array(
			'name'			=>	$name,
			'image'			=>	$image,
			'inventory'		=>	$inventory,
			'integral'		=>	$integral,
			'description'	=>	$description,
			'status'		=>	1,
			'sorting'		=>	$sorting
		);

		$obj = $IntegralProductModel->get(array('id'=>$id));

		if($IntegralProductModel->modify($data,array('id'=>$id))=== false)
		{
			redirect('?module='.nowmodule_."&act=edit&id={$id}","修改失败,系统繁忙!");
			return;
		}

		createAdminLog($db,9,"编辑积分商品【".$obj->name."】",'',$obj,$data,'integral_product');
		redirect('?module='.nowmodule,"修改成功!");
		return;
	break;

	case 'update_status' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule, "ID不能为空");
			return;
		}
		$status = intval($_REQUEST['status']);

		if ($IntegralProductModel->modify(array('status'=>$status),array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙,操作失败");
			return;
		}

		if ($status == 1) {
			$state = '上架';
		}else{
			$state = '下架';
		}

		createAdminLog($db,9,"审核积分商品信息,积分商品id:".implode(",", $id).'更新状态为'.$state,'更新状态为'.$state);

		redirect('?module=' . nowmodule, "操作成功");
		return;

	break;

	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule, "您没选中任何条目");
			return;
		}

		$obj_array = $IntegralProductModel->getAll(array('__IN__'=>array('id'=>$id)));

		foreach($obj_array as $image_row)
		{
			$old_images[] = $image_row->image;
		}


		if($IntegralProductModel->delete(array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙");
			return;
		}

		if(!empty($old_images)){
			foreach($old_images as $old_image)
			{
				//检查图片文件是否存在
				if (file_exists(INTEGRAL_PRODUCT_IMG_DIR . $old_image)) {

					unlink(INTEGRAL_PRODUCT_IMG_DIR . $old_image);
					unlink(INTEGRAL_PRODUCT_IMG_DIR."large/" . $old_image);
					unlink(INTEGRAL_PRODUCT_IMG_DIR."small/". $old_image);
				}
			}
		}

		createAdminLog($db,9,"删除积分商品信息,积分商品id:".implode(",", $id));

		redirect('?module=' . nowmodule, "操作成功");
		return;

		break;
	default :

		$url = "?module=" . nowmodule;
		$strSQL = "SELECT * FROM integral_product WHERE 1=1";

		$keys = !isset ($_REQUEST['keys']) 	? '' : sqlUpdateFilter($_REQUEST['keys']);

		if($keys != '' && $keys != '请输入积分商品名称')
		{
			$strSQL .= " AND name LIKE '%{$keys}%'";
			$url .= "&keys={$keys}";
		}

		$url .= "&page=";

		$strSQL .= " ORDER BY sorting DESC,id DESC";

		$pager = $IntegralProductModel->query( $strSQL,false, true, $page, 20 );

		include "tpl/integral_product_list.php";
	break;
}
?>