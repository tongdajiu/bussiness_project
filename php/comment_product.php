<?php
define('HN1', true);
require_once('./global.php');
include "common.php";	//设置只能用微信窗口打开

$CommentModel = M('comment');
$product_id = $_REQUEST['product_id'] == null ? 0 : $_REQUEST['product_id'];
$commentList = $CommentModel->getAll(array('product_id'=>$product_id),array('id'=>'DESC'));

include TEMPLATE_DIR.'/comment_product_web.php';
?>
