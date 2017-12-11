<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('BLESSING_TABLE',"blessing");
class blessingBean
{
	function search($db,$page,$per,$condition='',$keys='')
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".BLESSING_TABLE." where id>0";
		if($keys!=''){
			$sql.=" and (name like '%".$keys."%' or toname like '%".$keys."%')";
		}
		$sql.=" order by id desc";
//		echo $sql;
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
function get_results($db,$keys)
{
	$sql = "select * from ".BLESSING_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}
	function detail($db,$id)
{
		$sql = "select * from ".BLESSING_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_mid($db,$mid)
{
		$sql = "select * from ".BLESSING_TABLE." where mid = '".$mid."'";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db,$id)
{
	$db->query("delete from ".BLESSING_TABLE." where id in (".implode(",",$id).")");
	return true;
}
	function create($type,$name,$toname,$content,$db)
	{		
		$sql="insert into ".BLESSING_TABLE." (type,name,toname,content) values ('".$type."','".$name."','".$toname."','".$content."')";
//		echo $sql;
		$db->query($sql);
		$oid=$db->insert_id;
		$mid = md5($oid.time());
		$sql="update ".BLESSING_TABLE." set mid='".$mid."' where id=".$oid;
		$db->query($sql);
		return $mid;
	}
	function update($type,$name,$toname,$content=null,$db,$id)
	{
	$update_values="";
			if($type>0){
				$update_values.="type='".$type."',";
			}
			if($name!=null){
				$update_values.="name='".$name."',";
			}
			if($toname!=null){
				$update_values.="toname='".$toname."',";
			}
			if($content!=null){
				$update_values.="content='".$content."',";
			}
		$db->query("update ".BLESSING_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".BLESSING_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
