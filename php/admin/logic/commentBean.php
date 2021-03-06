<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('COMMENT_TABLE',"comment");
class commentBean
{
	function search($db,$page,$per,$condition,$keys,$score)
	{
		$sql = "select * from ".COMMENT_TABLE." where id>0";
		if($score > -1){
			$sql.=" and score=".$score;
		}
		if($condition == 'order_number'){
			$sql.=" and order_number=".$keys;
		}
		if($condition == 'shipping_firstname'){
			$sql.=" and shipping_firstname='".$keys."'";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".COMMENT_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_product($db,$product_id){
		$sql = "select * from ".COMMENT_TABLE." where product_id='".$product_id."' order by id desc";
		return $db->get_results($sql);
	}

	function get_results_order($db,$order_id){
		$sql = "select * from ".COMMENT_TABLE." where order_id='".$order_id."'";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".COMMENT_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_order_product($db,$order_id,$product_id){
		$sql = "select * from ".COMMENT_TABLE." where order_id='".$order_id."' and product_id='".$product_id."'";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".COMMENT_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($order_id,$order_number,$product_id,$score,$customer_id,$shipping_firstname,$comment,$db)
	{
		$db->query("insert into ".COMMENT_TABLE." (order_id,order_number,product_id,score,customer_id,shipping_firstname,addtime,comment) values ('".$order_id."','".$order_number."','".$product_id."','".$score."','".$customer_id."','".$shipping_firstname."','".time()."','".$comment."')");
		return true;
	}

	function update($order_id=-1,$order_number=-1,$product_id=0,$score=-1,$customer_id=-1,$shipping_firstname=null,$comment=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($order_id>0){
			$update_values.="order_id='".$order_id."',";
		}
		if($order_number>0){
			$update_values.="order_number='".$order_number."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($score>0){
			$update_values.="score='".$score."',";
		}
		if($customer_id>0){
			$update_values.="customer_id='".$customer_id."',";
		}
		if($shipping_firstname!=null){
			$update_values.="shipping_firstname='".$shipping_firstname."',";
		}
		if($comment!=null){
			$update_values.="comment='".$comment."',";
		}
//		echo "update ".COMMENT_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		$db->query("update ".COMMENT_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".COMMENT_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
