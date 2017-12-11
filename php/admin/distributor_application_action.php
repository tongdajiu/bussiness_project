<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel :: checkOpen('distributorQRCodeApply');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
$act = !isset ($_REQUEST['act']) ? "list" : $_REQUEST['act'];
$page      =! isset($_GET['page'])         ?  1 : intval($_GET['page']);
$status    =! isset($_GET['status'])       ? -1 :  intval($_GET['status']);
$userid    =! isset($_GET['userid'])       ? 0 :  intval($_GET['userid']);

$DistributorApplicationModel =D('DistributorApplication');


switch ($act) {
	/**************审核页面*************/
	case 'edit' :
		$id = isset ($_REQUEST['id']) ? $_REQUEST['id'] : '';

		$arrWhere = array (
			'id' => $id
		);
		$info = $DistributorApplicationModel->get($arrWhere);
		include "tpl/distributor_application_edit.php";
		break;

		/**************审核处理**************/
	case 'edit_save' :

		$id = isset ($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$status = isset ($_REQUEST['status']) ? $_REQUEST['status'] : '';
		$userid = isset ($_REQUEST['userid']) ? $_REQUEST['userid'] : '';

		$arrWhere = array (
			'id' => $id
		);

		$data = array (
			'status' => $status,
		'update_time' => time());

		$editinfo = $DistributorApplicationModel->get($arrWhere);

		if ($DistributorApplicationModel->modify($data, $arrWhere) === false) {
			redirect('?module=distributor_application_action', '操作失败！');
			return;
		}

		if ($status == 1) {
			global $site;
			$minfo = $db->get_var("select minfo from user where type=1024 and id=" . $userid);
			$data = $site . 'shop.php?minfo=' . $minfo;
			get_qrcode($data, AGENT_QRCODE_DIR, $userid . '.png');
		}
		if ($status == 1) {
			$state = '已审核';
		}
		elseif ($status == 0) {
			$state = '未审核';
		}
		createAdminLog($db, 7, "审核【" . $editinfo->name . "】的二维码申请信息,编号id:" . $id . '更新状态为' . $state, '更新状态为' . $state);
		redirect('?module=distributor_application_action', '操作成功！！');
		break;

		/**************删除处理**********/
	case 'del' :

		$id = isset ($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$arrWhere = array (
			'id' => $id
		);
		$delinfo = $DistributorApplicationModel->get($arrWhere);
		if ($DistributorApplicationModel->delete($arrWhere) === false) {
			redirect('?module=distributor_application_action', '操作失败！');
		}
		createAdminLog($db, 7, "删除【" . $delinfo->name . "】的二维码申请信息,编号id:" . $id);
		redirect('?module=distributor_application_action', '操作成功！');

		break;

	default :
/**********分页**********/
		$distributorList = $DistributorApplicationModel->gets('',array('id'=>'desc'),$page, $perpage = 20);
		$url = "?module=distributor_application_action";
			if ($status != '')
			{
				$url = $url . "&status=" . $status;
			}
			$url = $url . "&page=";
		include "tpl/distributor_application_web.php";
}
?>
