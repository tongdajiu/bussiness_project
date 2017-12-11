<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(dirname(__FILE__)).'/');
require_once SCRIPT_ROOT.'model/WxCouponModel.class.php';
require_once SCRIPT_ROOT.'model/CouponModel.class.php';
require_once dirname(dirname(__FILE__)) . "/lib/log.php";

class wx_coupon
{
	private $WxCouponModel;
	private $objWX;
	private $nowModel;

	public function __construct( $db, $objWX , $site )
	{
		$this->WxCouponModel = new WxCouponModel( $db );
		$this->CouponModel 	 = new CouponModel( $db );
		$this->objWX 		 = $objWX;
		$this->nowModel 	 = '?module=wx_coupon&act=list';

		$logFile 		= dirname(dirname(__FILE__)) . '/log/wx/coupon_' . date('Y_m_d',time()) . '.log';
        $logHandler		= new CLogFileHandler( $logFile );
    	$this->log 		= Log::Init($logHandler, 1);
    	$this->site		= $site;
	}

	/**
	 * 卡券颜色列表
	 * */
	private function get_coupon_color()
	{
		return array(
			"#63b359"=>"Color010",
			"#2c9f67"=>"Color020",
			"#509fc9"=>"Color030",
			"#5885cf"=>"Color040",
			"#9062c0"=>"Color050",
			"#d09a45"=>"Color060",
			"#e4b138"=>"Color070",
			"#ee903c"=>"Color080",
			"#f08500"=>"Color081",
			"#a9d92d"=>"Color082",
			"#dd6549"=>"Color090",
			"#cc463d"=>"Color100",
			"#cf3e36"=>"Color101",
			"#5E6671"=>"Color102"
		);
	}


	/**
	 * 页面显示
	 * */
	public function show( $type )
	{
		switch( $type )
		{
			/*============ 列表页面 ============*/
			case "add":
				$arrCouponColor = $this->get_coupon_color();
				include "tpl/wx_coupon_add.php";
			break;

			/*============ 列表页面 ============*/
			default:
				$page = isset($_GET['page']) && intval($_GET['page']) != 0 ? $_GET['page'] : 1;
				$pager = $this->WxCouponModel->gets( array('status'=>1), array('id'=>'desc'),$page  );
				include "tpl/wx_coupon_list.php";
		}
	}


