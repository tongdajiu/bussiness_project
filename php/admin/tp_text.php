<?php
!defined('HN1') && exit('Access Denied.');

class tb_text
{
	public function __construct( $db )
	{
		$this->TpTextModel 		= new TpTextModel( $db );
		$this->TpKeywordModel 	= new TpKeywordModel( $db );
		$this->nowModel = '?module=tp_text&act=list';
	}

	/*
	 * 功能：页面显示
	 * */
	public function show( $act, $from )
	{
		switch( $act )
		{
			/*============ 添加页面 ============*/
			case 'add':
				include_once("tpl/tp_text_add.php");
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
				$obj = $this->TpTextModel->get($arrWhere);
				include_once ("tpl/tp_text_edit.php");
			break;

			/*============ 列表页面 ============*/
			default:
				$page = isset($_GET['page']) && intval($_GET['page']) != 0 ? $_GET['page'] : 1;
				$arrWhere['keyword'] = array( '!='=>'subscribe' );
				$pager = $this->TpTextModel->gets( $arrWhere,array( 'id'=>'desc' ),$page );
				include_once("tpl/tp_text_list.php");
		}
	}

	/*
	 * 功能：添加操作
	 * */
	public function create()
	{
		$arrParam['text'] 	 		= !isset($_REQUEST['text']) 	? "" : sqlUpdateFilter($_REQUEST['text']);
		$arrParam['keyword'] 		= !isset($_REQUEST['keyword']) ? "" : sqlUpdateFilter($_REQUEST['keyword']);
		$from 	 					= !isset($_REQUEST['from']) 	? "" : sqlUpdateFilter($_REQUEST['from']);			// 来源： 如果是设置关注回复则为：subscribe
		$arrParam['createtime'] 	= time();
		$arrParam['updatetime'] 	= time();

		if ( $from == 'subscribe' )
		{
			$arrParam['keyword'] = 'subscribe';
			$this->nowModel		 = '?module=tp_subscribe&act=list';
		}

		if ( $arrParam['text'] == "" || $arrParam['keyword'] == "" )
		{
			redirect( $this->nowModel, '必选参数为空！');
			exit;
		}

		// 如果不是通过设置关注回复入口，且关键字为subscribe则为不允许添加
		if ( $from != 'subscribe' )
		{
			if ($arrParam['keyword'] == 'subscribe')
			{
				redirect( $this->nowModel, '您输入的关键字属于平台专用词，不允许设置');
				exit;
			}

			if ( ! $this->TpKeywordModel->isEnable( 'Text', $arrParam['keyword'] ) )
			{
				redirect( $this->nowModel, '该关键字已存在');
				exit;
			}

			$rs = $this->TpTextModel->add( $arrParam );

			if ( $rs === FALSE )
			{
				redirect( $this->nowModel, '新增记录失败');
				exit;
			}
		}

		$arrKeywordParam['keyword'] = $arrParam['keyword'];
		$arrKeywordParam['pid']		= $rs;
		$arrKeywordParam['module']	= 'Text';
		$this->TpKeywordModel->add( $arrKeywordParam );


		redirect( $this->nowModel, '新增记录成功');
	}

	/*
	 * 功能：更新操作
	 * */
	public function update()
	{
		$arrParam['text'] 	 		= !isset($_REQUEST['text']) 	? "" : sqlUpdateFilter($_REQUEST['text']);
		$arrParam['keyword'] 		= !isset($_REQUEST['keyword']) ? "" : sqlUpdateFilter($_REQUEST['keyword']);
		$from 	 					= !isset($_REQUEST['from']) 	? "" : sqlUpdateFilter($_REQUEST['from']);			// 来源： 如果是设置关注回复则为：subscribe
		$arrParam['updatetime'] 	= time();
		$arrWhere['id']		 		= !isset($_REQUEST['id']) 		? 0  : intval($_REQUEST['id']);

		if ( $arrWhere['id'] == 0 )
		{
			redirect( $this->nowModel, '传入参数有误！');
			exit;
		}

		if ( $from == 'subscribe' )
		{
			$arrParam['keyword'] = 'subscribe';
			$this->nowModel		 = '?module=tp_subscribe&act=list';
		}

		if ( $arrParam['text'] == "" || $arrParam['keyword'] == "" )
		{
			redirect( $this->nowModel, '必选参数为空！');
			exit;
		}

		// 如果不是通过设置关注回复入口，且关键字为subscribe则为不允许添加
		if ( $from != 'subscribe' )
		{
			if ( $arrParam['keyword'] == 'subscribe' )
			{
				redirect( $this->nowModel, '您输入的关键字属于平台专用词，不允许设置');
				exit;
			}

			$arrKeywordParam['keyword'] = $arrParam['keyword'];
			$rs = $this->TpKeywordModel->get($arrKeywordParam);

			if ( $rs != null )
			{
				if ( $rs->pid != $arrWhere['id'] )
				{
					redirect( $this->nowModel, '该关键字已存在');
					exit;
				}
			}
			else
			{
				$arrKeywordWhere['pid']		= $arrWhere['id'];
				$this->TpKeywordModel->delete($arrKeywordWhere);					// 删除原ID的记录

				$arrKeywordParam['keyword'] = $arrParam['keyword'];
				$arrKeywordParam['pid'] 	= $arrWhere['id'];
				$arrKeywordParam['module'] 	= 'Text';
				$this->TpKeywordModel->add($arrKeywordParam);
			}
		}

		$rs = $this->TpTextModel->modify( $arrParam, $arrWhere);

		if ( $rs === FALSE )
		{
			redirect( $this->nowModel, '更新记录失败');
			exit;
		}

		redirect( $this->nowModel, '更新记录成功');
	}


	// 删除操作
	public function delete()
	{
		$arrWhere['id']		 		= !isset($_REQUEST['id']) 		? 0  : intval($_REQUEST['id']);

		if ( $arrWhere['id'] == 0 )
		{
			redirect( $this->nowModel, '传入参数有误！');
			exit;
		}

		$rs = $this->TpTextModel->delete( $arrWhere );

		if ( $rs === FALSE )
		{
			redirect( $this->nowModel, '删除记录失败');
			exit;
		}

		$arrKeywordWhere['pid']		= $arrWhere['id'];
		$this->TpKeywordModel->delete($arrKeywordWhere);					// 删除原ID的记录

		redirect( $this->nowModel, '删除记录成功');
	}
}


define('SCRIPT_ROOT', dirname(dirname(__FILE__)) . '/');
require_once SCRIPT_ROOT . 'model/TpKeywordModel.class.php';
require_once SCRIPT_ROOT . 'model/TpTextModel.class.php';

$act  = !isset($_REQUEST['act']) ? "list" : $_REQUEST['act'];
$from = !isset($_REQUEST['from']) ? "" : $_REQUEST['from'];

$tb_text = new tb_text( $db );

if ( $act == 'add_save' )
{
	$tb_text->create();
}
elseif ( $act == 'edit_save' )
{
	$tb_text->update();
}
elseif ( $act == 'del' )
{
	$tb_text->delete();
}
else
{
	$tb_text->show( $act, $from );
}

?>
