<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('USER_GROUP_TABLE',"user_group");
class user_groupBean
{
	function get_results($db){
		$sql = "select * from ".USER_GROUP_TABLE." order by sorting asc,id desc";
		return $db->get_results($sql);
	}
	
	function detail($db,$id){
		$sql = "select * from ".USER_GROUP_TABLE." where id=".$id;
		return $db->get_row($sql);
	}

}
?>
