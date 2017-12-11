<?php
define('HN1', true);
require_once ('./global.php');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

include "common.php"; //设置只能用微信窗口打开

$i 				= !isset($_REQUEST['i']) 			? -1 : intval($_REQUEST['i']);
$product_id 	= !isset($_REQUEST['product_id']) 	? -1 : intval($_REQUEST['product_id']);
$act 			= !isset($_REQUEST['act']) 			? '' : $_REQUEST['act'];
$order_id 		= !isset($_REQUEST['order_id']) 	? 0  : intval($_REQUEST['order_id']);
$minfo 			= !isset($_REQUEST['minfo']) 		? '' : $_REQUEST['minfo'];
$from 			= !isset($_REQUEST['from']) 		? '' : $_REQUEST['from'];

$user = $_SESSION['userInfo'];
if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=favorites","您还未登陆！");
	return;
}

$Shop = D('Shop');

switch ($act)
{
	case 'share' :
		share($db);
		break;

	default :
		$time = time();
		// 获取商品信息
		$ProductModel = D('product',$db);
		$obj = $ProductModel->getInfo( $product_id );

		if ( $obj == null )
		{
			redirect("product.php", "找不到该商品！");
			return;
		}

		if ($obj->status === 0)
		{
			redirect("orders.php", "该商品已经下架，无法查看！");
			return;
		}

		// 收藏信息
		$VisitRecordsModel = M('favorites',$db);
		$arrWhere = array(
			'userid' 		=> $userid,
			'product_id'  	=> $product_id
		);
		$rs = $VisitRecordsModel->get($arrWhere);

// 		// 添加浏览记录
// 		$VisitRecordsModel = M('visit_records',$db);
// 		$arrParam = array(
// 			'userid' 		=> $userid,
// 			'product_id'	=> $product_id,
// 			'addtime'		=> $time
// 		);
// 		$VisitRecordsModel->add($arrParam);

		// 更新浏览数
		$arrParam = array( 'viewed' => $obj->viewed + 1 );
		$arrWhere = array( 'product_id' => $product_id );
		$ProductModel->modify($arrParam, $arrWhere);


		// 商品图片
		$ProductImageModel 	= M('productimage',$db);
		$arrWhere 			= array('productId' => $product_id, 'status' => 1);
		$imageList 			= $ProductImageModel->getAll( $arrWhere,'`id` desc' );

		


		// 用户信息
		$UserModel 			= M('user',$db);
		$arrWhere 			= array('id' => $userid);
		$obj_user 			= $UserModel->get( $arrWhere);

		// 商品评价
		$CommentModel 		= M('comment', $db);
		$arrWhere 			= array('product_id' => $product_id);
		$commentList 		= $CommentModel->getAll( $arrWhere,'`id` desc' );

/*
		// 商品属性列表
		$ProductAttrModel 	= M('product_attr', $db);
		$arrWhere 			= array('product_id' => $product_id);
		$attrList 			= $ProductAttrModel->getAll( $arrWhere );


		if(empty($attrList)){//没有属性
			$bPrice = $ProductModel->getValidBargainPrice(array($product_id=>0));
			if(!empty($bPrice[$product_id][0])){
				$pBargain = array();
				$bPrice = $bPrice[$product_id][0];
				if(isset($bPrice['price'])){
					if($obj->price != $bPrice['price']) {
						$pBargain['oprice'] = $obj->price;
						$pBargain['discount'] = round($bPrice['price']/$pBargain['oprice']*10, 1);
						$obj->price = $bPrice['price'];
					}
				}
				isset($bPrice['store']) && $obj->inventory = $bPrice['store'];
				$pBargain['rtime'] = $bPrice['etime'] ? $bPrice['etime']-$time : -1;
			}

			$priceRange = number_format($obj->price,2);
			$store = $obj->inventory;
		}else{
			$bPrice = array();
			$attrIds = array();
			foreach($attrList as $v){
				$attrIds[] = $v->id;
			}
			if(!empty($attrIds)){
				$bPrice = $ProductModel->getValidBargainPrice(array($product_id=>$attrIds));
				$bPrice = $bPrice[$product_id];
			}

			$arrStore = array();
			$arrPrice = array();
			foreach($attrList as $key=>$row)
			{

				$arrGroups = json_decode($row->attr_group,true);

				$arrkey = array();
				foreach($arrGroups as $g=>$arrGroup)
				{
					$attr_names[$arrGroup['attr_id']] = $arrGroup['attr_name'];

					$attr_values[$arrGroup['attr_id']][$arrGroup['attr_value']['id']] = $arrGroup['attr_value']['value'];

					$arrkey[] = $arrGroup['attr_id'].'-'.$arrGroup['attr_value']['id'];
				}
				sort($arrkey);
				$arrkey = implode(':', $arrkey);
				$arrMoney[$arrkey]['price'] = isset($bPrice[$row->id]['price']) ? $bPrice[$row->id]['price'] : $row->price;
				$arrMoney[$arrkey]['store'] = isset($bPrice[$row->id]['store']) ? $bPrice[$row->id]['store'] : $row->store;
				$arrMoney[$arrkey]['rtime'] = $bPrice[$row->id]['etime'] ? $bPrice[$row->id]['etime']-$time : -1;
				$arrMoney[$arrkey]['oprice'] = $row->price;
				$arrMoney[$arrkey]['discount'] = round($arrMoney[$arrkey]['price']/$arrMoney[$arrkey]['oprice']*10, 1);
				$arrStore[] = $arrMoney[$arrkey]['store'];
				$arrPrice[] = $arrMoney[$arrkey]['price'];
			}
			$minPrice = number_format(min($arrPrice), 2);
			$maxPrice = number_format(max($arrPrice), 2);
			$priceRange = $minPrice;
			($maxPrice != $minPrice) && $priceRange .= ' ~￥'.$maxPrice;
			$store = max($arrStore);
		}
*/
		if ($order_id > 0)
		{
			$title = '我刚买了' . $gSetting['site_name'] . ':' . $obj->name;
		}
		else
		{
			$title = $gSetting['site_name'] . '产品推荐:' . $obj->name;

		}

		if ($minfo != '')
		{
			redirect("login.php?dir=product_detail&product_id=" . $product_id . "&minfo=" . $minfo . "&from=" . $from);
			return;
		}

		break;
}


//获取jsapi签名
$noncestr = create_randomstr(16);
$timestamp = time();

$url = $_SERVER['QUERY_STRING'] == null ? $_SERVER['PHP_SELF'] : $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
$url = explode('/', $url);
$newurl = $url[1];
$signature = get_signature($noncestr, $timestamp, $newurl);

include TEMPLATE_DIR.'/product_detail_web.php';
?>