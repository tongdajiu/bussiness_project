<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('USER_ADDRESS_TABLE',"user_address");
class user_addressBean
{
	function search($db,$page,$per,$userid=0,$status=0,$condition='',$keys='',$name='')
	{
		$sql = "select * from ".USER_ADDRESS_TABLE." where id>0";
		if($userid>0){
			$sql.=" and userid ='".$userid."'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($name!=''){
			$users = $db->get_col("select id from user where name like '%".$name."%'");
			$id_str = implode(",",$users);
			$sql .= " and userid in(".$id_str.")";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".USER_ADDRESS_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".USER_ADDRESS_TABLE." where userid='".$userid."' order by id desc";
		return $db->get_results($sql);
	}

	function get_last_address($db,$userid){
		$sql = "select * from ".USER_ADDRESS_TABLE." where userid='".$userid."' order by id desc limit 0,1";
		return $db->get_row($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_ADDRESS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_address($db,$userid,$address){
		$sql = "select * from ".USER_ADDRESS_TABLE." where userid='".$userid."' and address='".$address."'";
		return $db->get_row($sql);
	}

	function detail_userid($db,$userid){
		$sql = "select * from ".USER_ADDRESS_TABLE." where userid='".$userid."' order by id desc limit 1";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".USER_ADDRESS_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
		function deletedate_user($db,$id,$userid)
	{
	//echo  "delete from ".USER_ADDRESS_TABLE." where id in (".implode(",",$id).") and userid=".$userid;
		$db->query("delete from ".USER_ADDRESS_TABLE." where id in (".implode(",",$id).") and userid=".$userid);
		return true;
	}

	function create($userid,$status,$chick,$city,$area,$address,$shipping_firstname,$telephone,$db)
	{
		//echo  "insert into ".USER_ADDRESS_TABLE." (userid,status,chick,city,area,address,shipping_firstname,telephone) values ('".$userid."','".$status."','".$chick."','".$city."','".$area."','".$address."','".$shipping_firstname."','".$telephone."')";
		$db->query("insert into ".USER_ADDRESS_TABLE." (userid,status,chick,city,area,address,shipping_firstname,telephone) values ('".$userid."','".$status."','".$chick."','".$city."','".$area."','".$address."','".$shipping_firstname."','".$telephone."')");
		return true;
	}

	function update($userid=-1,$status=-1,$chick=-1,$city=null,$area=null,$address=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($chick>0){
			$update_values.="chick='".$chick."',";
		}
		if($city!=null){
			$update_values.="city='".$city."',";
		}
		if($area!=null){
			$update_values.="area='".$area."',";
		}
		if($address!=null){
			$update_values.="address='".$address."',";
		}
		$db->query("update ".USER_ADDRESS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_ADDRESS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	/**
	 * 更新数据
	 *
	 *@param object $db 			数据库链接
	 *@param array	$arrParam		需要更新的数据
	 *@param array	$arrCondition	匹配条件
	 *@return Integer
	 */
	function updateNew($db,$arrParam,$arrCondition)
	{
		$rs = '';
		if ( is_array($arrParam) )
		{
			foreach( $arrParam as $key=>$val )
			{
				$arrVal[] = "`{$key}`='{$db->escape($val)}'";
				$strVal = implode(',',$arrVal);
			}

			foreach ( $arrCondition as $key=>$val )
			{
				$arrVal2[] = " AND `{$key}`='{$db->escape($val)}'";
				$strWhere = implode('',$arrVal2);
			}

			$strSQL = "UPDATE ".USER_ADDRESS_TABLE." SET {$strVal} WHERE 1=1 {$strWhere}";
			$rs =  $db->query($strSQL);
		}

		return $rs;

	}

	/**
	 * 添加数据
	 *
	 *@param object $db 			数据库链接
	 *@param array	$arrParam		需要添加的数据
	 *@return Integer
	 */
	function createNew( $db, $arr )
	{
		$rs = '';
		if ( is_array($arr) )
		{
			foreach( $arr as $key=>$val )
			{
				$arrKey[] = "`".$key."`";
				$arrVal[] = "'".$db->escape($val)."'";

				$strKey = implode(',',$arrKey);
				$strVal = implode(',',$arrVal);
			}
			$strSQL = "INSERT INTO ".USER_ADDRESS_TABLE." ($strKey) VALUES({$strVal})";

			if ( $db->query($strSQL) > 0 )
			{
				$rs =  $db->insert_id;
			}
			else
			{
				$rs = 0;
			}
		}

		return $rs;
	}

	/**
	 * 查找数据(多记录)
	 * @param object 	$db			数据库链接
	 * @param array		$arrWhere 	要查询的条件
	 * @param array		$arrCol 	要输出的列
	 * @param string	$strOrderBy	排序
	 * @return array
	 */
	function get_list( $db, $arrWhere, $arrCol = '', $strOrderBy = '' )
	{
		$strWhere = "";
		$strCol   = "*";
		$OrderBy  = "";

		if ( is_array( $arrWhere ) )
		{
			foreach ( $arrWhere as $key=>$val )
			{
				$arrVal2[] = " AND `{$key}`='{$db->escape($val)}'";
				$strWhere = implode(' ',$arrVal2);
			}
		}

		if ( is_array( $arrCol ) )
		{
			$strCol = implode(',',$arrCol);
		}

		if ( $strOrderBy != "" )
		{
			$OrderBy = "ORDER BY " . $strOrderBy;
		}

		$strSQL = "SELECT {$strCol} FROM ".USER_ADDRESS_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
		return $db->get_results($strSQL);
	}


	 /**
	 * 删除数据
	 * @param object 	$db			数据库链接
	 * @param array		$arrWhere 	要删除的条件
	 * @return integer
	 */
	function del( $db, $arrWhere )
	{
		$strWhere = "";

		if ( is_array( $arrWhere ) )
		{
			foreach ( $arrWhere as $key=>$val )
			{
				$arrVal2[] = " AND `{$key}`='{$db->escape($val)}'";
				$strWhere = implode(' ',$arrVal2);
			}
		}

		$strSQL = "DELETE FROM ".USER_ADDRESS_TABLE." WHERE 1=1 {$strWhere} ";
		return $db->query($strSQL);
	}

	/**
	 * 功能： 查找数据(单一记录)
	 *
	 * 参数：
	 * @param object	$db			数据库链接
	 * @param array		$arrWhere	要查询的条件
	 * @param array		$arrCol		要输出的列
	 * @return object
     * */
	function get_one( $db, $arrWhere, $arrCol = '', $strOrderBy = '' )
	{
		$strWhere = "";
		$strCol   = "*";
		$OrderBy = "";

		if ( is_array( $arrWhere ) )
		{
			foreach ( $arrWhere as $key=>$val )
			{
				$arrVal2[] = " AND `{$key}`='{$db->escape($val)}'";
				$strWhere = implode(' ',$arrVal2);
			}
		}

		if ( is_array( $arrCol ) )
		{
			$strCol = implode(',',$arrCol);
		}

		if ( $strOrderBy != "" )
		{
			$OrderBy = "ORDER BY " . $strOrderBy;
		}

		$strSQL = "SELECT {$strCol} FROM ".USER_ADDRESS_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
		return $db->get_row($strSQL);
	}

}
?>