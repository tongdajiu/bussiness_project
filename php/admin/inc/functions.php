<?php
/**
 * 功能：添加管理员操作记录
 * @param object  	$db 		数据库链接
 * @param integer 	$type 		操作类型：0登录；
 * 										1用户管理；
 * 										2订单管理；
 * 										3产品管理；
 * 										4微信公众平台设置；
 * 										5设置管理；
 * 										6文章管理；
 * 										7分销商管理；
 * 										8门店资料管理；
 * 										9活动促销
 * @param string 	$optitle 	操作标题
 * @param string 	$opcontent 	操作内容
 * @param object 	$obj 		原数据对象
 * @param array 	$arrParam 	更新参数数据
 * @param string 	$table 		更新表名
 */
function createAdminLog($db,$type,$optitle,$opcontent = '',$obj = '',$arrParam = '',$table = '',$Escape = false)
{
	include_once(MODEL_DIR.'/AdminModel.class.php');
	$Admin = new AdminModel($db);

	if($opcontent == '' && $obj!='' && $arrParam != '' && $table != '')
	{
		$opcontent = $Admin->getOpContent($obj,$arrParam,$table);
	}

	if($Escape)
	{
		$opcontent = mysql_real_escape_string($opcontent);
	}

	$data = array(
		'aid' => $_SESSION['myinfo']->id,
		'uname' => $_SESSION['myinfo']->username,
		'name' => $_SESSION['myinfo']->name,
		'type' => $type,
		'optitle' => $optitle,
		'opcontent' => $opcontent,
		'add_time' => time()
	);

	$Admin->genOpLog($data);
}

?>