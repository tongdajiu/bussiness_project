<?php

//!defined('HN1') && exit('Access Denied.');


class tb_subscribe
{
	public function __construct( $db )
	{
		$this->TpKeywordModel 	= new TpKeywordModel( $db );
		$this->TpImgModel 		= new TpImgModel( $db );
		$this->TpTextModel 		= new TpTextModel( $db );
		$this->nowModel = '?module=tp_subscribe&act=list';
	}

	/*
	 * 功能：页面显示
	 * */
	public function show( $act )
	{
		switch( $act )
		{
			/*============ 列表页面 ============*/
			default:
				$arrWhere['keyword'] = 'subscribe';
				$arrTxt 	= $this->TpTextModel->get( $arrWhere );
				$arrImg 	= $this->TpImgModel->getAll( $arrWhere );

				$rs 		= $this->TpKeywordModel->get( $arrWhere );
				if ( $rs == null )
				{
					$this->addData();
				}
				else
				{
					$getModule = $rs->module;
				}

				include_once("tpl/tp_subscribe_list.php");
		}
	}

	/**
	 * 功能： 修改subscribe的推送方式
	 * */
	public function update()
	{
		$module 				= !isset($_REQUEST['type']) ? "Text" : $_REQUEST['type'];
		$arrWhere['keyword'] 	= 'subscribe';
		$rs 					= $this->TpKeywordModel->get( $arrWhere );

		if ( $rs == null )
		{
			$this->addData();
		}
		else
		{
			$arrParam['module']  	= $module;
			$this->TpKeywordModel->modify( $arrParam, $arrWhere );
		}

		redirect( $this->nowModel, '更新成功');
		exit;
	}

	/**
	 * 当subscribe记录为空时，默认生成数据
	 */
	public function addData()
	{
		$arrParam['keyword'] 	= 'subscribe';
		$arrParam['module'] 	= 'Text';
		$this->TpKeywordModel->add( $arrParam );

		$arrTextParam['keyword'] 	= 'subscribe';
		$arrTextParam['type'] 	 	= 1;
		$arrTextParam['text'] 		= 'Welcome';
		$arrTextParam['createtime'] = time();
		$arrTextParam['updatetime'] = time();
		$this->TpTextModel->add($arrTextParam);

		redirect('index.php?module=tp_subscribe&act=list');
	}

}


define('SCRIPT_ROOT', dirname(dirname(__FILE__)) . '/');
require_once SCRIPT_ROOT . 'model/TpKeywordModel.class.php';
require_once SCRIPT_ROOT . 'model/TpImgModel.class.php';
require_once SCRIPT_ROOT . 'model/TpTextModel.class.php';

$act 			= !isset($_REQUEST['act']) ? "list" : $_REQUEST['act'];
$tb_subscribe 	= new tb_subscribe( $db );

if ( $act == 'update' )
{
	$tb_subscribe->update();
}
elseif( $act == 'del' )
{
	$tb_subscribe->delete();
}
else
{
	$tb_subscribe->show( $act );

}


?>
