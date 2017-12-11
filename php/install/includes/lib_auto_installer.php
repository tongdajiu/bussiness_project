<?php
/**
 * 安装模块函数库
 *
 * $Author: JN $
 * $Time: 2016-1-5 09:40:04$
 */

if (!defined('HN1'))
{
	die('Hacking attempt');
}

/**
 * Url
 *
 * @param string $url
 */
function redirect($url = '', $msg = '') {
	if($url == '')
		$url = 'index.php';
		$strs = '<script type="text/javascript">location.href="' . $url . '";</script>';
		if($msg != '')
			$strs = '<script type="text/javascript">alert("' . $msg . '");location.href="' . $url . '";</script>';
			echo $strs;
			exit();
}
/**
 * 获得服务器上的 GD 版本
 *
 * @access      public
 * @return      int         可能的值为0，1，2
 */
function gd_version()
{
	static $version = -1;

	if ($version >= 0)
	{
		return $version;
	}

	if (!extension_loaded('gd'))
	{
		$version = 0;
	}
	else
	{
		// 尝试使用gd_info函数
		if (PHP_VERSION >= '4.3')
		{
			if (function_exists('gd_info'))
			{
				$ver_info = gd_info();
				preg_match('/\d/', $ver_info['GD Version'], $match);
				$version = $match[0];
			}
			else
			{
				if (function_exists('imagecreatetruecolor'))
				{
					$version = 2;
				}
				elseif (function_exists('imagecreate'))
				{
					$version = 1;
				}
			}
		}
		else
		{
			if (preg_match('/phpinfo/', ini_get('disable_functions')))
			{
				/* 如果phpinfo被禁用，无法确定gd版本 */
				$version = 1;
			}
			else
			{
				// 使用phpinfo函数
				ob_start();
				phpinfo(8);
				$info = ob_get_contents();
				ob_end_clean();
				$info = stristr($info, 'gd version');
				preg_match('/\d/', $info, $match);
				$version = $match[0];
			}
		}
	}

	return $version;
}

/**
 * 是否支持GD
 *
 * @access  public
 * @return  boolean     成功返回true，失败返回false
 */
function has_supported_gd()
{
    return gd_version() === 0 ? false : true;
}


/**
 * 获得系统的信息
 *
 * @access  public
 * @return  array     系统各项信息组成的数组
 */
function get_system_info()
{
   
    $system_info = array();

    /* 检查系统基本参数 */
    $system_info[] = array('操作系统', PHP_OS);
    $system_info[] = array('PHP 版本', PHP_VERSION);

    /* 检查MYSQL支持情况 */
    $mysql_enabled = function_exists('mysql_connect') ? '支持' : '不支持';
    $system_info[] = array('是否支持MySQL', $mysql_enabled);

    /* 检查图片处理函数库 */
    $gd_ver = gd_version();
    $gd_ver = empty($gd_ver) ? '不支持' : $gd_ver;
    if ($gd_ver > 0)
    {
        if (PHP_VERSION >= '4.3' && function_exists('gd_info'))
        {
            $gd_info = gd_info();
            $jpeg_enabled = @($gd_info['JPEG Support']        === true) ? '支持' : '不支持';
            $gif_enabled  = ($gd_info['GIF Create Support'] === true) ? '支持' : '不支持';
            $png_enabled  = ($gd_info['PNG Support']        === true) ? '支持' : '不支持';
        }
        else
        {
            if (function_exists('imagetypes'))
            {
                $jpeg_enabled = ((imagetypes() & IMG_JPG) > 0) ? '支持' : '不支持';
                $gif_enabled  = ((imagetypes() & IMG_GIF) > 0) ? '支持' : '不支持';
                $png_enabled  = ((imagetypes() & IMG_PNG) > 0) ? '支持' : '不支持';
            }
            else
            {
                $jpeg_enabled = '不支持';
                $gif_enabled  = '不支持';
                $png_enabled  = '不支持';
            }
        }
    }
    else
    {
        $jpeg_enabled = '不支持';
        $gif_enabled  = '不支持';
        $png_enabled  = '不支持';
    }
    $system_info[] = array('GD 版本', $gd_ver);
    $system_info[] = array('是否支持 JPEG', $jpeg_enabled);
    $system_info[] = array('是否支持 GIF',  $gif_enabled);
    $system_info[] = array('是否支持 PNG',  $png_enabled);

    /* 服务器是否安全模式开启 */
    $safe_mode = ini_get('safe_mode') == '1' ? '开启' : '关闭';
    $system_info[] = array('服务器是否开启安全模式', $safe_mode);

    return $system_info;
}


