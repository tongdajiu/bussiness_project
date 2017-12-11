<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
$page	=	! isset($_GET['page'])		? 1 : intval($_GET['page']);
$act	=	! isset($_REQUEST['act'])	? "list" : $_REQUEST['act'];

$AttributeModel = M('attribute');
$attributeList = $AttributeModel->gets('',array('attr_id'=>'desc'),$page, $perpage = 20);
$url  = "?module=attribute_action". "&page=";




switch ($act)
{
	/**********添加页面***********/
	case 'add' :
		include "tpl/attribute_add.php";
		break;
		
	/*********添加处理***********/	
	case 'add_save' :		
		$attr_name 	= isset($_REQUEST['attr_name']) 	? trim($_REQUEST['attr_name']) 	:	'';
		$attr_value = isset($_REQUEST['attr_value']) 	? $_REQUEST['attr_value']		:	'';
		$sorting	= isset($_REQUEST['sorting'])		? intval($_REQUEST['sorting'])	:	0;

		$arrList = array(
			'attr_name'		=>	$attr_name,
			'attr_value'	=>	$attr_value,
			'sorting'		=>	$sorting
		);

		if($AttributeModel->add($arrList))
		{
			createAdminLog($db,3,"添加产品属性信息");
			redirect('?module=attribute_action', "操作成功");
		}
		else
		{
			redirect('?module=attribute_action', "系统忙，操作失败");
		}
		return;
	break;

	/*************修改页面*************/
	case 'edit' :
		$attr_id  = !isset ($_GET['attr_id']) ? 0 : intval($_GET['attr_id']);
		$obj = $AttributeModel->get($arrWhere=array('attr_id'=>$attr_id));
		include "tpl/attribute_edit.php";
		break;
		
	/************修改处理*************/	
    case 'edit_save' :
    	$attr_id    = isset($_REQUEST['attr_id']) 	    ? $_REQUEST['attr_id']		    :	'';
    	$attr_name 	= isset($_REQUEST['attr_name']) 	? trim($_REQUEST['attr_name']) 	:	'';
		$attr_value = isset($_REQUEST['attr_value']) 	? $_REQUEST['attr_value']		:	'';
		$sorting	= isset($_REQUEST['sorting'])		? intval($_REQUEST['sorting'])	:	0;

		$arrParam = array(
			'attr_name'		=>	$attr_name,
			'attr_value'	=>	$attr_value,
			'sorting'		=>	$sorting
		);

		$arrWhere = array( 'attr_id' => $attr_id );
		if($AttributeModel->modify($arrParam,$arrWhere))		
		{
			
			createAdminLog($db,3,"编辑产品属性【".$obj->attr_name."】信息,编号id:{$attr_id}",'',$obj,$arrParam,'attribute');

			redirect('?module=attribute_action'."&act=edit&attr_id=".$attr_id, "操作成功");
		}
		else
		{
			redirect('?module=attribute_action'."&act=edit&attr_id=".$attr_id, "系统忙，操作失败");
		}
		return;
	break;

    /***********删除处理***********/
	case 'del' :
		$attr_id = array ();
		$attr_id = $_REQUEST['attr_id'];
		if (empty ($attr_id)) {
			redirect('?module=attribute_action', "您没选中任何条目");
			return;
		}
		if ($AttributeModel->delete($arrhere=array('attr_id'=>$attr_id))) {
			createAdminLog($db,3,"删除产品属性信息,编号id:".implode(",", $id));
			redirect('?module=attribute_action', "操作成功");
			return;
		} else {
			redirect('?module=attribute_action', "系统忙");
			return;
		}
	break;

	default :
		include "tpl/attribute_list.php";
	break;
}
?>