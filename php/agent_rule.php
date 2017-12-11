<?php
define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$ArticleModel = D('Article');

$obj = $ArticleModel->getAll(array('channel'=>2), array('addtime'=>'DESC'),OBJECT,1);
$obj = $obj[0];

include TEMPLATE_DIR.'/agent_rule_web.php';

?>