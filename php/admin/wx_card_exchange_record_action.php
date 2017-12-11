<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');



$WxCardExchangeRecordsModel = M('wx_card_exchange_records');
$UserModel = D('User');
$CouponModel = D('Coupon');


$page 		= !isset ($_GET['page']) ? 1 : intval($_GET['page']);
/*$type = $_GET['type'] == null ? 0 :  intval($_GET['type']);
$status = $_GET['status'] == null ? -1 :  intval($_GET['status']);*/
$userid = $_GET['userid'] == null ? 0 :  intval($_GET['userid']);
$act 		= !isset ($_REQUEST['act']) ? "list" : $_REQUEST['act'];
$condition = !isset ($_REQUEST['condition']) ? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 	= !isset ($_REQUEST['keys']) ? '' : sqlUpdateFilter($_REQUEST['keys']);



$url = "?module=wx_card_exchange_record_action";
/*	if($type!=''){
	$url = $url."&type=".$type;
	}
	if($status!=''){
	$url = $url."&status=".$status;
	}
	if($userid!=''){
	$url = $url."&userid=".$userid;
	}*/
$url = $url . "&condition=$condition&keys=$keys&page=";
switch ($act) {
	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=wx_card_exchange_record_action', "您没选中任何条目");
			return;
		}
		if ($WxCardExchangeRecordsModel->delete(array('id'=>$id))) {
			redirect('?module=wx_card_exchange_record_action', "操作成功");
			return;
		} else {
			redirect('?module=wx_card_exchange_record_action', "系统忙");
			return;
		}
		break;
	default :
		if($userid !=0){
			$arrWhere=array('userid'=>$userid);
		}
		$cardList = $WxCardExchangeRecordsModel->gets($arrWhere, array('id'=>'desc'),$page, $perpage = 20);

		include "tpl/wx_card_exchange_record_list.php";
}
?>
