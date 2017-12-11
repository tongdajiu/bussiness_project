<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('INVITE_PRIZE_RECORDS_TABLE',"invite_prize_records");
class invite_prize_recordsBean
{
	function search($db,$page,$per,$status=0,$condition='',$keys='',$shop_id=0)
	{
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where id>0";

//		if($type>0){
//				$sql.=" and type='".$type."'";
//			}
			if($status>-1){
				$sql.=" and status='".$status."'";
			}
//			if($condition!=null){
//				$sql.=" and ".$condition." like '%".$keys."%'";
//			}
			if($condition == "userid"){
				$userids = $db->get_col("select id from user where name like '%".$keys."%'");
				$useridstring = implode(" or userid=",$userids);
				$sql.=" and userid=".$useridstring;
			}
			if($condition == "fuserid"){
				$userids = $db->get_col("select id from user where name like '%".$keys."%'");
				$useridstring = implode(" or userid=",$userids);
				$sql.=" and fuserid=".$useridstring;
			}
			if($condition == "card_number"){
				$sql.=" and card_number like '%".$keys."%'";
			}
			if($condition == "exp_value"){
				$sql.=" and exp_value like '%".$keys."%'";
			}
//			if($shop_id>0){
//				$sql.=" and shop_id=".$shop_id;
//			}

			$sql.=" order by id desc";
//			echo $sql;

		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	function search2($db,$page,$per,$condition='',$keys='',$shop_id=0,$activity_id=0)
	{
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where id>0";

			if($shop_id>0){
				$sql.=" and shop_id=".$shop_id;
			}
			if($condition=="shop_name"){
				$shopids = $db->get_col("select id from shop where name like '%".$keys."%'");
				$shopidstring = implode(" or userid=",$shopids);
				$sql.=" and shop_id=".$shopidstring;
			}
			if($condition=="prize_name"){
				$prizeids = $db->get_col("select id from shop_prize where name like '%".$keys."%'");
				$prizeidstring = implode(" or userid=",$prizeids);
				$sql.=" and prize_id=".$prizeidstring;
			}
			if($condition == "user_name"){
				$userids = $db->get_col("select id from user where name like '%".$keys."%'");
				$useridstring = implode(" or userid=",$userids);
				$sql.=" and userid=".$useridstring;
			}
			if($condition == "ticket_no"){
				$sql.=" and ticket_no=".$keys;
			}
			if($activity_id>0){
				$sql.=" and shake_id=".$activity_id;
			}

			$sql.=" order by id desc";

		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_results_used($db,$is_used,$prize_id)
	{
	$sql = "select * from ".SHOP_PRE_SERVICE_TABLE." where id>0";
		if($is_used!=''){
			$sql.=" and is_used=".$is_used;
		}
		if($prize_id!=''){
			$sql.=" and prize_id=".$prize_id;
		}
		$sql.=" and status=1 order by addtime desc";
		$list = $db->get_results($sql);
		return $list;
}
	function get_results_userid($db,$userid){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where userid='".$userid."' and status=1 and addtime>UNIX_TIMESTAMP()-30*24*60*60 order by addtime desc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_results_userid4($db,$userid){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where userid='".$userid."' and status=1 and addtime>UNIX_TIMESTAMP()-30*24*60*60 order by addtime desc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_results_userid5($db,$userid){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where userid='".$userid."' and status=1 and ".time()."<1440691200 && ".time()."> 1440000000 order by addtime desc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_results_userid2($db,$userid,$status,$source){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where userid=".$userid;
		if($status>-1){
				$sql.=" and status=".$status."";
			}
		if($source>-1){
				$sql.=" and source=".$source."";
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
		function get_results_userid3($db,$userid,$source){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where userid=".$userid;

		if($source>-1){
				$sql.=" and source>".$source;
		}
		$sql.=" and status=1 order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_shopid($db,$shop_id){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where shop_id='".$shop_id."' and addtime>UNIX_TIMESTAMP()-30*24*60*60 order by addtime desc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_results_shopid_userid($db,$shop_id,$userid){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where shop_id='".$shop_id."' and userid='".$userid." and addtime>UNIX_TIMESTAMP()-30*24*60*60 order by addtime desc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_count_used($db,$is_used,$prize_id){
		$sql = "select count(*) from ".INVITE_PRIZE_RECORDS_TABLE." where is_used='".$is_used."' and prize_id='".$prize_id."' order by id desc";
		$obj = $db->get_var($sql);
		return $obj;
	}

	function detail_today($db,$userid,$shop_id){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where addtime>=".strtotime(date('Y-m-d 00:00:00',time()))." and userid=".$userid." and shop_id=".$shop_id." and (is_share=0 || share_user=".$userid.") order by id desc limit 1";
		return $db->get_row($sql);
	}
	function detail_today2($db,$userid){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where addtime>=".strtotime(date('Y-m-d 00:00:00',time()))." and userid=".$userid."  and (is_share=0 || share_user=".$userid.") order by id desc limit 1";
		return $db->get_row($sql);
	}
	function detail_today3($db,$userid){
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where addtime>=".strtotime(date('Y-m-d 00:00:00',time()))." and userid=".$userid."   order by id desc";
//		echo $sql;
		return $db->get_results($sql);
	}
	function detail1($db,$userid)
	{
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where userid=".$userid."   order by id desc limit 1";
		$obj = $db->get_row($sql);
		return $obj;
	}
function detail3($db,$userid,$shake_id)
	{
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where userid=".$userid." and shake_id=".$shake_id."   order by id desc limit 1";
//		echo $sql;
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail($db,$id)
	{
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detailByshake($db,$userid,$shake_id)
	{
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where userid = ".$userid." and shake_id =".$shake_id;
//		echo $sql;
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detailByType($db,$type)
	{
		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where type = {$type}";
		$sql .= " and status=1 order by sorting asc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detailByShopId($db,$shop_id)
	{

		$sql = "select * from ".INVITE_PRIZE_RECORDS_TABLE." where shop_id={$shop_id}";
		$sql .= " order by sorting asc";
		$obj = $db->get_results($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".INVITE_PRIZE_RECORDS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$shop_id,$prize_id,$is_used,$used_time,$status,$db)


	{
		$db->query("insert into ".INVITE_PRIZE_RECORDS_TABLE." (userid,shop_id,prize_id,is_used,used_time,status,addtime) values ('".$userid."','".$shop_id."','".$prize_id."','".$is_used."','".$used_time."','".$status."','".time()."')");
		return true;
	}

	function create3($userid,$shop_id,$prize_id,$is_used,$used_time,$status,$book_time,$db)


	{

		$sql = "insert into ".INVITE_PRIZE_RECORDS_TABLE." (userid,shop_id,prize_id,is_used,used_time,status,book_time,addtime,effective_time,ticket_no) values ('".$userid."','".$shop_id."','".$prize_id."','".$is_used."','".$used_time."','".$status."','".$book_time."','".time()."','".(time()+30*24*60*60)."','".(microtime(true)*10000)."')";
		$db->query($sql);
		return true;
	}
	function create2($userid,$shop_id,$prize_id,$is_used,$used_time,$status,$book_time,$shake_id,$db)


	{

		$sql = "insert into ".INVITE_PRIZE_RECORDS_TABLE." (userid,shop_id,prize_id,is_used,used_time,status,book_time,shake_id,addtime,effective_time,ticket_no) values ('".$userid."','".$shop_id."','".$prize_id."','".$is_used."','".$used_time."','".$status."','".$book_time."','".$shake_id."','".time()."','".(time()+30*24*60*60)."','".(microtime(true)*10000)."')";
//		echo $sql;
		$db->query($sql);
		return true;
	}

	function update($userid=-1,$shop_id=-1,$prize_id=-1,$is_used=-1,$used_time=-1,$status=-1,$db,$id)
	{
		$update_values="";

		/*if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}*/

		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($shop_id>0){
			$update_values.="shop_id='".$shop_id."',";
		}
		if($prize_id>0){
			$update_values.="prize_id='".$prize_id."',";
		}
		if($is_used!=null){
			$update_values.="is_used='".$is_used."',";
		}
		if($used_time!=null){
			$update_values.="used_time='".$used_time."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}

		$sql = "update ".INVITE_PRIZE_RECORDS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		$db->query($sql);

		return true;
	}
	function update2($userid=-1,$shop_id=-1,$prize_id=-1,$is_used=-1,$used_time=-1,$status=-1,$book_time=-1,$db,$id)
	{
		$update_values="";

		/*if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}*/

		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($shop_id>0){
			$update_values.="shop_id='".$shop_id."',";
		}
		if($prize_id>0){
			$update_values.="prize_id='".$prize_id."',";
		}
		if($is_used>0){
			$update_values.="is_used='".$is_used."',";
		}
		if($used_time>0){
			$update_values.="used_time='".$used_time."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($book_time!=null){
			$update_values.="book_time='".$book_time."',";
		}

		$sql = "update ".INVITE_PRIZE_RECORDS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
//		echo $sql;
		$db->query($sql);

		return true;
	}

	function updatestate($db,$id,$status)
	{
		if($status==0){
			$c_status=1;
		}else if($status==1){
			$c_status=0;
		}
		$db->query("update ".INVITE_PRIZE_RECORDS_TABLE." set status='".($c_status)."' where id in (".implode(",",$id).")");
		return true;
	}

	function updateused($db,$id,$is_used)
	{
		if($is_used==0){
			$c_is_used=1;
		}else if($is_used==1){
			$c_is_used=0;
		}
		$db->query("update ".INVITE_PRIZE_RECORDS_TABLE." set is_used='".($c_is_used)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_is_used($db,$id){
		$db->query("update ".INVITE_PRIZE_RECORDS_TABLE." set is_used=1,used_time=".time()." where id=".$id);
		return true;
	}

	function update_userid($db,$userid,$share_user,$id){
		$db->query("update ".INVITE_PRIZE_RECORDS_TABLE." set userid=".$userid.",is_share=1,share_user=".$share_user." where id=".$id);
		return true;
	}
}
?>
