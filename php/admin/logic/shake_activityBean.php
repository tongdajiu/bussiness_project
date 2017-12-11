<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('SHAKE_ACTIVITY_TABLE',"shake_activity");

class shake_activityBean
{



	function search($db,$page,$per,$status,$type='',$condition='',$keys='')
	{

		$sql = "select * from ".SHAKE_ACTIVITY_TABLE." where id>0 ";
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($type>0){
				$sql.=" and type ='".$type."'";
			}
			if($keys!=''){
				$sql.=" and title like '%".$keys."%'";
			}
//			$sql.=" and title like '%".$keys."%'";
			if($condition=='content'){
				$sql.=" and content like '%".$keys."%'";
			}

		$sql.=" order by sorting asc";
//echo $sql;
		$pager = get_pager_data($db, $sql, $page, $per);

		return $pager;

	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".SHAKE_ACTIVITY_TABLE." where 1=1";
			if($keys!=''){
				$sql.=" where shop_id=".$keys;
		}
		$sql.=" and status=1 order by sorting asc,addtime desc";
		$list = $db->get_results($sql);
		return $list;
	}
		function get_results2($db,$shop_id)
	{
		$sql = "select * from ".SHAKE_ACTIVITY_TABLE." where id>0";
			if($shop_id>0){
				$sql.=" and shop_id=".$shop_id;
		}
		$sql.=" and status=1 order by sorting asc,addtime desc";
//		echo $sql;
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
{
		$sql = "select * from ".SHAKE_ACTIVITY_TABLE." where id = {$id}";
//		echo $sql;
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detailByShop($db,$shop_id)
	{
		$sql = "select * from ".SHAKE_ACTIVITY_TABLE." where shop_id = {$shop_id}";
		$obj = $db->get_results($sql);
		return $obj;
	}
	function detail_status($db,$id)
{
		$sql = "select * from ".SHAKE_ACTIVITY_TABLE." where id = {$id} and status = 1";
		$obj = $db->get_row($sql);
//		echo $sql;
		return $obj;
	}

	function detail_time($db){
//		$sql = "select * from ".SHAKE_ACTIVITY_TABLE." where addtime<=".strtotime(date('Y-m-d 00:00:00',time()))." && endtime>=".strtotime(date('Y-m-d 00:00:00',time()))." and status=1  order by id desc limit 1";
		$sql = "select * from ".SHAKE_ACTIVITY_TABLE." where starttime<=".time()." && endtime>=".time()." and status=1  order by id desc limit 1";
//		echo $sql;
		return $db->get_row($sql);
	}
	function deletedate($db,$id)
{
	$db->query("delete from ".SHAKE_ACTIVITY_TABLE." where id in (".implode(",",$id).")");
	return true;
}
	function create($type,$shop_id,$image,$sorting,$status,$hits,$title,$content,$addTime,$starttime,$endtime,$interview,$lat,$lng,$address,$db)
	{

		$sql ="insert into ".SHAKE_ACTIVITY_TABLE." (type,shop_id,image,sorting,status,hits,title,content,addTime,starttime,endtime,interview,lat,lng,address) values ('".$type."','".$shop_id."','".$image."','".$sorting."','".$status."','".$hits."','".$title."','".$content."','".time()."','".$starttime."','".$endtime."','".$interview."','".$lat."','".$lng."','".$address."')";
//		echo $sql;
		$db->query($sql);
        $rid = $db->insert_id;
        return $rid;
	}
	function create2($type,$sorting,$status,$title,$addTime,$starttime,$endtime,$db)
	{

		$sql ="insert into ".SHAKE_ACTIVITY_TABLE." (type,sorting,status,title,addTime,starttime,endtime) values ('".$type."','".$sorting."','".$status."','".$title."','".time()."','".$starttime."','".$endtime."')";
//		echo $sql;
		$db->query($sql);
        $rid = $db->insert_id;
        return true;
	}
	function update($type=-1,$shop_id=-1,$image=null,$sorting=-1,$status=-1,$hits=-1,$title=null,$content=null,$starttime=-1,$endtime=-1,$interview=-1,$lat=-1,$lng=-1,$address=null,$db,$id)
	{
	$update_values="";
		if (!empty($images))
		{
			$imagename = "images='".$images."',";
		}

			if($type>-1){
				$update_values.="type='".$type."',";
			}
			if($shop_id>-1){
				$update_values.="shop_id='".$shop_id."',";
			}
			if($sorting>-1){
				$update_values.="sorting='".$sorting."',";
			}
			if($status>-1){
				$update_values.="status='".$status."',";
			}
			if($hits>-1){
				$update_values.="hits='".$hits."',";
			}
			if($title!=null){
				$update_values.="title='".$title."',";
			}
			if($content!=null){
				$update_values.="content='".$content."',";
			}

			if($starttime>-1){
				$update_values.="starttime='".$starttime."',";
			}
			if($endtime>-1){
				$update_values.="endtime='".$endtime."',";
			}
			if($interview>-1){
				$update_values.="interview='".$interview."',";
			}
			if($image!=null){
				$update_values.="image='".$image."',";
			}
			if($lat>-1){
				$update_values.="lat='".$lat."',";
			}
			if($lng>-1){
				$update_values.="lng='".$lng."',";
			}
			if($address!=null){
				$update_values.="address='".$address."',";
			}
		$sql = "update ".SHAKE_ACTIVITY_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;

		$db->query($sql);
		return true;
	}
	function update2($type=-1,$sorting=-1,$status=-1,$title=null,$starttime=-1,$endtime=-1,$db,$id)
	{
	$update_values="";
		if (!empty($images))
		{
			$imagename = "images='".$images."',";
		}

			if($type>-1){
				$update_values.="type='".$type."',";
			}
			if($sorting>-1){
				$update_values.="sorting='".$sorting."',";
			}
			if($status>-1){
				$update_values.="status='".$status."',";
			}
			if($title!=null){
				$update_values.="title='".$title."',";
			}

			if($starttime>-1){
				$update_values.="starttime='".$starttime."',";
			}
			if($endtime>-1){
				$update_values.="endtime='".$endtime."',";
			}
		$sql = "update ".SHAKE_ACTIVITY_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;

		$db->query($sql);
		return true;
	}

	function updatestatus($db,$id,$status)
	{
		if($status==0){
			$c_status=1;
		}else if($status==1){
			$c_status=0;
		}
		$db->query("update ".SHAKE_ACTIVITY_TABLE." set status='".($c_status)."' where id in (".implode(",",$id).")");
		return true;
	}


}
?>
