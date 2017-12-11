<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PROMOTIONS_NEW_TABLE',"promotions_new");
class promotions_newBean
{
	function search($db,$page,$per,$status=0,$condition='',$keys='',$title='')
	{
		$sql = "select * from ".PROMOTIONS_NEW_TABLE." where id>0";
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($title != ''){
				$sql.=" and title like '%".$title."%'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	
	function get_results($db,$keys)
	{
		$sql = "select * from ".PROMOTIONS_NEW_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	
	function get_results_time($db,$time){
		$sql = "select * from ".PROMOTIONS_NEW_TABLE." where start_time<='".$time."' and end_time >='".$time."'";
		return $db->get_results($sql);
	}
	
	function detail($db,$id)
	{
		$sql = "select * from ".PROMOTIONS_NEW_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function deletedate($db,$id)
	{
		$db->query("delete from ".PROMOTIONS_NEW_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	
	function create($status,$title,$start_time,$end_time,$all_money,$send_money,$rebate,$image1,$image2,$db)
	{		
		$db->query("insert into ".PROMOTIONS_NEW_TABLE." (status,title,start_time,end_time,all_money,send_money,rebate,image1,image2) values ('".$status."','".$title."','".$start_time."','".$end_time."','".$all_money."','".$send_money."','".$rebate."','".$image1."','".$image2."')");
		$uid = $db->insert_id;
		return $uid;
	}
	
	function update($status=-1,$title=null,$start_time=-1,$end_time=-1,$all_money=-1,$send_money=-1,$rebate=null,$image1=null,$image2=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($start_time>0){
			$update_values.="start_time='".$start_time."',";
		}
		if($end_time>0){
			$update_values.="end_time='".$end_time."',";
		}
		if($all_money>0){
			$update_values.="all_money='".$all_money."',";
		}
		if($send_money>0){
			$update_values.="send_money='".$send_money."',";
		}
		if($rebate!=null){
			$update_values.="rebate='".$rebate."',";
		}
		if($image1!=null){
			$update_values.="image1='".$image1."',";
		}
		if($image2!=null){
			$update_values.="image2='".$image2."',";
		}
		$db->query("update ".PROMOTIONS_NEW_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PROMOTIONS_NEW_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
