<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('AGENT_TOTAL_TABLE',"agent_total");
class agent_totalBean
{
	function search($db,$page,$per,$status='',$year=0,$month=0,$userid=0)
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".AGENT_TOTAL_TABLE." where id>0";
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($year>0){
				$sql.=" and year ='".$year."'";
			}
			if($month>0){
				$sql.=" and month ='".$month."'";
			}
			if($userid>0){
				$sql.=" and agent_userid ='".$userid."'";
			}
		$sql.=" order by id desc";
//		echo $sql;
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
function get_results($db,$keys)
{
	$sql = "select * from ".AGENT_TOTAL_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}
	function detail($db,$id)
{
		$sql = "select * from ".AGENT_TOTAL_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function total_detail($db,$uid,$year,$month)
{
		$sql = "select * from ".AGENT_TOTAL_TABLE." where agent_userid = {$uid} and year= {$year} and month = {$month}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db,$id)
{
	$db->query("delete from ".AGENT_TOTAL_TABLE." where id in (".implode(",",$id).")");
	return true;
}
	function create($agent_userid,$year,$month,$total_price,$level,$back_integral,$status,$summary_time,$addTime,$db)
	{
		$db->query("insert into ".AGENT_TOTAL_TABLE." (agent_userid,year,month,total_price,level,back_integral,status,summary_time,addTime) values ('".$agent_userid."','".$year."','".$month."','".$total_price."','".$level."','".$back_integral."','".$status."','".$summary_time."','".$addTime."')");
return true;
	}
	function update($agent_userid=null,$year=null,$month=null,$total_price=null,$level=null,$back_integral=null,$status=null,$summary_time=null,$addTime=null,$db,$id)
	{
	$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
			if($agent_userid!=null){
				$update_values.="agent_userid='".$agent_userid."',";
			}
			if($year!=null){
				$update_values.="year='".$year."',";
			}
			if($month!=null){
				$update_values.="month='".$month."',";
			}
			if($total_price!=null){
				$update_values.="total_price='".$total_price."',";
			}
			if($level!=null){
				$update_values.="level='".$level."',";
			}
			if($back_integral!=null){
				$update_values.="back_integral='".$back_integral."',";
			}
			if($status!=null){
				$update_values.="status='".$status."',";
			}
			if($summary_time!=null){
				$update_values.="summary_time='".$summary_time."',";
			}
			if($addTime!=null){
				$update_values.="addTime='".$addTime."',";
			}
		$db->query("update ".AGENT_TOTAL_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	function updatestate($db,$id,$state)
	{

		$db->query("update ".AGENT_TOTAL_TABLE." set status='".($state)."',summary_time = ".time()." where id in (".implode(",",$id).")");
		return true;
	}
}
?>
