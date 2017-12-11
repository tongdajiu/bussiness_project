<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$condition 	= !isset ($_REQUEST['condition']) 	? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 		= !isset ($_REQUEST['keys']) 		? '' : sqlUpdateFilter($_REQUEST['keys']);
$classid 	= !isset ($_REQUEST['classid']) 	? '0' : intval($_REQUEST['classid']);



$ProductTypeModel = D('ProductType');
$typeList = $ProductTypeModel->gets($arrWhere=array('classid'=>$classid),array('id'=>'desc'),$page, $perpage = 20);


$url = "?module=product_type_action";
$url = $url . "&condition=$condition&keys=$keys&page=";


switch ($act) {
	/***********添加类型页面**************/
	case 'add' :
		include "tpl/product_type_add.php";
		break;
	
	/***********添加处理****************/
	case 'add_save' :
		$classid = $_REQUEST['classid'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['classid']));
		$name    = $_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$sorting = $_REQUEST['sorting'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['sorting']));
		if ($ProductTypeModel->add($data=array('classid'=>$classid,'name'=>$name,'num'=>0,'sorting'=>$sorting))) {
			createAdminLog($db,3,"添加产品类型信息");
			redirect('?module=product_type_action', "添加成功");
			return;
		} else {
			redirect('?module=product_type_action', "系统忙,操作失败");
			return;
		}
		break;

	/**************修改页面*****************/	
	case 'edit' :
		$id = intval($_REQUEST['id']);
			if (empty ($id)) {
				redirect("?module=product_type_action&act=edit&id=" . $id, "ID不能为空");
				return;
			}
	    $obj = $ProductTypeModel->get($arrWhere=array('id'=>$id));
	    include "tpl/product_type_edit.php";
		
		break;
	
	/************修改处理**************/
	case 'edit_save':	
		$id = intval($_REQUEST['id']);
		$classid = $_REQUEST['classid'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['classid']));
		$name = $_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$num = $_REQUEST['num'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['num']));
		$sorting = $_REQUEST['sorting'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['sorting']));
		$data = array(
				'classid' => $classid,
				'name'	=>	$name,
				'num'	=>	$num,
				'sorting'	=>	$sorting
			);
			if($ProductTypeModel->modify($data,array('id'=>$id)) === false)
			{
				redirect("?module=product_type_action&act=edit&id=" . $id, "系统忙,操作失败");
				return;
			}
			createAdminLog($db,3,"编辑产品类型【".$obj->name."】信息,编号id:{$id}",'',$obj,$data,'product_type');
		
			redirect("?module=product_type_action&act=edit&id=" . $id, "修改成功");
			return;	
		break;
	
	/*****************删除处理****************/
	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=product_type_action', "您没选中任何条目");
			return;
		}
		if ($ProductTypeModel->delete($arrWhere=array('id'=>$id))) {

			createAdminLog($db,3,"删除产品类型信息,编号id:".implode(",", $id));

			redirect('?module=product_type_action', "操作成功");
			return;
		} else {
			redirect('?module=product_type_action', "系统忙");
			return;
		}
		break;
	default :
		include "tpl/product_type_list.php";
		break;
}
?>
