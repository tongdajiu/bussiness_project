<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('VISIT_RECORDS_TABLE',"visit_records");
class visit_recordsBean
{
	function search($db,$page,$per,$condition,$keys,$name,$productname)
	{
		$sql = "select * from ".VISIT_RECORDS_TABLE." where id>0";
			if($name != ''){
			$users = $db->get_col("select id from user where name like '%".$name."%'");
			$id_str = implode(',',$users);
			$sql.=" and userid in(".$id_str.")";
		}
		if($productname != ''){
			$products = $db->get_col("select product_id from product where name like '%".$productname."%'");
			$id_str = implode(',',$products);
			$sql.=" and product_id in(".$id_str.")";
		}
		$sql.=" order by id desc";
		//echo $sql;
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".VISIT_RECORDS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_agent($db,$page,$per,$userid)
	{
		$sql = "select * from ".VISIT_RECORDS_TABLE." where userid in(select userid from user_connection where fuserid='".$userid."') order by id desc";
		$list = get_pager_data($db, $sql, $page,$per);
		return $list;
	}

	function get_results_68before($db,$userid,$product_id){
		$sql = "select * from ".VISIT_RECORDS_TABLE." where userid='".$userid."' and product_id='".$product_id."' and addtime<".strtotime('2015-06-09 00:00:00')." order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".VISIT_RECORDS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function create($userid,$product_id,$db)
	{
		$db->query("insert into ".VISIT_RECORDS_TABLE." (userid,product_id,addtime) values ('".$userid."','".$product_id."','".time()."')");
		return true;
	}

	function update($userid=-1,$product_id=-1,$db,$id)
	{
		$update_values="";
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		$db->query("update ".VISIT_RECORDS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".VISIT_RECORDS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
