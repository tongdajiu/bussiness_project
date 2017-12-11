<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('distributorWithdrawDeposit');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

$page = !isset ($_GET['page']) ? 1 : intval($_GET['page']);
$status = !isset ($_GET['status']) ? -1 : intval($_GET['status']);
$act = !isset ($_REQUEST['act']) ? "list" : $_REQUEST['act'];
$condition = !isset ($_REQUEST['condition']) ? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys = !isset ($_REQUEST['keys']) ? '' : sqlUpdateFilter($_REQUEST['keys']);

$DistributorMoneyModel = M('distributor_money');
$UserModel = D('User');

$distributorList =$DistributorMoneyModel->gets('',array('add_time'=>'desc'),$page, $perpage = 20);
$url = "?module=distributor_money_action";
if ($status != '') {
	$url = $url . "&status=" . $status;
}
$url = $url . "&page=";

switch ($act) {
	case 'edit' :
        $id = $_REQUEST['id'] == null ? '' : sqlUpdateFilter($_REQUEST['id']);
		    if($id !=''){
			$arrWhere =array(
			'id'=>$id
			);
			}
        $infoList =$DistributorMoneyModel->get($arrWhere);
		include "tpl/distributor_money_edit.php";
		break;

    case 'edit_save' :
		$id = intval($_POST['id']);
		empty($id) && redirect('?module=distributor_money_action', '参数错误');
		$status = !isset ($_REQUEST['status'])  ? '' : sqlUpdateFilter($_REQUEST['status']);
		$remark = !isset ($_REQUEST['remark'])  ? '' : $_REQUEST['remark'];
		$username = $_SESSION['myinfo']->username;
		$obj_moeny = $DistributorMoneyModel->get($arrWhere=array('id'=>$id));
		$user_moeny = $UserModel->get($arrWhere1=array('id'=>$obj_moeny->userid));

		if ($status == 2) {
			$state = '审核不通过';
		} elseif ($status == 1) {
			$state = '审核通过';
		}
		if ($status == 2) {
			$DistributorMoneyModel->modify($data=array('status'=>$status,'through_time'=>time(),'username'=>$username, 'remark'=>$remark),$arrWhere2=array('id'=>$id));       //审核失败
			$obj_ub = $UserModel->query("update user set `money`='" . ($obj_moeny->d_money + $user_moeny->money) . "' where id='" . $obj_moeny->userid . "' ",true,false,'','');   //资金解冻

			createAdminLog($db,7,"审核分销商提现信息,编号id:".$id.'更新状态为'.$state,'更新状态为'.$state);
			redirect('?module=distributor_money_action', "操作成功");
			return;
		} elseif ($status == 1) {
			$DistributorMoneyModel->modify($data=array('status'=>$status,'through_time'=>time(),'username'=>$username, 'remark'=>$remark),$arrWhere3=array('id'=>$id));  //审核成功
			createAdminLog($db,7,"审核分销商提现信息,编号id:".$id.'更新状态为'.$state,'更新状态为'.$state);
			redirect('?module=distributor_money_action', "操作成功");
			return;
		} else {
			redirect('?module=distributor_money_action', "操作失败");
			return;
		}
		break;

	case 'update_play' :
		//打款操作

			$id = $_REQUEST['id'];
			if (empty ($id)) {
				redirect('?module=distributor_money_action', "ID不能为空");
				return;
			}
			$play_type = 1;
			if ($DistributorMoneyModel->modify($data=array('play_type'=>$play_type,'play_time'=>time()),$arrWhere4=array('id'=>$id)) ){
				createAdminLog($db,7,"分销商提现信息,编号id:".$id.'更新状态为确认打款','更新状态为确认打款');
				$type = 1;
			}
			else
			{
				$type = 0;
			}
			echo $type;
	break;

	default :

		include "tpl/distributor_money_list.php";
}
?>
