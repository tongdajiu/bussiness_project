<?php
	/**
	 * 	游戏模版类
	 *
	 * 	authon:Dennis
	 *  time: 2016-01-04
	 * */

	abstract class Game
	{
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
		 */
		abstract function getGameList();

		/**
		 *	获取活动信息
		 */
		abstract function getGameInfo($id='');

		/**
		 *	添加活动信息
		 */
		abstract function addGameInfo($arrParam);

		/**
		 *	更新活动信息
		 */
		abstract function editGameInfo($arrParam, $arrWhere);

		/**
		 *	删除活动信息
		 */
		abstract function delGameInfo($arrWhere);


		/*============================  奖品相关 ===============================*/
		/**
		 *	获取奖品列表
		 */
		abstract function getGamePrizeList();

		/**
		 *	获取奖品信息
		 */
		abstract function getGamePrizeInfo($id='');

		/**
		 *	添加奖品信息
		 */
		abstract function addGamePrize($arrParam);

		/**
		 *	更新奖品信息
		 */
		abstract function editGamePrize($arrParam, $arrWhere);

		/**
		 *	删除奖品信息
		 */
		abstract function delGamePrize($arrWhere);

		/*============================  参与记录相关 ===============================*/

		/**
		 *	获取参与记录列表
		 */
		abstract function getGameLogList();

		/**
		 *	获取参与记录信息
		 */
		abstract function getGameLog($id='');

		/**
		 *	添加参与记录信息
		 */
		abstract function addGameLog($arrParam);

		/**
		 *	更新参与记录信息
		 */
		abstract function editGameLog($arrParam, $arrWhere);

		/**
		 *	删除参与记录信息
		 */
		abstract function delGameLog($arrWhere);
	}


	/**
	 * 根据输入的游戏代号，实例化出相应的对象
	 *
	 */
	class GameFactoryModel
	{
		static function create($GameName)
		{
			require_once(dirname(__FILE__)."/GameAllModel.class.php");

			switch ( $GameName )
			{
				case 'Lottery':
					$GameType = 1;
					return new GameAllModel($GameType);
				break;

				case 'Egg':
					$GameType = 2;
					return new GameAllModel($GameType);
				break;

				case 'Yy':
					$GameType = 3;
					return new GameAllModel($GameType);
				break;

				default:
					return new GameAllModel();
			}
		}
	}
?>