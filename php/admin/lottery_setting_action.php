<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
VersionModel::checkOpen('turntableLottery');

require_once MODEL_DIR .  '/LotterySettingModel.class.php';
require_once MODEL_DIR . '/CouponModel.class.php';
require_once MODEL_DIR . '/LotteryModel.class.php';


include_once(  LIB_DIR . '/GameModel.class.php');
$Lottery = GameFactoryModel::create('All');

$page = !isset ($_GET['page']) ? 1 : intval($_GET['page']);
$status = !isset ($_GET['status']) ? -1 : intval($_GET['status']);
$act = !isset ($_REQUEST['act']) ? "list" : $_REQUEST['act'];






switch ($act)
{
	/**********添加和修改页面*********/
	case 'add' :
		$setting_id =! isset ($_REQUEST['setting_id']) ? '' : $_REQUEST['setting_id'];
	    $id =! isset ($_REQUEST['id']) ? '' : $_REQUEST['id'];
	    $prizeList   =  $Lottery->getGamePrizeList( $id,$setting_id );
	    $CouponModel = M('Coupon',$db);
		$couponList  = $CouponModel->getAll();
	    include "tpl/lottery_setting_add.php";
	break;


	/**********添加和修改页面处理*********/
	case 'add_save' :
	    $setting_id =! isset ($_REQUEST['setting_id']) ? '' : $_REQUEST['setting_id'];
	    $id      	=! isset ($_REQUEST['id'])         ? '' : $_REQUEST['id'];
		$prize      =! isset ($_REQUEST['prize'])      ? '' : $_REQUEST['prize'];
		$number     =! isset ($_REQUEST['number'])     ? '' : $_REQUEST['number'];
		$pos        =! isset ($_REQUEST['pos'])        ? '' : $_REQUEST['pos'];
		$chance     =! isset ($_REQUEST['chance'])     ? '' : $_REQUEST['chance'];
		$prize_type =! isset ($_REQUEST['prize_type']) ? '' : $_REQUEST['prize_type'];
		$prize_val  =! isset ($_REQUEST['prize_val'])  ? '' : $_REQUEST['prize_val'];
		$arrayCount = count($prize);
		for ($i = 0; $i < $arrayCount; $i++)
		{
			if ( intval($id[$i])  == 0 )
			{
				$data =array(
		            'prize'      => $prize[$i],
					'number'     => $number[$i],
					'pos'        => $pos[$i],
		            'chance'     => $chance[$i],
					'prize_type' => $prize_type[$i],
					'prize_val'  => $prize_val[$i],
		            'setting_id' => $setting_id
			    );

			    $rs= $Lottery->addGamePrize( $data );
			}
			else
			{
				$data =array(
		            'prize'      => $prize[$i],
					'number'     => $number[$i],
					'pos'        => $pos[$i],
		            'chance'     => $chance[$i],
					'prize_type' => $prize_type[$i],
					'prize_val'  => $prize_val[$i],
		            'setting_id' => $setting_id
			    );

			    $arrWhere = array( 'id' => $id[$i] );
			    $rs= $Lottery->editGamePrize( $data,$arrWhere );
			}

		}

		createAdminLog($db,9, "活动奖品设置");
		redirect('?module=lottery_setting_action&act=add&setting_id='.$setting_id, "操作成功");
		return;

	break;

/**********删除处理*********/
	case 'del':
		$id     	=! isset ($_REQUEST['id']) ? '' : $_REQUEST['id'];
		$setting_id =! isset ($_REQUEST['setting_id']) ? '' : $_REQUEST['setting_id'];
		$rs			= $Lottery->delGamePrize( array('id'=>$id, 'setting_id'=>$setting_id) );
	break;


}

?>
