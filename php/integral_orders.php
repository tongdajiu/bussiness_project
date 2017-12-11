<?php
define('HN1', true);
require_once('./global.php');
VersionModel::checkOpen('integralExchangeManagement');
require_once MODEL_DIR . '/IntegralProductModel.class.php';
require_once MODEL_DIR . '/UserAddressModel.class.php';
require_once MODEL_DIR . '/UserModel.class.php';
//require_once MODEL_DIR . '/IntegralOrdersModel.class.php';
require_once MODEL_DIR . '/IntegralPayModel.class.php';


include "common.php";	//设置只能用微信窗口打开

$userAddressModel 		= new UserAddressModel($db);
$integralProductModel 	= new IntegralProductModel($db);
$userModel 				= new UserModel($db);
$integralOrders 		= D('IntegralOrders');
$integralOrdersDetail 	= M('integral_orders_detail');
$integralPayModel 		= new IntegralPayModel($db,'integral_pay');

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user","您还未登陆！");
	return;
}

$act = !isset($_REQUEST['act']) ? '' : $_REQUEST['act'];

switch($act){
	case 'confirm':
		$user_obj = $userModel->get(array('id'=>$userid,'status'=>1));

		if(empty($user_obj))
		{
			redirect("login.php?dir=user","您的账号被封,请联系客服！");
			return;
		}

		$addressId = isset($_REQUEST['addressId']) ? intval($_REQUEST['addressId']) : 0;		//收货地址id
		$product_id = isset($_REQUEST['product_id']) ? intval($_REQUEST['product_id']) : 0;		//积分商品id

		$address = $userAddressModel->get(array('id'=>$addressId,'userid'=>$userid));
		if(empty($address))
		{
			redirect("integral_address.php?product_id={$product_id}","收货地址错误,请勿违法操作");
			return;
		}
		$obj = $integralProductModel->get(array('id'=>$product_id,'status'=>1,'__NOTIN__'=>array('inventory' => 0)));
		if(empty($obj))
		{
			redirect("integral_product.php","商品已下架或库存不足！");
			return;
		}

		if($user_obj->integral < $obj->integral)
		{
			redirect("integral.php","您的积分不足！");
			return;
		}
						
		$order_number = IntegralOrdersModel::genNo();		//对外订单号

		$Model = new Model($db);
		$Model->startTrans();

		$success = true;	//标志

		try{

			$data = array(
				'customer_id'	=>	$user_obj->id,
				'order_number'	=>	$order_number,
				'all_integral'	=>	$obj->integral,
				'receiver'		=>	$address->shipping_firstname,
				'address'		=>	$address->address,
				'phone'			=>	$address->telephone,
				'delivery_status'	=>	0,
				'receiving_state'	=>	0,
				'create_time'		=>	time(),
				'ip'			=>	GetIP()
			);

			//添加积分订单，返回id
			$integral_orders_id = $integralOrders->add($data);
			if($integral_orders_id === false)
			{
				$success = false;
				break;
			}

			$arrList = array(
				'userid'				=>	$user_obj->id,
				'product_id'			=>	$obj->id,
				'product_name'			=>	$obj->name,
				'product_image'			=>	$obj->image,
				'product_integral'		=>	$obj->integral,
				'shipping_number'		=>	1,
				'integral_orders_id'	=>	$integral_orders_id
			);
			//添加积分订单详情
			if($integralOrdersDetail->add($arrList)	===	false)
			{
				$success = false;
				break;
			}

			//更新用户积分
			if($userModel->modify(array('integral' => ($user_obj->integral-$obj->integral*1)),array('id'=>$user_obj->id))	===	false)
			{
				$success = false;
				break;
			}


			//更新库存
			$num = $integralProductModel->get(array('id'=>$obj->id),'inventory');
			
			$num = intval($num->inventory) -1;
			
			
			$rs = $integralProductModel->query("update ".T('integral_product')." set inventory = {$num} where id=".$obj->id);

			if( $rs < 1)
			{

				$success = false;
				break;
			}

			//添加积分使用记录
			if($integralPayModel->addIntegralPay(2,$user_obj->id,$obj->integral,"兑换商品,订单号【{$order_number}】") === false){
				$success = false;
				break;
			}

		}
		catch(Exception $e)
		{
			$success = false;
		}

		if($success){
			$Model->commit();
			$opmsg = '';
		}else{
			$Model->rollback();
			$opmsg = '操作失败';
		}
		redirect('integral_orders.php', $opmsg);
		return;
	break;

	case 'receiving':
		$order_id = intval($_REQUEST['id']);

		$obj = $integralOrders->get(array('id'=>$order_id,'customer_id'=>$userid,'user_del'=>0));

		empty($obj) && redirect('integral_orders.php', "订单不存在");

		($obj->delivery_status == 0) && redirect('integral_orders.php', "订单未发货");

		($obj->receiving_state == 1) && redirect('integral_orders.php', "订单已确认");

		if($integralOrders->modify(array('receiving_state'=>1, 'receiving_time'=>time()), array('id'=>$order_id)) === false)
		{
			redirect('integral_orders.php', "操作失败");
			return;
		}

		redirect('integral_orders.php');
		return;
	break;


	case 'del':
		$order_id = intval($_REQUEST['id']);

		$obj = $integralOrders->get(array('id'=>$order_id,'customer_id'=>$userid,'user_del'=>0));

		empty($obj) && redirect('integral_orders.php', "订单不存在");

		($obj->delivery_status == 0) && redirect('integral_orders.php', "订单未发货");

		($obj->receiving_state == 0) && redirect('integral_orders.php', "订单未确认");

		if($integralOrders->modify(array('user_del'=>1), array('id'=>$order_id)) === false)
		{
			redirect('integral_orders.php', "操作失败");
			return;
		}

		redirect('integral_orders.php');
		return;
	break;

	default:
		$integralOrdersList = $integralOrders->getAll(array('customer_id' => $userid,'user_del' => 0),array('create_time' => 'DESC'));
		include TEMPLATE_DIR.'/integral_orders_web.php';
	break;
}
?>