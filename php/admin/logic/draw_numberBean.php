<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('DRAW_NUMBER',"draw_number");
class draw_numberBean
{
	function search($db,$page,$per,$title='',$condition='',$keys='',$activity_id=0)
	{
		$sql = "select * from ".DRAW_NUMBER." where id > 0 ";
//		if($title!=''){
//				$activity_id = $db->get_var("select id from draw_activity where title='".$title."'");
//				if($activity_id != null){
//					$sql.=" and activity_id ='".$activity_id."'";
//				}
//			}
		if($activity_id>0){
			$sql.=" and activity_id='".$activity_id."'";
		}
     if($condition=="number"){
		$sql.=" and number like '%".$keys."%'";
	}else if($condition=="username"){
		$users = $db->get_col("select id from user where name like '%".$keys."%'");
			$id_str = implode(',',$users);
			$sql.=" and userid in(".$id_str.")";
	}

		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".DRAW_NUMBER;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_result_openid($db,$activity_id,$openid){
		$sql = "select * from ".DRAW_NUMBER." where activity_id='".$activity_id."' and openid='".$openid."'";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".DRAW_NUMBER." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_number($db,$number,$activity_id){
		$sql = "select * from ".DRAW_NUMBER." where number='".$number."' and activity_id='".$activity_id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".DRAW_NUMBER." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$openid,$name,$activity_id,$number,$addTime,$suserid,$db)
	{
		$db->query("insert into ".DRAW_NUMBER." (userid,openid,name,activity_id,number,addTime,suserid) values ('".$userid."','".$openid."','".$name."','".$activity_id."','".$number."','".$addTime."','".$suserid."')");
		return true;
	}
}
?>
