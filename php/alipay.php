<?php
define('HN1', true);
require_once('global.php');
include "common.php";	//设置只能用微信窗口打开

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=alipay");
	return;
}

include TEMPLATE_DIR.'/alipay_web.php';
?>