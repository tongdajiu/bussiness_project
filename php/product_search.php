<?php

define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$key = $_REQUEST['key'] == null || $_REQUEST['key'] == '请输入关键字' ? '' : $_REQUEST['key'];

$Product = D('Product',$db);
$productList = $Product->getSearchList( $key );

include TEMPLATE_DIR.'/product_search_web.php';
?>
