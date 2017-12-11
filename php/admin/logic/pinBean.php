<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PIN_TABLE',"pin");
class pinBean
{
	function search($db,$page,$per,$status=0,$userid=0,$condition='',$keys='')
	{
		$sql = "select * from ".PIN_TABLE." where id>0";
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($userid>0){
				$sql.=" and userid ='".$userid."'";
			}
			if($condition == "username"){
				$users = $db->get_col("select id from user where name like '%".$keys."%'");
				$id_str = implode(',',$users);
				$sql.=" and userid in(".$id_str.")";
			}
			if($condition == "order_num"){
				$order = $db->get_row("select * from orders where order_number='".$keys."'");
				$sql.=" and order_id='".$order->order_id."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function search2($db,$page,$per,$status=0,$userid=0,$condition='',$keys='')
	{
		$sql = "select * from ".PIN_TABLE." where id>0";
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($userid>0){
				$sql.=" and userid ='".$userid."'";
			}
			if($condition == "username"){
				$users = $db->get_col("select id from user where name like '%".$keys."%'");
				$id_str = implode(',',$users);
				$sql.=" and userid in(".$id_str.")";
			}
			if($condition == "order_num"){
				$order = $db->get_row("select * from orders where order_number='".$keys."'");
				$sql.=" and order_id='".$order->order_id."'";
			}
		$sql.=" and pin_type=1 order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".PIN_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select d.type as type,p.* from pin_details d left join ".PIN_TABLE." p on p.id = d.pin_id where d.userid='".$userid."' and p.close_status=0 group by p.id,d.type order by sorting asc,id desc";
		return $db->get_results($sql);
	}

	function get_results_show($db){
		$sql = "select * from ".PIN_TABLE." where show_status=1 and close_status=0 order by sorting asc,id desc";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PIN_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_order($db,$order_id,$userid){
		$sql = "select * from ".PIN_TABLE." where order_id='".$order_id."' and userid='".$userid."'";
		return $db->get_row($sql);
	}
//查询类型为1的pin数据
	function detail_type($db,$id){
		$sql = "select * from ".PIN_TABLE." where id='".$id."' and pin_type=1";
		return $db->get_results($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".PIN_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($status,$price,$name,$title,$content,$sorting,$close_status,$isread,$order_id,$userid,$show_cart,$show_status,$starttime,$endtime,$product_id,$db)
	{
		$db->query("insert into ".PIN_TABLE." (status,price,name,title,content,sorting,close_status,isread,order_id,userid,show_cart,show_status,starttime,endtime,addtime,product_id) values ('".$status."','".$price."','".$name."','".$title."','".$content."','".$sorting."','".$close_status."','".$isread."','".$order_id."','".$userid."','".$show_cart."','".$show_status."','".$starttime."','".$endtime."','".time()."','".$product_id."')");
		$pid=$db->insert_id;
		return $pid;
	}
	function create2($status,$price,$name,$title,$content,$sorting,$close_status,$isread,$order_id,$userid,$show_cart,$show_status,$starttime,$endtime,$product_id,$type,$db)
	{
//		echo "insert into ".PIN_TABLE." (status,price,name,title,content,sorting,close_status,isread,order_id,userid,show_cart,show_status,starttime,endtime,addtime,product_id,pin_type) values ('".$status."','".$price."','".$name."','".$title."','".$content."','".$sorting."','".$close_status."','".$isread."','".$order_id."','".$userid."','".$show_cart."','".$show_status."','".$starttime."','".$endtime."','".time()."','".$product_id."','".$type."')";

		$db->query("insert into ".PIN_TABLE." (status,price,name,title,content,sorting,close_status,isread,order_id,userid,show_cart,show_status,starttime,endtime,addtime,product_id,pin_type) values ('".$status."','".$price."','".$name."','".$title."','".$content."','".$sorting."','".$close_status."','".$isread."','".$order_id."','".$userid."','".$show_cart."','".$show_status."','".$starttime."','".$endtime."','".time()."','".$product_id."','".$type."')");

		$pid=$db->insert_id;

		return $pid;
	}

	function update($status=-1,$price=null,$name=null,$title=null,$content=null,$sorting=-1,$close_status=-1,$isread=-1,$order_id=-1,$userid=-1,$show_cart=-1,$show_status=-1,$starttime=-1,$endtime=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($price!=null){
			$update_values.="price='".$price."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($content!=null){
			$update_values.="content='".$content."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($close_status>0){
			$update_values.="close_status='".$close_status."',";
		}
		if($isread>0){
			$update_values.="isread='".$isread."',";
		}
		if($order_id>0){
			$update_values.="order_id='".$order_id."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($show_cart>0){
			$update_values.="show_cart='".$show_cart."',";
		}
		if($show_status>0){
			$update_values.="show_status='".$show_status."',";
		}
		if($starttime>0){
			$update_values.="starttime='".$starttime."',";
		}
		if($endtime>0){
			$update_values.="endtime='".$endtime."',";
		}
		$db->query("update ".PIN_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	function update2($status=-1,$price=null,$name=null,$title=null,$content=null,$sorting=-1,$close_status=-1,$isread=-1,$order_id=-1,$userid=-1,$show_cart=-1,$show_status=-1,$starttime=-1,$endtime=-1,$type=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($price!=null){
			$update_values.="price='".$price."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($content!=null){
			$update_values.="content='".$content."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($close_status>0){
			$update_values.="close_status='".$close_status."',";
		}
		if($isread>0){
			$update_values.="isread='".$isread."',";
		}
		if($order_id>0){
			$update_values.="order_id='".$order_id."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($show_cart>0){
			$update_values.="show_cart='".$show_cart."',";
		}
		if($show_status>0){
			$update_values.="show_status='".$show_status."',";
		}
		if($starttime>0){
			$update_values.="starttime='".$starttime."',";
		}
		if($endtime>0){
			$update_values.="endtime='".$endtime."',";
		}if($type>0){
			$update_values.="pin_type='".$type."',";
		}
		$db->query("update ".PIN_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

//	@yuzefeng 后台团购编辑 20150508
		function update3($status=-1,$price=null,$name=null,$title=null,$content=null,$sorting=-1,$isread=-1,$close_status=-1,$product_id=-1,$order_id=-1,$userid=-1,$show_cart=-1,$show_status=-1,$starttime=-1,$endtime=-1,$type=-1,$db,$id)
	{
		$update_values="";
/*		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}*/
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($price!=null){
			$update_values.="price='".$price."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($content!=null){
			$update_values.="content='".$content."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($close_status>0){
			$update_values.="close_status='".$close_status."',";
		}
		if($isread>0){
			$update_values.="isread='".$isread."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($order_id>0){
			$update_values.="order_id='".$order_id."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($show_cart>0){
			$update_values.="show_cart='".$show_cart."',";
		}
		if($show_status>0){
			$update_values.="show_status='".$show_status."',";
		}
		if($starttime>0){
			$update_values.="starttime='".$starttime."',";
		}
		if($endtime>0){
			$update_values.="endtime='".$endtime."',";
		}if($type>0){
			$update_values.="pin_type='".$type."',";
		}
		$sql = "update ".PIN_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
//		echo $sql;
		$db->query($sql);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PIN_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_order_number($db,$oid,$pin_id){
		$sql = "update ".PIN_TABLE." set order_id='".$oid."' where id='".$pin_id."'";
		$db->query($sql);
		return true;
	}

	function update_status($db,$pin_status,$pin_id){
		$sql = "update ".PIN_TABLE." set status='".$pin_status."' where id='".$pin_id."'";
		$db->query($sql);
		return true;
	}
}
?>
