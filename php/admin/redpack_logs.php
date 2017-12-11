<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(dirname(__FILE__)).'/');
require_once SCRIPT_ROOT.'model/RedPackLogsModel.class.php';

class redpack
{
	private $RedPackModel;
	private $nowModel;
	private $from;

	public function __construct( $db )
	{
		$this->RedPackLogsModel = new RedPackLogsModel( $db );
		$this->nowModel 		= '?module=redpack&act=list';
		$this->from 			= array( '0'=>'测试','1'=>'摇一摇' );
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
				$id 	= !isset($_GET['id'])  		? 0 :  intval($_REQUEST['id']);
				$page = isset($_GET['page']) && intval($_GET['page']) != 0 ? $_GET['page'] : 1;
				$pager = $this->RedPackLogsModel->gets( array( 'redpack_id'=> $id ), array('id'=>'desc'), $page );
				include "tpl/redpack_logs_list.php";
		}
	}


	/*
	 * 功能：添加操作
	 * */
	public function create()
	{
		$arrParam['redpack_id'] 	= !isset($_REQUEST['rid']) 		? "" 	: intval($_REQUEST['rid']);
		$arrParam['total_amount'] 	= !isset($_REQUEST['amount']) 	? "" 	: intval($_REQUEST['amount']);
		$arrParam['get_from'] 	 	= !isset($_REQUEST['from']) 	? "0" 	: intval($_REQUEST['from']);
		$arrParam['user_id'] 	 	= !isset($_REQUEST['uid']) 		? "" 	: intval($_REQUEST['uid']);
		$arrParam['user_openid'] 	= !isset($_REQUEST['oid']) 		? "" 	: sqlUpdateFilter($_REQUEST['oid']);
		$arrParam['get_time'] 	 	= time();

		if ( $arrParam['redpack_id'] == "" || $arrParam['total_amount'] == "" || $arrParam['user_openid'] == "" || $arrParam['user_id'] == "" )
		{
			redirect( $this->nowModel, '必选参数为空！');
			exit;
		}

		$rs = $this->RedPackLogsModel->add( $arrParam );

		if ( $rs === false )
		{
			redirect( $this->nowModel, '必选参数为空！');
			exit;
		}

		redirect( $this->nowModel, '新增记录成功');
	}

	/*
	 * 功能：更新操作
	 * */
	public function update()
	{
		$arrParam['type'] 	 		= !isset($_REQUEST['type']) 		? "" 			: sqlUpdateFilter($_REQUEST['type']);
		$arrParam['total_amount'] 	= !isset($_REQUEST['total_amount']) ? "1" 			: intval($_REQUEST['total_amount']);
		$arrParam['act_name'] 	 	= !isset($_REQUEST['act_name']) 	? "act_name" 	: sqlUpdateFilter($_REQUEST['act_name']);
		$arrParam['send_name'] 	 	= !isset($_REQUEST['send_name']) 	? "send_name" 	: sqlUpdateFilter($_REQUEST['send_name']);
		$arrParam['wishing'] 	 	= !isset($_REQUEST['wishing']) 		? "wishing" 	: sqlUpdateFilter($_REQUEST['wishing']);
		$arrParam['remark'] 	 	= !isset($_REQUEST['remark']) 		? "remark" 		: sqlUpdateFilter($_REQUEST['remark']);
		$arrParam['start_time'] 	= !isset($_REQUEST['start_time']) 	? "" 			: strtotime($_REQUEST['start_time']);
		$arrParam['end_time'] 	 	= !isset($_REQUEST['end_time']) 	? "" 			: strtotime($_REQUEST['end_time']);
		$arrParam['count'] 	 		= !isset($_REQUEST['count']) 		? "" 			: intval($_REQUEST['count']);
		$arrParam['status'] 	 	= !isset($_REQUEST['status']) 		? "" 			: sqlUpdateFilter($_REQUEST['status']);
		$arrWhere['id'] 	 		= !isset($_REQUEST['id']) 			? "" 			: intval($_REQUEST['id']);

		if ( $arrWhere['id'] == 0 )
		{
			redirect( $this->nowModel, '传入参数有误！');
			exit;
		}

		if ( $arrParam['type'] == "" || $arrParam['total_amount'] == "" )
		{
			redirect( $this->nowModel, '必选参数为空！');
			exit;
		}

		$rs = $this->RedPackModel->modify( $arrParam, $arrWhere);

		if ( $rs === FALSE )
		{
			redirect( $this->nowModel, '更新记录失败');
			exit;
		}

		redirect( $this->nowModel, '更新记录成功');
	}

}



$act 		= !isset($_REQUEST['act']) 	? "list" : $_REQUEST['act'];
$redpack  	= new redpack($db,$objWX);

if ( $act == 'add' )
{
	$redpack->create();
}
elseif ( $act == 'edit' )
{
	$redpack->update();
}
else
{
	$redpack->show( $act );
}



?>