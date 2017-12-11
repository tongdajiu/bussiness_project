<?php
define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开

$AnnouncementModel = M('announcement');

//!VersionModel::isOpen('articleIntegral') && $cond['__NOTIN__'] = array('id'=>array(11));
$announcementList = $AnnouncementModel->getALL();

include TEMPLATE_DIR.'/announcement_web.php';
?>








