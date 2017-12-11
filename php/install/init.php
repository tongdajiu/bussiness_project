<?php
if (!defined('HN1'))
{
    die('Hacking attempt');
}
error_reporting(E_ALL);

if (__FILE__ == '')
{
    die('Fatal error code: 0');
}

/* 取得当前系统所在的根目录 */
define('ROOT_PATH', str_replace('install/init.php', '', str_replace('\\', '/', __FILE__)));

if (!file_exists(ROOT_PATH . 'data/install.lock') && !file_exists(ROOT_PATH . 'install/install.lock'))
{
	header("Location: ./install/index.php\n");

	exit;
}


?>