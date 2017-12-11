<?php
define('IS_TEST', false);//调试模式
!defined('HN1') && define('HN1', true);
require_once('./global.php');
!defined('SCRIPT_ROOT') && define('SCRIPT_ROOT',  dirname(__FILE__).'/');

$hideIndexIcon	= false;
$hideCartIcon	= false;


if(IS_TEST)
{
	$UserModel = D('User');
	$_SESSION['userInfo'] = $UserModel->get(array('id'=>1));
}
else
{
	if(!isWeixin() && !isset($_GET['show'])){
		echo 'Please use Weixin';
		exit();
	}
}


//如果没有登录，则根据登录时间，生成一个临时的userid
if(isset($_SESSION['userInfo']) && !empty($_SESSION['userInfo'])){
	$user = $_SESSION['userInfo'];
	$userid = $user->id;
}else{
	(!isset($_SESSION['tempUserInfo']) || empty($_SESSION['tempUserInfo'])) && $_SESSION['tempUserInfo'] = time();
	$userid = $_SESSION['tempUserInfo'];
	$user = null;
}
?>