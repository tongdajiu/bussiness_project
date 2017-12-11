<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');

class AdminGroup
{
	private $AdminMapModel;
	private $AdminGroupModel;
	private $nowModel;

	public function __construct(  )
	{
		$this->AdminMapModel  	= D('AdminMap');
		$this->AdminGroupModel	= M('admin_group');
		$this->nowModel = '?module=admin_group_action';
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
				$arrInfos 	= $this->getRulesList();
				include "tpl/admin_group_add.php";
			break;

			/*============ 添加页面 ============*/
			case 'edit':
				$arrInfos 	= $this->getRulesList();		// 获取权限列表

				$nID 	 	= !isset($_REQUEST['id']) ? "" : $_REQUEST['id'];
				$arrData = $this->AdminGroupModel->get( array('id'=>$nID) );
				if ( $arrData == NULL )
				{
					redirect( $this->nowModel."&act=lists", '非法操作！' );
					exit;
				}

				$arrRules 		 = explode(',',$arrData->rules);
				include "tpl/admin_group_edit.php";
			break;

			default:
				$nPage 	= !isset($_REQUEST['page'])  ? 1 :  intval($_REQUEST['page']);
				$pager = $this->AdminGroupModel->gets('', '', $nPage);
				include "tpl/admin_group_list.php";
		}
	}

	/**
	 * 添加操作
	 */
	public function add()
	{
		$strTitle 	 	 = !isset($_REQUEST['title']) 		? "" : $_REQUEST['title'];
		$strDescription  = !isset($_REQUEST['description']) ? "" : $_REQUEST['description'];
		$status  		 = !isset($_REQUEST['status']) 		? 0  : intval($_REQUEST['status']);
		$setPrivileges 	 = !isset($_REQUEST['rules']) 		? "" : $_REQUEST['rules'];
		$arrPrivileges   = array();

		foreach( $setPrivileges as $Privileges )
		{
			$arr = $this->getMoudleId( $Privileges );								// 获取对应功能的关联功能ID
			$arrPrivileges[] = $Privileges;

			if ( $arr != null )
			{
				$arrPrivileges = array_unique(array_merge($arrPrivileges, $arr ));	// 去重并且合并功能ID
			}
		}

		$strRules 		 = implode(',',$arrPrivileges);

		if ( $strTitle == ""  || $strDescription == "" || $strRules == "" )
		{
			redirect( $this->nowModel."&act=add", '传入参数有误！' );
			exit;
		}

		$rs = $this->AdminGroupModel->get( array('title'=>$strTitle) );
		if ( $rs != NULL )
		{
			redirect( $this->nowModel."&act=add", '该组名已存在！' );
			exit;
		}

		$arrParam = array(
			'title'			=> $strTitle,
			'description'	=> $strDescription,
			'status'		=> $status,
			'rules'			=> $strRules
		);

		$rs = $this->AdminGroupModel->add( $arrParam );
		redirect( $this->nowModel."&act=lists", '添加成功！' );
	}

	/**
	 * 修改操作
	 */
	public function update()
	{
		$id 		 	 = !isset($_REQUEST['id']) 			? 0  : intval($_REQUEST['id']);
		$strTitle 	 	 = !isset($_REQUEST['title']) 		? "" : $_REQUEST['title'];
		$strDescription  = !isset($_REQUEST['description']) ? "" : $_REQUEST['description'];
		$status  		 = !isset($_REQUEST['status']) 		? 0  : intval($_REQUEST['status']);
		$setPrivileges 	 = !isset($_REQUEST['rules']) 		? "" : $_REQUEST['rules'];
		$arrPrivileges   = array();

		foreach( $setPrivileges as $Privileges )
		{
			$arr = $this->getMoudleId( $Privileges );								// 获取对应功能的关联功能ID
			$arrPrivileges[] = $Privileges;

			if ( $arr != null )
			{
				$arrPrivileges = array_unique(array_merge($arrPrivileges, $arr ));	// 去重并且合并功能ID
			}

		}

		$strRules 		 = implode(',',$arrPrivileges);

		if ( $strTitle == ""  || $strDescription == "" || $strRules == "" )
		{
			redirect( $this->nowModel."&act=edit&id=$id", '传入参数有误！' );
			exit;
		}

		if ( $id  == 0 )
		{
			redirect( $this->nowModel."&act=lists", '非法操作！' );
			exit;
		}

		$arrParam = array(
			'title'			=> $strTitle,
			'description'	=> $strDescription,
			'status'		=> $status,
			'rules'			=> $strRules
		);

		$rs = $this->AdminGroupModel->modify( $arrParam, array('id'=>$id) );
		redirect( $this->nowModel."&act=lists", '更新成功！' );
	}

	/**
	 * 获取权限列表
	 */
	public function delete()
	{
		$id 		 	 = !isset($_REQUEST['id']) 			? 0 : intval($_REQUEST['id']);
		if ( $id  == 0 )
		{
			redirect( $this->nowModel."&act=lists", '非法操作！' );
			exit;
		}

		$rs = $this->AdminGroupModel->delete( array('id'=>$id) );
		redirect( $this->nowModel."&act=list", '删除成功！' );
	}

	/**
	 * 获取权限列表
	 */
	private function getRulesList()
	{
		$arrCfg 	= include_once( INC_DIR.'/vercfg_func.php');
		$arrInfos 	= $this->AdminMapModel->getList();
		return $arrInfos;
	}


	/**
	 * 获取功能ID
	 */
	private function getMoudleId( $id )
	{
		$arr  = null;
		$data = null;
		$rs = $this->AdminMapModel->get( array( 'id'=>$id ) );
		if ( $rs->pid > 0 )
		{
			if ( $rs->actions != 'list' && $rs->actions != '' )
			{
				$data[] = $this->AdminMapModel->get( array( 'id'=>$rs->pid ), array('id') );
				$data[] = $this->AdminMapModel->get( array( 'pid'=>$rs->pid, 'actions'=>'list' ), array('id') );
			}
			else if ( $rs->actions == 'list' )
			{
				$data[] = $this->AdminMapModel->get( array( 'id'=>$rs->pid ), array('id') );
			}
		}

		if ( $data != null )
		{
			foreach( $data as $rs )
			{
				$arr[] = $rs->id;
			}
		}

		return $arr;
	}

}


$act 		= !isset($_REQUEST['act']) 	? "list" : $_REQUEST['act'];

$AdminGroup = new AdminGroup();

if ( $act == 'edit_save' )
{
	$AdminGroup->update();
}
elseif ( $act == 'add_save' )
{
	$AdminGroup->add();
}
elseif ( $act == 'del' )
{
	$AdminGroup->delete();
}
else
{
	$AdminGroup->show( $act );
}


?>