/**
 * 检查目录的读写权限
 *
 * @access  public
 * @param   array     $checking_dirs     目录列表
 * @return  array     检查后的消息数组，
 *    成功格式形如array('result' => 'OK', 'detail' => array(array($dir, $_LANG['can_write']), array(), ...))
 *    失败格式形如array('result' => 'ERROR', 'd etail' => array(array($dir, $_LANG['cannt_write']), array(), ...))
 */
function check_dirs_priv($checking_dirs)
{
	$msgs = array('result' => 'OK', 'detail' => array());

	foreach ($checking_dirs AS $dir)
	{
		if (!file_exists(ROOT_PATH . $dir))
		{
			$msgs['result'] = 'ERROR';
			$msgs['detail'][] = array($dir, '目录不存在');
			continue;
		}

		if (file_mode_info(ROOT_PATH . $dir) < 2)
		{
			$msgs['result'] = 'ERROR';
			$msgs['detail'][] = array($dir, '不可写');
		}
		else
		{
			$msgs['detail'][] = array($dir, '可写');
		}
	}

	return $msgs;
}
/**
 * 文件或目录权限检查函数
 *
 * @access          public
 * @param           string  $file_path   文件路径
 * @param           bool    $rename_prv  是否在检查修改权限时检查执行rename()函数的权限
 *
 * @return          int     返回值的取值范围为{0 <= x <= 15}，每个值表示的含义可由四位二进制数组合推出。
 *                          返回值在二进制计数法中，四位由高到低分别代表
 *                          可执行rename()函数权限、可对文件追加内容权限、可写入文件权限、可读取文件权限。
 */
function file_mode_info($file_path)
{
	/* 如果不存在，则不可读、不可写、不可改 */
	if (!file_exists($file_path))
	{
		return false;
	}

	$mark = 0;

	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
	{
		/* 测试文件 */
		$test_file = $file_path . '/cf_test.txt';

		/* 如果是目录 */
		if (is_dir($file_path))
		{
			/* 检查目录是否可读 */
			$dir = @opendir($file_path);
			if ($dir === false)
			{
				return $mark; //如果目录打开失败，直接返回目录不可修改、不可写、不可读
			}
			if (@readdir($dir) !== false)
			{
				$mark ^= 1; //目录可读 001，目录不可读 000
			}
			@closedir($dir);

			/* 检查目录是否可写 */
			$fp = @fopen($test_file, 'wb');
			if ($fp === false)
			{
				return $mark; //如果目录中的文件创建失败，返回不可写。
			}
			if (@fwrite($fp, 'directory access testing.') !== false)
			{
				$mark ^= 2; //目录可写可读011，目录可写不可读 010
			}
			@fclose($fp);

			@unlink($test_file);

			/* 检查目录是否可修改 */
			$fp = @fopen($test_file, 'ab+');
			if ($fp === false)
			{
				return $mark;
			}
			if (@fwrite($fp, "modify test.\r\n") !== false)
			{
				$mark ^= 4;
			}
			@fclose($fp);

			/* 检查目录下是否有执行rename()函数的权限 */
			if (@rename($test_file, $test_file) !== false)
			{
				$mark ^= 8;
			}
			@unlink($test_file);
		}
		/* 如果是文件 */
		elseif (is_file($file_path))
		{
			/* 以读方式打开 */
			$fp = @fopen($file_path, 'rb');
			if ($fp)
			{
				$mark ^= 1; //可读 001
			}
			@fclose($fp);

			/* 试着修改文件 */
			$fp = @fopen($file_path, 'ab+');
			if ($fp && @fwrite($fp, '') !== false)
			{
				$mark ^= 6; //可修改可写可读 111，不可修改可写可读011...
			}
			@fclose($fp);

			/* 检查目录下是否有执行rename()函数的权限 */
			if (@rename($test_file, $test_file) !== false)
			{
				$mark ^= 8;
			}
		}
	}
	else
	{
		if (@is_readable($file_path))
		{
			$mark ^= 1;
		}

		if (@is_writable($file_path))
		{
			$mark ^= 14;
		}
	}

	return $mark;
}
/**
 * 获得数据库列表
 *
 * @access  public
 * @param   string      $db_host        主机
 * @param   string      $db_port        端口号
 * @param   string      $db_user        用户名
 * @param   string      $db_pass        密码
 * @return  mixed       成功返回数据库列表组成的数组，失败返回false
 */
