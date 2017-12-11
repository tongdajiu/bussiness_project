<?php
define('HN1', true);
require_once ('global.php');
VersionModel::checkOpen('distributorWithdrawDeposit');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
include "common.php"; //设置只能用微信窗口打开
require_once MODEL_DIR . '/MoneyModel.class.php';

$act = !isset ($_REQUEST['act']) ? '' : $_REQUEST['act'];
$DistributorMoneyModel =M('distributor_money');
$UserModel =D('User');

$user = $_SESSION['userInfo'];
if ($user != null) {
	$userid = $user->id;
} else {
	redirect("login.php?dir=distributor_money");
	return;
}

switch($act)
{
	/*********添加页面*********/
	case 'add':
    include TEMPLATE_DIR.'/distributor_money_web.php';
    break;

    /*********添加页面处理*********/
	case 'add_save':
	$money_log = new MoneyModel($db);
	$userid         = $_SESSION['userInfo']->id;
	$name           = $_SESSION['userInfo']->name;
	$mobile         = $_REQUEST['mobile']         == null ? '' : $_REQUEST['mobile'];
	$id_number      = $_REQUEST['id_number']      == null ? '' : $_REQUEST['id_number'];
	$d_money        = $_REQUEST['d_money']        == null ? '' : $_REQUEST['d_money'];
	$account_number = $_REQUEST['account_number'] == null ? '' : $_REQUEST['account_number'];
	$pay_method     = $_REQUEST['pay_method']     == null ? '' : $_REQUEST['pay_method'];

	$obj_money = $UserModel->get($arrWhere=array('id'=>$userid));
		if ($obj_money->money >= $d_money) {
			$data=array(
				'userid'			=>	$userid,
				'name'				=>	$name,
				'mobile'			=>	$mobile,
				'id_number'			=>	$id_number,
				'd_money'			=>	$d_money,
	            'add_time'			=>	time(),
	            'account_number'	=>	$account_number,
				'status'			=>	0,
				'pay_method'		=>	$pay_method
			);
			$DistributorMoneyModel->add($data);
			$c = $obj_money->money;
			$b = $d_money;
			$obj_ub = $UserModel->query("update user set `money`='" . ($c - $b) . "'where id='" . $userid . "' ",true,false,'','');
			$data = array (
				'uid'      => $userid,
			    'add_time' => time(),
                'money'    => $d_money,
                'remark'   => '',
                'type'     => 3
                );
			$money_log->addLog($data);
			redirect("distributor_money.php", "申请成功，我们会及时与您联系！");
			return;
		} else {
			redirect("distributor_money.php", "您的钱包余额不足！");
			return;
		}
	break;

/**************提现详情页面***************/
    case 'details':
    $id = !isset ($_GET['id']) ? 0 : intval($_GET['id']);
    $obj_dm =$DistributorMoneyModel->get($arrWhere=array('id'=>$id));
    include TEMPLATE_DIR.'/distributor_money_web3.php';
    break;

    default :
	/*********列表显示页面*********/
		$moneyList = $DistributorMoneyModel->getALL($arrWhere=array('userid'=>$userid),array('id'=>'desc'));
		$obj_user = $UserModel->get($arrWhere1=array('id'=>$userid));
        include TEMPLATE_DIR.'/distributor_money_web2.php';
}

?>