	/**
	 * 添加微信优惠券
	 * */
	public function add()
	{
		$card_type  					= isset($_REQUEST['card_type']) 		? intval($_REQUEST['card_type']) 		: '';
		$deal_detail  					= isset($_REQUEST['deal_detail']) 		? $_REQUEST['deal_detail'] 				: '';
		$least_cost  					= isset($_REQUEST['least_cost']) 		? intval($_REQUEST['least_cost']) 		: '';
		$reduce_cost  					= isset($_REQUEST['reduce_cost']) 		? intval($_REQUEST['reduce_cost']) 		: '';
		$discount  						= isset($_REQUEST['discount']) 			? $_REQUEST['discount'] 				: '';
		$gift  							= isset($_REQUEST['gift']) 				? $_REQUEST['gift'] 					: '';
		$default_detail 				= isset($_REQUEST['default_detail']) 	? $_REQUEST['default_detail'] 			: '';
		$arrParam['logo_url']  			= isset($_REQUEST['logo_url']) 			? $_REQUEST['logo_url'] 				: '';
		$arrParam['code_type']  		= isset($_REQUEST['code_type']) 		? $_REQUEST['code_type'] 				: '';
		$arrParam['brand_name']  		= isset($_REQUEST['brand_name']) 		? $_REQUEST['brand_name'] 				: '';
		$arrParam['title']  			= isset($_REQUEST['title']) 			? $_REQUEST['title'] 					: '';
		$arrParam['sub_title']  		= isset($_REQUEST['sub_title']) 		? $_REQUEST['sub_title'] 				: '';
		$color  						= isset($_REQUEST['color']) 			? $_REQUEST['color'] 					: '';
		$arrParam['notice']  			= isset($_REQUEST['notice']) 			? $_REQUEST['notice'] 					: '';
		$arrParam['description']  		= isset($_REQUEST['description']) 		? $_REQUEST['description'] 				: '';
		$arrParam['sku']  				= isset($_REQUEST['sku']) 				? $_REQUEST['sku'] 						: '';
		$arrParam['quantity']  			= isset($_REQUEST['quantity']) 			? $_REQUEST['quantity'] 				: '';
		$type  							= isset($_REQUEST['type']) 				? $_REQUEST['type'] 					: '';
		$begin_timestamp				= isset($_REQUEST['begin_timestamp']) 	? $_REQUEST['begin_timestamp'] 			: '';
		$end_timestamp  				= isset($_REQUEST['end_timestamp']) 	? $_REQUEST['end_timestamp'] 			: '';
		$fixed_term  					= isset($_REQUEST['fixed_term']) 		? intval($_REQUEST['fixed_term']) 		: 0;
		$fixed_begin_term  				= isset($_REQUEST['fixed_begin_term']) 	? intval($_REQUEST['fixed_begin_term']) : 0;
		$arrParam['status']  			= isset($_REQUEST['status']) 			? $_REQUEST['status'] 					: '';
		$get_limit						= isset($_REQUEST['get_limit'])			? intval($_REQUEST['get_limit']) 		: 1;


		// 团购劵
		if ( $card_type == 0 )
		{
			if ( $deal_detail == "" )
			{
				redirect('?module=wx_coupon&act=add','团购详情说明不能为空');
				exit;
			}
			else
			{
				$arrParam['deal_detail'] 	= $_REQUEST['deal_detail'];
				$arrParam['card_type'] 		= 'GROUPON';
			}
		}

		// 代金券
		if ( $card_type == 1 )
		{
			if ( $least_cost == "" ||  $reduce_cost == "" )
			{
				redirect('?module=wx_coupon&act=add','金额范围不能为空');
				exit;
			}
			else
			{
				$arrParam['least_cost']		= $least_cost * 100;
				$arrParam['reduce_cost']	= $reduce_cost * 100;
				$arrParam['card_type'] 		= 'CASH';
			}
		}

		// 折扣券
		if ( $card_type == 2 )
		{
			if ( $discount == "" )
			{
				redirect('?module=wx_coupon&act=add','打折额度不能为空');
				exit;
			}
			else
			{
				$arrParam['discount']		= $discount;
				$arrParam['card_type'] 		= 'DISCOUNT';
			}
		}

		// 礼品券
		if ( $card_type == 3 )
		{
			if ( $gift == "" )
			{
				redirect('?module=wx_coupon&act=add','礼品的名称不能为空');
				exit;
			}
			else
			{
				$arrParam['gift']		= $gift;
				$arrParam['card_type'] 		= 'GIFT';
			}
		}

		// 优惠券
		if ( $card_type == 4 )
		{
			if ( $default_detail == "" )
			{
				redirect('?module=wx_coupon&act=add','优惠详情不能为空');
				exit;
			}
			else
			{
				$arrParam['default_detail']		= $default_detail;
				$arrParam['card_type'] 			= 'GENERAL_COUPON';
			}
		}

		// 固定日期
		if ( $type == 0 )
		{
			if ( $begin_timestamp == "" || $end_timestamp == "" )
			{
				redirect('?module=wx_coupon&act=add','生效期和（或）失效期不能为空');
				exit;
			}
			else
			{
				$arrData['type'] 			=  	$arrParam['type']				= 'DATE_TYPE_FIX_TIME_RANGE';
				$arrData['begin_timestamp'] =	$arrParam['begin_timestamp'] 	= strtotime( $begin_timestamp );
				$arrData['end_timestamp'] 	=	$arrParam['end_timestamp'] 		= strtotime( $end_timestamp );

				$arrParam['date_info'] 		= json_encode( $arrData );
			}
		}

		// 自领取后按天算
		if ( $type == 1 )
		{
			$arrData['type'] =	$arrParam['type']							= 'DATE_TYPE_FIX_TERM';
			$arrData['fixed_term']  =	$arrParam['fixed_term']				= strtotime( $fixed_term );
			$arrData['fixed_begin_term']  = $arrParam['fixed_begin_term']	= strtotime( $fixed_begin_term );
			$arrData['end_timestamp'] =	$arrParam['end_timestamp']			= strtotime( $end_timestamp );

			$arrParam['date_info'] 			= json_encode( $arrData );
		}

		if ( $arrParam['logo_url'] != '' )
		{
			$arrParam['logo_url'] = 'http://weixinm2c.taozhuma.com/wxstore/upfiles/wxcoupon/' . $arrParam['logo_url'];
		}

		$arrParam['sku'] = array('quantity'=>$arrParam['quantity']);

		if ( $arrParam['logo_url'] == '' || $arrParam['code_type'] == '' || $arrParam['brand_name'] == ''  || $arrParam['title']  == '' || $arrParam['notice']  == '' || $arrParam['description']  == '' || $arrParam['date_info']   == ''  )
		//if ( $arrParam['logo_url'] == '' || $arrParam['code_type'] == '' || $arrParam['brand_name'] == ''  || $arrParam['title']  == '' || $arrParam['notice']  == '' || $arrParam['description']  == '' || $arrParam['sku']  == '' 	|| $arrParam['quantity']   == '' || $arrParam['date_info']   == ''  )
		{
			redirect('?module=wx_coupon&act=add','有必选参数为空');
			exit;
		}

		$arrColorList = $this->get_coupon_color();
		$arrParam['color']= $arrColorList[$color];

		// 添加本地优惠券信息到微信，并生成微信优惠券
		$wx_coupon_sn = $this->getWxCouponData( $arrParam,$get_limit );
		if ( $wx_coupon_sn === FALSE )
		{
			redirect('?module=wx_coupon&act=add','微信优惠券生成有误！！');
			exit;
		}

		// 添加微信优惠券到wxcoupon表
		$arrParam['sku'] = json_encode(array('quantity'=>$arrParam['quantity']));
		$arrParam['least_cost']		= $least_cost;
		$arrParam['reduce_cost']	= $reduce_cost;
		$arrParam['wx_card_id'] 	= $wx_coupon_sn;
		$rs = $this->WxCouponModel->add($arrParam);

		if ( $rs === FALSE )
		{
			redirect('?module=wx_coupon&act=add','微信优惠券添加有误！！');
			exit;
		}

		// 添加微信优惠券信息到系统优惠券 coupon表
		$this->addCoupon( $wx_coupon_sn, $arrParam );

		redirect( $this->nowModel,'微信优惠券添加成功！');
		exit;
	}

