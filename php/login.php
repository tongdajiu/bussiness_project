<?php
define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$UserModel = D('User');
$UserConnectionModel = M('user_connection');
$ProductModel = D('Product'); 
$CouponModel = D('Coupon');


$username		= (isset($_REQUEST['username']) && !empty($_REQUEST['username'])) ? $_REQUEST['username'] : '';
$pass			= (isset($_REQUEST['pass']) && !empty($_REQUEST['pass'])) ? $_REQUEST['pass'] : '';
$act			= (isset($_REQUEST['act']) && !empty($_REQUEST['act'])) ? $_REQUEST['act'] : '';
$dir			= (isset($_REQUEST['dir']) && !empty($_REQUEST['dir'])) ? $_REQUEST['dir'] : 'user';
$product_id		= (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) ? $_REQUEST['product_id'] : '0';
$state			= (isset($_REQUEST['state']) && !empty($_REQUEST['state'])) ? $_REQUEST['state'] : '';
$mcode			= (isset($_REQUEST['mcode']) && !empty($_REQUEST['mcode'])) ? $_REQUEST['mcode'] : '';
$pin_id			= (isset($_REQUEST['pin_id']) && !empty($_REQUEST['pin_id'])) ? $_REQUEST['pin_id'] : 0;
$cart_ids		= (isset($_REQUEST['cart_ids']) && !empty($_REQUEST['cart_ids'])) ? $_REQUEST['cart_ids'] : '';
$pin_type		= (isset($_REQUEST['pin_type']) && !empty($_REQUEST['pin_type'])) ? $_REQUEST['pin_type'] : 0;
$share_user		= (isset($_REQUEST['share_user']) && !empty($_REQUEST['share_user'])) ? $_REQUEST['share_user'] : '';
$share_name		= (isset($_REQUEST['share_name']) && !empty($_REQUEST['share_name'])) ? $_REQUEST['share_name'] : '';
$suserid		= (isset($_REQUEST['suserid']) && !empty($_REQUEST['suserid'])) ? $_REQUEST['suserid'] : '';
$activity_id	= (isset($_REQUEST['activity_id']) && !empty($_REQUEST['activity_id'])) ? $_REQUEST['activity_id'] : 0;
$mid			= (isset($_REQUEST['mid']) && !empty($_REQUEST['mid'])) ? $_REQUEST['mid'] : '';
$cardid			= (isset($_REQUEST['cardid']) && !empty($_REQUEST['cardid'])) ? $_REQUEST['cardid'] : '';
$openid			= (isset($_REQUEST['openid']) && !empty($_REQUEST['openid'])) ? $_REQUEST['openid'] : '';
$minfo			= (isset($_REQUEST['minfo']) && !empty($_REQUEST['minfo'])) ? $_REQUEST['minfo'] : '';
$category_id	= (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) ? $_REQUEST['category_id'] : '';
$head_image		= (isset($_REQUEST['head_image']) && !empty($_REQUEST['head_image'])) ? $_REQUEST['head_image'] : '';
$from			= (isset($_REQUEST['from']) && !empty($_REQUEST['from'])) ? $_REQUEST['from'] : '';
$type			= (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) ? $_REQUEST['type'] : -1;
$phase_id		= (isset($_REQUEST['phase_id']) && !empty($_REQUEST['phase_id'])) ? $_REQUEST['phase_id'] : 0;


