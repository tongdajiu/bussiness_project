<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('FOCUS_TABLE',"focus");
class focusBean
{
	function search($db,$page,$per,$type=0,$status=0)
	{
		$sql = "select * from ".FOCUS_TABLE." where id > 0 ";
		if($type>0){
			$sql.=" and type = '".$type."'";
		}
		if($status>=0){
			$sql.=" and status = '".$status."'";
		}
		$sql.=" order by id desc";

		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	
	function get_results($db,$type)
	{
		$sql = "select * from ".FOCUS_TABLE." where id>0";
		if($type>0){
			$sql.=" and type = '".$type."'";
		}
		$sql.=" and  status=1 order by sorting,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	
	function get_results_group($db,$group_id)
	{
		$sql = "select * from ".FOCUS_TABLE;
		if($group_id!=''){
			$sql.=" where group_id=".$group_id;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	
	function get_index_type($db,$type=0,$limit=0)
	{
		$sql = "select * from ".FOCUS_TABLE." where id > 0 ";
		if($type>0){
			$sql.=" and type = '".$type."' ";
		}
		$sql.=" order by sorting desc,id asc";
		if($limit>0){
			$sql.=" limit ".$limit."";
		}
		$list = $db->get_results($sql);
		return $list;
	}
	
	function detail($db,$id)
	{
		$sql = "select * from ".FOCUS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function detail_focus($db,$id)
	{
		$sql = "select * from ".FOCUS_TABLE." where type='".$id."' and status='1'";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function detail_focus2($db,$id)
	{
		$sql = "select * from ".FOCUS_TABLE." where type='".$id."' and status='0' order by sorting desc";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function deletedate($db,$id)
	{
		$db->query("delete from ".FOCUS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".FOCUS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
	
	function create($sorting,$image,$urls,$type,$title,$group_id,$db)
	{
		$db->query("insert into ".FOCUS_TABLE." (pic,addtime,type,status,sorting,urls,group_id) values ('".$image."','".time()."','".$type."','0','".$sorting."','".$urls."','".$group_id."')");
        return true;
	}
	
	function update($sorting=-1,$image='',$urls=null,$type=0,$sorting2,$group_id=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "pic='".$image."',";
		}
		if($sorting>=0){
			$update_values.="type='".$sorting."',";
		}
		if($sorting2>=0){
			$update_values.="sorting='".$sorting2."',";
		}
		if($type!=null){
			$update_values.="title='".$type."',";
		}
		if($urls!=null){
			$update_values.="urls='".$urls."',";
		}
		if($group_id>-1){
			$update_values.="group_id='".$group_id."',";
		}
		//echo "update ".FOCUS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		$db->query("update ".FOCUS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
}
?>
