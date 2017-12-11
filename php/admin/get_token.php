<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
define('HN1', true);
require_once('../global.php');
$token = $objWX->checkAuth($wxOption['appid'], $wxOption['appsecret']);
$grouplist=get_group($token) ;

if($grouplist['errcode']){


	$token = get_token();
}



?>
