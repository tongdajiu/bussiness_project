<?php
!defined('HN1') && exit('Access Denied.');
require_once MODEL_DIR . '/AdminModel.class.php';

$Admin = new AdminModel($db,'admin');
$user = $_SESSION['myinfo'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $reUrl = '?module=user_update_pass';
	$password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);
    ($password == '') && redirect($reUrl, '请输入密码');
    ($password != $repassword) && redirect($reUrl, '两次输入的密码不一致');

    ($Admin->modify(array('password'=>$Admin->getEncryptionPassword($password)), array('id'=>$user->id)) === false) && redirect($reUrl, '密码修改失败！');
    createAdminLog($db,1,"修改账号【".$_SESSION['myinfo']->username."】管理员密码,编号id:{$userid}");
    redirect($reUrl,"密码修改成功！");
}

include ("tpl/user_update_pass.php");
?>
