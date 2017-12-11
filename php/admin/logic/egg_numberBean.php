<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('EGG_NUMBER',"egg_number");
class egg_numberBean
{
	function search($db,$page,$per,$title='')
	{
		$sql = "select a.*, b.name as names from ".EGG_NUMBER."  as a left join user as b on a.openid = b.openid where a.id > 0 ";
		if($title!=''){
				$activity_id = $db->get_var("select id from draw_activity where title='".$title."'");
				if($activity_id != null){
					$sql.=" and activity_id ='".$activity_id."'";
				}
			}
		$sql.=" order by a.id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	
	function get_results($db,$keys)
	{
		$sql = "select * from ".EGG_NUMBER;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_result_openid($db,$activity_id,$openid){
		$sql = "select * from ".EGG_NUMBER." where activity_id='".$activity_id."' and openid='".$openid."'";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".EGG_NUMBER." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function detail_number($db,$number,$activity_id){
		$sql = "select * from ".EGG_NUMBER." where number='".$number."' and activity_id='".$activity_id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".EGG_NUMBER." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$openid,$name,$activity_id,$number,$addTime,$suserid,$db)
	{
		$db->query("insert into ".EGG_NUMBER." (userid,openid,name,activity_id,number,addTime,suserid) values ('".$userid."','".$openid."','".$name."','".$activity_id."','".$number."','".$addTime."','".$suserid."')");
		return true;
	}
}
?>
