<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once SCRIPT_ROOT.'logic/wx_cardBean.php';
define(nowmodule,"modify_card_reduce_cost_action");
$card_id = $_GET['card_id'] == null ? 0 : $_GET['card_id'];
$act = $_GET['act'] == null ? 'list' : $_GET['act'];
//$id = $_GET['id'] == null ? '0' : $_GET['id'];

$wcb = new wx_cardBean();
$re_wx_card = $wcb->detail_cardid($db,$card_id);

if($act == 'modify_reducecost_of_card'){
	modify_reduce_cost_to_card($db);
}

	function modify_reduce_cost_to_card($db)
	{


		$wxcb = new wx_cardBean();
//		$id=intval($_REQUEST['id']);
//		if (empty($id))
//		{
//			redirect('?module='.nowmodule,"ID不能为空");
//			return;
//		}
		$card_id =$_REQUEST['card_id'] == null ? '0' : sqlUpdateFilter($_REQUEST['card_id']);
		$reduce_cost =$_REQUEST['reduce_cost'] == null ? '0' : sqlUpdateFilter($_REQUEST['reduce_cost']);

		if($wxcb->update_reduce_cost($reduce_cost,$db,$card_id))
		{
			redirect('?module='.nowmodule,"操作成功");
			return;
		}else{
			redirect('?module='.nowmodule,"系统忙,操作失败");
			return;
		}
	}
include "tpl/modify_card_reduce_cost.php";
?>
