<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('AGENT_APPLICATION_TABLE',"agent_application");
class agent_applicationBean
{
	function search($db,$page,$per,$userid='',$condition='',$keys='')
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".AGENT_APPLICATION_TABLE." where id>0";
			if($userid>0){
				$sql.=" and userid ='".$userid."'";
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
	$sql = "select * from ".AGENT_APPLICATION_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}
	function detail($db,$id)
{
		$sql = "select * from ".AGENT_APPLICATION_TABLE." where  id = {$id}";
		$obj = $db->get_row($sql);

		return $obj;
	}


	function detail_new($db,$id)
{
		$sql = "select * from ".AGENT_APPLICATION_TABLE." where  userid = {$id}";
		$obj = $db->get_row($sql);

		return $obj;
	}



	function deletedate($db,$id)
{
	$db->query("delete from ".AGENT_APPLICATION_TABLE." where id in (".implode(",",$id).")");
	return true;
}
	function create($userid,$name,$mobile,$id_number,$email,$author_status,$db)
	{
		$db->query("insert into ".AGENT_APPLICATION_TABLE." (userid,name,mobile,id_number,email,author_status,addTime) values ('".$userid."','".$name."','".$mobile."','".$id_number."','".$email."','".$author_status."','".time()."')");

    return true;
	}
	function update($userid=null,$name=null,$mobile=null,$id_number=null,$email=null,$author_status=null,$addTime=null,$db,$id)
	{
	$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
			if($userid!=null){
				$update_values.="userid='".$userid."',";
			}
			if($name!=null){
				$update_values.="name='".$name."',";
			}
			if($mobile!=null){
				$update_values.="mobile='".$mobile."',";
			}
			if($id_number!=null){
				$update_values.="id_number='".$id_number."',";
			}
			if($email!=null){
				$update_values.="email='".$email."',";
			}
			if($author_status!=null){
				$update_values.="author_status='".$author_status."',";
			}
			if($addTime!=null){
				$update_values.="addTime='".$addTime."',";
			}
		$db->query("update ".AGENT_APPLICATION_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		//echo "update ".AGENT_APPLICATION_TABLE." set author_status='".($state)."' where id in (".implode(",",$id).")";
		$db->query("update ".AGENT_APPLICATION_TABLE." set author_status='".($state)."' where id in (".implode(",",$id).")");
		return true;
	}
}



?>
