<?php
!defined('HN1') && exit('Access Denied.');

class tb_img
{
	private $_upload_file;
	private $_web_site;

	public function __construct( $db )
	{
		$this->TpImgModel 		= new TpImgModel( $db );
		$this->TpKeywordModel 	= new TpKeywordModel( $db );
		$this->nowModel 		= '?module=tp_img&act=list';
		$this->_upload_file		= dirname(dirname(__FILE__)) . UPLOAD_DIR  .'Img/';
		$this->_web_site 		= WEB_SITE . "upfiles/Img/";

	}

	/*
	 * 功能：页面显示
	 * */
	public function show( $act,$from )
	{
		switch( $act )
		{
			/*============ 添加页面 ============*/
			case 'add':
				include_once("tpl/tp_img_add.php");
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
				$obj = $this->TpImgModel->get($arrWhere);
				include_once ("tpl/tp_img_edit.php");
			break;

			/*============ 列表页面 ============*/
			default:
				$page = isset($_GET['page']) && intval($_GET['page']) != 0 ? $_GET['page'] : 1;
				$arrWhere['keyword'] = array( '!='=>'subscribe' );
				$pager = $this->TpImgModel->gets( $arrWhere, array('id'=>'desc'),$page  );
				include_once("tpl/tp_img_list.php");
		}
	}

	/*
	 * 功能：添加操作
	 * */
	public function create()
	{

		$arrParam['keyword'] 		= !isset($_REQUEST['keyword']) 	? "" : sqlUpdateFilter($_REQUEST['keyword']);
		$arrParam['text'] 	 		= !isset($_REQUEST['text']) 	? "" : sqlUpdateFilter($_REQUEST['text']);
		$arrParam['info'] 	 		= !isset($_REQUEST['info']) 	? "" : sqlUpdateFilter($_REQUEST['info']);
		$arrParam['url'] 	 		= !isset($_REQUEST['url']) 		? "" : sqlUpdateFilter($_REQUEST['url']);
		$arrParam['title'] 	 		= !isset($_REQUEST['title']) 	? "" : sqlUpdateFilter($_REQUEST['title']);
		$from 	 					= !isset($_REQUEST['from']) 	? "" : sqlUpdateFilter($_REQUEST['from']);			// 来源： 如果是设置关注回复则为：subscribe
		$arrParam['createtime'] 	= time();
		$arrParam['uptatetime'] 	= time();

		if ( $from == 'subscribe' )
		{
			$arrParam['keyword'] = 'subscribe';
			$this->nowModel		 = '?module=tp_subscribe&act=list';
		}

		if (is_uploaded_file($_FILES['pic']['tmp_name']))
		{
			$pic = uploadfile('pic', $this->_upload_file);
			$arrParam['pic'] = $this->_web_site . $pic;
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


			if ( ! $this->TpKeywordModel->isEnable( 'Img', $arrParam['keyword'] ) )
			{
				redirect( $this->nowModel, '该关键字已存在');
				exit;
			}
		}

		// 添加图文信息表
		$rs = $this->TpImgModel->add( $arrParam );

		if ( $rs === FALSE )
		{
			redirect( $this->nowModel, '新增记录失败');
			exit;
		}

		// 添加关键字表
		if ( $from != 'subscribe' )
		{
			$arrKeywordParam['keyword'] = $arrParam['keyword'];
			$arrKeywordParam['pid']		= $rs;
			$arrKeywordParam['module']	= 'Img';
			$this->TpKeywordModel->add( $arrKeywordParam );
		}


		redirect( $this->nowModel, '新增记录成功');
	}

	/*
	 * 功能：更新操作
	 * */
	public function update()
	{
		$arrParam['keyword'] 		= !isset($_REQUEST['keyword']) 	? "" : sqlUpdateFilter($_REQUEST['keyword']);
		$arrParam['text'] 	 		= !isset($_REQUEST['text']) 	? "" : sqlUpdateFilter($_REQUEST['text']);
		$arrParam['info'] 	 		= !isset($_REQUEST['info']) 	? "" : sqlUpdateFilter($_REQUEST['info']);
		$arrParam['url'] 	 		= !isset($_REQUEST['url']) 		? "" : sqlUpdateFilter($_REQUEST['url']);
		$arrParam['title'] 	 		= !isset($_REQUEST['title']) 	? "" : sqlUpdateFilter($_REQUEST['title']);
		$from 	 					= !isset($_REQUEST['from']) 	? "" : sqlUpdateFilter($_REQUEST['from']);			// 来源： 如果是设置关注回复则为：subscribe
		$arrParam['uptatetime'] 	= time();
		$arrWhere['id']		 		= !isset($_REQUEST['id']) 		? 0  : intval($_REQUEST['id']);

		if ( $from == 'subscribe' )
		{
			$arrParam['keyword'] = 'subscribe';
			$this->nowModel		 = '?module=tp_subscribe&act=list';
		}

		if (is_uploaded_file($_FILES['pic']['tmp_name']))
		{
			$pic = uploadfile('pic', $this->_upload_file);
			$arrParam['pic'] = $this->_web_site . $pic;
		}

		if ( $arrWhere['id'] == 0 )
		{
			redirect( $this->nowModel, '传入参数有误！');
			exit;
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

			if ( $rs != null && $rs->module == 'Text' )
			{
				redirect( $this->nowModel, '该关键字已存在');
				exit;
			}
			else
			{
				$arrKeywordWhere['pid']		= $arrWhere['id'];
				$this->TpKeywordModel->delete($arrKeywordWhere);					// 删除原ID的记录

				$arrKeywordParam['keyword'] = $arrParam['keyword'];
				$arrKeywordParam['pid'] 	= $arrWhere['id'];
				$arrKeywordParam['module'] 	= 'Img';
				$this->TpKeywordModel->add($arrKeywordParam);
			}
		}

		$rs = $this->TpImgModel->modify( $arrParam, $arrWhere);

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

		$rs = $this->TpImgModel->delete( $arrWhere );

		if ( $rs === FALSE )
		{
			redirect( $this->nowModel, '删除记录失败');
			exit;
		}

		$arrKeywordWhere['pid']		= $arrWhere['id'];
		$this->TpKeywordModel->delete($arrKeywordWhere);					// 删除原ID的记录

		$url = ( $_GET['from'] == 'subscribe' ) ? '?module=tp_subscribe&act=list' : $this->nowModel;
		redirect( $url, '删除记录成功');
	}
}


define('SCRIPT_ROOT', dirname(dirname(__FILE__)) . '/');
require_once SCRIPT_ROOT . 'model/TpKeywordModel.class.php';
require_once SCRIPT_ROOT . 'model/TpImgModel.class.php';

$act  = !isset($_REQUEST['act']) ? "list" : $_REQUEST['act'];
$from = !isset($_REQUEST['from']) ? "" : $_REQUEST['from'];

$tb_img = new tb_img( $db );

if ( $act == 'add_save' )
{
	$tb_img->create();
}
elseif ( $act == 'edit_save' )
{
	$tb_img->update();
}
elseif ( $act == 'del' )
{
	$tb_img->delete();
}
else
{
	$tb_img->show( $act,$from );
}

?>
