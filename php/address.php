<?php
define('HN1', true);
require_once('global.php');
include "common.php";	//设置只能用微信窗口打开

$act 		= isset($_REQUEST['act'])  		? $_REQUEST['act']			: '';
$cart_ids 	= isset($_REQUEST['cart_ids'])	? $_REQUEST['cart_ids']		: '';

$UserModel = D('User');
$UserAddressModel = D('UserAddress');

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
	case 'add':
		$obj_user = $UserModel->get(array('id'=>$userid));
		include TEMPLATE_DIR.'/address_add_web.php';
	break;
	
	
	case 'post':
		$address 			= $_REQUEST['address'] 				== null ? '' : $_REQUEST['address'];
		$shipping_firstname = $_REQUEST['shipping_firstname'] 	== null ? 0  : $_REQUEST['shipping_firstname'];
		$telephone 			= $_REQUEST['telephone'] 			== null ? '' : $_REQUEST['telephone'];
		$s_province 		= $_REQUEST['s_province'] 			== null ? '' : $_REQUEST['s_province'];
		$s_city 			= $_REQUEST['s_city'] 				== null ? '' : $_REQUEST['s_city'];
		$s_county			= $_REQUEST['s_county'] 			== null ? '' : $_REQUEST['s_county']=='市、县级市' ? '' : $_REQUEST['s_county'];
		
		
		//判断是否从订单那边跳转过来
		if(empty($cart_ids))
		{
			$rebackUrl = "address.php";
		}
		else
		{
			$rebackUrl = "order_address.php?cart_ids=".$cart_ids;
		}
		
		
		if( empty($s_city))
		{
			redirect($rebackUrl,"该地址不符合规格，请重新填写地址");
			return;
		}
		
		if( $s_province == $s_city )
		{
			$address = $s_province.$s_county.$address;
		}
		else
		{
			$address = $s_province.$s_city.$s_county.$address;
		}
		
		$arrParam = array(
				'userid'	=> $userid,
				'status'	=> 1,
				'chick'		=> 0,
				'city'		=> $s_city,
				'area'		=> $s_county,
				'address'	=> $address,
				'shipping_firstname'	=> $shipping_firstname,
				'telephone'	=> $telephone
		);
		
		if ($UserAddressModel->add($arrParam) === false)
		{
			redirect($rebackUrl,"添加失败");
			return;
		}
		
		$obj_user = $UserModel->get(array('id'=>$userid));		
		// 校验如果姓名在user表为空，那么就保存收货人姓名到用户昵称
		if($obj_user->name=='')
		{
			$UserModel->modify( array('shipping_firstname'=>$shipping_firstname), array('userid'=>$userid) );
		}
		
		redirect($rebackUrl);
		return;
		
	break;
	
	case 'del':
			$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
			if($UserAddressModel->delete( array( 'id'=>$id, 'userid'=>$userid ) ) === false)
			{
				redirect('address.php',"删除失败");
				return;
			}
			redirect('address.php');
			return;
	break;
	
	default:
		$addressList = $UserAddressModel->getAll(array('userid'=>$userid),array('id'=>'DESC'));
		include TEMPLATE_DIR.'/address_web.php';
	break;
}
?>
