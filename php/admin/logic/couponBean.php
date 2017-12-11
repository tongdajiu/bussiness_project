<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('COUPON_TABLE',"coupon");
class couponBean
{
	function search($db,$page,$per,$userid=-1,$status=0,$type=-1,$condition='',$keys='',$starttime,$endtime,$username='')
	{
		$sql = "select * from ".COUPON_TABLE." where id>0";
		if($userid > -1){
			$sql.=" and userid='".$userid."'";
		}
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($type>-1){
			$sql.=" and type ='".$type."'";
		}
		if($starttime > 0){
			$sql.=" and starttime='".$starttime."'";
		}
		if($endtime > 0){
			$sql.=" and endtime='".$endtime."'";
		}
		if($username!=''){
			$users = $db->get_col("select id from user where name like '%".$username."%'");
			$id_str = implode(',',$users);
			$sql.=" and userid in(".$id_str.")";
		}
		$sql.=" and exp_value>0 order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".COUPON_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_result_coupon_count_value($db,$userid,$exp_value){
		$sql = "select count(*) from ".COUPON_TABLE." where userid='".$userid."' and exp_value='".$exp_value."' and experience=0";
		return $db->get_var($sql);
	}

	function get_results_userid($db,$userid){
		$sql = "select * from ".COUPON_TABLE." where userid='".$userid."' and experience=0 and exp_value>0 order by id desc";
		return $db->get_results($sql);
	}

	function get_result_exp_value($db,$userid,$exp_value){
		$sql = "select * from ".COUPON_TABLE." where userid='".$userid."' and exp_value='".$exp_value."' and experience=0";
		return $db->get_results($sql);
	}

	function get_last_coupon($db,$userid,$exp_value){
		$sql = "select * from ".COUPON_TABLE." where userid='".$userid."' and exp_value='".$exp_value."' and experience=0 and status=1 order by id desc limit 1";
		return $db->get_row($sql);
	}

	function get_excel_results($db,$status=0,$type=-1,$condition='',$keys='',$starttime=0,$endtime=0){
		$sql = "select * from ".COUPON_TABLE." where id>0";
		if($status>-1){
			$sql.=" and status ='".$status."'";
		}
		if($type>-1){
			$sql.=" and type ='".$type."'";
		}
		if($starttime > 0){
			$sql.=" and starttime='".$starttime."'";
		}
		if($endtime > 0){
			$sql.=" and endtime='".$endtime."'";
		}
		$sql.=" order by type asc,id desc";
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".COUPON_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_coupon($db,$car_number)
	{
		$sql = "select * from ".COUPON_TABLE." where card_number = '{$car_number}'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_card_number($db,$card_number){
		$sql = "select * from ".COUPON_TABLE." where card_number='".$card_number."'";
		return $db->get_row($sql);
	}
	function detail_today3($db,$userid){
		$sql = "select * from ".COUPON_TABLE." where addtime>=".strtotime(date('Y-m-d 00:00:00',time()))." and userid=".$userid."   order by id desc";
//		echo $sql;
		return $db->get_results($sql);
	}
	function deletedate($db,$id)
	{
		$db->query("delete from ".COUPON_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($card_number,$exp_value,$starttime,$endtime,$status,$experience,$type,$userid,$db)
	{
		$db->query("insert into ".COUPON_TABLE." (card_number,exp_value,starttime,endtime,status,addtime,experience,type,userid) values ('".$card_number."','".$exp_value."','".$starttime."','".$endtime."','".$status."','".time()."','".$experience."','".$type."','".$userid."')");
		return true;
	}
//邀请人奖励记录
	function create1($card_number,$exp_value,$starttime,$endtime,$status,$fuserid,$userid,$db)
	{
		$db->query("insert into invite_prize_records (card_number,exp_value,starttime,endtime,status,addtime,fuserid,userid) values ('".$card_number."','".$exp_value."','".$starttime."','".$endtime."','".$status."','".time()."','".$fuserid."','".$userid."')");
		return true;
	}

	function update($card_number=null,$exp_value=null,$starttime=-1,$endtime=-1,$status=-1,$experience=-1,$type=-1,$userid=0,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($card_number!=null){
			$update_values.="card_number='".$card_number."',";
		}
		if($exp_value!=null){
			$update_values.="exp_value='".$exp_value."',";
		}
		if($starttime>0){
			$update_values.="starttime='".$starttime."',";
		}
		if($endtime>0){
			$update_values.="endtime='".$endtime."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($experience>0){
			$update_values.="experience='".$experience."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($userid > 0){
			$update_values.="userid='".$userid."'";
		}
		$db->query("update ".COUPON_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".COUPON_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
	function update_user_coupon($db,$userid,$number_coupon)
	{
		$db->query("update ".COUPON_TABLE." set userid='".$userid."' where card_number ='".$number_coupon."'");
		return true;
	}
	function update_owner($db,$id,$userid,$give_userid){
		$sql = "update ".COUPON_TABLE." set userid='".$userid."',give_userid='".$give_userid."' where id='".$id."'";
		$db->query($sql);
		return true;
	}

	function update_experience($db,$id){
		$sql = "update ".COUPON_TABLE." set experience='".time()."' where id='".$id."'";
		$db->query($sql);
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

			$strSQL = "UPDATE ".COUPON_TABLE." SET {$strVal} WHERE 1=1 {$strWhere}";
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
			$strSQL = "INSERT INTO ".COUPON_TABLE." ($strKey) VALUES({$strVal})";

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

		$strSQL = "SELECT {$strCol} FROM ".COUPON_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
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

		$strSQL = "DELETE FROM ".COUPON_TABLE." WHERE 1=1 {$strWhere} ";
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

		$strSQL = "SELECT {$strCol} FROM ".COUPON_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
		return $db->get_row($strSQL);
	}


}
?>