<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('USER_CONNECTION_TABLE',"user_connection");
class user_connectionBean
{
	function search($db,$page,$per,$userid=0,$type=0,$condition='',$keys='',$name='')
	{
		$sql = "select * from ".USER_CONNECTION_TABLE." where id>0";
		if($userid>0){
			$sql.=" and (userid ='".$userid."' or fuserid='".$userid."')";
		}
		if($type>0){
			$sql.=" and type ='".$type."'";
		}
		if($name != ''){
			$userids = $db->get_col("select id from user where name like '".$name."'");
			$sql .=" and (userid in(".implode($userids).") or fuserid in(".implode($userids)."))";
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
	function get_results_fuserid($db,$fuserid){
		$sql = "select * from ".USER_CONNECTION_TABLE." where fuserid='".$fuserid."'";
		return $db->get_results($sql);
	}
	function get_results($db,$keys)
	{
		$sql = "select * from ".USER_CONNECTION_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_user_connection($db,$userid){
		$sql = "select fuserid userid from ".USER_CONNECTION_TABLE." where userid='".$userid."'";
		$sql .= " union ";
		$sql .= " select userid from ".USER_CONNECTION_TABLE." where fuserid='".$userid."'";
	//	echo $sql;
		return $db->get_col($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".USER_CONNECTION_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_userid($db,$userid){
		$sql = "select * from ".USER_CONNECTION_TABLE." where userid='".$userid."'";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
	$db->query("delete from ".USER_CONNECTION_TABLE." where id in (".implode(",",$id).")");
	return true;
	}

	function create($userid,$fuserid,$minfo,$type,$db)
	{
		$db->query("insert into ".USER_CONNECTION_TABLE." (userid,fuserid,minfo,type,addtime) values ('".$userid."','".$fuserid."','".$minfo."','".$type."','".time()."')");
		return true;
	}

	function update($userid=-1,$fuserid=-1,$minfo=null,$type=-1,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($fuserid>0){
			$update_values.="fuserid='".$fuserid."',";
		}
		if($minfo!=null){
			$update_values.="minfo='".$minfo."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		$db->query("update ".USER_CONNECTION_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".USER_CONNECTION_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
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

			$strSQL = "UPDATE ".USER_CONNECTION_TABLE." SET {$strVal} WHERE 1=1 {$strWhere}";
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
			$strSQL = "INSERT INTO ".USER_CONNECTION_TABLE." ($strKey) VALUES({$strVal})";

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

		$strSQL = "SELECT {$strCol} FROM ".USER_CONNECTION_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
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

		$strSQL = "DELETE FROM ".USER_CONNECTION_TABLE." WHERE 1=1 {$strWhere} ";
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

		$strSQL = "SELECT {$strCol} FROM ".USER_CONNECTION_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
		return $db->get_row($strSQL);
	}

}
?>