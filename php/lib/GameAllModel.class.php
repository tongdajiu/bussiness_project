<?php
	/**
	 * 	游戏模版类
	 *
	 * 	authon:Dennis
	 *  time: 2016-01-04
	 * */

	class GameAllModel
	{

		public function __construct( $GameType = '' )
		{
			$this->GameType = $GameType;
		}

		/*
		 * 用于抽奖获取用户得到的奖品
		 *
		 * @param array $proArr 奖品信息  array( '奖品ID' => '获奖概率' );
		 * @return int 奖品ID
		 *
		 * */
		static function drawStraws( $proArr )
		{
		    $result = '';
		    $nSum = array_sum( $proArr );				// 计算概率的总和

		    //概率数组循环
		    foreach ( $proArr as $key => $proCur )
		    {
		        $randNum = mt_rand( 1, $nSum );
		        if ($randNum <= $proCur)
		        {
		            $result = $key;
		            break;
		        }
		        else
		        {
		            $nSum -= $proCur;
		        }
		    }
		    unset ($proArr);
		    return $result;
		}

		/*============================  活动相关 ===============================*/

		/**
		 *	获取活动列表
		 *
		 *	@param int $page 			页数 (选填)
		 *  @param int $lottery_type 	活动类型 (选填)
		 *  @param int $isPage 			是否分页 (选填)
		 * 	@return object
		 *
		 */
		public function getGameList( $page=1, $lottery_type="", $isPage=FALSE )
		{
			$LotteryModel = M( 'Lottery' );

			$arrWhere = '';
			if ( intval($lottery_type) != 0 )
			{
				$arrWhere = array( 'lottery_type'=>$lottery_type );
			}

			if ( $isPage )
			{
				return $rs = $LotteryModel->gets( $arrWhere, '`lottery_id` DESC', $page, 20 );
			}
			else
			{
				$rs = $LotteryModel->getAll( $arrWhere, '`lottery_id` DESC' );
				return $rs['DataSet'] = $rs;
			}
		}


		/**
		 *	获取活动信息(根据活动ID查找)
		 *
		 *  @param int $id  指定活动ID (必填)
		 * 	@return object | FALSE
		 *
		 */
		public function getGameInfo( $id )
		{
			$LotteryModel = M( 'Lottery' );

			if ( intval($id) == 0  )
			{
				return FALSE;
			}

			$arrWhere = array( 'lottery_id'=>$id );
			return $rs = $LotteryModel->get( $arrWhere );
		}

		/**
		 *	获取活动信息(根据游戏类型查找)
		 *
		 *  @param int $lottery_type  指定游戏类型 (必填)
		 * 	@return object | FALSE
		 *
		 */
		public function getIngGameInfo( $lottery_type )
		{
			$LotteryModel = M( 'Lottery' );

			$arrWhere = array( 'lottery_type'=>$lottery_type, 'status'=>1 );

			return $rs = $LotteryModel->get( $arrWhere );

		}


		/**
		 *	添加活动信息
		 *
		 *  @param array $arrParam  添加活动参数 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function addGameInfo( $arrParam )
		{
			$LotteryModel = M( 'Lottery' );

			if ( $arrParam == '' )
			{
				return FALSE;
			}

			return $LotteryModel->add( $arrParam );
		}

		/**
		 *	更新活动信息
		 *
		 *  @param array $arrParam  更新活动参数 (必填)
		 *  @param array $arrWhere  条件语句 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function editGameInfo( $arrParam, $arrWhere )
		{
			$LotteryModel = M( 'Lottery' );

			if ( $arrParam == '' || $arrWhere == '' )
			{
				return FALSE;
			}

			return $LotteryModel->modify( $arrParam, $arrWhere );

		}

		/**
		 *	删除活动信息
		 *
		 *  @param array $arrWhere  条件语句 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function delGameInfo( $arrWhere )
		{
			$LotteryModel = M( 'Lottery' );

			if ( $arrWhere == '' )
			{
				return FALSE;
			}

			return $LotteryModel->delete( $arrWhere );
		}


		/*============================  奖品相关 ===============================*/

		/**
		 *	获取奖品列表
		 *
		 *	@param int $page 			页数 (选填)
		 *  @param int $nLotteryID 		活动类型 (选填)
		 *  @param int $isPage 			是否分页 (选填)
		 * 	@return object
		 *
		 */
		public function getGamePrizeList( $page=1, $nLotteryID, $isPage=FALSE )
		{
			$LotterySettingModel = M( 'Lottery_setting' );
			$arrWhere = array( 'setting_id'=>$nLotteryID );

			if ( $isPage )
			{
				return $rs = $LotterySettingModel->gets( $arrWhere, '`id` DESC', $page, 20 );

			}
			else
			{
				$rs = $LotterySettingModel->getAll( $arrWhere, '`id` DESC' );

				return $rs['DataSet'] = $rs;
			}
		}


		/**
		 *	获取奖品信息
		 *
		 *  @param int $id  指定活动ID (必填)
		 * 	@return object | FALSE
		 *
		 */
		public function getGamePrizeInfo( $nPrizeID )
		{
			$LotterySettingModel = M( 'Lottery_setting' );

			if ( intval($nPrizeID) == 0  )
			{
				return FALSE;
			}

			$arrWhere = array( 'id'=>$nPrizeID );
			return $rs = $LotterySettingModel->get( $arrWhere );
		}


		/**
		 *	添加奖品信息
		 *
		 *  @param array $arrParam  添加活动参数 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function addGamePrize( $arrParam )
		{
			$LotterySettingModel = M( 'Lottery_setting' );

			if ( $arrParam == '' )
			{
				return FALSE;
			}

			return $LotterySettingModel->add( $arrParam );
		}


		/**
		 *	更新奖品信息
		 *
		 *  @param array $arrParam  更新活动参数 (必填)
		 *  @param array $arrWhere  条件语句 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function editGamePrize( $arrParam, $arrWhere )
		{
			$LotterySettingModel = M( 'Lottery_setting' );

			if ( $arrParam == '' || $arrWhere == '' )
			{
				return FALSE;
			}

			return $LotterySettingModel->modify( $arrParam, $arrWhere );
		}


		/**
		 *	删除奖品信息
		 *
		 *  @param array $arrWhere  条件语句 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function delGamePrize( $arrWhere )
		{
			$LotterySettingModel = M( 'Lottery_setting' );

			if ( $arrWhere == '' )
			{
				return FALSE;
			}

			return $LotterySettingModel->delete( $arrWhere );
		}


		/**
		 *	改变奖品数量
		 */
		public function changeGamePrizeNum( $nPrizeID, $nSettingID )
		{
			if( intval( $nPrizeID ) == 0 || intval( $nSettingID ) == 0 )
			{
				return false;
			}

			$rs = $this->getGamePrizeInfo( $nPrizeID );

            if($rs->number ==0 )
            {
            	return false;
            }

            $arrParam = array('number'=>$rs->number - 1);
			$arrWhere = array( 'id'=>$nPrizeID, 'setting_id'=>$nSettingID );
			return $this->editGamePrize( $arrParam, $arrWhere );
		}

		/*============================  参与记录相关 ===============================*/

		/**
		 *	获取参与记录列表
		 *
		 *	@param int $page 			页数 (选填)
		 *  @param int $nLotteryID 		活动类型 (选填)
		 *  @param int $isPage 			是否分页 (选填)
		 * 	@return object
		 *
		 */
		public function getGameLogList( $page, $nLotteryID, $isPage=FALSE )
		{
			$LotteryLogModel = M( 'Lottery_log' );
			$arrWhere = array( 'activity'=>$nLotteryID );

			if ( $isPage )
			{
				return $rs = $LotteryLogModel->gets( $arrWhere, '`lottery_log_id` DESC', $page, 20 );
			}
			else
			{
				$rs = $LotteryLogModel->getAll( $arrWhere, '`lottery_log_id` DESC' );
				return $rs['DataSet'] = $rs;
			}
		}


		/**
		 *	获取指定用户指定活动的参与数
		 */
		public function getUserGameLogCount( $nLotteryID, $nUserID )
		{
			$LotteryLogModel = M( 'Lottery_log' );

			if( intval( $nLotteryID ) == 0 || intval( $nUserID ) == 0 )
			{
				return false;
			}

			$arrWhere = array( 'activity'=>$nLotteryID, 'user_id'=>$nUserID );
			return $LotteryLogModel->getCount($arrWhere);
		}

		/**
		 *	获取参与记录信息
		 *
		 *  @param int $nLogID  指定活动ID (必填)
		 * 	@return object | FALSE
		 *
		 */
		public function getGameLog( $nLogID )
		{
			$LotteryLogModel = M( 'Lottery_log' );

			if ( intval( $nLogID ) == 0  )
			{
				return FALSE;
			}

			$arrWhere = array( 'lottery_log_id'=>$nLogID );
			return $LotteryLogModel->get( $arrWhere );
		}


		/**
		 *	添加参与记录信息
		 *
		 *  @param array $arrParam  添加活动参数 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function addGameLog($arrParam)
		{
			$LotteryLogModel = M( 'Lottery_log' );

			if ( $arrParam == '' )
			{
				return FALSE;
			}

			return $LotteryLogModel->add( $arrParam );
		}


		/**
		 *	更新参与记录信息
		 *
		 *  @param array $arrParam  更新活动参数 (必填)
		 *  @param array $arrWhere  条件语句 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function editGameLog($arrParam, $arrWhere)
		{
			$LotteryLogModel = M( 'Lottery_log' );

			if ( $arrParam == '' || $arrWhere == '' )
			{
				return FALSE;
			}

			return $LotteryLogModel->modify( $arrParam, $arrWhere );
		}


		/**
		 *	删除参与记录信息
		 *
		 *  @param array $arrWhere  条件语句 (必填)
		 * 	@return int | FALSE
		 *
		 */
		public function delGameLog($arrWhere)
		{
			$LotteryLogModel = M( 'Lottery_log' );

			if ( $arrWhere == '' )
			{
				return FALSE;
			}

			return $LotteryLogModel->delete( $arrWhere );
		}



	}
?>