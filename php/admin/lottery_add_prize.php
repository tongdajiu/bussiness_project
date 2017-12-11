<?php

	// 用于添加奖品设置时调用

	define('HN1', true);
	require_once('../global.php');

	require_once INC_DIR . '/functions.php';
	$CouponModel = M('Coupon',$db);
	$couponList = $CouponModel->getAll();

	include "tpl/lottery_add_prize.php";

?>