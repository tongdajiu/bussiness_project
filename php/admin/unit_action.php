<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

$page = !isset ($_GET['page']) ? 1 : intval($_GET['page']);
$status = !isset ($_GET['status']) ? -1 : intval($_GET['status']);
$act = !isset ($_REQUEST['act']) ? "list" : $_REQUEST['act'];
$condition = !isset ($_REQUEST['condition']) ? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys = !isset ($_REQUEST['keys']) ? '' : sqlUpdateFilter($_REQUEST['keys']);

$UnitModel = M('unit'); 
$unitList = $UnitModel->gets('',array('id'=>'desc'),$page, $perpage = 20);

$url = "?module=unit_action";
if ($status != '') {
	$url = $url . "&status=" . $status;
}
$url = $url . "&condition=$condition&keys=$keys&page=";

switch ($act) {
	/*************添加页面******************/
	case 'add' :
		include "tpl/unit_add.php";
		break;
	
	/****************添加处理*************/	
	case 'add_save' :
		$name   = $_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$status = $_REQUEST['status'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['status']));
		
		if ($UnitModel->add($data=array('name'=>$name,'status'=>$status,'addtime'=>time()))) {		

			createAdminLog($db,3,"添加产品单位信息【{$name}】");
		
			redirect('?module=unit_action', "添加成功");
			return;
		} else {
			redirect('?module=unit_action', "系统忙,操作失败");
			return;
		}
		break;

	/***********修改页面***********/	
	case 'edit' :
		$id   = $_REQUEST['id'] == null ? '' : $_REQUEST['id'];
		$obj  = $UnitModel->get($arrWhere=array('id'=>$id));
		include "tpl/unit_edit.php";
		break;
	
	/**************修改处理*************/
	case 'edit_save' :
		$id = intval($_REQUEST['id']);
		if (empty ($id)) {
			redirect("?module=unit_action&act=edit&id=" . $id, "ID不能为空");
			return;
		}
		$name   = $_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$status = $_REQUEST['status'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['status']));
		if ($UnitModel->modify($data=array('name'=>$name,'status'=>$status,'addtime'=>time()),$arrWhere=array('id'=>$id))) {
		
			createAdminLog($db,3,"编辑产品单位信息,编号id:{$id},名称更新为:{$name}");
		
			redirect("?module=unit_action&act=edit&id=" . $id, "修改成功");
			return;
		} else {
			redirect("?module=unit_action&act=edit&id=" . $id, "系统忙,操作失败");
			return;
		}
		break;
	
	/**************删除处理**************/
	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=unit_action', "您没选中任何条目");
			return;
		}
		if ($UnitModel->delete($arrWhere=array('id'=>$id))) {
			createAdminLog($db,3,"删除产品单位信息,编号id:".implode(",",$id));
			redirect('?module=unit_action', "操作成功");
			return;
		} else {
			redirect('?module=unit_action', "系统忙");
			return;
		}
		break;
	default :
		include "tpl/unit_list.php";
		break;
}


?>