function get_db_list($db_host, $db_port, $db_user, $db_pass)
{
	$databases = array();
	$filter_dbs = array('information_schema', 'mysql');
	$db_host = construct_db_host($db_host, $db_port);
	$conn = @mysql_connect($db_host, $db_user, $db_pass);

	if ($conn === false)
	{
		echo '连接数据库失败,请检查您输入的数据库帐号是否正确。';
		exit;
	}
	keep_right_conn($conn);

	$result = mysql_query('SHOW DATABASES', $conn);
	if ($result !== false)
	{
		while (($row = mysql_fetch_assoc($result)) !== false)
		{
			if (in_array($row['Database'], $filter_dbs))
			{
				continue;
			}
			$databases[] = $row['Database'];
		}
	}
	else
	{
		echo '查询数据库失败，请检查您输入的数据库帐号是否正确。';
		exit;
	}
	@mysql_close($conn);

	return $databases;
}
/**
 * 把host、port重组成指定的串
 *
 * @access  public
 * @param   string      $db_host        主机
 * @param   string      $db_port        端口号
 * @return  string      host、port重组后的串，形如host:port
 */
function construct_db_host($db_host, $db_port)
{
	return $db_host . ':' . $db_port;
}
/**
 * 保证进行正确的数据库连接（如字符集设置）
 *
 * @access  public
 * @param   string      $conn                      数据库连接
 * @param   string      $mysql_version        mysql版本号
 * @param   string      $db_charset        	数据库字符编码
 * @return  void
 */
function keep_right_conn($conn, $mysql_version='',$db_charset = 'utf8')
{
	if ($mysql_version === '')
	{
		$mysql_version = mysql_get_server_info($conn);
	}

	if ($mysql_version >= '4.1')
	{
		mysql_query('SET character_set_connection=' . $db_charset . ', character_set_results=' . $db_charset . ', character_set_client=binary', $conn);

		if ($mysql_version > '5.0.1')
		{
			mysql_query("SET sql_mode=''", $conn);
		}
	}
}
/**
 * 创建数据库配置文件
 *
 * @access  public
 * @param   string      $db_host        主机
 * @param   string      $db_port        端口号
 * @param   string      $db_user        用户名
 * @param   string      $db_pass        密码
 * @param   string      $db_name        数据库名
 * @return  integer     成功返回1，失败返回负数
 */
function create_dbConfig_file($db_host, $db_port, $db_user, $db_pass, $db_name)
{

	$db_host = construct_db_host($db_host, $db_port);

	
	/***************创建数据库配置文件******************/
	$content = '<?' ."php\n";
	$content .= "// database host\n";
	$content .= "\$dbCfg['host'] = '$db_host';\n\n";
	$content .= "// database name\n";
	$content .= "\$dbCfg['name']  = '$db_name';\n\n";
	$content .= "// database username\n";
	$content .= "\$dbCfg['user']   = '$db_user';\n\n";
	$content .= "// database password\n";
	$content .= "\$dbCfg['password'] = '$db_pass';\n\n";
	$content .= "\$dbCfg['prefix'] = '';\n\n";
	$content .= "\$dbCfg['charset'] = 'utf8';\n\n";
	$content .= '?>';

	$fp = @fopen(ROOT_PATH . 'data/dbConfig.php', 'wb+');
	if (!$fp)
	{		
		return -1;
	}
	if (!@fwrite($fp, trim($content)))
	{		
		return -2;
	}
	@fclose($fp);

	return 1;
}


/**
 * 创建网站配置文件
 *
 * @access  public
 * @param   string      $appid        微信appid
 * @param   string      $appsecret    微信appsecret
 * @param   string      $token        微信token
 * @param   string      $site_url     站点地址
 * @param   string      $site_name    站点名称
 * @return  integer     成功返回1，失败返回负数
 */
