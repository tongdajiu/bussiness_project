<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
define(nowmodule,"modify_card_stock_action");
$card_id = $_GET['card_id'] == null ? 0 : $_GET['card_id'];
$act = $_GET['act'] == null ? 'list' : $_GET['act'];

if($act == 'modify_stock_of_card'){
	modify_stock_of_card();
}

	function modify_stock_of_card()
	{
		$card_id = $_REQUEST['card_id'] == null ? 0 : $_REQUEST['card_id'];
		$increase_number = $_REQUEST['increase_number'] == null ? 0 : $_REQUEST['increase_number'];
		$reduce_number = $_REQUEST['reduce_number'] == null ? 0 : $_REQUEST['reduce_number'];
		$return_content = modify_card_stock($card_id,$increase_number,$reduce_number);

	}
include "tpl/modify_card_stock.php";
?>
