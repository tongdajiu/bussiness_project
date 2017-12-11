<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('USER_MONEY_TABLE',"user_money");
class user_moneyBean
{
	function search($db,$page,$per,$userid='',$condition='',$keys='')
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".USER_MONEY_TABLE." where id>0";
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
	$sql = "select * from ".USER_MONEY_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}

	function get_results_user($db,$userid){
		$sql = "select * from ".USER_MONEY_TABLE." where userid='".$userid."' ";
		$sql .= " order by id desc limit 10";
		return $db->get_results($sql);
	}




	function detail($db,$id)
{
		$sql = "select * from ".USER_MONEY_TABLE." where  id = {$id}";
		$obj = $db->get_row($sql);

		return $obj;
	}


	function detail_new($db,$id)
{
		$sql = "select * from ".USER_MONEY_TABLE." where  userid = {$id}";
		$obj = $db->get_row($sql);

		return $obj;
	}



//	function deletedate($db,$id)
//{
//	$db->query("delete from ".USER_MONEY_TABLE." where id in (".implode(",",$id).")");
//	return true;
//}

	function create($userid,$name,$mobile,$id_number,$money,$status,$db)
	{
		$db->query("insert into ".USER_MONEY_TABLE." (userid,name,mobile,id_number,money,add_time,status) values ('".$userid."','".$name."','".$mobile."','".$id_number."','".$money."','".time()."','".$status."')");
    return true;
	}

	function update($status=null,$through_time=null,$username=null,$db,$id)
	{
	$update_values="";
			if($status!=null){
				$update_values.="status='".$status."',";
			}
			if($through_time!=null){
				$update_values.="through_time='".$through_time."',";
			}
			if($username!=null){
				$update_values.="username='".$username."',";
			}
		$db->query("update ".USER_MONEY_TABLE." set  ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updateplay($db,$id,$play_type)
	{
		$db->query("update ".USER_MONEY_TABLE." set play_type='".($play_type)."' , play_time='". time() ."' where id=".$id);
		return true;
	}
}



?>