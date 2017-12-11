<?php

/**
 * 抽奖入口
 * Date: 2015/7/17
 * Time: 10:22
 */
define('HN1', true);
require_once ('./global.php');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

empty ($_SESSION['userInfo']) && redirect('/login.php?dir=lottery_new.php');

$action = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'show';
$user = $_SESSION['userInfo'];

include_once(  LIB_DIR . '/GameModel.class.php');
$Lottery = GameFactoryModel::create('All');
$eggInfo = $Lottery->getIngGameInfo(2);									// 获取正在进行中的活动信息
$settingInfo = $Lottery->getGamePrizeList( '', $eggInfo->lottery_id );		// 获取游戏的奖品信息
$arrEggImg = (object)json_decode($eggInfo->lottery_image);					// 获取游戏的图片

require_once MODEL_DIR . '/UserCouponModel.class.php';
$UserCoupon      = new UserCouponModel($db);


switch ($action)
{
	case 'check':

		if (empty ($user->openid))
		{
			ajaxResponse(false, '请先登录');
		}
		elseif ( $eggInfo == NULL )
		{
			ajaxResponse(false, '没有进行中的活动');
		}
		elseif (!$eggInfo->status)
		{
			ajaxResponse(false, '活动没有开始');
		}
		elseif ($eggInfo->start_time > time())
		{
			ajaxResponse(false, '活动尚未开始');
		}
		elseif ($eggInfo->end_time < time())
		{
			ajaxResponse(false, '活动已经结束');
		}

// 		$UserGameCount = $Lottery->getUserGameLogCount( $eggInfo->lottery_id, $user->id );

// 		if ( intval($eggInfo->number) == 0 )
// 		{
// 			$eggInfo->number = 1;
// 		}

// 		if ( $eggInfo->number <= $UserGameCount )
// 		{
// 			ajaxResponse(false, '超过抽奖次数');
// 		}

		foreach ($settingInfo as $rs)
		{
			$arraya[$rs->id] = $rs->chance;
		}

		$rid = $Lottery->drawStraws($arraya); //根据概率获取奖项id

		$PrizeList = arrPrize($settingInfo);
		$getPrizeInfo = $PrizeList[$rid];
		$prize_val 	= '';


		switch( $getPrizeInfo->prize_type )
		{
			case 1:
				$prize_val  = $UserCoupon->addRecord($user->id, 2, $getPrizeInfo->prize_val);
				$state 		= 1;
				$msg 		= '恭喜，您中得' . $getPrizeInfo->prize . '!';
			break;

			case 2:
				$state 		= 1;
				$msg 		= '转发获取抽奖机会';
			break;

			default:
				$state		= 0;
				$msg 		= '很遗憾,您没能中奖!';
		}

       $rs2 = $Lottery->changeGamePrizeNum( $getPrizeInfo->id, $getPrizeInfo->setting_id );

        if ( ! $rs2 )
        {
        	ajaxResponse( false, '再来一次！');
        	return;
        }

		addData( $user->id, $getPrizeInfo->prize, $getPrizeInfo->prize_type, $prize_val, $eggInfo->lottery_id  );
		ajaxResponse($state, $msg, $data);
	break;

	default : //界面
		include TEMPLATE_DIR.'/egg_web.php';
}





function arrPrize($settingInfo)
{
	foreach ($settingInfo as $rs)
	{
		$data[$rs->id] = $rs;
	}
	return $data;
}

// function ajaxResponse($state, $msg = '', $data = array ())
// {
// 	$arr = array (
// 		'state' => $state ? 1 : 0,
// 		'msg' => $msg,
// 		'data' => $data,

// 	);
// 	echo json_encode($arr);
// 	exit;
// }


function addData( $userid, $PrizeName,$PrizeType, $prize_val, $activity )
{
	global $Lottery;

	$arrParam = array(
       'user_id'    => $userid,
       'time'   => time(),
       'prize'      => $PrizeName,
       'prize_type' => $PrizeType,
       'prize_val'  => $prize_val,
       'activity'   => $activity
     );

	$Lottery->addGameLog($arrParam);
}

?>