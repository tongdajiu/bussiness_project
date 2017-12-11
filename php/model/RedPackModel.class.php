<?php
/**
 * 红包记录模型
 */

require_once dirname(dirname(__FILE__)) . "/lib/log.php";
require_once dirname(dirname(__FILE__)) . '/wxpay/redpack/RedPackCore.php';

class RedPackModel extends Model
{
	public function __construct($db, $table='')
	{
        $table = 'redpack';
        parent::__construct($db, $table);

        $logFile 		= dirname(dirname(__FILE__)) . '/log/wx/redpack_' . date('Y-d-m',time()) . '.log';
        $logHandler		= new CLogFileHandler( $logFile );
    	$this->log 		= Log::Init($logHandler, 4);
    }


    /**
     *	发送红包操作
     *
     *	@param int 		$redpack_id  红包活动信息
     *	@param string 	$openid  	 用户openid
     *	@param int 		$get_from  	 获取来源
     *	@param int 		$user_id  	 用户id
     */
    public function send( $redpack_id="", $openid="", $user_id="", $get_from=""  )
    {
		if ( intval( $redpack_id ) < 0 || $redpack_id == "" )
    	{
    		$this->log->WARN('redpack_id参数有误，传入值为【' . $redpack_id . '】');
    		return FALSE;
    	}

    	if ( intval( $get_from ) < 0 || $get_from == ""  )
    	{
			$this->log->WARN('获取来源格式有误！ get_from:【' . $get_from . '】');
    		return FALSE;
    	}

    	if ( $openid == "" || $user_id == "" || intval( $get_from ) < 0 )
    	{
			$this->log->WARN('用户信息为空，找不到要发送的用户，openid【'. $openid .'】， user_id【' . $user_id . '】');
    		return FALSE;
    	}

    	$rs = $this->_getActionInfo( $redpack_id );				// 获取活动信息

    	if ( $rs === FALSE )
    	{
    		$this->log->WARN('redpack_id的记录为空，传入值为【' . $redpack_id . '】');
			return FALSE;
    	}

    	$redpack_id 	= $rs->id;								// 获取活动id
    	$total_amout 	= $rs->total_amount;					// 获取活动对应的红包额

    	$this->log->INFO('开始发送红包....');

    	$rs = $this->_sendRedPack( 'cash', $rs, $openid );		// 调用发送红包的接口

    	if ( ! is_array( $rs ) )
    	{
    		$this->log->WARN('红包发送失败');
    		return FALSE;
    	}

    	if ( $rs['return_code'] != 'SUCCESS' || $rs['result_code'] != 'SUCCESS' )
		{
			$this->log->WARN("\n红包发送失败，原因：\nerr_code：{$rs['err_code']}\nreturn_msg：{$rs['return_msg']}\nerr_code_des：{$rs['err_code_des']}\nmch_billno:{$rs['mch_billno']}\nre_openid:{$rs['re_openid']}\ntotal_amount:{$rs['total_amount']}");
			return FALSE;
		}


		$arrData = array(
			'redpack_id' 	=> $redpack_id,
			'total_amount' 	=> $total_amout,
			'get_time' 		=> time(),
			'get_from'	 	=> $get_from,
			'user_id' 		=> $user_id,
			'user_openid' 	=> $openid
		);

		$this->_wRedPackLog( $arrData );							// 写入获取红包记录
		$this->log->INFO('红包发送成功！');

		return TRUE;
    }

     /**
     * 获取指定红包活动信息
     *
     * @param int $redpack_id  红包活动信息
     * @return bool/obj
     * */
    private function _getActionInfo( $redpack_id )
    {
    	$rs = $this->get( array( 'id'=>$redpack_id ) );

    	if ( $rs == null )
    	{
    		return FALSE;
    	}

    	return $rs;
    }


    /**
     *	调用微信发送红包接口
     *
     *	@param string $type  	发送红包类型  cash现金 group分裂
     *  @param obj $obj  	 	信息源
     *  @param string $openid  	openid
     */
    private function _sendRedPack( $type, $obj, $openid )
    {
		$RedPackCore = new RedPackCore( $type );
		$RedPackCore->setSendName( $obj->send_name );
		$RedPackCore->setReOpenID( $openid );
		$RedPackCore->setTotalAmount( $obj->total_amount );
		$RedPackCore->setWishing( $obj->wishing );
		$RedPackCore->setActName( $obj->act_name  );
		$RedPackCore->setRemark( $obj->remark );

//		return array(
//			"return_code"	=> "SUCCESS",
//			"return_msg"	=> "此IP地址不允许调用接口，如有需要请登录微信支付商户平台更改配置" ,
//			"result_code"	=> "SUCCESS" ,
//			"err_code"		=> "NO_AUTH" ,
//			"err_code_des"	=> "此IP地址不允许调用接口，如有需要请登录微信支付商户平台更改配置" ,
//			"mch_billno"	=> "1288970801201512151133168728" ,
//			"mch_id"		=> "1288970801" ,
//			"wxappid"		=> "wx94138c1f4a3126d0" ,
//			"re_openid"		=> "oqhMswGN1Od_tUDErqHbSLeMCMmE" ,
//			"total_amount"	=> "1"
//		);

		return $RedPackCore->cash_option();
    }


	/**
	 * 记录获取红包信息
	 *
	 * @param array $arrData  要添加的数据
	 */
	 private function _wRedPackLog($arrData)
	 {
		$this->setTable('redpack_logs');
		return $this->add($arrData);
	 }

}
?>