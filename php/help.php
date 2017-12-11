<?php
define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$ArticleModel = D('Article');

$articleList = $ArticleModel->getAll(array('channel'=>1,'status'=>1),array('sorting'=>'desc', 'id'=>'asc'));

include TEMPLATE_DIR."/help_web.php";
?>