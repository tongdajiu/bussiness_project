<?php
define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$id = $_REQUEST['id'] == null ? '0' : intval($_REQUEST['id']);
$article = D('Article');
$article_content=$article->get(array('id'=>$id));

include TEMPLATE_DIR."/help_detail_web.php";

?>