<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('REDBAG_PRIZE',"redbag_prize");
class redbag_prizeBean
{
	function search($db,$page,$per,$title='',$condition='',$keys='',$activity_id=0,$prize=-1)
	{
		$sql = "select * from ".REDBAG_PRIZE." where id > 0 ";
		if($activity_id>0){
			$sql.=" and activity_id='".$activity_id."'";
		}
     if($prize>-1){
		$sql.=" and prize = '".$prize."'";
	}
	if($condition=="username"){
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
		$sql = "select * from ".REDBAG_PRIZE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_result_openid($db,$activity_id,$openid){
		$sql = "select * from ".REDBAG_PRIZE." where activity_id='".$activity_id."' and openid='".$openid."'";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".REDBAG_PRIZE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function detail_newest($db,$userid){
		$sql = "select * from ".REDBAG_PRIZE." where userid = '".$userid."' order by id desc limit 1";
		return $db->get_results($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".REDBAG_PRIZE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$openid,$name,$activity_id,$prize,$addTime,$suserid,$db)
	{
		$db->query("insert into ".REDBAG_PRIZE." (userid,openid,name,activity_id,prize,addTime,suserid) values ('".$userid."','".$openid."','".$name."','".$activity_id."','".$prize."','".$addTime."','".$suserid."')");
		return true;
	}
}
?>
