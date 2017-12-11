<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('REDBAG_ACTIVITY',"redbag_activity");
class redbag_activityBean
{
	function search($db,$page,$per,$condition,$keys)
	{
		$sql = "select * from ".REDBAG_ACTIVITY." where id>0";
			if($keys != ''){
				$sql .= " and title like '%".$keys."%'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".REDBAG_ACTIVITY;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".REDBAG_ACTIVITY." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".REDBAG_ACTIVITY." where id in (".implode(",",$id).")");
		return true;
	}

	function create($sorting,$title,$content,$background_image,$start_date,$end_date,$add_time,$prize_count,$db)
	{
		$db->query("insert into ".REDBAG_ACTIVITY." (sorting,title,content,background_image,start_date,end_date,add_time,prize_count) values ('".$sorting."','".$title."','".$content."','".$background_image."','".$start_date."','".$end_date."','".$add_time."','".$prize_count."')");
		return true;
	}

	function update($sorting=-1,$title=null,$content=null,$background_image=null,$start_date=null,$end_date=null,$state=-1,$prize_count=-1,$db,$id)
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
		if($state > -1){
			$update_values.="state='".$state."',";
		}
		if($prize_count >-1){
			$update_values.="prize_count='".$prize_count."',";
		}
		$db->query("update ".REDBAG_ACTIVITY." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

}
?>
