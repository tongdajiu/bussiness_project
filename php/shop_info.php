<?php
define('HN1', true);
require_once ('global.php');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

include "common.php"; //设置只能用微信窗口打开

$ShopModel = M('shop');


$user = $_SESSION['userInfo'];

if ($user != null) {
	$userid = $user->id;
} else {
	redirect("login.php?dir=agent_user");
	return;
}
$act = isset ($_REQUEST['act']) ? $_REQUEST['act'] : "list";
$myself = isset ($_GET['myself']) ? true : false;


if ($myself) {
	$name = isset ($_REQUEST['name']) ? sqlUpdateFilter(trim($_REQUEST['name'])) : '';
	$old_icon = isset ($_REQUEST['old_icon']) ? trim($_REQUEST['old_icon']) : '';
	$shop_info = $ShopModel ->get(array('uid'=>$userid));

	if ($name == '') {
		redirect("shop_edit.php?myself&act=edit", "店铺名称不能为空！");
		return;
	}

	$arrList = array (
		'name' =>$name
	);

	if (is_uploaded_file($_FILES['icon']['tmp_name'])) {
		//检查图片文件是否存在
		if (file_exists("./upfiles/logo/" . $old_icon)) {
			unlink("./upfiles/logo/" . $old_icon);
		}

		$icon = uploadfile("icon", "./upfiles/logo/");
		$arrList['icon'] = $icon;
	}
	$ShopModel->modify($arrList, array ('uid' => intval($userid)));
	redirect("shop_edit.php?myself", "修改成功");
	return;

}
?>