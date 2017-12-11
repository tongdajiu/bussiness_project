<?php
	define('HN1', true);
	require_once('global.php');

	ini_set('display_errors', '1');

	$act = $_REQUEST['act'];

	switch ( $act )
	{
		case 'coupon':
			$uid = $_REQUEST['uid'];
			$cid = $_REQUEST['cid'];
		 	$num = $_REQUEST['num'];


			require_once MODEL_DIR.'/UserCouponModel.class.php';
			$UserCouponModel 	= new UserCouponModel( $db );

			for( $i=1; $i<=$num; $i++ )
			{
				var_dump($UserCouponModel->addRecord( $uid, '1', $cid ));		// 用户获取优惠券时执行
			}

		break;


		case 'pack':
			include_once  dirname(__FILE__) . '/wxpay/redpack/RedPackCore.php';

			$RedPackCore 	 = new RedPackCore('cash');
			$RedPackCore->setSendName( 'test send name' );
			$RedPackCore->setReOpenID( 'oqhMswGN1Od_tUDErqHbSLeMCMmE' );
			$RedPackCore->setTotalAmount( 100 );
			$RedPackCore->setWishing( 'test wishing' );
			$RedPackCore->setActName( 'test act name'  );
			$RedPackCore->setRemark( 'test remark'  );

			//header("Content-type: text/xml");
			$rs = $RedPackCore->cash_option();

			var_dump($rs);

		break;

		case 'send':
			require_once MODEL_DIR.'/RedPackModel.class.php';
			$RedPack 	 = new RedPackModel($db);
			$rid = $_REQUEST['rid'];

			$openid = array( 'oqhMswG0LOPRqIEbu8KTn8oZW5SE','oqhMswGOLmj8Z4-ULTyQw7xJ39y0' );
			$key = rand(0,1);
			$userid = ( $key == 0 ) ? 53 : 59;

			$rs = $RedPack->send($rid, $openid[$key], $userid, 3);
			var_dump($rs);

		break;

        case 'version':
            $uid = $_REQUEST['uid'];
            $v = $_REQUEST['v'];
            $time = strtotime("+1 day");
            $str = array(
                'uid' => $uid,
                'version' => $v,
                'passTime' => $time
            );
            $file = serialize($str);
            $result = file_put_contents(DATA_DIR.'/version',$file);
        break;

		case 'adminMenu'://重置后台左侧菜单
			// 添加功能表
			$arrCfg = include_once( INC_DIR.'/vercfg_func.php');
			$AdminMapModel = D('AdminMap');
			$AdminMapModel->addInfo( $arrCfg );
			$rs = $AdminMapModel->getList();
			exit;
			break;
	}

?>