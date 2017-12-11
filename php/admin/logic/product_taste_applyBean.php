<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PRODUCT_TASTE_APPLY_TABLE',"product_taste_apply");
class product_taste_applyBean
{
	function search($db,$page,$per,$status=-1,$condition='',$keys='')
	{
		$sql = "select * from ".PRODUCT_TASTE_APPLY_TABLE." where product_id>0";
			if($status > -1){
				$sql .= " and status ='".$status."'";
			}
			if($keys != ''){
				$pids = $db->get_col("select product_id from product where name like '%".$keys."%'");
				$sql .= " and product_id in(".implode(',',$pids).")";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".PRODUCT_TASTE_APPLY_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_user($db,$userid){
		$sql = "select * from ".PRODUCT_TASTE_APPLY_TABLE." where userid='".$userid."' order by id desc";
		return $db->get_results($sql);
	}

	function get_results_product($db,$product_id){
		$sql = "select * from ".PRODUCT_TASTE_APPLY_TABLE." where product_id='".$product_id."'";
		$sql .= " order by id desc";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PRODUCT_TASTE_APPLY_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".PRODUCT_TASTE_APPLY_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$product_id,$name,$tel,$address,$status,$db)
	{
		$db->query("insert into ".PRODUCT_TASTE_APPLY_TABLE." (userid,product_id,name,tel,address,status,addtime) values ('".$userid."','".$product_id."','".$name."','".$tel."','".$address."','".$status."','".time()."')");
		return true;
	}

	function update($userid=0,$product_id=0,$name=null,$tel=null,$address=null,$status=-1,$db,$id)
	{
		$update_values="";
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($tel!=null){
			$update_values.="tel='".$tel."',";
		}
		if($address!=null){
			$update_values.="address='".$address."',";
		}
		if($status>-1){
			$update_values.="status='".$status."',";
		}
		$db->query("update ".PRODUCT_TASTE_APPLY_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		$db->query("update ".PRODUCT_TASTE_APPLY_TABLE." set status='".($state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
