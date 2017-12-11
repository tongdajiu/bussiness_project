<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PRODUCT_PHASE_TABLE',"product_phase");
class product_phaseBean
{
	function search($db,$page,$per,$userid='',$status=0,$condition='',$keys='',$name='',$product_id)
	{
		$sql = "select * from ".PRODUCT_PHASE_TABLE." where id>0 and product_id = $product_id ";
		if($userid!=''){
			$sql.=" and userid like '%".$userid."%'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($name!=''){
			$products = $db->get_col("select product_id from product where name like '%".$name."%'");
			$id_str = implode(",",$products);
			$sql .= " and product_id in(".$id_str.")";
		}
		$sql.=" order by sorting asc , id desc";
//		echo $sql;
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".PRODUCT_PHASE_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_product_id($db,$product_id){
		$sql = "select * from ".PRODUCT_PHASE_TABLE." where product_id='".$product_id."' and status=1 and sale_status=1";
		$sql .= " order by id desc";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PRODUCT_PHASE_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".PRODUCT_PHASE_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($phase_number,$product_id,$total_amount,$limit_amount,$title,$description,$sorting,$status,$sale_status,$starttime,$endtime,$finishtime,$final_lucky_number,$addtime,$db)
	{
		$db->query("insert into ".PRODUCT_PHASE_TABLE." (phase_number,product_id,total_amount,limit_amount,title,description,sorting,status,sale_status,starttime,endtime,finishtime,final_lucky_number,addtime) values ('".$phase_number."','".$product_id."','".$total_amount."','".$limit_amount."','".$title."','".$description."','".$sorting."','".$status."','".$sale_status."','".$starttime."','".$endtime."','".$finishtime."','".$final_lucky_number."','".$addtime."')");
		return true;
	}

	function update($phase_number=null,$product_id=-1,$total_amount=-1,$limit_amount=-1,$title=null,$description=null,$sorting=-1,$status=-1,$sale_status=-1,$starttime=-1,$endtime=-1,$finishtime=-1,$final_lucky_number=null,$addtime=-1,$db,$id)
	{
		$update_values="";
		if($phase_number!=null){
			$update_values.="phase_number='".$phase_number."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($total_amount>0){
			$update_values.="total_amount='".$total_amount."',";
		}
		if($limit_amount>0){
			$update_values.="limit_amount='".$limit_amount."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($description!=null){
			$update_values.="description='".$description."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($sale_status>0){
			$update_values.="sale_status='".$sale_status."',";
		}
		if($starttime>0){
			$update_values.="starttime='".$starttime."',";
		}
		if($endtime>0){
			$update_values.="endtime='".$endtime."',";
		}
		if($finishtime>0){
			$update_values.="finishtime='".$finishtime."',";
		}
		if($final_lucky_number!=null){
			$update_values.="final_lucky_number='".$final_lucky_number."',";
		}
		if($addtime>0){
			$update_values.="addtime='".$addtime."',";
		}
		$db->query("update ".PRODUCT_PHASE_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
//		echo "update ".PRODUCT_PHASE_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PRODUCT_PHASE_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
	
	function update_final_lucky_number($db,$id,$final_lucky_number){
		$sql = "update ".PRODUCT_PHASE_TABLE." set final_lucky_number=".$final_lucky_number.",sale_status=3,endtime=".time().",finishtime=".time()." where id=".$id;
		$db->query($sql);
		return true;
	}
}
?>
