<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('SHOP_PRIZE_TABLE',"shop_prize");
class shop_prizeBean
{
	function search($db,$page,$per,$status=0,$condition='',$keys='',$shop_id)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE." where id>0 and shop_id=".$shop_id;


			if($status>-1){
				$sql.=" and status='".$status."'";
			}
			if($condition=="title"){
				$sql.=" and title like '%".$keys."%'";
			}

		$sql.=" order by sorting asc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	function search2($db,$page,$per,$condition='',$keys='',$shop_id)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE." where id>0 and shop_id=".$shop_id;

			if($keys!=null){
				$sql.=" and name like '%".$keys."%'";
			}

		$sql.=" order by sorting asc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	function search3($db,$page,$per,$condition='',$keys='')
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE." where id>0 ";

			if($keys!=null){
				$sql.=" and name like '%".$keys."%'";
			}

		$sql.=" order by probability desc,addtime desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc, id desc, addtime desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_accounts($db)
	{
		$sql = "select sum(account) from ".SHOP_PRIZE_TABLE." where status=1 ";
		$list = $db->get_var($sql);
		return $list;
	}

	function get_results_shop($db,$shop_id)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE;
		if($shop_id!=''){
			$sql.=" where shop_id=".$shop_id;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_results_shop2($db)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE." where id>0 ";

		$sql.=" and status=1  order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db,$id)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detailByType($db,$type)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE." where type = {$type}";
		$sql .= " and status=1 order by sorting asc";
		$list = $db->get_results($sql);
		return $list;
	}
	function detail_source($db,$source)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE." where source=".$source;
		$sql .= " and status=1 order by sorting asc";
		$list = $db->get_results($sql);
		return $list;
	}
	function detail_source2($db,$id,$source)
	{
		$sql = "select * from ".SHOP_PRIZE_TABLE." where id>0 ";
		if($id>-1){
				$sql.=" and id=".$id;
		}
		if($source>-1){
				$sql.=" and source=".$source;
		}
		$sql .= " and status=1 order by sorting asc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detailByShopId($db,$shop_id)
	{

		$sql = "select * from ".SHOP_PRIZE_TABLE." where shop_id={$shop_id}";
		$sql .= " order by sorting asc";
		$obj = $db->get_results($sql);
		return $obj;
	}
	function detailByShopId2($db,$shop_id)
	{

		$sql = "select * from ".SHOP_PRIZE_TABLE." where shop_id={$shop_id}";
		$sql .= " and status=1 order by sorting asc";
		$obj = $db->get_results($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".SHOP_PRIZE_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($shop_id,$image,$name,$prize_no,$probability,$sorting,$status,$source,$introduce,$account,$db)

	{
		$sql = "insert into ".SHOP_PRIZE_TABLE." (shop_id, image, name, prize_no, probability, sorting,status,source,introduce,account,addtime) values ('".$shop_id."','".$image."','".$name."','".$prize_no."','".$probability."','".$sorting."','".$status."','".$source."','".$introduce."','".$account."','".time()."')";
		$db->query($sql);
//		echo $sql;
		return true;
	}

	function update($shop_id=-1,$image=null,$name=null,$prize_no=null,$probability=-1,$sorting=-1,$status=-1,$source=-1,$introduce=null,$account=-1,$db,$id)
	{
		$update_values="";
		if (!empty($images))
		{
			$imagename = "images='".$images."',";
		}
		if($shop_id>0){
			$update_values.="shop_id='".$shop_id."',";
		}

		if($image>0){
			$update_values.="image='".$image."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($prize_no!=null){
			$update_values.="prize_no='".$prize_no."',";
		}
		if($probability>0){
			$update_values.="probability='".$probability."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($source>-1){
			$update_values.="source='".$source."',";
		}
		if($introduce>-1){
			$update_values.="introduce='".$introduce."',";
		}
		if($account>-1){
			$update_values.="account='".$account."',";
		}
		$sql = "update ".SHOP_PRIZE_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;

		$db->query($sql);

		return true;
	}
	function update_account($db,$id)
	{

		$sql = "update ".SHOP_PRIZE_TABLE." set account = IF(account<1, 0, account-1) where status=1 and  id=".$id;
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
		$db->query("update ".SHOP_PRIZE_TABLE." set status='".($c_status)."' where id in (".implode(",",$id).")");
		return true;
	}

}
?>
