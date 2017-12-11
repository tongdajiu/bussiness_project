<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('integralGetRecord');

$IntegralRecordModel = D('IntegralRecord');

$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);

$condition 	= !isset ($_GET['condition']) 	? '' : sqlUpdateFilter($_GET['condition']);
$keys 		= !isset ($_GET['keys']) || $_GET['keys'] == '请输入搜索内容' ? '' : sqlUpdateFilter($_GET['keys']);

define('nowmodule', "integral_record_action");

$url = "?module=" . nowmodule;

$sql = "select * from (select ir.*,(select order_number from ".T('orders')." where order_id=ir.order_id) as order_number,u.name from ".T('integral_record')." as ir left join `".T('user')."` as u on ir.userid=u.id) as t where 1=1";

if(!empty($condition))
{
	$url .= "&condition={$condition}";
	if($condition == "username")
	{
		$sql.=" and t.name like '%$keys%'";
		$url .= "&keys={$keys}";
	}
	if($condition == "order_number")
	{
		$sql.=" and t.order_number=$keys";
		$url .= "&keys={$keys}";
		
	}
}

$sql .= " order by t.addtime desc,t.id desc";
$url .= "&page=";

$pager = $IntegralRecordModel->query($sql,false, true, $page, 40);

include "tpl/integral_record_list.php";
?>