<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(dirname(__FILE__)).'/');
require_once SCRIPT_ROOT.'model/TpDiymenClassModel.class.php';


class tp_diymen
{
	private $TpDiymenClassModel;
	private $nowModel;
	private $objWX;

	public function __construct( $db, $objWX )
	{
		$this->TpDiymenClassModel = new TpDiymenClassModel( $db );
		$this->nowModel = '?module=tp_diymen_class&act=list';
		$this->objWX    = $objWX;
	}

	/*
	 * 功能：页面显示
	 * */
	public function show( $type )
	{
		switch( $type )
		{
			/*============ 添加页面 ============*/
			case 'add':
				include ("tpl/tp_diymen_class_add.php");
			break;


			/*============ 更新页面 ============*/
			case 'edit':
				$id 	= !isset($_GET['id'])  		? 0 :  intval($_REQUEST['id']);

				if ( $id <= 0 )
				{
					redirect( $this->nowModel, '传入参数有误！');
					exit;
				}

				$arrWhere['id'] = $id;
				$obj = $this->TpDiymenClassModel->get($arrWhere);
				include ("tpl/tp_diymen_class_edit.php");
			break;


			/*============ 列表页面 ============*/
			default:
				$arrData = $this->TpDiymenClassModel->getList();
				include "tpl/tp_diymen_class_list.php";
		}
	}


	/*
	 * 功能：添加操作
	 * */
	public function create()
	{

	}

	/*
	 * 功能：更新操作
	 * */
	public function update()
	{
		$arrParam['title'] 	 = !isset($_REQUEST['title']) 	? "" : sqlUpdateFilter($_REQUEST['title']);
		$arrParam['keyword'] = !isset($_REQUEST['keyword']) ? "" : sqlUpdateFilter($_REQUEST['keyword']);
		$arrParam['sort'] 	 = !isset($_REQUEST['sort']) 	? 0  : intval($_REQUEST['sort']);
		$arrParam['url'] 	 = !isset($_REQUEST['url']) 	? "" : sqlUpdateFilter($_REQUEST['url']);
		$arrParam['type'] 	 = !isset($_REQUEST['type']) 	? 1  : intval($_REQUEST['type']);
		$arrWhere['id']		 = !isset($_REQUEST['id']) 		? 0  : intval($_REQUEST['id']);

		if ( $arrWhere['id'] == 0 )
		{
			redirect( $this->nowModel, '传入参数有误！');
			exit;
		}

		if ( $arrParam['title'] != "" && (( $arrParam['type']==1 && $arrParam['keyword'] == "" ) || ( $arrParam['type']==2 && $arrParam['url'] == "" )) )
		{
			redirect( $this->nowModel, '必选参数为空！');
			exit;
		}

		$rs = $this->TpDiymenClassModel->modify( $arrParam, $arrWhere);

		if ( $rs === FALSE )
		{
			redirect( $this->nowModel, '更新记录失败');
			exit;
		}

		redirect( $this->nowModel, '更新记录成功');
	}

	/*
	 * 设置微信菜单
	 * */
	public function setWxMenu()
	{
		$data['button'] = $this->TpDiymenClassModel->getMenu();

		if ( $data['button'] == null )
		{
			redirect( $this->nowModel, '更新失败：原因：菜单记录为空！');
			exit;
		}

		$rs = $this->objWX->createMenu($data);			// 更新至微信

		if ( $rs === false )
		{
			$tip = "菜单更新成功失败！";
		}
		else
		{
			$tip = "菜单更新成功！";
		}

		redirect( $this->nowModel, $tip);
	}

	/*
	 * 移除微信菜单
	 * */
	public function delWxMenu()
	{
		$rs = $this->objWX->deleteMenu();
		if ( $rs === false )
		{
			$tip = "菜单删除成功失败！";
		}
		else
		{
			$tip = "菜单删除成功！";
		}

		redirect( $this->nowModel, $tip);
	}


}



$act 		= !isset($_REQUEST['act']) 	? "list" : $_REQUEST['act'];
$tp_diymen  = new tp_diymen($db,$objWX);

if ( $act == 'add_save' )
{
	$tp_diymen->create();
}
elseif ( $act == 'edit_save' )
{
	$tp_diymen->update();
}
elseif ( $act == 'set_menu' )
{
	$tp_diymen->setWxMenu();
}
elseif( $act == 'del_menu' )
{
	$tp_diymen->delWxMenu();
}
else
{
	$tp_diymen->show( $act );
}



?>