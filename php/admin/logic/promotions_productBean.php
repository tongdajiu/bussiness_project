<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PROMOTIONS_PRODUCT_TABLE',"promotions_product");
class promotions_productBean
{
	function search($db,$page,$per,$status=0,$condition='',$keys='',$p_id=0)
	{
		$sql = "select * from ".PROMOTIONS_PRODUCT_TABLE." where id>0";
			if($status>-1){
				$sql.=" and status ='".$status."'";
			}
			if($condition == 'title'){
				$promotions = $db->get_col("select id from promotions_new where title like '%".$keys."%'");
				$id_str = implode(",",$promotions);
				$sql.=" and p_id in(".$id_str.")";
			}
			if($condition == 'product'){
				$products = $db->get_col("select product_id from product where name like '%".$keys."%'");
				$id_str = implode(",",$products);
				$sql.=" and product_id in (".$id_str.")";
			}
			if($p_id > 0){
				$sql .= " and p_id = '".$p_id."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	
	function get_results($db,$keys)
	{
		$sql = "select * from ".PROMOTIONS_PRODUCT_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	
	function get_all_promotion_now_time($db){
		$sql = "select pp.product_id,pn.* from ".PROMOTIONS_PRODUCT_TABLE." as pp inner join promotions_new as pn on pn.id=pp.p_id where pp.id>0";
		$nowtime=time();
		$sql.=" and pn.start_time<".$nowtime." and pn.end_time>".$nowtime;
		$sql.=" and pn.status=1 order by pn.end_time asc";
		//echo $sql;
		return $db->get_results($sql);
	}
	function get_all_promotion_next_time($db){
		$sql = "select pp.product_id,pn.* from ".PROMOTIONS_PRODUCT_TABLE." as pp inner join promotions_new as pn on pn.id=pp.p_id where pp.id>0";
		$nowtime=time();
		$sql.=" and pn.start_time>".$nowtime;
		$sql.=" and pn.status=1 order by pn.end_time asc";
		//echo "<br/>".$sql;
		return $db->get_results($sql);
	}

	function get_results_promotion($db,$p_id){
		$sql = "select * from ".PROMOTIONS_PRODUCT_TABLE." where p_id='".$p_id."' order by id desc";
		return $db->get_results($sql);
	}

	function get_index_product($db){
		$sql = "select * from ".PROMOTIONS_PRODUCT_TABLE." order by sorting asc,id desc limit 3";
		return $db->get_results($sql);
	}
	
	function detail($db,$id)
	{
		$sql = "select * from ".PROMOTIONS_PRODUCT_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	
	function detail_product($db,$pid,$product_id){
		$sql = "select * from ".PROMOTIONS_PRODUCT_TABLE." where product_id='".$product_id."' and p_id='".$pid."'";
		return $db->get_row($sql);
	}
	
	function deletedate($db,$id)
	{
		$db->query("delete from ".PROMOTIONS_PRODUCT_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	
	function create($status,$sorting,$p_id,$product_id,$number,$db)
	{		
		$db->query("insert into ".PROMOTIONS_PRODUCT_TABLE." (status,sorting,p_id,product_id,addtime,number) values ('".$status."','".$sorting."','".$p_id."','".$product_id."','".time()."','".$number."')");
		return true;
	}
	
	function update($status=-1,$sorting=-1,$p_id=-1,$product_id=-1,$number=-1,$db,$id)
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
		if($p_id>0){
			$update_values.="p_id='".$p_id."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($number > -1){
			$update_values.="number='".$number."',";
		}
		$db->query("update ".PROMOTIONS_PRODUCT_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PROMOTIONS_PRODUCT_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
