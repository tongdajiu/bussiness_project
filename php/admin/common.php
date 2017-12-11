<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

require_once SCRIPT_ROOT.'logic/ordersBean.php';
require_once SCRIPT_ROOT.'logic/userBean.php';
require_once SCRIPT_ROOT.'logic/cartBean.php';
require_once SCRIPT_ROOT.'logic/productBean.php';
require_once SCRIPT_ROOT.'logic/user_connectionBean.php';
require_once SCRIPT_ROOT.'logic/integral_recordBean.php';
require_once SCRIPT_ROOT.'logic/product_priceBean.php';

//$agent = $_SERVER['HTTP_USER_AGENT'];
//if(!strpos($agent,"icroMessenger")&&!isset($_GET['show'])) {
//	echo '此功能只能在微信浏览器中使用';exit;
//}

//如果没有登录，则根据登录时间，生成一个临时的userid
if($_SESSION['userInfo'] == null && $_SESSION['tempUserInfo'] == null){
	$_SESSION['tempUserInfo'] = time();
//	$_SESSION['tempUserInfo'] = 5;
}
$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	$userid = $_SESSION['tempUserInfo'];
}

/**
 * 注册用户
 */
 function register_user($db,$username,$pass,$name,$sex,$birthday,$email,$tel,$phone,$minfo,$openid){
	$ub = new userBean();
	$ucb = new user_connectionBean();

	//当前用户随机生成推荐码
	while(true){
		$user_minfo = rand(1000000000,9999999999);
		$obj_user = $ub->detail_minfo($db,$user_minfo);
		if($obj_user == null){
			break;
		}
	}
 	$userid = $ub->create($type=0,$level=0,$status=1,$sorting=1,$username,$pass,$name,$sex,$birthday,$email,$tel,$phone,$lastaccess=0,$landing_num=0,$integral=0,$obj_fuser->name,$isread=0,$openid,time(),$user_minfo,$privileges='',$db);

	// 验证推荐码，插入关系表
	$obj_fuser = $ub->detail_minfo($db,$minfo);
	if($obj_fuser != null){
		$ucb->create($userid,$obj_fuser->id,$minfo,$type=0,$db);
	}
 }

/**
 * 加入购物车
 */
function add_cart($db,$userid,$product_id,$shopping_number,$shopping_size='',$shopping_colorid=0,$price_id=0){
	$pb = new productBean();
	$cb = new cartBean();
	$ppb = new product_priceBean();
	$ub = new userBean();

	$obj_price = $ppb->detail($db,$price_id);
	$obj_product = $pb->detail($db,$product_id);
	$obj_user = $ub->detail($db,$userid);
	if($obj_price != null){
		$product_standard = $obj_price->standard;
		$product_price = $obj_price->price;
		$product_price_old = $obj_price->price_old;
	}else{
		$product_standard = $obj_product->standard;
		$product_price = $obj_product->price;
		$product_price_old = $obj_product->price_old;
	}
	if($obj_product->hot == 2 && $obj_user->type == 1){
		$product_type = 1;
	}else{
		$product_type = 0;
	}
	$cb->create($userid,$product_id,$obj_product->name,$product_standard,$product_price,$product_price_old,$obj_product->image,$order_id=0,$shopping_number,$shopping_size,$shopping_colorid,$obj_product->integral,$paying_status=0,$product_type,$type=0,$promotions_content='',time(),$db);
}

/**
 * 计算推荐关系各层积分获取
 * @order_id 订单编号
 */
function get_connection_integral($db,$order_id){
	$ob = new ordersBean();
	$cb = new cartBean();
	$pb = new productBean();
	$ub = new userBean();
	$irb = new integral_recordBean();

	$obj_order = $ob->detail($db,$order_id);
	$obj_user = $ub->detail($db,$obj_order);
	$carts = $cb->get_result_order($db,$order_id);

	$total_integral = 0;
	foreach($carts as $cart){
		$obj_product = $pb->detail($db,$cart->product_id);
		$total_integral += ($obj_product->integral * $cart->shopping_number);
	}
	// 当前用户获取积分
	$irb->create($type=0,$status=1,$obj_user->id,$pin_id=0,$pin_type=0,$order_id,$total_integral,time(),$db);
	$ub->update_integral($db,$total_integral,$obj_user->id);
	//用户上层推荐人获取积分，按1:1获取
	set_fuser_integral($db,$order_id,$obj_user->id,$total_integral);
}

/**
 * 递归获取用户上层的所有推荐人
 */
 function set_fuser_integral($db,$order_id,$userid,$integral){
 	$ucb = new user_connectionBean();
 	$ub = new userBean();

 	$obj_connection = $ucb->detail_userid($db,$userid);
 	if($obj_connection != null){
 		$obj_fuser = $ub->detail($db,$obj_connection->fuserid);
 		$irb->create($type=1,$status=1,$obj_fuser->id,$pin_id=0,$pin_type=0,$order_id,$integral,time(),$db);
		$ub->update_integral($db,$integral,$obj_fuser->id);
		set_fuser_integral($db,$order_id,$obj_fuser->id,$integral);
 	}else{
 		break;
 	}
 }

/**
 * 将临时用户的购物车记录更新到当前用户
 */
function update_cart_temp($db){
	$cb = new cartBean();
	$user = $_SESSION['userInfo'];
	$temp_userid = $_SESSION['tempUserInfo'];
	if($user != null){
		$cb->update_temp_carts($db,$temp_userid,$user->id);
	}
}
?>