function create_webConfig_file($appid,$appsecret,$token,$site_url,$site_name)
{
	/***************创建网站配置文件******************/
	$str = '<?' ."php\n";
	$str .= "return array(\n";
	$str .= "\t'token' => '".$token."',\n";	
	$str .= "\t'appid' => '".$appid."',\n";	
	$str .= "\t'logo' => '',\n";
	$str .= "\t'contact' => '',\n";
	$str .= "\t'appsecret' => '".$appsecret."',\n";
	$str .= "\t'encodingaeskey' => '',\n";
	$str .= "\t'site_name' => '".$site_name."',\n";
	$str .= "\t'statistics_link' => '',\n";
	$str .= "\t'distribution_rebate' => '20#10#5',\n";
	$str .= "\t'site_url' => '".$site_url."',\n";
	$str .= "\t'skin' => 'default',\n";
	$str .= "\t'wx_pay_mchid' => '',\n";
	$str .= "\t'site_desc' => '',\n";
	$str .= "\t'weixin_follow_link' => '',\n";
	$str .= "\t'wx_pay_key' => '',\n";
	$str .= "\t'wx_pay_dir' => './wxpay/',\n";
	$str .= "\t'express_code_id' => '',\n";
	$str .= "\t'baidu_map_keys' => '',\n";
	$str .= "\t'logistics_interface' => 'kuaidi',\n";
	$str .= ")\n?>";
	
	$webFp = @fopen(ROOT_PATH . 'data/setting.php', 'wb+');
	
	if (!$webFp)
	{
		return -1;
	}
	if (!@fwrite($webFp, trim($str)))
	{
		return -2;
	}	
	
	@fclose($webFp);
	
	return 1;
}


/**
 * 创建指定名字的数据库
 *
 * @access  public
 * @param   string      $db_host        主机
 * @param   string      $db_port        端口号
 * @param   string      $db_user        用户名
 * @param   string      $db_pass        密码
 * @param   string      $db_name        数据库名
 * @param   string      $db_charset        数据库字符编码
 * @return  integer     成功返回1，失败返回负数
 */
function create_database($db_host, $db_port, $db_user, $db_pass, $db_name,$db_charset = 'utf8')
{

	$db_host = construct_db_host($db_host, $db_port);
	$conn = @mysql_connect($db_host, $db_user, $db_pass);
	
	if ($conn === false)
	{
		return -1;
	}

	$mysql_version = mysql_get_server_info($conn);
	keep_right_conn($conn, $mysql_version);
	if (mysql_select_db($db_name, $conn) === false)
	{
		$sql = $mysql_version >= '4.1' ? "CREATE DATABASE $db_name DEFAULT CHARACTER SET " . $db_charset : "CREATE DATABASE $db_name";
		if (mysql_query($sql, $conn) === false)
		{
			return -2;
		}
	}
	@mysql_close($conn);

	return 1;
}

/**
 * 安装数据
 *
 * @access  public
 * @param  	string		
 * @return  boolean       成功返回true，失败返回false
 */
function install_data($db_host, $db_port, $db_user, $db_pass, $db_name,$db_charset = 'utf8')
{
	
	//读取出所有行
	$lines=file(ROOT_PATH . "install/data/data.sql");
	
	if(empty($lines))
	{
		return false;
	}
	
	$sqlstr="";
	foreach($lines as $line){
		$line=trim($line);
		if($line!=""){
			if(!($line{0}=="-" || $line{0}.$line{1}=="--")){
				$sqlstr.=$line;
			}
		}
	}
	$sqlstr=rtrim($sqlstr,";");
	$sqls=explode(";",$sqlstr);
	
	
	
	$db_host = construct_db_host($db_host, $db_port);

	$conn = @mysql_connect($db_host, $db_user, $db_pass);

	mysql_set_charset('utf8', $conn);
	if ($conn === false)
	{
		return false;
	}
	
	$mysql_version = mysql_get_server_info($conn);
	keep_right_conn($conn, $mysql_version);
	mysql_select_db($db_name, $conn);
	
	
	foreach($sqls as $sql)
	{
		mysql_query($sql);
	}
	
	@mysql_close($conn);
	
	return true;
}
/**
 * 安装完成后的一些善后处理
 *
 * @access  public
 * @return  boolean     成功返回true，失败返回false
 */
function deal_aftermath()
{
	/* 写入安装锁定文件 */
	$fp1 = @fopen(ROOT_PATH . 'data/install.lock', 'wb+');
	
	if (!$fp1)
	{
		return false;
	}
	if (!@fwrite($fp1,"TRADE SHOP INSTALLED"))
	{
		return false;
	}	
	
	@fclose($fp1);
	
	$fp2 = @fopen(ROOT_PATH . 'install/install.lock', 'wb+');
	
	if (!$fp2)
	{
		return false;
	}
	if (!@fwrite($fp2,"TRADE SHOP INSTALLED"))
	{
		return false;
	}	
	
	@fclose($fp2);

	return true;
}
?>