<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('UNIT_TABLE',"unit");
class unitBean
{
	function search($db,$page,$per,$status=0,$condition='',$keys='')
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".UNIT_TABLE." where id>0";
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
function get_results($db,$status)
{
	$sql = "select * from ".UNIT_TABLE." where id>0";
	if($status>-1){
		$sql .= " and status=".$status;
	}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}
	function detail($db,$id)
{
		$sql = "select * from ".UNIT_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db,$id)
{
	$db->query("delete from ".UNIT_TABLE." where id in (".implode(",",$id).")");
	return true;
}
	function create($name,$status,$db)
	{		
		$db->query("insert into ".UNIT_TABLE." (name,status,addtime) values ('".$name."','".$status."','".time()."')");
return true;
	}
	function update($name=null,$status=-1,$db,$id)
	{
	$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
			if($name!=null){
				$update_values.="name='".$name."',";
			}
			if($status>0){
				$update_values.="status='".$status."',";
			}
		$db->query("update ".UNIT_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".UNIT_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
