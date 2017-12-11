<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('ORDER_NUM_TABLE',"order_num");
class order_numBean
{
	function search($db,$page,$per)
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".ORDER_NUM_TABLE." where id>0";
		$sql.=" order by order_num desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
function get_results($db,$keys)
{
	$sql = "select * from ".ORDER_NUM_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by order_num desc";
			$list = $db->get_results($sql);
			return $list;
}
	function detail($db,$id)
{
		$sql = "select * from ".ORDER_NUM_TABLE." where order_num = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db,$id)
{
	$db->query("delete from ".ORDER_NUM_TABLE." where order_num in (".implode(",",$id).")");
	return true;
}
	function create($db)
	{		
		$db->query("insert into ".ORDER_NUM_TABLE." (addtime) values ('".time()."')");
return true;
	}
	function update($db,$id)
	{
	$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		$db->query("update ".ORDER_NUM_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where order_num=".$id);
		return true;
	}
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".ORDER_NUM_TABLE." set status='".($c_state)."' where order_num in (".implode(",",$id).")");
		return true;
	}
}
?>
