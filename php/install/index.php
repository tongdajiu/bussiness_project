<?php
define('HN1', true);
/* 取得当前系统所在的根目录 */
define('ROOT_PATH', str_replace('install/index.php', '', str_replace('\\', '/', __FILE__)));

if (file_exists(ROOT_PATH . 'data/install.lock') || file_exists(ROOT_PATH . 'install/install.lock'))
{
	header("Location: ".ROOT_PATH."index.php\n");
	exit;
}


include_once(ROOT_PATH.'install/includes/lib_auto_installer.php');

$tag = true;


//获取系统环境信息
$system_info = get_system_info();
if(empty($system_info))
{
	echo '获取不到系统环境信息';
	exit;
}

//判断php版本
if($system_info[1][1] < 5.2)
{
	$tag = false;
}

//是否支持MySQL
if($system_info[2][1] == '不支持')
{
	$tag = false;
}

//是否支持GD
if(!has_supported_gd())
{
	$tag = false;
}
else
{
	//是否支持JPEG图片
	if($system_info[4][1] == '不支持')
	{
		$tag = false;
	}
}


//目录名,路径相对于根目录
$checking_dirs = array(
	'data',
	'log',
	'upfiles'
);

//检测目录权限
$dir_checking = check_dirs_priv($checking_dirs);

if(empty($dir_checking))
{
	echo '无法检测目录权限';
	exit;
}

if($dir_checking['result'] == 'ERROR')
{
	$tag = false;
}

session_start();
$_SESSION['check'] = $tag;

include_once "tpl/index_web.php";
?>