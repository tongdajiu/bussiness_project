<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('integralUseRecord');

$IntegralPayModel = D('IntegralPay');

$page 		= !isset ($_GET['page']) ? 1 : intval($_GET['page']);
$username 	= !isset ($_GET['username']) || $_GET['username'] == '请输入用户名' ? "" : $_GET['username'];

define('nowmodule', "integral_pay_action");
$url = "?module=" . nowmodule;

$sql = "select ip.*,u.name as username from ".T('integral_pay')." as ip left join `".T('user')."` as u on u.id=ip.userid where 1=1";

if ($username != '') 
{
	$sql .= " and u.`name` like '%{$username}%'";	
	$url .= "&username={$username}";
}
$sql .= " order by ip.addtime desc,ip.id desc";
$url .= "&page=";

$pager = $IntegralPayModel->query($sql,false, true, $page, 40);

include "tpl/integral_pay_list.php";
	
?>