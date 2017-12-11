<?php
!defined('HN1') && exit('Access Denied.');
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

$act = $_REQUEST['act'] == null ? "list" : $_REQUEST['act'];

define(nowmodule,"wx_user_group_action");

$wxcb = new wx_cardBean();


switch($act)
{
case 'post':
break;
default:
$card_list = get_group_list();

foreach( $card_list['card_id_list'] as $row ){

}
break;
}

include "tpl/wx_card_list.php";
?>
