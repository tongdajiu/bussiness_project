<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once(MODEL_DIR.'/AdminModel.class.php');
require_once(dirname(__FILE__).'/inc/functions.php');

$Admin = D('Admin');

//deal parameters
$act       = !isset($_GET['action']) ? '' : strtolower(trim($_GET['action']));
$returnUrl = !isset($_GET['returnUrl']) ? 'index.php' : trim($_GET['returnUrl']);

switch($act)
{
    case 'logout':
        empty($_SESSION['myinfo']) ? createAdminLog($db,0,"非正常退出") : createAdminLog($db,0,"管理员【".$_SESSION['myinfo']->username."】正常退出");
        unset($_SESSION['myinfo']);
        break;
    default:
        !empty($_SESSION['myinfo']) && redirect('index.php');
        break;
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $reUrl = '?module=login';
    $uname = trim($_POST['uname']);
    empty($uname) && redirect($reUrl, '请填写帐号');
    $password = trim($_POST['pass']);
    empty($password) && redirect($reUrl, '请填写密码');

    $admin = $Admin->get(array('username'=>$uname));

    (empty($admin) || ($admin->password != $Admin->getEncryptionPassword($password))) && redirect($reUrl, '帐号或密码错误');

    if(!$admin->admin_type && !$admin->status){
    	redirect($reUrl, '该账号为无效账号');
    }

    $Admin->modify(array('last_login_time'=>time(), 'last_ip'=>GetIP()), array('id'=>$admin->id));
    $_SESSION['myinfo'] 		= $admin;

    createAdminLog($db,0,"管理员【".$admin->username."】登录");
    redirect($returnUrl);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理平台</title>
<style>
    html,body{margin:0;padding:0;width:100%;height:100%;}
    body{background:url(images/login_bg.jpg) no-repeat center center;background-size:cover;}
    .login{position:absolute;left:50%;top:40%;width:470px;margin-left:-235px;margin-top:-170px;background:#fff;padding:60px 0;border-radius:5px;box-shadow:0 0 2px 2px #fff;}
    .login h2{padding-bottom:20px;font-size:20px;text-align:center;color:#438eb9;}
    .login ul{margin:0 auto;padding:0;width:290px;}
    .login ul li{list-style:none;padding-bottom:20px;}
    .login ul li input{border:1px solid #ccc;border-radius:3px;width:235px;height:33px;line-height:33px;padding:0 5px;padding-left:45px;font-size:13px;color:#666;}
    #user{background:url(images/login_user.jpg) left top no-repeat;}
    #pass{background:url(images/login_pwd.jpg) left top no-repeat;}
    .login ul li button{display:block;width:290px;height:35px;margin:0 auto;line-height:35px;background:#438eb9;color:#fff;border-radius:3px;border:none;cursor:pointer;}
    .login ul li button:hover{background:#2a739d;}
    .copyright{position:absolute;bottom:0;left:0;width:100%;text-align:center;color:#fff;font-size:12px;padding-bottom:10px;}
</style>
</head>

<body>
<div class="login">
    <h2>后台管理</h2>
    <form id="login_form" action="login.php" method="post" target="_self">
	    <ul>
	        <li>
	            <input name="uname" id="user" autofocus="autofocus" value="" placeholder="请输入帐号" type="text" />
	        </li>
	        <li>
	            <input name="pass" id="pass" placeholder="请输入密码" type="password" />
	        </li>
	        <li>
	            <button name="login" type="submit" id="login_submit">登录</button>
	        </li>
	    </ul>
    </form>
</div>

<div class="copyright">版权所有©2016</div>
</body>
</html>