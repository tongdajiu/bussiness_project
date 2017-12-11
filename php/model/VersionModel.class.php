<?php
/**
 * 版本相关
 */
define('VERSION_TYPE_FILE', INC_DIR.'/lock');					// 版本文件
define('VERSION_FUNCTION_CFG_FILE', INC_DIR.'/vercfg.php');		// 版本功能文件
//define('VERSION_TEST_FILE', DATA_DIR.'/version');				// 测试人员版本文件

class VersionModel extends Model
{
    private static $versionTypes = array(0=>'普通版', 1=>'标准版', 2=>'旗舰版');

    /**
     * 获取版本
     *
     * @return integer
     */
    public static function getVersion()
    {
        if(file_exists(VERSION_TYPE_FILE))
        {
            $verFlag = file_get_contents(VERSION_TYPE_FILE);
            $verFlag = in_array($verFlag, array_keys(self::$versionTypes)) ? intval($verFlag) : 0;
        }
        else
        {
            $verFlag = 0;
        }

        /**************测试人员更改版本******************/
//        $userInfo = defined('BACKSTAGE') ? $_SESSION['myinfo'] : $_SESSION['userInfo'] ;
//        if(file_exists(VERSION_TEST_FILE)){
//            $str = unserialize(file_get_contents(VERSION_TEST_FILE));
//            if($str['uid'] == $userInfo->id && $str['passTime'] >= time()){
//                $verFlag = $str['version'];
//            }
//        }
        /***********************************************/
        return $verFlag;

    }

    /**
     * 获取版本信息
     *
     * @return array(flag=>版本标识, name=>版本名称)
     */
    public static function getVersionInfo()
    {
        $version = self::getVersion();
        return array('flag'=>$version, 'name'=>self::$versionTypes[$version]);
    }

    /**
     * 判断指定操作是否有开通
     *
     * @param string $op 操作
     * @return boolean
     */
    public static function isOpen($op)
    {
        if(!file_exists(VERSION_FUNCTION_CFG_FILE)) die('系统错误');
        $cfg = include(VERSION_FUNCTION_CFG_FILE);
        if(!isset($cfg[$op])) return false;
        $version = self::getVersion();
        return in_array($version, $cfg[$op]['versions']) ? true : false;
    }

    /**
     * 检测指定操作是否有开通，没开通则提示并返回
     *
     * @param string $op 操作
     * @return void
     */
    public static function checkOpen($op)
    {
        if(!self::isOpen($op))
        {
            $refer = empty($_SERVER['HTTP_REFERER']) ? 'index.php' : $_SERVER['HTTP_REFERER'];
            (!BACKSTAGE || (BACKSTAGE && (strpos($refer, 'manage.php') === false))) && header('refresh:3;url='.$refer);
            echo '<div style="text-align:center;">当前版本不支持此操作</div>';
            exit();
        }
        return true;
    }

	/**
	 * 获取功能列表
	 *
	 * @return object/NULL
	 */
    public static function getList()
    {
    	$cfg = include(VERSION_FUNCTION_CFG_FILE);
		$version = self::getVersion();

		foreach( $cfg as $key => $val )
		{
			if ( ! in_array( $version, $val['versions'] ) )
			{
				unset( $cfg[$key] );
			}
		}

    	return $cfg;
    }


	/**
	 * 获取游戏列表
	 */
   public static function getGameList()
   {
   		$cfg 	  = include(VERSION_FUNCTION_CFG_FILE);
   		$GameList = array( $cfg['turntableLottery'], $cfg['wxShake'], $cfg['eggGame'] );

   		$version = self::getVersion();

		foreach( $GameList as $key => $val )
		{
			if ( in_array( $version, $val['versions'] ) )
			{
				$arrGameList[$key] = array( 'name' => $val['name'] );
			}
		}

		return $arrGameList;
   }
}