<?php
define('HN1', true);
require_once('global.php');

include "common.php";	//设置只能用微信窗口打开

$PayRecordsModel = M('pay_records');
$UserModel = D('User');

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=pay_records");
	return;
}

$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$recordsList = $PayRecordsModel->gets(array('userid'=>$userid),array('id'=>'DESC'),$page,15);

$obj_user = $UserModel->get(array('id'=>$userid));

include TEMPLATE_DIR.'/pay_records_web.php';
?>