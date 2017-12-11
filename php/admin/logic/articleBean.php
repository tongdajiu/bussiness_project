<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('ARTICLE_TABLE',"article");
class articleBean
{
	function search($db,$page,$per,$status=0,$type=0,$condition='',$keys='')
	{
		$sql = "select * from ".ARTICLE_TABLE." where id>0";
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($type>0){
				$sql.=" and type ='".$type."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	
	function get_results($db,$keys)
	{
		$sql = "select * from ".ARTICLE_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	
	function detail($db,$id)
	{
		$sql = "select * from ".ARTICLE_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function detail_type($db,$type){
		$sql = "select * from ".ARTICLE_TABLE." where type='".$type."' order by id desc limit 0,1";
		return $db->get_row($sql);
	}
	
	function deletedate($db,$id)
	{
		$db->query("delete from ".ARTICLE_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	
	function create($status,$sorting,$type,$title,$content,$db)
	{		
		$db->query("insert into ".ARTICLE_TABLE." (status,sorting,type,title,content,addtime) values ('".$status."','".$sorting."','".$type."','".$title."','".$content."','".time()."')");
		return $db->insert_id;
	}
	
	function update($status=-1,$sorting=-1,$type=-1,$title=null,$content=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($content!=null){
			$update_values.="content='".$content."',";
		}
		$db->query("update ".ARTICLE_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".ARTICLE_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
