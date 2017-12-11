<?php
!defined('HN1') && exit('Access Denied.');

error_reporting(E_ALL);
error_reporting(0);
ini_set('magic_quotes_runtime', 0);
define('ROOT_DIR', dirname(__FILE__));
define('INC_DIR', ROOT_DIR . '/inc');
define('LIB_DIR', ROOT_DIR.'/lib');
define('MODEL_DIR', ROOT_DIR.'/model');
define('APP_INC', ROOT_DIR.'/inc/');
define('LOG_DIR', ROOT_DIR.'/log');
define('DATA_DIR', ROOT_DIR.'/data');
define('LOGISTIC_DIR', ROOT_DIR.'/lib/logistic');

if (!file_exists(DATA_DIR . '/install.lock') && !file_exists(ROOT_DIR . 'install/install.lock'))
{
	if(is_dir(ROOT_DIR . '/install'))
	{
		require_once(ROOT_DIR.'/install/init.php');
	}else
	{
		echo '安装目录不存在';
		exit;
	}
}

include_once(INC_DIR.'/config.php');
include_once(INC_DIR.'/ez_sql_core.php');
include_once(INC_DIR.'/ez_sql_mysql.php');
include_once(INC_DIR.'/functions.php');
include_once(LIB_DIR.'/Model.class.php');
require_once(MODEL_DIR.'/VersionModel.class.php');

define('UPLOAD_DIR', '/upfiles/');
define('PRODUCT_IMG_DIR', ROOT_DIR.UPLOAD_DIR.'product/');
define('STORE_IMG_DIR',ROOT_DIR.'/upfiles/store/');					// 上传门店图册路径
define('AGENT_QRCODE_DIR','../upfiles/shopqrcode/');
define('INTEGRAL_PRODUCT_IMG_DIR',ROOT_DIR.'/upfiles/integral/');	// 上传积分商品图片路径
define('TEMPLATE_DIR_NAME', 'tpl');									//模板目录名
define('SKIN_DIR_NAME', 'skin');									//皮肤目录名
define('ARTICLE_IMG_DIR',ROOT_DIR.'/upfiles/article/');				// 文章封面路径

$db = new ezSQL_mysql($dbCfg['user'], $dbCfg['password'], $dbCfg['name'], $dbCfg['host']);
$db->query('SET character_set_connection=' . $dbCfg['charset'] . ', character_set_results=' . $dbCfg['charset'] . ', character_set_client=binary');

header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); 						// 设置默认时区

//全站设置信息
include_once(MODEL_DIR.'/SettingModel.class.php');
$objSetting = new SettingModel($db, 'setting');

$gSetting = $objSetting->getItems();
$site_name = $gSetting['site_name'];
$site = $gSetting['site_url'];
(substr($site, -1) != '/') && $site .= '/';
define( 'WEB_SITE', $site );										// 网站地址 格式：http://www.abc.com/

//分销用户最大级别
$distributionMaxLevel = 3;

define('__RES__', '/res');
define('__IMG__', __RES__.'/images');
define('__CSS__', __RES__.'/css');
define('__JS__', __RES__.'/js');
define('__UTILS__', __RES__.'/utils');

//模板
//$gTpl = empty($gSetting['template']) ? 'new' : $gSetting['template'];
$gTpl  = 'default';
define('TEMPLATE_DIR', ROOT_DIR.'/'.TEMPLATE_DIR_NAME.'/'.$gTpl);//模板目录物理路径
define('__TEMPLATE__', $site.TEMPLATE_DIR_NAME.'/'.$gTpl);

//皮肤
$gSkin = empty($gSetting['skin']) ? 'default' : $gSetting['skin'];
define('__SKIN__', __TEMPLATE__.'/'.SKIN_DIR_NAME.'/'.$gSkin.'/');

//微信相关配置信息
$app_info = array(
    'appid' => $gSetting['appid'],
    'secret' => $gSetting['appsecret'],
    'token' => $gSetting['token'],
    'encodingaeskey' => $gSetting['encodingaeskey'],
);

//微信相关配置信息(用于微信类)
$wxOption = array(
    'appid' => $app_info['appid'],
    'appsecret' => $app_info['secret'],
    'token' => $app_info['token'],
    'encodingaeskey' => $app_info['encodingaeskey'],
);


//微信对象
include_once(LIB_DIR.'/Weixin.class.php');
include_once(LIB_DIR.'/weixin/errCode.php');
$objWX = new Weixin($wxOption);
?>