<?php
define('HN1', true);
require_once('global.php');
include "common.php";	//设置只能用微信窗口打开

$act 		= isset($_REQUEST['act'])  		? $_REQUEST['act']			: '';

$cart_ids 	= isset($_REQUEST['cart_ids'])	? $_REQUEST['cart_ids']		: '';

$UserModel			= D('User');
$UserAddressModel	= D('UserAddress');
$CartModel        	= D('Cart');
$OrderProductModel	= D('OrderProduct');
$ProductModel		= D('Product');
$WxPayInfoModel		= D('WxPayInfo');

$user = $_SESSION['userInfo'];
if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=user");
	return;
}



switch($act)
{
	case 'post':

		$obj_user = $UserModel ->get(array('id'=>$userid));
	
		$cart_ids = $_REQUEST['cart_ids'];
		$cartids  = explode(",",$cart_ids);

		$cartList = $CartModel->getAll(array('paying_status'=>0,'__IN__'=>array('id'=>$cart_ids)));
		if(empty($cartList)){
			redirect("order_address.php?cart_ids=".$cart_ids,"此订单已添加");
			return;
		}
	
		$cartIds = array();
		$productIds = array();
		$products = array();
		$attrIds = array();
		$attrs = array();
		foreach($cartList as $v){
			$cartIds[] = $v->id;
			$productIds[] = $v->product_id;
			$v->attribute_id && $attrIds[] = $v->attribute_id;
		}

//		$diffCart = array_diff($selCartIds, $cartIds);
//		!empty($diffCart) && redirect("cart.php","购物车信息错误");
		
		//商品信息
		if(!empty($productIds)){
			$rs = $ProductModel->getAll(array('__IN__'=>array('product_id'=>$productIds), 'status'=>1), array(), ARRAY_A);
			foreach($rs as $v){
				$products[$v['product_id']] = $v;
			}
		}
		//商品属性
		!empty($attrIds) && $attrs = $ProductModel->getAttrs($attrIds);
		
		//重设商品实时价格
		$cartList = $CartModel->realtime($cartList);
		
		
		//统计结算总金额，添加到订单表
		$all_price = 0;
		$pay_online = 0;
		
		
		foreach($cartList as $cart)
		{
			empty($products[$cart->product_id]) && redirect("cart.php", '商品 '.$cart->product_name.' 已下架');
			
			if($cart->attribute_id != 0)
			{
				empty($attrs[$cart->attribute_id]) && redirect("cart.php", '商品 '.$cart->product_name.' 有变动,请删除后重新添加');
			}	
			($cart->shopping_number > $cart->product_store) && redirect("cart.php", '商品 '.$cart->product_name.' 库存不足');
		
			$curTotal = $cart->product_price * $cart->shopping_number;
			$all_price += $curTotal;
		}

		$pay_online = $all_price;
			
		$remark    = ! isset($_REQUEST['remark']) || $_REQUEST['remark'] == null ? '' : $_REQUEST['remark'];
		$addressId = ! isset($_REQUEST['addressId'] ) || $_REQUEST['addressId'] == null ? '' : $_REQUEST['addressId'];
		
		$address_chose = $UserAddressModel->get(array('id'=>$addressId,'userid'=>$userid));	

		//todo 暂时取消运费，支付测试完后恢复
		$yunfei=0;
		
		$OrderModel = D('Order');
		
		$order_number = OrderModel::genNo();
		$out_trade_no = $order_number . create_number_randomstr(6);    // 微信支付订单编码
		
		$OrderModel->startTrans();

		$arrParam = array(
			'customer_id' =>$obj_user->id,
			'email' => $obj_user->email,
			'telephone' => $address_chose->telephone,
			'shipping_firstname' => $address_chose->shipping_firstname,
			'shipping_address_1' => $address_chose->address,
			'shipping_city' => $address_chose->city,
			'shipping_method' => 0,
			'remark' => $remark,
			'order_status_id' => 0,
			'date_added' => date('Y-m-d H:i:s',time()),
			'date_modified' => date('Y-m-d H:i:s',time()),
			'ip' => GetIP(),
			'order_number' => $order_number,
			'pay_method' => 1,
//			'rebate' => $hole_discount,
			'addtime' => time(),
			'isread' => 1,
			'all_price'=>$all_price,
			'status_bu' => 0,
			'pay_online' => $pay_online+$yunfei
		);

		$oid = $OrderModel->add($arrParam);

		if($oid === false)
		{
			$OrderModel->rollback();
			redirect("order_address.php?cart_ids=".$cart_ids,"订单生成失败1，请重新尝试");
			return;
		}		

		// 将cart记录到order_product
		$product_names  = "";
		$product_number = 0;
	
		foreach($cartList as $cart){
			$arrList = array(
					'userid' 			=> 	$obj_user->id,
					'product_id'		=>	$cart->product_id,
					'product_name'		=>	$cart->product_name,
					'product_model'		=>	$cart->product_model,
					'product_price'		=>	$cart->product_price,
					'product_price_old'	=>	$cart->product_price_old,
					'product_image'		=>	$cart->product_image,
					'order_id'			=>	$oid,
					'shopping_number'	=>	$cart->shopping_number,
					'shopping_size'		=>	$cart->shopping_size,
					'shopping_colorid'	=>	$cart->shopping_colorid,
					'integral'			=>	$cart->integral,
					'paying_status'		=>	$cart->paying_status,
					'product_type'		=>	$cart->product_type,
					'type'				=>	$cart->type,
					'promotions_content'=>	$cart->promotions_content,
					'addTime'			=>	time(),
					'attribute_id'		=>	$cart->attribute_id,
					'attribute'			=>	$cart->attribute
			);
			
			$arrOrderProduct = $OrderProductModel->add($arrList);
			
			if($arrOrderProduct === false)
			{
				$OrderModel->rollback();
				redirect("order_address.php?cart_ids=".$cart_ids,"订单生成失败2，请重新尝试");
				return;
			}
			
			
			//更新库存信息
			$ProductModel = D('Product');
				
			$product_inventory = $ProductModel->get(array('product_id'=>$cart->product_id));
			
			if($cart->attribute_id != 0 )
			{
				$ProductAttrModel = M('product_attr');				
				$obj_attr = $ProductAttrModel->get(array('id'=>$cart->attribute_id,'product_id'=>$cart->product_id));			
				$ProductAttrModel->modify(array('store'=>$obj_attr->store-$cart->shopping_number), array('id'=>$cart->attribute_id,'product_id'=>$cart->product_id));
								
				//$ProductModel->query("update `".T('product_attr')."` set `store`=(store-".$cart->shopping_number.") where product_id=".$cart->product_id." and id=".$cart->attribute_id);
			}
								
			$ProductModel->query("update `".T('product')."` set `inventory`=($product_inventory->inventory-".$cart->shopping_number.") where product_id=".$cart->product_id);
			
			$product_names .= $cart->product_name.'('.$cart->attribute.')*'.$cart->shopping_number.' ￥'.($cart->product_price*$cart->shopping_number).'\n';
			$product_number += $cart->shopping_number;
		}
			
		//删除掉cart的记录
		if($CartModel->delete(array('__IN__'=>array('id'=>$cartids))) === false)
		{
			$OrderModel->rollback();
			redirect("order_address.php?cart_ids=".$cart_ids,"订单生成失败3，请重新尝试");
			return;
		}


		$arrParam = array(
            'out_trade_no'  => $out_trade_no,
            'openid'        => $user->openid,
            'trade_type'    => 'JSAPI',
            'total_fee'     => $pay_online * 100,
            'coupon_fee'    => 0,
            'coupon_count'  => 0,
            'coupon_ids'    => 0,
            'coupon_fees'   => 0,
            'time'          => time(),
            'order_id'		=> $oid
        );
		$rs = $WxPayInfoModel->add( $arrParam );

		if ( $rs <= 0 )
		{
			$OrderModel->rollback();
			redirect("order_address.php?cart_ids=".$cart_ids,"订单生成失败4，请重新尝试");
			return;
		}	

		$OrderModel->commit();
		redirect("orders_confirm.php?order_id=".$oid);
		return;
		
	break;
	
	case 'del':
			$cart_ids = trim($_GET['cart_ids']);
			$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;	
			if($UserAddressModel->delete( array( 'id'=>$id, 'userid'=>$userid ) ))
			{
				redirect('order_address.php?cart_ids='.$cart_ids);
				return;
			}
	break;
	
	default:
		$addressList = $UserAddressModel->getAll(array('userid'=>$userid),array('id'=>'DESC'));
		include TEMPLATE_DIR.'/order_address_web.php';
	break;
}
?>