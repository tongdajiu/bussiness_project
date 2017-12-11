<?php

define('HN1', true);
require_once('./global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

//include "common.php";	//设置只能用微信窗口打开

require_once SCRIPT_ROOT.'admin/logic/blessingBean.php';
require_once SCRIPT_ROOT.'admin/logic/greeting_cardsBean.php';
$ib = new blessingBean();
$gb = new greeting_cardsBean();
$mid =$_REQUEST['mid'] == null ? '' : sqlUpdateFilter($_REQUEST['mid']);
$cardid =$_REQUEST['cardid'] == null ? '0' : intval($_REQUEST['cardid']);

$obj_card = $gb->detail($db,$cardid);

if($mid!=""){
	$obj =$ib->detail_mid($db,$mid);
	include "tpl/index_blessing_web.php";
}else{
		$ib = new blessingBean();		
		$type =$_REQUEST['type'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['type']));
		$name =$_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$toname =$_REQUEST['toname'] == null ? '' : sqlUpdateFilter($_REQUEST['toname']);
		$content =$_REQUEST['content'] == null ? '' : sqlUpdateFilter($_REQUEST['content']);
		if($content!=''){
			$mid=$ib->create($type,$name,$toname,$content,$db);
			if($mid)
			{
				$obj =$ib->detail_mid($db,$mid);
				include "tpl/index_blessing_web.php";
			}else{
				redirect("/blessing.php","发布祝福失败");
				return;	
			}
		}else{
			redirect("/blessing.php","祝福内容不能为空");
		}
	
}

?>
