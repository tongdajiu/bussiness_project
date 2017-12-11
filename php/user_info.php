<?php

define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开



$UserModel = D('User');
$act =!isset($_REQUEST['act']) ? '' : $_REQUEST['act'];

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user_info");
	return;
}
$obj_user = $UserModel->get(array('id'=>$userid));

switch($act){
case 'post':
	$userid = $_SESSION['userInfo']->id;//$_REQUEST['userid'] == null ? '' : $_REQUEST['userid'];
	$name = !isset($_REQUEST['name']) ? '' : sqlUpdateFilter($_REQUEST['name']);
	$tel = sqlUpdateFilter($_REQUEST['tel']) == null ? '' : sqlUpdateFilter($_REQUEST['tel']);

	if($name==''){
		redirect('user_info.php','昵称不能为空！');
		return;
	}if($tel==''){
		redirect('user_info.php','手机号码不能为空！');
		return;
	}else{
		$UserModel->modify($data=array('name'=>$name,'tel'=>$tel),array('id'=>$userid));
	
		redirect('user.php','修改成功！');
		return;
	}	
break;
default:
$obj_user_name = $obj_user->name;
break;
}
include TEMPLATE_DIR.'/user_info_web.php';
?>
