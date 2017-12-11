<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PIN_DETAILS_TABLE',"pin_details");
class pin_detailsBean
{
	function search($db,$page,$per,$userid=0,$status=0,$type=0,$condition='',$keys='',$pin_id=0)
	{
		$sql = "select * from ".PIN_DETAILS_TABLE." where id>0";
		if($userid>0){
			$sql.=" and userid ='".$userid."'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($type>0){
			$sql.=" and type ='".$type."'";
		}
		if($condition == "pin_id"){
			$sql .= " and pin_id=".$keys;
		}
		if($condition == "username"){
			$users = $db->get_col("select id from user where name like '%".$keys."%'");
			$id_str = implode(',',$users);
			$sql.=" and userid in(".$id_str.")";
		}
		if($condition == "order_num"){
			$order = $db->get_row("select * from orders where order_number='".$keys."'");
			$sql.=" and orderid='".$order->order_id."'";
		}
		if($pin_id > 0){
			$sql.=" and pin_id='".$pin_id."'";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	
	function get_excel_results($db,$userid=0,$status=0,$type=0,$condition='',$keys='',$pin_id=0){
		$sql = "select * from ".PIN_DETAILS_TABLE." where id>0";
		if($userid>0){
			$sql.=" and userid ='".$userid."'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($type>0){
			$sql.=" and type ='".$type."'";
		}
		if($condition == "pin_id"){
			$sql .= " and pin_id=".$keys;
		}
		if($condition == "username"){
			$users = $db->get_col("select id from user where name like '%".$keys."%'");
			$id_str = implode(',',$users);
			$sql.=" and userid in(".$id_str.")";
		}
		if($condition == "order_num"){
			$order = $db->get_row("select * from orders where order_number='".$keys."'");
			$sql.=" and orderid='".$order->order_id."'";
		}
		if($pin_id > 0){
			$sql.=" and pin_id='".$pin_id."'";
		}
		$sql.=" order by id desc";
		return $db->get_results($sql);
	}
	
	function get_results($db,$keys)
	{
		$sql = "select * from ".PIN_DETAILS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	
	function get_results_pin($db,$pin_id){
		$sql = "select * from ".PIN_DETAILS_TABLE." where pin_id = '".$pin_id."' order by id desc";
		return $db->get_results($sql);
	}
	
	function detail($db,$id)
	{
		$sql = "select * from ".PIN_DETAILS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function get_results_pin_user($db,$pin_id,$userid){
		$sql = "select * from ".PIN_DETAILS_TABLE." where pin_id='".$pin_id."' and userid='".$userid."'";
		return $db->get_results($sql);
	}
	
	function deletedate($db,$id)
	{
		$db->query("delete from ".PIN_DETAILS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	
	function detail_order($db,$order_id,$userid){
		$sql = "select * from ".PIN_DETAILS_TABLE." where orderid='".$order_id."' and userid='".$userid."'";
		return $db->get_row($sql);
	}
	
	function create($userid,$status,$pin_id,$type,$name,$orderid,$price,$refund,$bank_card_number,$addtime,$address_id,$db)
	{		
		$db->query("insert into ".PIN_DETAILS_TABLE." (userid,status,pin_id,type,name,orderid,price,refund,bank_card_number,addtime,address_id) values ('".$userid."','".$status."','".$pin_id."','".$type."','".$name."','".$orderid."','".$price."','".$refund."','".$bank_card_number."','".$addtime."','".$address_id."')");
		return true;
	}
	
	function update($userid=-1,$status=-1,$pin_id=-1,$type=-1,$name=null,$orderid=-1,$price=null,$refund=-1,$bank_card_number=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($pin_id>0){
			$update_values.="pin_id='".$pin_id."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($orderid>0){
			$update_values.="orderid='".$orderid."',";
		}
		if($price!=null){
			$update_values.="price='".$price."',";
		}
		if($refund>0){
			$update_values.="refund='".$refund."',";
		}
		if($bank_card_number!=null){
			$update_values.="bank_card_number='".$bank_card_number."',";
		}
		$db->query("update ".PIN_DETAILS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PIN_DETAILS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
	
	function update_order_number($db,$oid,$pin_id){
		$sql = "update ".PIN_TABLE." set orderid='".$oid."' where pin_id='".$pin_id."'";
		$db->query($sql);
		return true;
	}
	
	function update_refund($db,$id){
		$sql = "update ".PIN_DETAILS_TABLE." set refund=1 where pin_id='".$id."'";
		$db->query($sql);
		return true;
	}
	
	function update_address($db,$detailid,$address_id){
		$sql = "update ".PIN_DETAILS_TABLE." set address_id='".$address_id."' where id='".$detailid."'";
		$db->query($sql);
		return true;
	}
	
	function update_orderid($db,$orderid,$id){
		$sql = "update ".PIN_DETAILS_TABLE." set orderid='".$orderid."' where id='".$id."'";
		$db->query($sql);
		return true;
	}
	
	function update_price($db,$price,$id){
		$sql = "update ".PIN_DETAILS_TABLE." set price='".$price."' where id='".$id."'";
		$db->query($sql);
		return true;
	}
}
?>
