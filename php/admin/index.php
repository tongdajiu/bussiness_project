<?php
define('HN1', true);
define('BACKSTAGE', true);//标识为后台
require_once('../global.php');

$curTime = time();
define('ADMIN_INC_DIR', dirname(__FILE__).'/inc');
if(isset($_GET['module']) && $_GET['module'])
{
	//内容页面
	if(empty($_SESSION['myinfo']))
	{
		echo '<script language="javascript">top.location.href = "login.php";</script>';
		exit();
	}

	require_once(ADMIN_INC_DIR.'/functions.php');
	$module = isset($_GET['module']) ? strtolower(trim($_GET['module'])) : 'home';
	$modPage = $module.'.php';
	$user = $_SESSION['myinfo'];

	if ( ! file_exists($modPage) )							// 当文件不存在，生成404页面
	{
		redirect('index.php?module=home&act=not_found');
	}

	if($user->admin_type != 1)
	{
		if ( ! isView( explode(',', $user->rules) ))			// 判断访问性
		{
			redirect('index.php','对不起,您无访问权限！！',TRUE);
		}
	}

	$PageType = ! isset($_GET['PageType']) ? 'main' : 'json';

	include ('tpl/index_' . $PageType . '.php');
}
else
{
	//框架页面
	if(empty($_SESSION['myinfo']))
	{
		header('location:login.php');
		exit();
	}

	$weeks 		 = array(0=>'星期天', 1=>'星期一', 2=>'星期二', 3=>'星期三', 4=>'星期四', 5=>'星期五', 6=>'星期六');

	$fullModules = getAllFuncID();	// 获取所有的功能ID；

	$week 		 = date('w', $curTime);
	$today 		 = date('Y年n月j日', $curTime).' '.$weeks[$week];
	$obj 		 = $_SESSION['myinfo'];

	if ( $obj->admin_type == 1 )
	{
		$AdminMap = M('admin_map');
		$arrRules = $AdminMap->getAll('', '', 'OBJECT', '',array('id'));

		foreach( $arrRules as $rs )
		{
			$privileges[] = $rs->id;
		}
	}
	else
	{
		$privileges  = explode(",",$obj->rules);
	}

	$menuOpt 	 = "autoScroll:true,border:false,iconCls:'nav',";
	$trees 		 = array();
	foreach( $fullModules as $_cfg )
	{
		$_menus 	 = array();
		foreach ($_cfg->child as $_menu)
		{
			if ( in_array( $_menu->id, $privileges )  )			// 判断访问性
	 		{
				$_menus[] = '<li><a target="main" href="index.php?module=' . $_menu->functions . '">' . $_menu->name . '</a></li>';
			}
		}

		if ( count($_menus) > 0 )
		{
			$trees[] = "{{$menuOpt} 'title':'{$_cfg->name}', 'html':'<ul class=\"LeftNav\">" . implode('', $_menus) . "</ul>'}";
		}
	}

	$trees = implode(',', $trees);

	include ('tpl/index.php');
}
?>