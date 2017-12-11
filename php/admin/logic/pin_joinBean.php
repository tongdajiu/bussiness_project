<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PIN_JOIN_TABLE',"pin_join");
class pin_joinBean
{
	function search($db,$page,$per,$pin_id=0,$condition='',$keys='')
	{
		$sql = "select * from ".PIN_JOIN_TABLE." where id>0 ";

			if($pin_id>0){
				$sql.=" and pin_id ='".$pin_id."'";
			}

			/*if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($condition == "we_no"){
				$users = $db->get_col("select id from user where name like '%".$keys."%'");
				$id_str = implode(',',$users);
				$sql.=" and userid in(".$id_str.")";
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
		$sql = "select * from ".PIN_JOIN_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_pin($db,$pin_id){
		$sql = "select * from ".PIN_JOIN_TABLE." where pin_id = '".$pin_id."' order by id desc";
		return $db->get_results($sql);
	}
	function get_results_num($db,$pin_id){
		$sql = "select count(pin_id) from ".PIN_JOIN_TABLE." where pin_id=".$pin_id;
		return $db->get_var($sql);
	}
	function get_results_show($db){
		$sql = "select * from ".PIN_JOIN_TABLE." where show_status=1 and close_status=0 order by sorting asc,id desc";
		return $db->get_results($sql);
	}

	function get_results_userid($db,$pin_id,$userid)
	{
		$sql = "select * from ".PIN_JOIN_TABLE." where pin_id = {$pin_id} and userid=".$userid;
		$obj = $db->get_results($sql);
		return $obj;
	}
	
	function get_userids($db,$pin_id){
		$sql = "select userid from ".PIN_JOIN_TABLE." where pin_id='".$pin_id."'";
		return $db->get_col($sql);
	}
	function detail($db,$id)
	{
		$sql = "select * from ".PIN_JOIN_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_pinid($db,$pin_id)
	{
		$sql = "select * from ".PIN_JOIN_TABLE." where pin_id = {$pin_id}";
		$obj = $db->get_results($sql);
		return $obj;
	}

	function detail_order($db,$order_id,$userid){
		$sql = "select * from ".PIN_JOIN_TABLE." where order_id='".$order_id."' and userid='".$userid."'";
		return $db->get_row($sql);
	}
//查询类型为1的pin数据
	function detail_type($db,$id){
		$sql = "select * from ".PIN_JOIN_TABLE." where id='".$id."' and type=1";
		return $db->get_results($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".PIN_JOIN_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	
	function create($userid,$pin_id,$wx_no,$db)
	{		
		$db->query("insert into ".PIN_JOIN_TABLE." (userid,pin_id,wx_no,addtime) values ('".$userid."','".$pin_id."','".$wx_no."','".time()."')");
		return true;
	}
	function update($userid=-1,$pin_id=-1,$wx_no=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($pin_id>0){
			$update_values.="pin_id='".$pin_id."',";
		}
		if($wx_no!=null){
			$update_values.="wx_no='".$wx_no."',";
		}

		$db->query("update ".PIN_JOIN_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PIN_JOIN_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_order_number($db,$oid,$pin_id){
		$sql = "update ".PIN_JOIN_TABLE." set order_id='".$oid."' where id='".$pin_id."'";
		$db->query($sql);
		return true;
	}

	function update_status($db,$pin_status,$pin_id){
		$sql = "update ".PIN_JOIN_TABLE." set status='".$pin_status."' where id='".$pin_id."'";
		$db->query($sql);
		return true;
	}
}
?>
