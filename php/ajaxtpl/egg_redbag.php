<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  substr(dirname(__FILE__), 0, -7));

require_once('../wxpay/pay.php');

$pn =$_REQUEST['pn'] == null ? '0' : intval($_REQUEST['pn']);
$openid =$_REQUEST['openid'] == null ? '0' : $_REQUEST['openid'];

//判断用户是否登录
$user = $_SESSION['userInfo'];
$userid = $user->id;
if($userid<1||$user==null){
		echo "-1";//请关注茶园优品服务号后登录参与活动;
		exit();
}

//判断用户当天的抽奖记录是否存在
$sql = "select * from egg_number where userid = '".$userid."' and addTime>=".strtotime(date('Y-m-d 00:00:00',time()))." and addTime<=".strtotime(date('Y-m-d 23:59:59',time()));
$obj = $db->get_row($sql);
	if($obj!=null&&$obj->number>0){//抽奖次数3则无法再抽
		echo "-2";//"您的抽奖次数已满，期待您的好友帮您抽到奖品，感谢参与！";
		exit();
	}else{//用户抽奖次数少于3次继续抽奖
		if($obj!=null&&$obj->number>0){
			$db->query("update egg_number set number='".($obj->number+1)."',updateTime='".time()."' where userid = '".$userid."' and addTime>=".strtotime(date('Y-m-d 00:00:00',time()))." and addTime<=".strtotime(date('Y-m-d 23:59:59',time())));
		}else{
			$db->query("insert into egg_number (userid,openid,number,addTime,updateTime,prizenumber) values ('".$userid."','".$openid."','1','".time()."','".time()."','')");
			$sql = "select * from egg_number where userid = '".$userid."' and addTime>=".strtotime(date('Y-m-d 00:00:00',time()))." and addTime<=".strtotime(date('Y-m-d 23:59:59',time()));
			$obj = $db->get_row($sql);
		}
	}
	
	$packet = new Packet();
	
	$game = $db->get_row("select * from egg_game where id=1");
	$today_money = $db->get_var("select sum(price) from redbag_records where addtime>=".strtotime(date("Y-m-d 00:00:00",time()))." and addtime<=".strtotime(date("Y-m-d 23:59:59",time())));
	if(($today_money/100) < $game->money && $pn>5 && $pn<=10 && $obj->prizenumber==''){
		$prizenumber=rand(100000,900000);
		$db->query("update egg_number set prizenumber='".($obj->number.",".$prizenumber)."',updateTime='".time()."' where userid = '".$userid."' and addTime>=".strtotime(date('Y-m-d 00:00:00',time()))." and addTime<=".strtotime(date('Y-m-d 23:59:59',time())));
		//发送红包给中奖用户
		$obj_user = $db->get_row("select * from user where id=".$userid);
		$results = $packet->_route('wxgrouppacket',array('openid'=>$obj_user->openid,'price'=>500,'total_num'=>3));
		$db->query("insert into redbag_records(userid,price,addtime) values('".$userid."',500,'".time()."')");
	}else if(($today_money/100) < $game->money && $pn>10 && $pn<=15 && $obj->prizenumber==''){
		$prizenumber=rand(100000,900000);
		$db->query("update egg_number set prizenumber='".($obj->number.",".$prizenumber)."',updateTime='".time()."' where userid = '".$userid."' and addTime>=".strtotime(date('Y-m-d 00:00:00',time()))." and addTime<=".strtotime(date('Y-m-d 23:59:59',time())));
		//发送红包给中奖用户
		$obj_user = $db->get_row("select * from user where id=".$userid);
		$results = $packet->_route('wxgrouppacket',array('openid'=>$obj_user->openid,'price'=>1000,'total_num'=>8));
		$db->query("insert into redbag_records(userid,price,addtime) values('".$userid."',1000,'".time()."')");
	}else if(($today_money/100) < $game->money && $pn>20 && $pn<=22 && $obj->prizenumber==''){
		$prizenumber=rand(100000,900000);
		$db->query("update egg_number set prizenumber='".($obj->number.",".$prizenumber)."',updateTime='".time()."' where userid = '".$userid."' and addTime>=".strtotime(date('Y-m-d 00:00:00',time()))." and addTime<=".strtotime(date('Y-m-d 23:59:59',time())));
		//发送红包给中奖用户
		$obj_user = $db->get_row("select * from user where id=".$userid);
		$results = $packet->_route('wxgrouppacket',array('openid'=>$obj_user->openid,'price'=>2000,'total_num'=>15));
		$db->query("insert into redbag_records(userid,price,addtime) values('".$userid."',2000,'".time()."')");
	}


?>
