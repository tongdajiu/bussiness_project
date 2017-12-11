<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('storeInfoManagement');

$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$keys 		= !isset ($_REQUEST['keys']) 		? '' : sqlUpdateFilter($_REQUEST['keys']);

define('nowmodule',"store_information_action");


$StoreInformationModel = D('StoreInformation');
$StoreImagesModel = D('StoreImages');

switch ($act) 
{	
	/********************添加*************************/
	case 'add':
		include ("tpl/store_information_add.php");
	break;
	
	/********************添加保存**********************/
	case 'post' :
		$name 		= $_REQUEST['name'] 		== null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$address 	= $_REQUEST['address'] 		== null ? '' : sqlUpdateFilter($_REQUEST['address']);
		$longitude 	= $_REQUEST['longitude'] 	== null ? '' : sqlUpdateFilter($_REQUEST['longitude']);
		$latitude 	= $_REQUEST['latitude'] 	== null ? '' : sqlUpdateFilter($_REQUEST['latitude']);
		$mobile 	= $_REQUEST['mobile'] 		== null ? '' : sqlUpdateFilter($_REQUEST['mobile']);
		$uid 		= $_REQUEST['uid'] 			== null ? '' : sqlUpdateFilter($_REQUEST['uid']);

		if (empty ($uid)) {
			redirect('?module=' . nowmodule.'&act=add', "请选择负责人！");
			return;
		}

		$data = array(
			'uid'		=>	$uid,
			'name'		=>	$name,
			'mobile'	=>	$mobile,
			'address'	=>	$address,
			'longitude'	=>	$longitude,
			'latitude'	=>	$latitude,
			'create_time'	=>	time(),
			'status'	=>	1
		);

		if($StoreInformationModel->add($data) === false)
		{
			redirect('?module='.nowmodule,"添加失败,系统繁忙!");
			return;
		}
		createAdminLog($db,8,"添加门店【{$name}】资料");
		redirect('?module='.nowmodule,"添加成功!");
		return;

	break;

	/********************编辑*************************/
	case 'edit' :
		$id = !isset($_GET['id'])  ? 0 :  intval($_GET['id']);
		
		if(empty($id))
		{
			redirect("?module=".nowmodule, "ID不能为空");
			return;
		}
		$UserModel = D('User');
		$obj = $StoreInformationModel->get(array('id'=>$id));
		$user_obj = $UserModel->get(array('id'=>$obj->uid));
		include ("tpl/store_information_edit.php");
	break;
	
	/********************编辑保存**********************/
	case 'edit_save':
		$id = intval($_REQUEST['id']);
		if (empty ($id)) {
			redirect("?module=".nowmodule."&act=edit&id=" . $id, "ID不能为空");
			return;
		}
		
		$name 		= $_REQUEST['name'] 		== null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$address 	= $_REQUEST['address'] 		== null ? '' : sqlUpdateFilter($_REQUEST['address']);
		$longitude 	= $_REQUEST['longitude'] 	== null ? '' : sqlUpdateFilter($_REQUEST['longitude']);
		$latitude 	= $_REQUEST['latitude'] 	== null ? '' : sqlUpdateFilter($_REQUEST['latitude']);
		$mobile 	= $_REQUEST['mobile'] 		== null ? '' : sqlUpdateFilter($_REQUEST['mobile']);
		$uid 		= $_REQUEST['uid'] 			== null ? '' : sqlUpdateFilter($_REQUEST['uid']);
		
		if (empty ($uid)) {
			redirect('?module='.nowmodule.'&act=edit&id='.$id, "请选择负责人！");
			return;
		}
		
		
		$data = array(
				'uid'		=>	$uid,
				'name'		=>	$name,
				'mobile'	=>	$mobile,
				'address'	=>	$address,
				'longitude'	=>	$longitude,
				'latitude'	=>	$latitude,
		);
		$obj = $StoreInformationModel->get(array('id'=>$id));
		if($StoreInformationModel->modify($data,array('id'=>$id)) === false)
		{
			redirect('?module='.nowmodule.'&act=edit&id='.$id,"修改失败,系统繁忙!");
			return;
		}
		
		createAdminLog($db,8,"编辑门店【".$obj->name."】资料",'',$obj,$data,'store_information');
		redirect('?module='.nowmodule,"修改成功!");
		return;
	break;
	
	/********************更新状态**********************/
	case 'update_status' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule, "ID不能为空");
			return;
		}
		$status = intval($_REQUEST['status']);

		if ($StoreInformationModel->modify(array('status'=>$status),array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙,操作失败");
			return;
		}

		if ($status == 1) {
			$state = '启用';
		}else{
			$state = '禁用';
		}

		createAdminLog($db,8,"审核门店资料信息,编号id:".implode(",", $id).'更新状态为'.$state,'更新状态为'.$state);

		redirect('?module=' . nowmodule, "操作成功");
		return;

	break;

	/********************删除数据***********************/
	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule, "您没选中任何条目");
			return;
		}

		//获取删除前的数据
		$obj_array = $StoreImagesModel->getAll(array('__IN__'=>array('store_id'=>$id)));


		if($obj_array != null)
		{
			//获取需要删除的图片名
			foreach($obj_array as $image_row)
			{
				$old_images[] = $image_row->image;
			}
		}


		if($StoreInformationModel->delete(array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙");
			return;
		}

		//删除门店下的图册信息
		$StoreImagesModel->delete(array('__IN__'=>array('store_id'=>$id)));

		if(!empty($old_images)){
			foreach($old_images as $old_image)
			{
				//检查图片文件是否存在
				if (file_exists(STORE_IMG_DIR . $old_image)) {

					//删除相对应的图片
					unlink(STORE_IMG_DIR . $old_image);
					unlink(STORE_IMG_DIR."large/" . $old_image);
					unlink(STORE_IMG_DIR."small/". $old_image);
				}
			}
		}

		createAdminLog($db,8,"删除门店资料信息,编号id:".implode(",", $id));
		redirect('?module=' . nowmodule, "操作成功");
		return;
		
	break;
	
	/********************默认列表页************************/
	default :
		$url = "?module=" . nowmodule;
		$strSQL = "select si.*,u.name as user_name from ".T('store_information')." as si left join ".T('user')." as u on si.uid=u.id where 1=1";

		if($keys != '' && $keys != '请输入门店名称')
		{
			$strSQL .= " AND si.name LIKE '%{$keys}%'";
			$url .= "&keys={$keys}";
		}

		$url .= "&page=";

		$strSQL .= " ORDER BY si.id DESC";

		$pager = $StoreInformationModel->query( $strSQL,false, true, $page, $perpage=40 );
		include "tpl/store_information_list.php";
	break;
}
?>