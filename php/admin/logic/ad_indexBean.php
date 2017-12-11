<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('AD_INDEX_TABLE',"ad_index");
class ad_indexBean
{
	function search($db,$page,$per,$type=0,$status=0)
	{
		$sql = "select * from ".AD_INDEX_TABLE." where id > 0 ";
		if($type>0){
			$sql.=" and type = '".$type."'";
		}
		if($status>=0){
			$sql.=" and status = '".$status."'";
		}
		$sql.=" order by sorting asc,id desc";

		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".AD_INDEX_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_results_group($db,$group_id)
	{
		$sql = "select * from ".AD_INDEX_TABLE;
		if($group_id!=''){
			$sql.=" where group_id=".$group_id;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_index_type($db,$type=0,$limit=0)
	{
		$sql = "select * from ".AD_INDEX_TABLE." where id > 0 ";
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
		$sql = "select * from ".AD_INDEX_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_focus($db,$id)
	{
		$sql = "select * from ".AD_INDEX_TABLE." where type='".$id."' and status='1'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_focus2($db,$id)
	{
		$sql = "select * from ".AD_INDEX_TABLE." where type='".$id."' and status='0' order by sorting desc";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".AD_INDEX_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".AD_INDEX_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function create($sorting,$image,$url,$type,$title,$db)
	{
		$db->query("insert into ".AD_INDEX_TABLE." (pic,addtime,type,status,sorting,url) values ('".$image."','".time()."','".$type."','0','".$sorting."','".$url."')");
        return true;
	}

	function update($sorting=-1,$image='',$title=null,$url=null,$size_tips,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "image='".$image."',";
		}
		if($sorting>=0){
			$update_values.="sorting='".$sorting."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($url!=null){
			$update_values.="url='".$url."',";
		}
		if($size_tips!=null){
			$update_values.="size_tips='".$size_tips."',";
		}
//	echo 	"update ".AD_INDEX_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		$db->query("update ".AD_INDEX_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
}
?>