switch($act)
{
	case 'login_out':
		login_out();
		break;

	default:
		if($state == '')
		{

			$redirectUri = $site."login.php?dir=".$dir."&mcode=".$mcode."&pin_id=".$pin_id."&cart_ids=".$cart_ids."&pin_type=".$pin_type."&share_user=".$share_user."&share_name=".$share_name."&suserid=".$suserid."&activity_id=".$activity_id."&mid=".$mid."&cardid=".$cardid."&openid=".$openid."&minfo=".$minfo."&product_id=".$product_id."&category_id=".$category_id."&from=".$from."&type=".$type."&phase_id=".$phase_id;

			$wxOauthUrl = $objWX->getOauthRedirect($redirectUri, '123', 'snsapi_base');
			header('location:' . $wxOauthUrl);
			exit();
		}

		$CODE = (isset($_REQUEST['code']) && !empty($_REQUEST['code'])) ? $_REQUEST['code'] : '';
		$mcode = (isset($_REQUEST['mcode']) && !empty($_REQUEST['mcode'])) ? $_REQUEST['mcode'] : '';
		$pin_id = (isset($_REQUEST['pin_id']) && !empty($_REQUEST['pin_id'])) ? $_REQUEST['pin_id'] : 0;
		$cart_ids = (isset($_REQUEST['cart_ids']) && !empty($_REQUEST['cart_ids'])) ? $_REQUEST['cart_ids'] : '';
		$pin_type = (isset($_REQUEST['pin_type']) && !empty($_REQUEST['pin_type'])) ? $_REQUEST['pin_type'] : 0;
		$share_user = (isset($_REQUEST['share_user']) && !empty($_REQUEST['share_user'])) ? $_REQUEST['share_user'] : '';
		$share_name = (isset($_REQUEST['share_name']) && !empty($_REQUEST['share_name'])) ? $_REQUEST['share_name'] : '';
		$suserid = (isset($_REQUEST['suserid']) && !empty($_REQUEST['suserid'])) ? $_REQUEST['suserid'] : '';
		$activity_id = (isset($_REQUEST['activity_id']) && !empty($_REQUEST['activity_id'])) ? $_REQUEST['activity_id'] : 0;
		$mid = (isset($_REQUEST['mid']) && !empty($_REQUEST['mid'])) ? $_REQUEST['mid'] : '';
		$cardid = (isset($_REQUEST['cardid']) && !empty($_REQUEST['cardid'])) ? $_REQUEST['cardid'] : '';
		$openid = (isset($_REQUEST['openid']) && !empty($_REQUEST['openid'])) ? $_REQUEST['openid'] : '';
		$minfo = (isset($_REQUEST['minfo']) && !empty($_REQUEST['minfo'])) ? $_REQUEST['minfo'] : '';
		$category_id = (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) ? $_REQUEST['category_id'] : '';
		$head_image = (isset($_REQUEST['head_image']) && !empty($_REQUEST['head_image'])) ? $_REQUEST['head_image'] : '';

		$curTime = time();
		$result_array = $objWX->getOauthAccessToken();

/*
		$result_array = array(
						'status' 		=> 1,
						'nickname'		=> 'Dennis',
						'pass'			=> md5('123456'),
						'sex'			=> 1,
						'openid'		=> 'oxasbdjfdi12345',
						'addTime'		=> time(),
						'headimgurl'	=> '/images/avtance'
					);
*/
		$KDatetime = date('Y-m-d H:i:s',$curTime);
		if( $result_array["openid"] != '' )
		{
			$wx_user_info = $objWX->getUserInfo($result_array["openid"]);					// 微信调用获取用户信息

			$obj_user = $UserModel->get(array('openid'=>$wx_user_info["openid"]));
			$KFile    = DATA_DIR.'/user_login_txt.txt';
			$KContent = "openid:".$result_array["openid"]."\n Time:".$KDatetime."\n";
			file_put_contents($KFile,$KContent,FILE_APPEND);

			if( $obj_user == null || $obj_user == '' )
			{
				//当前用户随机生成推荐码
				while(true)
				{
					$user_minfo = create_randomstr(7);
					$obj_user = $UserModel->get(array('minfo'=>$user_minfo));
					if($obj_user == null)
					{
						break;
					}
				}

				$newUserData = array(
					'openid' => $wx_user_info['openid'],
					'name' => $wx_user_info['nickname'],
					'username' => $wx_user_info['nickname'],
					'pass'	   => md5('123456'),
					'status' => 1,
					'sex' => $wx_user_info['sex'],
					'head_image' => $wx_user_info['headimgurl'],
					'addTime' => $curTime,
					'minfo'		=> $user_minfo
				);

				$userid = $UserModel->add($newUserData);
			}

			$obj_user = $UserModel->get(array('openid'=>$wx_user_info["openid"]));

			$_SESSION['userInfo'] = $obj_user;

			$url = '/'.$dir.".php?i=1";
			($pin_id > 0) && $url.="&pin_id=".$pin_id;
			($cart_ids != null || $cart_ids != '') && $url.="&cart_ids=".$cart_ids;
			($pin_type > 0) && $url.="&pin_type=".$pin_type;
			($product_id > 0) && $url.="&product_id=".$product_id;
			($share_user != '') && $url.="&share_user=".$share_user;
			($share_name != '') && $url.="&share_name=".$share_name;
			($suserid != '') && $url.="&suserid=".$suserid;
			($activity_id > 0) && $url.="&activity_id=".$activity_id;
			($mid != '') && $url.="&mid=".$mid;
			($cardid != '') && $url.="&cardid=".$cardid;
			($openid != '') && $url.="&openid=".$openid;
			($category_id != '') && $url.="&category_id=".$category_id;
			($head_image != '') && $url.="&head_image=".$head_image;
			($from != '') && $url.="&from=".$from;
			($type > -1) && $url.="&type=".$type;
			($phase_id > 0) && $url.="&phase_id=".$phase_id;
			redirect($url);
		}
		else
		{
			$KFile='user_error_txt.txt';
			$KContent="CODE:".$CODE."\n Time:".$KDatetime."\n";
			file_put_contents($KFile,$KContent,FILE_APPEND);
		}
}

/**
 * 退出登录
 */
function login_out(){
 	$_SESSION['userInfo'] = null;
 	redirect('index.php');
	return;
}
?>
