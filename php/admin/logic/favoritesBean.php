<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('FAVORITES_TABLE',"favorites");
class favoritesBean
{
	function search($db,$page,$per,$status=0,$type=-1,$userid=0,$condition='',$keys='')
	{
		$sql = "select * from ".FAVORITES_TABLE." where id>0";
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($type>-1){
			$sql.=" and type ='".$type."'";
		}
		if($userid>0){
			$sql.=" and userid ='".$userid."'";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".FAVORITES_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".FAVORITES_TABLE." where userid='".$userid."' order by id desc";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".FAVORITES_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_fav($db,$userid,$product_id)
	{
		$sql = "select * from ".FAVORITES_TABLE." where userid ='".$userid."' and   product_id ='".$product_id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".FAVORITES_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	function delete($db,$userid,$product_id){
		$db->query("delete from ".FAVORITES_TABLE." where userid =".$userid." and product_id = ".$product_id);
		return true;
	}

	function create($status,$type,$userid,$product_id,$db)
	{
		$db->query("insert into ".FAVORITES_TABLE." (status,type,userid,addtime,product_id) values ('".$status."','".$type."','".$userid."','".time()."','".$product_id."')");
		return true;
	}

	function update($status=-1,$type=-1,$userid=-1,$db,$id)
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
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		$db->query("update ".FAVORITES_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".FAVORITES_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
