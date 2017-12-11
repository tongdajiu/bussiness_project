<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PRODUCT_TYPE_TABLE',"product_type");
class product_typeBean
{
	function search($db,$page,$per,$classid)
	{
		$sql = "select * from ".PRODUCT_TYPE_TABLE." where id>0";
		if($classid > -1){
			$sql .= " and classid=".$classid;
		}
		$sql.=" order by sorting asc,id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".PRODUCT_TYPE_TABLE;
		if($keys >= -1){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_resultsFromAltitude($db)
	{
		$classid = $db->get_var("select id from product_type where name='海拔高度'");

		$sql = "select * from ".PRODUCT_TYPE_TABLE;
//获取产品类型中海拔高度的id
//获取父类为海拔高度的子类型
		$sql.=" where classid=".$classid;

		$sql.=" order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_son_number($db,$id){
		$sql = "select count(id) from ".PRODUCT_TYPE_TABLE." where classid='".$id."'";
		return $db->get_var($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PRODUCT_TYPE_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
	$db->query("delete from ".PRODUCT_TYPE_TABLE." where id in (".implode(",",$id).")");
	return true;
	}

	function create($classid,$name,$num,$sorting,$db)
	{
		$db->query("insert into ".PRODUCT_TYPE_TABLE." (classid,name,num,sorting) values ('".$classid."','".$name."','".$num."','".$sorting."')");
		return true;
	}

	function update($classid=-1,$name=null,$num=-1,$sorting=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($classid>0){
			$update_values.="classid='".$classid."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($num>0){
			$update_values.="num='".$num."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		$db->query("update ".PRODUCT_TYPE_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PRODUCT_TYPE_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
