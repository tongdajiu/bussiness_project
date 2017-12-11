<?php
!defined('HN1') && exit('Access Denied.');

$act = isset($_GET['act']) ? $_GET['act'] :  '';


switch( $act )
{
	case 'not_found':
		include '404.php';
	break;

	default:
		echo '<div style="padding-top:200px;text-align:center;font-size:20px;"><p>欢迎登录，'.$site_name.'后台管理</p></div>';
	break;
}


?>
