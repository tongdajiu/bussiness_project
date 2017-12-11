<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('AGENT_INFO_TABLE',"agent_info");
class agent_infoBean
{
	function search($db,$page,$per,$userid='',$type='',$status='',$condition='',$keys='')
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".AGENT_INFO_TABLE." where id>0";
			if($userid>0){
				$sql.=" and userid ='".$userid."'";
			}
			if($type>0){
				$sql.=" and type ='".$type."'";
			}
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($condition=='name'){
				$sql.=" and name like '%".$keys."%'";
			}
			if($condition=='tel'){
				$sql.=" and mobile ='".$keys."'";
			}
			if($condition=='number'){
				$sql.=" and id_number ='".$keys."'";
			}
			if($condition=='email'){
				$sql.=" and email ='".$keys."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
function get_results($db,$keys)
{
	$sql = "select * from ".AGENT_INFO_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}
	function agent_detail($db,$uid)
{
		$sql = "select * from ".AGENT_INFO_TABLE." where userid = {$uid}";
		//echo $sql;
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail($db,$id)
{
		$sql = "select * from ".AGENT_INFO_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_new($db,$id)
{
		$sql = "select * from ".AGENT_INFO_TABLE." where userid = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}






	function deletedate($db,$id)
{
	$db->query("delete from ".AGENT_INFO_TABLE." where id in (".implode(",",$id).")");
	return true;
}
	function create($userid,$type,$name,$mobile,$email,$id_number,$pre_money,$join_money,$city,$join_time,$status,$addTime,$db)
	{
		$db->query("insert into ".AGENT_INFO_TABLE." (userid,type,name,mobile,email,id_number,pre_money,join_money,city,join_time,status,addTime) values ('".$userid."','".$type."','".$name."','".$mobile."','".$email."','".$id_number."','".$pre_money."','".$join_money."','".$city."','".$join_time."','".$status."','".$addTime."')");
return true;
	}
	function update($userid=null,$type=null,$name=null,$mobile=null,$email=null,$id_number=null,$pre_money=null,$join_money=null,$city=null,$join_time=null,$status=null,$addTime=null,$db,$id)
	{
	$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
			if($userid!=null){
				$update_values.="userid='".$userid."',";
			}
			if($type!=null){
				$update_values.="type='".$type."',";
			}
			if($name!=null){
				$update_values.="name='".$name."',";
			}
			if($mobile!=null){
				$update_values.="mobile='".$mobile."',";
			}
			if($email!=null){
				$update_values.="email='".$email."',";
			}
			if($id_number!=null){
				$update_values.="id_number='".$id_number."',";
			}
			if($pre_money!=null){
				$update_values.="pre_money='".$pre_money."',";
			}
			if($join_money!=null){
				$update_values.="join_money='".$join_money."',";
			}
			if($city!=null){
				$update_values.="city='".$city."',";
			}
			if($join_time!=null){
				$update_values.="join_time='".$join_time."',";
			}
			if($status!=null){
				$update_values.="status='".$status."',";
			}
			if($addTime!=null){
				$update_values.="addTime='".$addTime."',";
			}
		$db->query("update ".AGENT_INFO_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	function user_update($name=null,$mobile=null,$email=null,$id_number=null,$db,$userid)
	{
	$update_values="";

			if($name!=null){
				$update_values.="name='".$name."',";
			}
			if($mobile!=null){
				$update_values.="mobile='".$mobile."',";
			}
			if($email!=null){
				$update_values.="email='".$email."',";
			}
			if($id_number!=null){
				$update_values.="id_number='".$id_number."',";
			}
//         echo "update ".AGENT_INFO_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where userid=".$userid;
		$db->query("update ".AGENT_INFO_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where userid=".$userid);
		return true;
	}
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".AGENT_INFO_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
