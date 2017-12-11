<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');

class coupon_action
{
	private $CouponModel;
	private $UserCouponModel;
	private $nowModel;
	private $objWX;
	private $coupon_type;		// 优惠劵类型

	public function __construct( $objWX )
	{
		$this->CouponModel 		= D( 'Coupon' );
		$this->UserCouponModel 	= D( 'UserCoupon' );
		$this->nowModel 		= '?module=coupon_action&act=list';
		$this->objWX    		= $objWX;
		$this->coupon_type    	= array( '满额减', '立即减' );
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
				include ("tpl/coupon_add.php");
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
				$obj = $this->CouponModel->get($arrWhere);
				include ("tpl/coupon_edit.php");
			break;

			/*============ 更新页面 ============*/
			case 'del':
				$id 	= !isset($_GET['id'])  		? 0 :  intval($_REQUEST['id']);
				if ( $id <= 0 )
				{
					redirect( $this->nowModel, '传入参数有误！');
					exit;
				}

				$arrWhere['id'] = $id;
				$this->CouponModel->delete($arrWhere);

				redirect( $this->nowModel, '删除成功！' );
			break;
			
			case 'use':
				$nCouponID 	= !isset($_REQUEST['cid'])  ? 0 :  intval($_REQUEST['cid']);
				if ( $nCouponID <= 0 )
				{
					redirect( $this->nowModel, '传入参数有误！');
					exit;
				}
				
				$arrData = $this->UserCouponModel->getList( $nCouponID );
				
				include "tpl/user_coupon_list.php";
			break;


			/*============ 列表页面 ============*/
			default:
				$nPage 	= !isset($_REQUEST['page'])  ? 1 :  intval($_REQUEST['page']);
				$pager = $this->CouponModel->gets('', '', $nPage);
				include "tpl/coupon_list.php";
		}
	}


	/*
	 * 功能：添加操作
	 * */
	public function create()
	{
		$start_time 				= !isset($_REQUEST['start_time']) 	? 0  : $_REQUEST['start_time'];
		$end_time 					= !isset($_REQUEST['end_time']) 	? 0  : $_REQUEST['end_time'];
		$max_use 	 				= !isset($_REQUEST['max_use']) 		? 0  : intval($_REQUEST['max_use']);
		$vaild_date					= !isset($_REQUEST['vaild_date']) 	? 0  : intval($_REQUEST['vaild_date']);
		$arrParam['type'] 	 		= !isset($_REQUEST['type']) 		? 0  : intval($_REQUEST['type']);
		$arrParam['name'] 	 		= !isset($_REQUEST['name']) 		? "" : sqlUpdateFilter($_REQUEST['name']);
		$arrParam['create_time'] 	= time();
		$arrParam['status'] 	 	= !isset($_REQUEST['status']) 		? 0  : intval($_REQUEST['status']);
		$arrParam['discount']		= !isset($_REQUEST['discount']) 	? 0  : intval($_REQUEST['discount']);
		$arrParam['vaild_type']		= !isset($_REQUEST['vaild_type']) 	? 0  : intval($_REQUEST['vaild_type']);

		if ( $arrParam['name'] == "" || $arrParam['discount'] == 0 )
		{
			redirect( $this->nowModel, '必选参数为空！');
			exit;
		}

		if ( $arrParam['vaild_type'] == 1 )
		{
			if ( $vaild_date == 0 )
			{
				redirect( $this->nowModel, '有效期不能为空' );
			}
			else
			{
				$arrParam['vaild_date']		= intval($vaild_date);
			}
		}


		if ( $arrParam['vaild_type'] == 0 )
		{
			if ( $start_time == 0 || $end_time == 0 )
			{
				redirect( $this->nowModel, '请填写正确的起始日期' );
			}
			else
			{
				$arrParam['start_time'] 	= strtotime( $start_time . ' 00:00:00');
				$arrParam['end_time'] 		= strtotime( $end_time   . ' 23:59:59');
			}

		}

		if ( $arrParam['type'] == 0 )
		{
			$arrParam['max_use'] = $max_use;
		}

		$rs = $this->CouponModel->add( $arrParam );

		if ( $rs === FALSE )
		{
			redirect( $this->nowModel, '新增记录失败！');
			exit;
		}

		redirect( $this->nowModel, '新增记录成功');

	}

	/*
	 * 功能：更新操作
	 * */
	public function update()
	{
		$start_time 				= !isset($_REQUEST['start_time']) 	? 0  : $_REQUEST['start_time'];
		$end_time 					= !isset($_REQUEST['end_time']) 	? 0  : $_REQUEST['end_time'];
		$max_use 	 				= !isset($_REQUEST['max_use']) 		? 0  : intval($_REQUEST['max_use']);
		$vaild_date					= !isset($_REQUEST['vaild_date']) 	? 0  : intval($_REQUEST['vaild_date']);
		$arrParam['type'] 	 		= !isset($_REQUEST['type']) 		? 0  : intval($_REQUEST['type']);
		$arrParam['name'] 	 		= !isset($_REQUEST['name']) 		? "" : sqlUpdateFilter($_REQUEST['name']);
		$arrParam['create_time'] 	= time();
		$arrParam['status'] 	 	= !isset($_REQUEST['status']) 		? 0  : intval($_REQUEST['status']);
		$arrParam['discount']		= !isset($_REQUEST['discount']) 	? 0  : intval($_REQUEST['discount']);
		$arrParam['vaild_type']		= !isset($_REQUEST['vaild_type']) 	? 0  : intval($_REQUEST['vaild_type']);
		$arrWhere['id']				= !isset($_REQUEST['id']) 			? 0  : intval($_REQUEST['id']);

		if ( $arrWhere['id'] == 0 )
		{
			redirect( $this->nowModel, '传入参数有误！');
			exit;
		}

		if ( $arrParam['name'] == "" || $arrParam['discount'] == 0 )
		{
			redirect( $this->nowModel, '必选参数为空！');
			exit;
		}

		if ( $arrParam['vaild_type'] == 1 )
		{
			if ( $vaild_date == 0 )
			{
				redirect( $this->nowModel, '有效期不能为空' );
			}
			else
			{
				$arrParam['vaild_date']		= intval($vaild_date);
				$arrParam['start_time']		= 0;
				$arrParam['end_time']		= 0;
			}
		}


		if ( $arrParam['vaild_type'] == 0 )
		{
			if ( $start_time == 0 || $end_time == 0 )
			{
				redirect( $this->nowModel, '请填写正确的起始日期' );
			}
			else
			{
				$arrParam['start_time'] 	= strtotime( $start_time . ' 00:00:00');
				$arrParam['end_time'] 		= strtotime( $end_time   . ' 23:59:59');
				$arrParam['vaild_date']		= 0;
			}

		}

		if ( $arrParam['type'] == 0 )
		{
			$arrParam['max_use'] = $max_use;
		}
		else
		{
			$arrParam['max_use'] = 0;
		}

		$rs = $this->CouponModel->modify( $arrParam, $arrWhere);

		if ( $rs === FALSE )
		{
			redirect( $this->nowModel, '更新记录失败');
			exit;
		}

		redirect( $this->nowModel, '更新记录成功');
	}

}



$act 		= !isset($_REQUEST['act']) 	? "list" : $_REQUEST['act'];
$coupon  = new coupon_action($objWX);

if ( $act == 'add_save' )
{
	$coupon->create();
}
elseif ( $act == 'edit_save' )
{
	$coupon->update();
}
else
{
	$coupon->show( $act );
}



?>