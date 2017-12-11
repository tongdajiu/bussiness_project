<?php
define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$UserModel = D('User');
$VisitRecordsModel = M('visit_records');
$ProductModel = D('Product');

$page      =! isset($_GET['page'])         ?  1 : intval($_GET['page']);

$url = $url."agent_visit_product.php?page=";

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=agent_visit_product");
	return;
}
$obj_user = $UserModel->get($arrWhere=array('id'=>$user = $_SESSION['userInfo']->id));

$recordsList = $VisitRecordsModel->gets($arrWhere=array('userid'=>$obj_user->id),array('id'=>'desc'),$page, $perpage = 20);

include TEMPLATE_DIR.'/agent_visit_product_web.php';
?>