	/**
	 * 添加微信优惠券，并获取优惠券ID
	 *
	 * @param array   $arrParam  优惠券信息
	 * @return FALSE/String
	 * */
	private function getWxCouponData( $arrParam, $get_limit )
	{
		$data['card']['card_type'] 		= $arrParam['card_type'];
		$key = strtolower($arrParam['card_type']);

		$data['card'][$key]['base_info'] 	= array(
			"logo_url"  	=> $arrParam['logo_url'],
           	"brand_name" 	=> urlencode($arrParam['brand_name']),
           	"code_type" 	=> urlencode($arrParam['code_type']),
           	"title" 		=> urlencode($arrParam['title']),
           	"sub_title" 	=> urlencode($arrParam['sub_title']),
           	"color" 		=> $arrParam['color'],
           	"notice" 		=> urlencode($arrParam['notice']),
           	"description" 	=> urlencode($arrParam['description']),
//           "sku" 			=> json_decode($arrParam['sku']),
			"sku" 			=> $arrParam['sku'],
           	"date_info" 	=> json_decode($arrParam['date_info']),
           	"get_limit"		=> $get_limit,
		);

		switch ( $arrParam['card_type'] )
		{
			case 'GROUPON':
				$data['card'][$key]['deal_detail'] = $arrParam['deal_detail'];
			break;

			case 'CASH':
				$data['card'][$key]['least_cost'] = $arrParam['least_cost'];
				$data['card'][$key]['reduce_cost'] = $arrParam['reduce_cost'];
			break;

			case 'DISCOUNT':
				$data['card'][$key]['discount'] = $arrParam['discount'];
			break;

			case 'GIFT':
				$data['card'][$key]['gift'] = $arrParam['gift'];
			break;

			case 'GENERAL_COUPON':
				$data['card'][$key]['default_detail'] = $arrParam['default_detail'];
			break;
		}


		$rs = $this->objWX->createCard($data);

		if ( ! $rs['result'] )
		{
			$str = "\ncode:{$rs['code']}\nmsg:{$rs['msg']}";
			$this->log->DEBUG($str);

			return FALSE;
		}
		else
		{
			$str = "\nmsg:优惠券获取成功,优惠券ID为【 {$rs['data']} 】";
			$this->log->DEBUG($str);

			return $rs['data'];
		}
	}

