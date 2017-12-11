<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('DRAW_ACTIVITY',"draw_activity");
class draw_activityBean
{
	function search($db,$page,$per,$condition,$keys)
	{
		$sql = "select * from ".DRAW_ACTIVITY." where id>0";
			if($keys != ''){
				$sql .= " and title like '%".$keys."%'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".DRAW_ACTIVITY;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".DRAW_ACTIVITY." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".DRAW_ACTIVITY." where id in (".implode(",",$id).")");
		return true;
	}

	function create($sorting,$title,$content,$background_image,$start_date,$end_date,$number,$add_time,$db)
	{
		$db->query("insert into ".DRAW_ACTIVITY." (sorting,title,content,background_image,start_date,end_date,number,add_time) values ('".$sorting."','".$title."','".$content."','".$background_image."','".$start_date."','".$end_date."','".$number."','".$add_time."')");
		return true;
	}

	function update($sorting=-1,$title=null,$content=null,$background_image=null,$start_date=null,$end_date=null,$number=null,$state=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($sorting>-1){
			$update_values.="sorting='".$sorting."',";
		}
		if($title != null){
			$update_values.="title='".$title."',";
		}
		if($content != null){
			$update_values.="content='".$content."',";
		}
		if($background_image != null){
			$update_values.="background_image='".$background_image."',";
		}
		if($start_date != null){
			$update_values.="start_date='".$start_date."',";
		}
		if($end_date != null){
			$update_values.="end_date='".$end_date."',";
		}
		if($number != null){
			$update_values.="number='".$number."',";
		}
		if($state > -1){
			$update_values.="state='".$state."',";
		}
		$db->query("update ".DRAW_ACTIVITY." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

}
?>
