<?php
/**
 * 用户优惠券模型
 */
class UserCouponModel extends Model{
    public function __construct($db, $table=''){
        $table = 'user_coupon';
        parent::__construct($db, $table);
    }


    /**
     * 获取优惠券的编码
     *
     * @return string;
     * */
    private function getCouponNum()
    {
		$randNum = rand( 0, 9999 );
		return sprintf( '%02d', rand( 10, 30 ) ) . time() . sprintf( '%04d', rand( 0, 9999 ) );

    }

    /**
     * 记录获得优惠券信息
     *
     * @param   int $nUserID   	  用户ID
     * @param   int $nFrom     	  获取来源
     * @param   int $nCouponID    优惠券ID
     * @return  int				  -2:优惠券不可用  -1：添加失败  $coupon_sn：返回优惠券码  -3:该用户已领取
     * */
    public function addRecord( $nUserID, $nFrom, $nCouponID )
    {
    	$arrWhere['id'] = $nCouponID;
    	$this->table = 'coupon';
    	$rs = $this->get( $arrWhere );

        if ( $rs == null )
        {
            return -1;
        }

		if ( $rs->status == 0 )
		{
			return '-2';
		}

		$this->table = 'user_coupon';

        $fUserHasConpon = $this->get( array( 'user_id'=>$nUserID, 'coupon_id'=>$nCouponID ) );

        if ( $fUserHasConpon != NULL )
        {
            return -3;
        }

		$coupon_sn = $this->getCouponNum();


		if ( $rs->vaild_type == 0 )
		{
			// 如果按优惠券生效的时间
			$arrParam = array(
				'user_id' 	 	=> $nUserID,
			  	'coupon_num' 	=> $coupon_sn,
			  	'get_time' 	 	=> time(),
			  	'from' 		 	=> $nFrom,
			  	'coupon_id'	 	=> $nCouponID,
			  	'valid_stime'	=> $rs->start_time,
			  	'valid_etime'	=> $rs->end_time
			);
		}
		else
		{
			// 按用户得到优惠券的时间
			$arrParam = array(
				'user_id' 	 	=> $nUserID,
			  	'coupon_num' 	=> $coupon_sn,
			  	'get_time' 	 	=> time(),
			  	'from' 		 	=> $nFrom,
			  	'coupon_id'	 	=> $nCouponID,
			  	'valid_stime'	=> time(),
			  	'valid_etime'	=> time() + $rs->vaild_date * 86400
			);
		}


		if ($this->add( $arrParam ) === FALSE)
		{
			return '-1';
		}

		return $coupon_sn;
    }

    /**
     * 获取指定优惠券的获取列表
     *
     * @param   int $nCouponID    优惠券ID
     * */
    public function getList( $nCouponID='' )
    {
		if ( $nCouponID != '' )
		{
			$strSQL = "SELECT `coupon_num`,`get_time`,`is_used`,`use_time`,`from`,`status`, (SELECT `name` FROM `user` WHERE `id`=user_id) AS name FROM `user_coupon` WHERE `coupon_id`={$nCouponID} ORDER BY `id` DESC";
		}
		else
		{
			$strSQL = "SELECT `coupon_num`,`get_time`,`is_used`,`use_time`,`from`,`status`, (SELECT `name` FROM `user` WHERE `id`=user_id) AS name FROM `user_coupon` ORDER BY `id` DESC";
		}

    	$rs = $this->query( $strSQL );
    	return $rs;
    }

    /**
     * 使用优惠券方法
     *
     * @param string $strCouponNum 		优惠券编号
     * @return int 			-2:优惠券已使用  -1：更新失败  1：更新成功
     */
    public function useCoupon( $strCouponNum )
    {
    	if ( ! $this->check_coupon( $strCouponNum ) )
    	{
    		return -2;
    	}

    	$arrParam = array(
    		'is_used' 	=> 1,
    		'use_time'	=> time(),
    	);

    	$arrWhere['coupon_num'] = $strCouponNum;

    	$rs = $this->modify( $arrParam, $arrWhere );

    	return ( $rs === FALSE ) ? -1 : 1;
    }

   /**
     * 检查优惠券是否可用
     *
     * @param string $strCouponNum 		优惠券编号
     * @return bool
     */
    public function checkCoupon( $strCouponNum )
    {
    	$arrWhere['coupon_num'] = $strCouponNum;
    	$rs = $this->get( $arrWhere );

		if ( $rs->is_used == 1 || $rs->status == 0 )
		{
			return false;
		}

    	if ( $rs->valid_stime > time() || time() > $rs->valid_etime  )
    	{
    		return false;
    	}

    	return true;
    }


	/**
	 * 获取指定用户的优惠券
	 *
	 * @param int $nUserID		需查询的用户ID
	 * @param integer $valid 状态null不限，1有效，-1无效
	 * */
    public function getUserCouponList($nUserID, $valid=null)
    {
    	$nUserID 		= intval($nUserID);
		$arrData 		= $this->getAll( array('user_id'=>$nUserID) );
		$this->table 	= 'coupon';

		if ( $arrData == null )
		{
			return null;
		}

		foreach( $arrData as $key=>$data )
		{
			$enable = true;

			$arrWhere['id'] = $data->coupon_id;
			$dataCoupon = $this->get( $arrWhere );

			if ( $data->is_used == 1 || $data->status == 0 )
			{
				$enable = false;
			}

	    	if ( $data->valid_stime > time() || time() > $data->valid_etime  )
	    	{
	    		$enable = false;
	    	}

			if(is_null($valid) || (($valid == 1) && $enable) || (($valid == -1) && !$enable)){
				$rs[$key] = $data;
				$rs[$key]->enable = $enable;
				$rs[$key]->name = $dataCoupon->name;
				$rs[$key]->max_use = $dataCoupon->max_use;
				$rs[$key]->discount = $dataCoupon->discount;
				$rs[$key]->used = $data->is_used;
			}
		}

		return $rs;
    }


    /**
     * 添加微信优惠券到系统优惠券
     *
     * @param string $strWxCardID 来自微信卡券号
     * @param string $strOpenID   来自微信openid
     *
     * @return  int				  -2:优惠券不可用  -1：添加失败  $coupon_sn：返回优惠券码
     *
     * */
    public function addFromWXCoupon( $strWxCardID, $strOpenID )
    {
    	$strWxCardID = 'p_Z7Ut5wCvFfqEjfsiSl_2y95Ppc';
    	$strOpenID 	 = 'oVJchs__D2mgmzOouu_8ZPvuE7D8';

    	if( $strWxCardID == "" )
    	{
    		return false;
    	}

		$this->table 	= 'coupon';
    	$couponInfo = $this->get( array('wx_card_id'=>$strWxCardID, 'status'=>1), array('id') );
    	if ( $couponInfo == NULL )
    	{
    		return false;
    	}

    	$this->table 	= 'user';
    	$userInfo = $this->get( array('openid'=>$strOpenID),array('id') );
    	if ( $userInfo == NULL )
    	{
    		return false;
    	}

    	return $this->addRecord( $userInfo->id, 99, $couponInfo->id );
    }

}