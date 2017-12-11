<?php
define('HN1', true);
require_once ('./global.php');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

include "common.php"; //设置只能用微信窗口打开

$act = ! isset($_REQUEST['act']) ? '' : $_REQUEST['act'];

$ProductAttrModel = M('product_attr',$db);
$hideCartIcon = true;

$CartModel 		= M('cart',$db);
$UserModel 		= M('user',$db);
$ProductModel 	= D('product',$db);

$obj_user  = $UserModel->get( array( 'id'=>$userid ) );		// 用户信息

switch ($act)
{
	// 提交信息
	case 'post' :

		$selCartIds = $_REQUEST['cart_id'];
		empty($selCartIds) && redirect('cart.php', '请选择要购买的商品');

		$cartIds = array();
		$productIds = array();
		$products = array();
		$attrIds = array();
		$attrs = array();
		$cartList = $CartModel->getAll(array('__IN__'=>array('id'=>$selCartIds)));

		foreach($cartList as $v){
			$cartIds[] = $v->id;
			$productIds[] = $v->product_id;
			$v->attribute_id && $attrIds[] = $v->attribute_id;
		}

/*
		$diffCart = array_diff($selCartIds, $cartIds);

		!empty($diffCart) && redirect("cart.php","购物车信息错误");
*/
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
		$Cart = D('Cart');
		$cartList = $Cart->realtime($cartList);

		foreach($cartList as $cart){
			empty($products[$cart->product_id]) && redirect("cart.php", '商品 '.$cart->product_name.' 已下架');
			($cart->attribute_id && empty($attrs[$cart->attribute_id])) && redirect("cart.php", '商品 '.$cart->product_name.' 有变动,请删除后重新添加');
			($cart->shopping_number > $cart->product_store) && redirect("cart.php", '商品 '.$cart->product_name.' 库存不足');
		}

		$strCartId = implode(',', $selCartIds);
		redirect("order_address.php?cart_ids=" . $strCartId);
		return;
	break;

	case 'add' :
		$userid 		 = $userid;

		$product_id 	 = !isset($_REQUEST['product_id'])  	? 0 : intval($_REQUEST['product_id']);
		$shopping_number = !isset($_REQUEST['shopping_number']) ? 1 : intval($_REQUEST['shopping_number']);
		$fastBuy = intval($_REQUEST['fastbuy']);
		$fastBuy = $fastBuy ? 1 : 0;

		if ( $product_id == 0 )
		{
			echo -5;
			exit;
		}

		// 获取产品信息
		$obj_product = $ProductModel->get( array('product_id' => $product_id ));

		if ( $obj_product == null )
		{
			echo -5;
			exit;
		}

		$standard 	= isset($_REQUEST['standard']) ? sqlUpdateFilter(trim($_REQUEST['standard'])) : '';	//规格
		$attrList 	= $ProductAttrModel->getAll(array('product_id' => $product_id));

		if($attrList != null)
		{
			$bPrice = array();
			$attrIds = array();
			foreach($attrList as $v){
				$attrIds[] = $v->id;
			}
			if(!empty($attrIds)){
				$bPrice = $ProductModel->getValidBargainPrice(array($product_id=>$attrIds));
				$bPrice = $bPrice[$product_id];
			}
			
			foreach($attrList as $key=>$row)
			{
				$arrGroups = json_decode($row->attr_group,true);

				$arrkey 	= '';
				$arrkeyname = '';			
				
				$arrkey = array();
				foreach($arrGroups as $g=>$arrGroup)
				{
					$arrkey[] = $arrGroup['attr_id'].'-'.$arrGroup['attr_value']['id'];
					$arrkeyname[$arrGroup['attr_id']] = $arrGroup['attr_name'].':'.$arrGroup['attr_value']['value'].';';					
				}
				sort($arrkey);
				$arrkey = implode(':', $arrkey);

				$arrMoney[$arrkey]['price'] = isset($bPrice[$row->id]['price']) ? $bPrice[$row->id]['price'] : $row->price;
				$arrMoney[$arrkey]['store'] = isset($bPrice[$row->id]['store']) ? $bPrice[$row->id]['store'] : $row->store;
				$arrMoney[$arrkey]['id'] 	= $row->id;
				$arrMoney[$arrkey]['standard'] = implode('', $arrkeyname);
				$arrkey = '';
				$arrkeyname = '';
			}
		}
/*
		if($standard!='')
		{
			echo 'bbbb======</br>';
			if(isset($arrMoney[$standard]['standard']))
			{
				$product_standard = $arrMoney[$standard]['standard'];
				$attribute_id = $arrMoney[$standard]['id'];
				$store = $arrMoney[$standard]['store'];
			}
			else
			{
				echo -3;
				return;
			}

			$product_price = $arrMoney[$standard]['price'];
		}
		else
		{
			$b_Price = $ProductModel->getValidBargainPrice(array($product_id=>0));
			$b_Price = $b_Price[$product_id][0];
			$store = isset($b_Price['store']) && $b_Price['store'] > 0 ? $b_Price['store'] : $obj_product->inventory;
			$product_price = isset($b_Price['price']) && $b_Price['price'] > 0 ? $b_Price['price'] : $obj_product->price;							
			$attribute_id = 0;
			$product_standard = '';	
		}
*/
		$product_standard = '';	
		$attribute_id = 0;
		$store = $obj_product->inventory;
		$product_price = $obj_product->price;
		$product_price_old = $obj_product->price_old;

		//验证库存是否足够
		if($shopping_number > $store)
		{
			echo -4;
			return;
		}

		$product_type = ($obj_product->hot == 2 && $obj_user->type == 1) ? 1 : 0;
		$cartInfo = array(
			'userid' 			=> 	$userid,
			'product_id'		=>	$product_id,
			'product_name'		=>	$obj_product->name,
			'product_model'		=>	'',
			'product_price'		=>	$product_price,
			'product_price_old'	=>	$product_price_old,
			'product_image'		=>	$obj_product->image,
			'order_id'			=>	0,
			'shopping_number'	=>	$shopping_number,
			'shopping_size'		=>	'',
			'shopping_colorid'	=>	0,
			'integral'			=>	$obj_product->integral,
			'paying_status'		=>	0,
			'type'				=>	0,
			'promotions_content'=>	'',
			'addTime'			=>	time(),
			'attribute_id'		=>	$attribute_id,
			'attribute'			=>	$product_standard,
		);



		if($fastBuy){
			$cartInfo['fast_buy'] = 1;
			//购物车中立即购买的商品
			$fastCart = $CartModel->get(array('userid'=>$userid, 'fast_buy'=>1));
			if(empty($fastCart)){
				$cid = $CartModel->add($cartInfo);
			}else{
				$cid = $fastCart->id;
				$CartModel->modify($cartInfo, array('id'=>$cid));
			}
		}else{
			//验证该物品是否存在于购物车
			$obj_cart = $CartModel->getCount( array( 'userid' =>$userid, 'product_id'=>$product_id, 'attribute'=>$standard, 'fast_buy'=>0) );

			if ( $obj_cart > 0 )
			{
				echo -1;
				return;
			}
			$cartInfo['fast_buy'] = 0;
			$cid = $CartModel->add($cartInfo);

		}

		echo $cid ? ($fastBuy ? $cid : 1) : -2;
	break;

	// 修改购物车的数量
	case 'inventory':

		$cartId 	= isset($_REQUEST['cart_id']) 		? intval($_REQUEST['cart_id']) : '';		// 购物车id
		$num = isset($_REQUEST['buy_number']) 	? intval($_REQUEST['buy_number']) : '';		// 购买数量
		empty($cartId) && _ajaxReturn(-1);//缺少参数

		$userid = getSession_userid();	//用户id

		//获取购物车信息
		$cart = $CartModel->get(array('id'=>$cartId,'userid'=>$userid));
		empty($cart) && _ajaxReturn(-2);//没有这条购物车信息

		//获取产品信息
		$product = $ProductModel->get(array('product_id'=>$cart->product_id,'status'=>1));
		empty($product) && _ajaxReturn(-3);//商品已不存在

		if($cart->attribute_id){//有属性
			$proAttr = $ProductModel->getAttr($cart->attribute_id);
			empty($proAttr) && _ajaxReturn(-5);//商品属性发生变动

			$bPrice = $ProductModel->getValidBargainPrice(array($product->product_id=>array($cart->attribute_id)));
			$bPrice = $bPrice[$product->product_id];
			$store = isset($bPrice['store']) ? $bPrice['store'] : $proAttr['store'];
			($num > $store) && _ajaxReturn(-4);//超出库存数
		}else{//有属性
			($num > $product->inventory) && _ajaxReturn(-4);//超出库存数
		}
		
		$CartModel->modify(array('shopping_number'=>$num), array('id'=>$cartId));
		_ajaxReturn(1);
		$CartModel->modify(array('shopping_number'=>$num), array('id'=>$cartId));
		_ajaxReturn(1);
	break;


	case 'del' :
		$id = !isset($_REQUEST['id']) 		? '' : intval($_REQUEST['id']);
		$CartModel->delete( array( 'id'=>$id ) );
		redirect("cart.php");
		return;
	break;

	default :
		$cartList = $CartModel->getAll(array('userid'=>$userid, 'fast_buy'=>0));
		$Cart = D('Cart');
		$cartList = $Cart->realtime($cartList);
		include TEMPLATE_DIR.'/cart_web.php';
	break;
}

function _ajaxReturn($code){
	echo $code;
	exit();
}
?>