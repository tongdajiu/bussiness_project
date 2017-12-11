<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');

class Admin
{
	private $AdminModel;
	private $AdminGroupModel;
	private $nowModel;

	public function __construct(  )
	{
		$this->AdminModel  		= M('Admin');
		$this->AdminGroupModel	= M('admin_group');
		$this->nowModel = 'admin_action';
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
				$arrAdminGroup = $this->getGroupList();
				include "tpl/admin_add.php";
			break;

			/*============ 添加页面 ============*/
			case 'edit':
				$nID 	= !isset($_REQUEST['id']) ? "" : $_REQUEST['id'];
				$arrData 	= $this->AdminModel->get( array('id'=>$nID) );
				if ( $arrData == NULL )
				{
					redirect( "?module=admin_action&act=lists", '非法操作！' );
					exit;
				}

				$arrAdminGroup = $this->getGroupList();
				include "tpl/admin_edit.php";
			break;

			default:
				$nPage 	= !isset($_REQUEST['page'])  ? 1 :  intval($_REQUEST['page']);
				$pager = $this->AdminModel->gets(array('__NOTIN__'=>array('id'=>1)), '', $nPage);
				include "tpl/admin_list.php";
		}
	}

	/**
	 * 添加操作
	 */
	public function add()
	{
		$strUsername 	 = !isset($_REQUEST['username']) 		? "" : $_REQUEST['username'];
		$strName  		 = !isset($_REQUEST['name']) 			? "" : $_REQUEST['name'];
		$strPassword  	 = !isset($_REQUEST['password']) 		? "" : $_REQUEST['password'];
		$nGroupAccess 	 = !isset($_REQUEST['group_access']) 	? 0 : intval($_REQUEST['group_access']);
		$nStatus 	 	 = !isset($_REQUEST['status']) 			? 0 : intval($_REQUEST['status']);

		if ( $strUsername == ""  || $strName == "" || $nGroupAccess == 0 )
		{
			redirect( "?module=admin_action&act=lists", '传入参数有误！' );
			exit;
		}

		$rs = $this->AdminModel->get( array('username'=>$strUsername) );
		if ( $rs != NULL )
		{
			redirect( "?module=admin_action&act=add", '该用户名已存在！' );
			exit;
		}

		$arrParam = array(
			'username'			=> $strUsername,
			'name'				=> $strName,
			'group_access'		=> $nGroupAccess,
			'password' 			=> md5($strPassword),
			'add_time'			=> time(),
			'status'			=> $nStatus,
			'admin_type'		=> 0,
			'is_del'			=> 1
		);

		$rs = $this->AdminModel->add( $arrParam );
		redirect( "?module=admin_action&act=lists", '添加成功！' );
	}

	/**
	 * 修改操作
	 */
	public function update()
	{
		$id 		 	 = !isset($_REQUEST['id']) 				? 0  : intval($_REQUEST['id']);
		$strUsername 	 = !isset($_REQUEST['username']) 		? "" : $_REQUEST['username'];
		$strName  		 = !isset($_REQUEST['name']) 			? "" : $_REQUEST['name'];
		$strPassword  	 = !isset($_REQUEST['password']) 		? "" : $_REQUEST['password'];
		$nGroupAccess 	 = !isset($_REQUEST['group_access']) 	? 0 : intval($_REQUEST['group_access']);
		$nAdminType 	 = !isset($_REQUEST['admin_type']) 		? 0 : intval($_REQUEST['admin_type']);
		$nStatus 	 	 = !isset($_REQUEST['status']) 			? 0 : intval($_REQUEST['status']);
		$nIsDel 	 	 = !isset($_REQUEST['is_del']) 			? 0 : intval($_REQUEST['is_del']);

		if ( $strUsername == ""  || $strName == "" || $nGroupAccess == 0 )
		{
			redirect( "?module=admin_action&act=edit&id=$id", '传入参数有误！' );
			exit;
		}

		if ( $id  == 0 )
		{
			redirect( "?module=admin_action&act=lists", '非法操作！' );
			exit;
		}

		$arrParam = array(
			'username'			=> $strUsername,
			'name'				=> $strName,
			'group_access'		=> $nGroupAccess,
			'status'			=> $nStatus,
			'is_del'			=> $nIsDel
		);

		if ( $strPassword != '' )
		{
			$arrParam['password'] = md5($strPassword);
		}

		$rs = $this->AdminModel->modify( $arrParam, array('id'=>$id) );
		redirect( "?module=admin_action&act=lists", '更新成功！' );
	}

	/**
	 * 获取权限列表
	 */
	public function delete()
	{
		$id 		 	 = !isset($_REQUEST['id']) 			? 0 : intval($_REQUEST['id']);
		if ( $id  == 0 )
		{
			redirect( "?module=admin_action&act=lists", '非法操作！' );
			exit;
		}

		$rs = $this->AdminModel->delete( array('id'=>$id) );
		redirect( "?module=admin_action&act=list", '删除成功！' );
	}

	/**
	 * 获取管理员组列表
	 */
	private function getGroupList()
	{
		$arrInfos 	= $this->AdminGroupModel->getAll(array('status'=>1),array(),OBJECT,'',array('id','title'));
		return $arrInfos;
	}

}


$act 		= !isset($_REQUEST['act']) 	? "list" : $_REQUEST['act'];

$Admin = new Admin();

if ( $act == 'edit_save' )
{
	$Admin->update();
}
elseif ( $act == 'add_save' )
{
	$Admin->add();
}
elseif ( $act == 'del' )
{
	$Admin->delete();
}
else
{
	$Admin->show( $act );
}



?>