	/**
	 *  添加coupon表
	 *  @param string $wx_coupon_sn 	微信优惠券号
	 *  @param array  $arrData    		优惠券数据
	 */
	private function addCoupon( $wx_coupon_sn, $arrData )
	{
		if ( $arrData['card_type'] == 'CASH' )
		{
			if ( $arrData['type'] == 'DATE_TYPE_FIX_TIME_RANGE' )
			{
				$arrParam['vaild_type'] = 0;
				$arrParam['vaild_type'] = 0;
				$arrParam['start_time'] = $arrData['begin_timestamp'];
				$arrParam['end_time'] 	= $arrData['end_timestamp'];
			}
			else
			{
				$arrParam['vaild_type'] = 1;
				$arrParam['vaild_date'] = $arrData['fixed_term'];
			}

			if ( $arrData['least_cost'] == 0 )
			{
				$arrParam['type'] 	 = 1;
				$arrParam['max_use'] = 0;
			}
			else
			{
				$arrParam['type'] 	 = 0;
				$arrParam['max_use'] = $arrData['least_cost'];
			}

			$arrParam['name'] 		 = $arrData['title'];
			$arrParam['create_time'] = time();
			$arrParam['discount'] 	 = $arrData['reduce_cost'];
			$arrParam['wx_card_id']  = $wx_coupon_sn;

			$this->CouponModel->add($arrParam);
		}
	}


	/**
	 * 生成优惠券二维码
	 * */
	public function send( $card_id  )
	{
		$rs = $this->objWX->createCardQrcode($card_id);

		if ( ! $rs['result'] )
		{
			$str = "\ncard_id:{$card_id}\nresult:'获取优惠券失败'\ncode:{$rs['code']}\nmsg:{$rs['msg']}";
			$this->log->DEBUG($str);
			return $rs = false;
		}

		return $rs;
	}


	/**
	 * 获取优惠券信息
	 */
	public function getWxCouponInfo( $card_id )
	{
		return $this->objWX->getCardInfo( $card_id );
	}

	public function getCodeInfo( $code )
	{
		return $this->objWX->consumeCardCode($code);
	}

	/**
	 * 删除优惠券
	 */
	public function delete($id)
	{
		$this->WxCouponModel->modify( array('status'=>0), array('id'=>$id) );
	}

}






$act 		= !isset($_REQUEST['act']) 	? "list" : $_REQUEST['act'];
$wx_coupon  = new wx_coupon( $db, $objWX, $site );

if( $act == 'add_save' )
{
	// 创建卡券
	$wx_coupon->add();
}
elseif ( $act == 'send' )
{
	// 生成卡券二维码
	$car_id = isset( $_REQUEST['cid'] ) ? $_REQUEST['cid'] : '';
	$rs = $wx_coupon->send( $car_id );
	if ( ! $rs )
	{
		redirect('/admin/index.php?module=wx_coupon','该卡券已失效！');
	}
	redirect($rs['data']['show_qrcode_url']);
}
elseif ( $act == "get_info" )
{
	// 获取卡券信息
	$car_id = 'pqhMswE0PlkUzV2JDpdEcZfIaLjM';
	$rs = $wx_coupon->getWxCouponInfo( $car_id );
	var_dump($rs);
}

elseif ( $act == 'getCode' )
{
	// 兑换成系统优惠券
	$car_id = '824484166107';
	$rs = $wx_coupon->getCodeInfo( $car_id );
}
elseif ( $act == 'upload' )
{
	$wx_coupon->upload( $act );
}
elseif ( $act == 'del' )
{
	$id = !isset($_REQUEST['id']) 	? 0 : $_REQUEST['id'];
	$wx_coupon->delete($id);
	redirect('/admin/index.php?module=wx_coupon','操作成功！');
}
else
{
	$wx_coupon->show( $act );
}




//require_once SCRIPT_ROOT.'model/UserCouponModel.class.php';
//$UserCoupon = new UserCouponModel( $db );
//var_dump($UserCoupon->addFromWXCoupon( 'p_Z7Ut5wCvFfqEjfsiSl_2y95Ppc','' ));
//exit;


?>