<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PIN_SYS_TABLE',"pin_sys");
class pin_sysBean
{
	function search($db,$page,$per)
	{
		$sql = "select * from ".PIN_SYS_TABLE." where id>0";
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	
	function get_results($db,$keys)
		{
		$sql = "select * from ".PIN_SYS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	
	function get_product_sys($db,$product_id){
		$sql = "select * from ".PIN_SYS_TABLE." where product_id='".$product_id."' and status=1 order by money";
		return $db->get_results($sql);
	}
	
	function detail($db,$id)
	{
		$sql = "select * from ".PIN_SYS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function deletedate($db,$id)
	{
		$db->query("delete from ".PIN_SYS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	
	function create($money,$discount,$product_id,$status,$db)
	{		
		$db->query("insert into ".PIN_SYS_TABLE." (money,discount,product_id,status) values ('".$money."','".$discount."','".$product_id."','".$status."')");
		return true;
	}
	
	function update($money=null,$discount=-1,$product_id=0,$status=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($money!=null){
			$update_values.="money='".$money."',";
		}
		if($discount>0){
			$update_values.="discount='".$discount."',";
		}
		if($product_id > 0){
			$update_values.="product_id='".$product_id."',";
		}
		if($status > -1){
			$update_values.="status='".$status."',";
		}
		$db->query("update ".PIN_SYS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PIN_SYS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
