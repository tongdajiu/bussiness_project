<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

$cart_id = $_GET['card_id'] == null ? '0' : $_GET['card_id'];
$act = $_GET['act'] == null ? 'list' : $_GET['act'];

//$result = get_card_info($card_id);
//$info = $result['card']['cash']['base_info'];


//switch($act)
//{
//case 'get_qrcode_to_card':
//get_qrcode_to_card();
//break;
//case 'modify_card_stock':
//get_qrcode_to_card();
//break;
//}
if($act == 'get_qrcode_to_card'){
	get_qrcode_to_card();
}
function get_qrcode_to_card(){
	$cart_id = $_GET['card_id'] == null ? '0' : $_GET['card_id'];
	$qrcode = get_card_qrcode($cart_id);
	$ticket = $qrcode['ticket'];
	$url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket ";
	echo "<img src='$url'/>";
}

?>
