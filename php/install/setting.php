<?php
session_start();
$tag = isset($_SESSION['check']) ? $_SESSION['check'] : false;

if(!$tag)
{
	die('Hacking attempt');
}

define('HN1', true);
/* 取得当前系统所在的根目录 */
define('ROOT_PATH', str_replace('install/setting.php', '', str_replace('\\', '/', __FILE__)));

if (file_exists(ROOT_PATH . 'data/install.lock') || file_exists(ROOT_PATH . 'install/install.lock'))
{
	die('Hacking attempt');
}

include_once(ROOT_PATH.'install/includes/lib_auto_installer.php');



if($_POST)
{
	/**********************************数据库账号*************************************/
	$dbHost = isset($_REQUEST['db_host']) ? trim($_REQUEST['db_host']) : '';
	$db_port = isset($_REQUEST['db_port']) ? trim($_REQUEST['db_port']) : '';
	$dbUser = isset($_REQUEST['db_user']) ? trim($_REQUEST['db_user']) : '';
	$dbPass = isset($_REQUEST['db_pass']) ? $_REQUEST['db_pass']	: '';
	$dbName = isset($_REQUEST['db_name']) ? trim($_REQUEST['db_name']) : '';


	if(empty($dbHost) || empty($db_port) || empty($dbUser) || empty($dbName))
	{
		redirect("javascript:window.history.go(-1);","数据库账号信息不完整，请正确填写!");
		return;
	}
	
	
	$conn = @mysql_connect($db_host, $dbUser, $dbPass);
		
	if ($conn === false)
	{
		redirect("javascript:window.history.go(-1);","连接数据库失败,请检查您输入的数据库帐号是否正确。");
		return;
	}
	@mysql_close($conn);
	$databases  = get_db_list($dbHost, $db_port, $dbUser, $dbPass);
	
	if(in_array($dbName,$databases))
	{
		redirect("javascript:window.history.go(-1);","数据库名重复，请重新输入！");
		return;
	}	
	
	//创建数据库配置文件
	$rs = create_dbConfig_file($dbHost, $db_port, $dbUser, $dbPass, $dbName);
	if($rs == -1)
	{
		redirect("javascript:window.history.go(-1);","无法写入 data/dbConfig.php，请检查该文件是否允许写入。");
		return;
	}
	
	if($rs == -2)
	{
		redirect("javascript:window.history.go(-1);","写入数据库配置文件出错");
		return;
	}
	
	
	
	/**********************************管理员账号*************************************/
	$admin_name = isset($_REQUEST['admin_name']) ? trim($_REQUEST['admin_name']) : '';
	$admin_pass = isset($_REQUEST['admin_pass']) ? trim($_REQUEST['admin_pass']) : '';
	$admin_pwd  = isset($_REQUEST['admin_pwd']) ? trim($_REQUEST['admin_pwd']) : '';
	
	if(empty($admin_name) || empty($admin_pass) || empty($admin_pwd))
	{
		redirect("javascript:window.history.go(-1);","管理员账号信息不完整，请正确填写!");
		return;
	}
	
	if($admin_pass != $admin_pwd)
	{
		redirect("javascript:window.history.go(-1);","管理员账号的的登录密码与确认密码不相同!");
		return;
	}
	
	
	/**********************************网站信息*************************************/
	$appid 		= isset($_REQUEST['appid']) 	? trim($_REQUEST['appid']) 		: '';
	$appsecret 	= isset($_REQUEST['appsecret']) ? trim($_REQUEST['appsecret']) 	: '';
	$token 		= isset($_REQUEST['token']) 	? trim($_REQUEST['token']) 		: '';
	$site_url 	= isset($_REQUEST['site_url']) 	? trim($_REQUEST['site_url']) 	: '';
	$site_name 	= isset($_REQUEST['site_name']) ? trim($_REQUEST['site_name']) 	: '';
	
	if(empty($appid) || empty($appsecret) || empty($token) || empty($site_url) || empty($site_name))
	{
		redirect("javascript:window.history.go(-1);","网站信息不完整，请正确填写!");
		return;
	}

	//创建网站配置文件
	$rs = create_webConfig_file($appid,$appsecret,$token,$site_url,$site_name);
	
	if($rs == -1)
	{
		redirect("javascript:window.history.go(-1);","无法写入 data/setting.php，请检查该文件是否允许写入。");
		return;
	}
	
	if($rs == -2)
	{
		redirect("javascript:window.history.go(-1);","写入网站配置文件出错");
		return;
	}
	
	//创建数据库
	$rs = create_database($dbHost, $db_port, $dbUser, $dbPass, $dbName,$db_charset = 'utf8');
	
	if($rs == -1)
	{
		redirect("javascript:window.history.go(-1);","连接数据库失败，请检查您输入的数据库帐号是否正确.");
		return;
	}
	
	if($rs == -2)
	{
		redirect("javascript:window.history.go(-1);","无法创建数据库");
		return;
	}
	
	if(install_data($dbHost, $db_port, $dbUser, $dbPass, $dbName,$db_charset = 'utf8') === false)
	{
		redirect("setting.php","导入数据库表失败");
		return;
	}
	
	//添加管理员
	$conn = @mysql_connect($db_host, $dbUser, $dbPass);
	mysql_set_charset('utf8', $conn);
	mysql_query("INSERT INTO `$dbName`.`admin` (`id`, `username`, `name`, `password`, `add_time`, `last_login_time`, `privileges`, `last_ip`, `is_del`, `status`, `admin_type`) VALUES ('1', '$admin_name', 'Administrator', '".md5($admin_pass)."', '".time()."', '', '1,2,3,4,5,6,7,8,9', '', '0', '0', '1')",$conn);
	@mysql_close($conn);
	
	//添加系统设置
	$conn = @mysql_connect($db_host, $dbUser, $dbPass);
	mysql_set_charset('utf8', $conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('token', '$token')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('logo', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('contact', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('appsecret', '$appsecret')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('encodingaeskey', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('appid', '$appid')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('site_name', '$site_name')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('statistics_link', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('distribution_rebate', '20#10#5')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('site_url', '$site_url')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('skin', 'default')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('wx_pay_mchid', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('site_desc', '$site_name')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('weixin_follow_link', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('wx_pay_key', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('wx_pay_dir', './wxpay/')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('express_code_id', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('baidu_map_keys', '')",$conn);
	mysql_query("INSERT INTO `$dbName`.`setting` VALUES ('logistics_interface', '')",$conn);	
	@mysql_close($conn);
	
	
	
	if(deal_aftermath() === false)
	{
		redirect("setting.php","写入安装锁定文件失败");
		return;
	}
	
	redirect("../admin/index.php","安装成功");
	session_start();
	unset($_SESSION['check']);
	exit;
}



include_once "tpl/setting_web.php";
?>