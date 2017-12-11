<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PIN_RECORDS_TABLE',"pin_records");
class pin_recordsBean
{
	function search($db,$page,$per,$pin_id=0,$condition='',$keys='',$type=0)
	{
		$sql = "select * from ".PIN_RECORDS_TABLE." where id>0 ";

			if($pin_id>0){
				$sql.=" and pin_id ='".$pin_id."'";
			}

			if($condition == "username"){
				$users = $db->get_col("select id from user where name like '%".$keys."%'");
				$id_str = implode(',',$users);
				$sql.=" and userid in(".$id_str.")";
			}
			if($condition == "pin_id"){
				if(!empty($keys)){

					$pin = $db->get_row("select * from pin where title like '%".$keys."%'");
					$sql.=" and pin_id='".$pin->id."'";
				}
			}
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
		$sql = "select * from ".PIN_RECORDS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_resultsGroupByPin_id($db)
	{
		$sql = "select * from ".PIN_RECORDS_TABLE;

		$sql.=" group by pin_id asc";
		$list = $db->get_results($sql);
		return $list;
	}


	function detail($db,$id)
	{
		$sql = "select * from ".PIN_RECORDS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detailTypeRecords($db,$type,$pin_id)
	{
		$sql = "select count(id) from ".PIN_RECORDS_TABLE." where type=".$type." and pin_id=".$pin_id;

		$obj = $db->get_var($sql);
		return $obj;
	}


	function deletedate($db,$id)
	{
		$db->query("delete from ".PIN_RECORDS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($pin_id,$userid,$type,$db)
	{
		$db->query("insert into ".PIN_RECORDS_TABLE." (pin_id,userid,addtime,type) values ('".$pin_id."','".$userid."','".time()."','".$type."')");
		return true;
	}
	function update($pin_id=-1,$userid=-1,$type=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($pin_id>-1){
			$update_values.="pin_id='".$pin_id."',";
		}
		if($userid>-1){
			$update_values.="user_id='".$userid."',";
		}
		if($type>-1){
			$update_values.="type='".$type."',";
		}

		$db->query("update ".PIN_RECORDS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}


	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PIN_RECORDS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

}
?>
