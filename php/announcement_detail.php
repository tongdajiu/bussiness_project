<?php
define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$id = $_REQUEST['id'] == null ? '0' : intval($_REQUEST['id']);
//(!VersionModel::isOpen('articleIntegral') && ($id == 11)) && redirect('article.php', '内容不存在');

$AnnouncementModel = M('announcement');
$announcement_content=$AnnouncementModel->get(array('id'=>$id));

include TEMPLATE_DIR.'/announcement_detail_web.php';
?>