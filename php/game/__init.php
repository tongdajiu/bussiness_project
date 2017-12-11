<?php
	/**
	 * 此文件只为测试调用！！无其他中那个要作用
	 * */
	include_once(dirname(__FILE__) . './GameFactoryModel.class.php');

	$Lottery = GameFactoryModel::create('Lottery');
	if ( $Lottery == null )
	{
		echo 'nothing';
	}
	else
	{
		$proArr = array( 1008 => 30, 1009 => 20, 1010 => 10, 1011 => 5, 1012 => 2, 1013 => 3 );
		echo 'U get the prize id is ' . $Lottery->drawStraws( $proArr );
	}
?>