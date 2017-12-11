<?php
define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
include "common.php";	//设置只能用微信窗口打开

$ShopModel = M('shop');
$Product   = D('Product');

$minfo = isset($_GET['minfo']) ? trim($_GET['minfo']) : '';

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=shop&minfo={$minfo}");
	return;
}

$AgentModel = M('agent_info');

if(empty($minfo)) {
	$referUrl = $_SERVER['HTTP_REFERER'];
	$agent = $AgentModel->get(array('userid'=>$userid));
	if(empty($agent)){
		$AgentApply = D('AgentApplication', $db);
		$apply = $AgentApply->get(array('userid'=>$userid));
		$msg = empty($apply) ? '您还不是分销商，没有小店' : '您的申请正在审核中';
		redirect($referUrl, $msg);
	}
}else{

	$UserModel = D('User');
	$minfoUser = $UserModel->get(array('minfo' => $minfo ));
	if(empty($minfoUser)) {
		redirect('index.php');
	}else{
		$userid = $minfoUser->id;
		if(empty($minfoUser->name)){
			$minfoAgent = $AgentModel->get(array('userid'=>$minfoUser->id));
			!empty($minfoAgent) && $shopName = $minfoAgent->name;
		}else{
			$shopName = $minfoUser->name;
		}
	}
}


//微信分享脚本
$wxJsTicket = $objWX->getJsTicket();
$wxShareCBUrl = $site.'shop.php';
$wxJsSign = $objWX->getJsSign($wxShareCBUrl);

$shop_info = $ShopModel->get(array('uid' => $userid ));

/***********************获取商品列表**************************/
//页码
$page 	= isset($_GET['page']) ? intval($_GET['page']) : 1;

//排序参数
$sell 	= isset($_GET['sell']) 	? true : false;		//销量
$cnum	= isset($_GET['cnum']) 	? true : false;		//评论数
$m		= isset($_GET['m'])		? sqlUpdateFilter(trim($_GET['m'])) : '';	//价格

$strSQL = "select sp.id,p.product_id,p.image,p.name,p.price,p.sell_number,(select count(id) as num from comment where product_id = p.product_id) as `comment_num` from product as p,shop_product as sp where sp.uid={$userid} and sp.product_id = p.product_id and p.status=1";

$url = "shop.php?o";

if($sell)
{
	$url .= "&sell";
	$strSQL .= " order by sell_number desc";
}
if($cnum)
{
	$url .= "&cnum";
	$strSQL .= " order by comment_num desc";
}
if($m != '')
{
	if($m == 'down')
	{
		$url .= "&m=up";
		$strSQL .= " order by price desc";
	}
	else
	{
		$url .= "&m=down";
		$strSQL .= " order by price asc";
	}
}

$url .= "&page=";

$pager = get_pager_data($db, $strSQL, $page,$per = 4);

if($shop_info == null)
{
	$arrParam = array(
		'uid'	=>	$userid,
		'name'	=> 	'',
		'icon'	=>	'',
		'addtime'	=> time()
	);
	$shop_id = $ShopModel->add($arrParam);

	if($shop_id == 0)
	{
		redirect("agent_user_new.php","创建店铺信息时失败");
		return;
	}

	$shop_info = $ShopModel->get(array('id' => $shop_id ));
}
$shopName = $shop_info->name;
empty($pager['DataSet']) && redirect('/shop_product.php?myself', '店铺没有商品，现在去选择商品');

$Product = M('product');
$productCount = $Product->getCount(array('status'=>1));
//todo 新品数量
$newPCount = min($productCount, 20);

$hideBotShop = true;

include TEMPLATE_DIR.'/shop_web.php';
?>