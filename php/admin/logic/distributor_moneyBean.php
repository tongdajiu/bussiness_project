<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('DISTRIBUTOR_MONEY_TABLE',"distributor_money");
class distributor_moneyBean
{
	function search($db,$page,$per,$userid='',$condition='',$keys='')
	{
		$sql = "select * from ".DISTRIBUTOR_MONEY_TABLE." where id>0";
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
	$sql = "select * from ".DISTRIBUTOR_MONEY_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}

	function get_results_user($db,$userid){
		$sql = "select * from ".DISTRIBUTOR_MONEY_TABLE." where userid='".$userid."' ";
		$sql .= " order by id desc limit 10";
		return $db->get_results($sql);
	}




	function detail($db,$id)
{
		$sql = "select * from ".DISTRIBUTOR_MONEY_TABLE." where  id = {$id}";
		$obj = $db->get_row($sql);

		return $obj;
	}


	function detail_new($db,$id)
{
		$sql = "select * from ".DISTRIBUTOR_MONEY_TABLE." where  userid = {$id}";
		$obj = $db->get_row($sql);

		return $obj;
	}

	function create($userid,$name,$mobile,$id_number,$d_money,$account_number,$status,$pay_method,$db)
	{
		$db->query("insert into ".DISTRIBUTOR_MONEY_TABLE." (userid,name,mobile,id_number,d_money,account_number,add_time,status,pay_method) values ('".$userid."','".$name."','".$mobile."','".$id_number."','".$d_money."','".$account_number."','".time()."','".$status."','".$pay_method."')");
    return true;
	}

	function update($status=null,$through_time=null,$username=null,$remark=null,$db,$id)
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
			if($remark!=null){
				$update_values.="remark='".$remark."',";
			}
		$db->query("update ".DISTRIBUTOR_MONEY_TABLE." set  ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updateplay($db,$id,$play_type)
	{
		$db->query("update ".DISTRIBUTOR_MONEY_TABLE." set play_type='".($play_type)."' , play_time='". time() ."' where id=".$id);
		return true;
	}
}



?>