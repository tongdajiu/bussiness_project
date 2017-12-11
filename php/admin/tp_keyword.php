<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(dirname(__FILE__)).'/');
require_once SCRIPT_ROOT.'model/TpKeywordModel.class.php';


class tp_keyword
{
	private $TpKeywordModel;
	private $nowModel;

	public function __construct( $db )
	{
		$this->TpKeywordModel = new TpKeywordModel( $db );
		$this->nowModel = '?module=tp_keyword&act=list';
	}

	/*
	 * 功能：页面显示
	 * */
	public function show( $type )
	{
		switch( $type )
		{
			/*============ 列表页面 ============*/
			default:
				$arrData = $this->TpDiymenClassModel->getList();
				include "tpl/tp_diymen_class_list.php";
		}
	}



	/*
	 * 移除微信菜单
	 * */
	public function delete()
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
$tp_diymen  = new tp_keyword($db);

if( $act == 'del_menu' )
{
	$tp_diymen->delete();
}
else
{
	$tp_diymen->show( $act );
}



?>