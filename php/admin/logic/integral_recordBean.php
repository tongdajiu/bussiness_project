<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('INTEGRAL_RECORD_TABLE',"integral_record");
class integral_recordBean
{
	function search($db,$page,$per,$type=0,$status=0,$userid=0,$condition='',$keys='')
	{
		$sql = "select * from ".INTEGRAL_RECORD_TABLE." where id>0";
			if($type>0){
				$sql.=" and type ='".$type."'";
			}
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($userid>0){
				$sql.=" and userid ='".$userid."'";
			}
			if($condition == "username"){
				$users = $db->get_col("select id from user where name like '%".$keys."%'");
				$id_str = implode(',',$users);
				$sql.=" and userid in(".$id_str.")";
			}
			if($condition == "order_number"){
				$order = $db->get_row("select * from orders where order_number='".$keys."'");
				$sql.=" and order_id='".$order->order_id."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results_integral($db,$userid)
	{
		$sql="select c.integral,c.type,c.addtime,c.color from ".
			  "(select '1' color,concat('-',a.integral) integral,a.type type,a.addtime addtime FROM integral_pay as a where a.userid='".$userid."' ".
			  "UNION all ".
			  "select '2' color,concat('+',b.integral) integral,b.type type,b.addtime addtime FROM integral_record as b where b.userid='".$userid."') ".
			  "as c order by c.addtime desc limit 100";
			$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid)
	{
		$sql = "select * from ".INTEGRAL_RECORD_TABLE;
		if($userid!=''){
			$sql.=" where userid=".$userid;
		}
		$sql.=" order by id desc limit 10";

		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_agent($db,$userid)
	{
		$sql = "select * from ".INTEGRAL_RECORD_TABLE." where (userid='".$userid."' or userid in(select userid from user_connection where fuserid='".$userid."')) and type=1 order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".INTEGRAL_RECORD_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function get_order_share_record($db,$userid,$order_id){
		$sql = "select * from ".INTEGRAL_RECORD_TABLE." where userid='".$userid."' and order_id='".$order_id."' and type=5 limit 1";
		return $db->get_row($sql);
	}

	function get_order_buy_record($db,$userid,$order_id){
		$sql = "select * from ".INTEGRAL_RECORD_TABLE." where userid='".$userid."' and order_id='".$order_id."' and type=1 limit 1";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".INTEGRAL_RECORD_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($type,$status,$userid,$pin_id,$pin_type,$order_id,$integral,$total_time,$db)
	{
		$db->query("insert into ".INTEGRAL_RECORD_TABLE." (type,status,userid,pin_id,pin_type,order_id,integral,addtime,total_time) values ('".$type."','".$status."','".$userid."','".$pin_id."','".$pin_type."','".$order_id."','".$integral."','".time()."','".$total_time."')");
		return true;
	}

	function update($type=-1,$status=-1,$userid=-1,$pin_id=-1,$pin_type=-1,$order_id=-1,$integral=null,$total_time=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($pin_id>0){
			$update_values.="pin_id='".$pin_id."',";
		}
		if($pin_type>0){
			$update_values.="pin_type='".$pin_type."',";
		}
		if($order_id>0){
				$update_values.="order_id='".$order_id."',";
		}
		if($integral!=null){
			$update_values.="integral='".$integral."',";
		}
		if($total_time>0){
			$update_values.="total_time='".$total_time."',";
		}
		$db->query("update ".INTEGRAL_RECORD_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".INTEGRAL_RECORD_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
