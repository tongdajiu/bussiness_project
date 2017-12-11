<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('EGG_GAME_TABLE',"egg_game");
class egg_gameBean
{
	function detail($db,$id)
	{
		$sql = "select * from ".EGG_GAME_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function deletedate($db,$id)
	{
		$db->query("delete from ".EGG_GAME_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function update($money=-1,$db,$id)
	{
		$update_values="";
		if($money>-1){
			$update_values.="money='".$money."',";
		}
		$db->query("update ".EGG_GAME_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
}
?>
