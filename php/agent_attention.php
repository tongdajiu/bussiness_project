<?php
define('HN1', true);
require_once('global.php');
include "common.php";	//设置只能用微信窗口打开

$UserModel = D('User');

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=agent_attention");
	return;
}

$obj_user = $UserModel->get(array('id'=>$userid));

$userList = array();
$UserChainModel = D('UserChain');

$lowUser = $UserChainModel->getDownUids($userid);

if(!empty($lowUser))
{
	$userRs = $UserModel->getAll(array('__IN__'=>array('id'=>array_keys($lowUser))), array(), ARRAY_A);
	foreach($userRs as $v){
		$tmp = array(
			'uid' => $v['id'],
			'level' => $lowUser[$v['id']]['level'],
			'info' => $v,
		);
		$userList[] = $tmp;
	}
}

include TEMPLATE_DIR.'/agent_attention_web.php';
?>