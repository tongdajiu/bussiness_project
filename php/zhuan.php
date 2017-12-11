<?php
define('HN1', true);
require_once('./global.php');

include "common.php";	//设置只能用微信窗口打开

$Agent = D('Agent');
if($Agent->isAgent($_SESSION['userInfo']->id)){
    header('location:shop.php');
}

$Apply = D('AgentApplication');
$apply = $Apply->get(array('userid'=>$_SESSION['userInfo']->id));

include TEMPLATE_DIR.'/zhuan_web.php';
?>