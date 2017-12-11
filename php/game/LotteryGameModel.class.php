<?php
	/**
	 * 	转盘游戏类
	 *
	 * 	authon:Dennis
	 *  time: 2016-01-04
	 * */
	class LotteryGameModel extends Game
	{
		/*============================  活动相关 ===============================*/
		/**
		 *	获取活动列表
		 */
		function getGameList(){}

		/**
		 *	获取活动信息
		 */
		function getGameInfo($id=''){}

		/**
		 *	添加活动信息
		 */
		function addGameInfo($arrParam){}

		/**
		 *	更新活动信息
		 */
		function editGameInfo($arrParam, $arrWhere){}

		/**
		 *	删除活动信息
		 */
		function delGameInfo($arrWhere){}


		/*============================  奖品相关 ===============================*/
		/**
		 *	获取奖品列表
		 */
		function getGamePrizeList(){}

		/**
		 *	获取奖品信息
		 */
		function getGamePrizeInfo($id=''){}

		/**
		 *	添加奖品信息
		 */
		function addGamePrize($arrParam){}

		/**
		 *	更新奖品信息
		 */
		function editGamePrize($arrParam, $arrWhere){}

		/**
		 *	删除奖品信息
		 */
		function delGamePrize($arrWhere){}

		/*============================  参与记录相关 ===============================*/

		/**
		 *	获取参与记录列表
		 */
		function getGameLogList(){}

		/**
		 *	获取参与记录信息
		 */
		function getGameLog($id=''){}

		/**
		 *	添加参与记录信息
		 */
		function addGameLog($arrParam){}

		/**
		 *	更新参与记录信息
		 */
		function editGameLog($arrParam, $arrWhere){}

		/**
		 *	删除参与记录信息
		 */
		function delGameLog($arrWhere){}


	}
?>