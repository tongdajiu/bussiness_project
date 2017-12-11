<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('INTEGRAL_PAY_TABLE',"integral_pay");
class integral_payBean
{
	function search($db,$page,$per,$userid=-1,$status=0,$type=0,$username='',$condition='',$keys='')
	{
		$sql = "select * from ".INTEGRAL_PAY_TABLE." where id>0";
			if($userid > -1){
				$sql.=" and userid = '".$userid."'";
			}
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($type>0){
				$sql.=" and type ='".$type."'";
			}
			if($username!=''){
				$users = $db->get_col("select id from user where name like '%".$username."%'");
				$id_str = implode(',',$users);
				$sql.=" and userid in(".$id_str.")";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".INTEGRAL_PAY_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".INTEGRAL_PAY_TABLE." where userid='".$userid."' limit 10";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".INTEGRAL_PAY_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".INTEGRAL_PAY_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($status,$type,$userid,$integral,$db)
	{
		$db->query("insert into ".INTEGRAL_PAY_TABLE." (status,type,userid,integral,addtime) values ('".$status."','".$type."','".$userid."','".$integral."','".time()."')");
		return true;
	}

	function update($status=-1,$type=-1,$userid=null,$integral=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($userid!=null){
			$update_values.="userid='".$userid."',";
		}
		if($integral>0){
			$update_values.="integral='".$integral."',";
		}
		$db->query("update ".INTEGRAL_PAY_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".INTEGRAL_PAY_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
