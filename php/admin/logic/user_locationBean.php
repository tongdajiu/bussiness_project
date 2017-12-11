<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('USER_LOCATION_TABLE',"user_location");
class user_locationBean
{
	function detail_openid($db,$openid){
		$sql = "select * from ".USER_LOCATION_TABLE." where openid='".$openid."' order by addTime desc limit 1";
		return $db->get_row($sql);
	}

}
?>
