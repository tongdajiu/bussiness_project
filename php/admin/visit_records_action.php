<?php
!defined('HN1') && exit ('Access Denied.');

$VisitRecordsModel = M('visit_records');

$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$name 		= !isset ($_REQUEST['name']) || $_REQUEST['name'] == '请输入姓名' ? '' : sqlUpdateFilter($_REQUEST['name']);
$productname = !isset ($_REQUEST['productname']) || $_REQUEST['productname'] == '请输入产品' ? '' : sqlUpdateFilter($_REQUEST['productname']);

define('nowmodule', "visit_records_action");

$url = "?module=" . nowmodule;

$sql = "select * from (select vr.*,u.name as username,(select `name` from ".T('product')." where product_id = vr.product_id) as product_name from ".T('visit_records')." as vr left join `".T('user')."` as u on u.id=vr.userid) as t where 1=1";

if (!empty($name)) 
{
	$url .= "&name={$name}";
	$sql .= " and t.username like '%{$name}%'";
}
if (!empty($productname)) 
{
	$url .= "&productname={$productname}";
	$sql .= " and t.product_name like '%{$productname}%'";
}

$url .= "&page=";
$sql .= " order by t.addtime desc,t.id desc";

$pager = $VisitRecordsModel->query($sql,false, true, $page, 40);

include "tpl/visit_records_list.php";
?>
