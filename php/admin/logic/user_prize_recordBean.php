<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('USER_PRIZE_RECORD_TABLE',"user_prize_record");
class user_prize_recordBean
{
	function search($db,$page,$per,$condition,$keys,$name,$productname)
	{
		$sql = "select * from ".USER_PRIZE_RECORD_TABLE." where id>0";
			if($name != ''){
			$users = $db->get_col("select id from user where name like '%".$name."%'");
			$id_str = implode(',',$users);
			$sql.=" and userid in(".$id_str.")";
		}
		if($productname != ''){
			$products = $db->get_col("select product_id from product where name like '%".$productname."%'");
			$id_str = implode(',',$products);
			$sql.=" and product_id in(".$id_str.")";
		}
		$sql.=" order by id desc";
		//echo $sql;
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function create($userid,$product_id,$phase_id,$lucky_number,$db){
		$sql = "insert into ".USER_PRIZE_RECORD_TABLE."(userid,product_id,phase_id,lucky_number,addtime) values('".$userid."','".$product_id."','".$phase_id."','".$lucky_number."','".time()."')";
		$db->query($sql);
		return  true;
	}
}
?>
