<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('WX_CARD_EXCHANGE_RECORDS_TABLE',"wx_card_exchange_records");
class wx_card_exchange_recordsBean
{
	function search($db,$page,$per,$condition='',$keys='')
	{
		$sql = "select * from ".WX_CARD_EXCHANGE_RECORDS_TABLE." where id>0";
//			if($condition == "username"){
//				$users = $db->get_col("select id from user where name like '%".$keys."%'");
//				$id_str = implode(',',$users);
//				$sql.=" and userid in(".$id_str.")";
//			}
//			if($condition == "order_number"){
//				$order = $db->get_row("select * from orders where order_number='".$keys."'");
//				$sql.=" and order_id='".$order->order_id."'";
//			}
		$sql.=" order by id desc";
//		echo $sql;
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}


	function get_results($db,$keys)
	{
		$sql = "select * from ".WX_CARD_EXCHANGE_RECORDS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".WX_CARD_EXCHANGE_RECORDS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".WX_CARD_EXCHANGE_RECORDS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($user_id,$card_id,$coupon_id,$reduce_cost,$wx_code,$db)
	{
		$db->query("insert into ".WX_CARD_EXCHANGE_RECORDS_TABLE." (user_id,card_id,coupon_id,reduce_cost,wx_code,addtime) values ('".$user_id."','".$card_id."','".$coupon_id."','".$reduce_cost."','".$wx_code."','".time()."')");
		return true;
	}

	function update($user_id=-1,$card_id=null,$coupon_id=-1,$reduce_cost=-1,$wx_code=null,$db,$id)
	{
		$update_values="";
		if($user_id >-1){
			$update_values.="user_id='".$user_id."',";
		}
		if($card_id != null){
			$update_values.="card_id='".$card_id."',";
		}
		if($coupon_id>-1){
			$update_values.="coupon_id='".$coupon_id."',";
		}
		if($reduce_cost>-1){
			$update_values.="reduce_cost='".$reduce_cost."',";
		}
		if($wx_code!=null){
			$update_values.="wx_code='".$wx_code."',";
		}
		$db->query("update ".WX_CARD_EXCHANGE_RECORDS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

/*	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".WX_CARD_EXCHANGE_RECORDS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
*/}
?>
