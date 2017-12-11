<?php
	/**
	 * 根据输入的游戏代号，实例化出相应的对象
	 *
	 */
	require_once(dirname(__FILE__) .'/GameModel.class.php');

	class GameFactoryModel
	{
		static function create($GameName)
		{
			require_once(dirname(__FILE__)."/{$GameName}GameModel.class.php");

			switch ( $GameName )
			{
				case 'Lottery':
					return new LotteryGameModel();
				break;

				case 'Yy':
					return new YyGameModel();
				break;

				case 'Egg':
					return new EggGameModel();
				break;

				default:
					return NULL;
			}
		}
	}
?>