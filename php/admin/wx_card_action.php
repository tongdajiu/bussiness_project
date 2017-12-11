<?php
!defined('HN1') && exit ('Access Denied.');
require_once ('../global.php');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
require_once SCRIPT_ROOT . 'logic/wx_cardBean.php';

$act = !isset ($_REQUEST['act']) ? "list" : $_REQUEST['act'];

define('nowmodule', "wx_card_action");

$wxcb = new wx_cardBean();

switch ($act) {
	case 'post' :
		post($db);
		break;
	case 'edit' :
		edit($db);
		break;
	default :
		$card_list = get_card_list();
		if(is_array($card_list)){
		foreach ($card_list['card_id_list'] as $row) {

			$re_wxcard = $wxcb->detail_cardid($db, $row);

			if (empty ($re_wxcard)) {

				$result = get_card_info($row);
				$wxcb->create($row, $result['card']['cash']['reduce_cost'] / 100, $db);
			}
		}
		}
		break;
}
//	function post($db)
//	{
//		$wxcb = new wx_cardBean();
//
//
//		$card_id =$_REQUEST['card_id'] == null ? '0' : sqlUpdateFilter($_REQUEST['card_id']);
//		$reduce_cost =$_REQUEST['reduce_cost'] == null ? '0' : sqlUpdateFilter($_REQUEST['reduce_cost']);
//
//		if($wxcb->create($card_id,$reduce_cost,$db))
//		{
//			redirect('?module='.nowmodule,"操作成功");
//			return;
//		}else{
//			redirect('?module='.nowmodule,"系统忙,操作失败");
//			return;
//		}
//	}

//	function edit($db)
//	{
//		$wxcb = new wx_cardBean();
//		$id=intval($_REQUEST['id']);
//		if (empty($id))
//		{
//			redirect('?module='.nowmodule,"ID不能为空");
//			return;
//		}
//		$card_id =$_REQUEST['card_id'] == null ? '0' : sqlUpdateFilter($_REQUEST['card_id']);
//		$reduce_cost =$_REQUEST['reduce_cost'] == null ? '0' : sqlUpdateFilter($_REQUEST['reduce_cost']);
//
//		if($wxcb->update($card_id,$reduce_cost,$db,$id))
//		{
//			redirect('?module='.nowmodule,"操作成功");
//			return;
//		}else{
//			redirect('?module='.nowmodule,"系统忙,操作失败");
//			return;
//		}
//	}

include "tpl/wx_card_list.php";
?>
