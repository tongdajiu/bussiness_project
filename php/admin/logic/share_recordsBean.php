<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('SHARE_RECORDS_TABLE',"share_records");
class share_recordsBean
{
	function search($db,$page,$per,$condition='',$keys='',$type=0)
	{
		$sql = "select * from ".SHARE_RECORDS_TABLE." where id>0 ";

		/*	if($pin_id>0){
				$sql.=" and pin_id ='".$pin_id."'";
			}*/

			if($condition == "username"){
				$users = $db->get_col("select id from user where name like '%".$keys."%'");
				$id_str = implode(',',$users);
				$sql.=" and userid in(".$id_str.")";
			}
			/*if($condition == "pin_id"){
				if(!empty($keys)){

					$pin = $db->get_row("select * from pin where title like '%".$keys."%'");
					$sql.=" and pin_id='".$pin->id."'";
				}
			}*/
			/*if($condition == "type"){
				$sql.=" and type='".$keys."'";
			}*/
			if($type>0){
				$sql.=" and type=".$type;
			}
			/*if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($condition == "order_num"){
				$order = $db->get_row("select * from orders where order_number='".$keys."'");
				$sql.=" and order_id='".$order->order_id."'";
			}*/

		$sql.=" order by addtime desc";

		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}



	function get_results($db,$keys)
	{
		$sql = "select * from ".SHARE_RECORDS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
//统计每一种类型记录的数量
	function get_count_type($db,$type)
	{
		$sql = "select count(id) from ".SHARE_RECORDS_TABLE." where type=".$type;

		$sql.=" order by id asc";
		$obj = $db->get_var($sql);
		return $obj;
	}
	function get_resutls_type($db,$type)
	{
		$sql = "select addtime from ".SHARE_RECORDS_TABLE." where type=".$type;
		$sql.=" order by id asc";
		$list = $db->get_col($sql);
		return $list;
	}


	function detail($db,$id)
	{
		$sql = "select * from ".SHARE_RECORDS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}


	function deletedate($db,$id)
	{
		$db->query("delete from ".SHARE_RECORDS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$type,$db)
	{
		$db->query("insert into ".SHARE_RECORDS_TABLE." (userid,addtime,type) values ('".$userid."','".time()."','".$type."')");
		return true;
	}
	function update($userid=-1,$type=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>-1){
			$update_values.="user_id='".$userid."',";
		}
		if($type>-1){
			$update_values.="type='".$type."',";
		}

		$db->query("update ".SHARE_RECORDS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}


	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".SHARE_RECORDS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

}
?>
