<?php
if (!defined('SCRIPT_ROOT'))
	die("no permission");
define('USER_TABLE', "user");
class userBean {
	function search($db, $page, $per, $type = -1, $status = -1, $condition = '', $keys = '', $name = '', $minfo = '', $starttime = 0, $endtime = 0, $add_type = -1) {
		$sql = "select * from " . USER_TABLE . " where id>0";
		if ($type > -1) {
			$sql .= " and type ='" . $type . "'";
		}
		if ($status > -1) {
			$sql .= " and status ='" . $status . "'";
		}
		if ($name != '') {
			$sql .= " and name like '%" . $name . "%' ";
		}
		if ($minfo != '邀请码搜索') {
			$sql .= " and minfo like '%" . $minfo . "%'";
		}
		if ($starttime > 0) {
			$sql .= " and addTime >=" . $starttime;
		}
		if ($endtime > 0) {
			$sql .= " and addTime <=" . $endtime;
		}
		if ($add_type > -1) {
			$sql .= " and add_type =" . $add_type;
		}
		//屏蔽掉超级管理员
		$sql .= " and id <> '1'";
		$sql .= " order by sorting asc,id desc";
		//echo $sql;
		$pager = get_pager_data($db, $sql, $page, $per);
		return $pager;
	}

	function update_telphone($db, $userid, $telephone) {
		$sql = "update " . USER_TABLE . " set tel='" . $telephone . "' where id='" . $userid . "'";
		$db->query($sql);
		return true;
	}
	function get_excel_results($db, $type, $status, $condition, $keys, $name = '', $starttime, $endtime) {
		$sql = "select * from " . USER_TABLE . " where id>0";
		if ($type > -1) {
			$sql .= " and type ='" . $type . "'";
		}
		if ($status > -1) {
			$sql .= " and status ='" . $status . "'";
		}
		if ($name != '') {
			$sql .= " and name like '%" . $name . "%'";
		}
		if ($starttime > 0) {
			$sql .= " and addTime >=" . $starttime;
		}
		if ($endtime > 0) {
			$sql .= " and addTime <=" . $endtime;
		}
		//屏蔽掉超级管理员
		$sql .= " and id <> '1'";
		$sql .= " order by sorting asc,id desc";
		return $db->get_results($sql);
	}

	function get_results($db, $keys) {
		$sql = "select * from " . USER_TABLE;
		if ($keys != '') {
			$sql .= " where classid=" . $keys;
		}
		$sql .= " order by sorting asc,id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_agent($db, $userid) {
		$sql = "select * from " . USER_TABLE . " where id in(select userid from user_connection where fuserid='" . $userid . "') order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function detail($db, $id) {
		$sql = "select * from " . USER_TABLE . " where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_username($db, $username, $phone, $email) {
		$sql = "select * from " . USER_TABLE . " where (username='" . $username . "' or phone='" . $phone . "' or email='" . $email . "')";
		return $db->get_row($sql);
	}

	function detail_minfo($db, $minfo = 0) {
		$sql = "select * from " . USER_TABLE . " where minfo='" . $minfo . "' order by id desc limit 0,1";
		return $db->get_row($sql);
	}

	function detail_openid($db, $openid) {
		$sql = "select * from " . USER_TABLE . " where openid='" . $openid . "'";
		return $db->get_row($sql);
	}

	function deletedate($db, $id) {
		$db->query("delete from " . USER_TABLE . " where id in (" . implode(",", $id) . ")");
		return true;
	}

	function create_openid($openid, $name, $sex, $minfo = '', $fminfo = '', $db) {
		($name == null) && $name = '';
		$sql = "insert into " . USER_TABLE . " (status,openid,name,sex,addTime,minfo,fminfo) values ('1','" . $openid . "','" . $name . "','" . intval($sex) . "','" . time() . "','" . $minfo . "','" . $fminfo . "')";

		$KFile = DATA_DIR.'/user_txt.txt';
		$KContent = $sql . "\n";
		file_put_contents($KFile, $KContent, FILE_APPEND);

		$db->query($sql);
		$uid = $db->insert_id;
		return $uid;
	}

	function create($type, $level, $status, $sorting, $username, $pass, $name, $sex, $birthday, $email, $tel, $phone, $lastaccess, $landing_num, $integral, $invitation_name, $isread, $openid, $addTime, $minfo, $privileges, $db) {
		$db->query("insert into " . USER_TABLE . " (type,level,status,sorting,username,pass,name,sex,birthday,email,tel,phone,lastaccess,landing_num,integral,invitation_name,isread,openid,addTime,minfo,privileges) values ('" . $type . "','" . $level . "','" . $status . "','" . $sorting . "','" . $username . "','" . $pass . "','" . $name . "','" . $sex . "','" . $birthday . "','" . $email . "','" . $tel . "','" . $phone . "','" . $lastaccess . "','" . $landing_num . "','" . $integral . "','" . $invitation_name . "','" . $isread . "','" . $openid . "','" . $addTime . "','" . $minfo . "','" . $privileges . "')");
		$uid = $db->insert_id;
		return $uid;
	}
	function create2($type, $level, $status, $sorting, $username, $pass, $name, $sex, $birthday, $email, $tel, $phone, $lastaccess, $landing_num, $integral, $invitation_name, $isread, $openid, $addTime, $minfo, $privileges, $head_image, $db) {
		$db->query("insert into " . USER_TABLE . " (type,level,status,sorting,username,pass,name,sex,birthday,email,tel,phone,lastaccess,landing_num,integral,invitation_name,isread,openid,addTime,minfo,privileges,head_image) values ('" . $type . "','" . $level . "','" . $status . "','" . $sorting . "','" . $username . "','" . $pass . "','" . $name . "','" . $sex . "','" . $birthday . "','" . $email . "','" . $tel . "','" . $phone . "','" . $lastaccess . "','" . $landing_num . "','" . $integral . "','" . $invitation_name . "','" . $isread . "','" . $openid . "','" . $addTime . "','" . $minfo . "','" . $privileges . "','" . $head_image . "')");
		$uid = $db->insert_id;
		return $uid;
	}

	function update($type = -1, $level = -1, $status = -1, $sorting = -1, $username = null, $pass = null, $name = null, $sex = -1, $birthday = null, $email = null, $tel = null, $phone = null, $lastaccess = -1, $landing_num = -1, $integral = -1, $invitation_name = null, $isread = -1, $openid = null, $addTime = -1, $privileges = null, $db, $id) {
		$update_values = "";
		if (!empty ($image)) {
			$imagename = "images='" . $image . "',";
		}
		if ($type > 0) {
			$update_values .= "type='" . $type . "',";
		}
		if ($level > 0) {
			$update_values .= "level='" . $level . "',";
		}
		if ($status > 0) {
			$update_values .= "status='" . $status . "',";
		}
		if ($sorting > 0) {
			$update_values .= "sorting='" . $sorting . "',";
		}
		if ($username != null) {
			$update_values .= "username='" . $username . "',";
		}
		if ($pass != null) {
			$update_values .= "pass='" . $pass . "',";
		}
		if ($name != null) {
			$update_values .= "name='" . $name . "',";
		}
		if ($sex > 0) {
			$update_values .= "sex='" . $sex . "',";
		}
		if ($birthday != null) {
			$update_values .= "birthday='" . $birthday . "',";
		}
		if ($email != null) {
			$update_values .= "email='" . $email . "',";
		}
		if ($tel != null) {
			$update_values .= "tel='" . $tel . "',";
		}
		if ($phone != null) {
			$update_values .= "phone='" . $phone . "',";
		}
		if ($lastaccess > 0) {
			$update_values .= "lastaccess='" . $lastaccess . "',";
		}
		if ($landing_num > 0) {
			$update_values .= "landing_num='" . $landing_num . "',";
		}
		if ($integral > 0) {
			$update_values .= "integral='" . $integral . "',";
		}
		if ($invitation_name != null) {
			$update_values .= "invitation_name='" . $invitation_name . "',";
		}
		if ($isread > 0) {
			$update_values .= "isread='" . $isread . "',";
		}
		if ($openid != null) {
			$update_values .= "openid='" . $openid . "',";
		}
		if ($addTime > 0) {
			$update_values .= "addTime='" . $addTime . "',";
		}
		if ($privileges != null) {
			$update_values .= "privileges='" . $privileges . "',";
		}
		$db->query("update " . USER_TABLE . " set {$imagename} " . substr($update_values, 0, $update_values . strlen - 1) . " where id=" . $id);
		return true;
	}
	function update2($type = -1, $level = -1, $status = -1, $sorting = -1, $username = null, $pass = null, $name = null, $sex = -1, $birthday = null, $email = null, $tel = null, $phone = null, $lastaccess = -1, $landing_num = -1, $integral = -1, $invitation_name = null, $isread = -1, $openid = null, $addTime = -1, $privileges = null, $head_image = null, $db, $id) {
		$update_values = "";
		if (!empty ($image)) {
			$imagename = "images='" . $image . "',";
		}
		if ($type > 0) {
			$update_values .= "type='" . $type . "',";
		}
		if ($level > 0) {
			$update_values .= "level='" . $level . "',";
		}
		if ($status > 0) {
			$update_values .= "status='" . $status . "',";
		}
		if ($sorting > 0) {
			$update_values .= "sorting='" . $sorting . "',";
		}
		if ($username != null) {
			$update_values .= "username='" . $username . "',";
		}
		if ($pass != null) {
			$update_values .= "pass='" . $pass . "',";
		}
		if ($name != null) {
			$update_values .= "name='" . $name . "',";
		}
		if ($sex > 0) {
			$update_values .= "sex='" . $sex . "',";
		}
		if ($birthday != null) {
			$update_values .= "birthday='" . $birthday . "',";
		}
		if ($email != null) {
			$update_values .= "email='" . $email . "',";
		}
		if ($tel != null) {
			$update_values .= "tel='" . $tel . "',";
		}
		if ($phone != null) {
			$update_values .= "phone='" . $phone . "',";
		}
		if ($lastaccess > 0) {
			$update_values .= "lastaccess='" . $lastaccess . "',";
		}
		if ($landing_num > 0) {
			$update_values .= "landing_num='" . $landing_num . "',";
		}
		if ($integral > 0) {
			$update_values .= "integral='" . $integral . "',";
		}
		if ($invitation_name != null) {
			$update_values .= "invitation_name='" . $invitation_name . "',";
		}
		if ($isread > 0) {
			$update_values .= "isread='" . $isread . "',";
		}
		if ($openid != null) {
			$update_values .= "openid='" . $openid . "',";
		}
		if ($addTime > 0) {
			$update_values .= "addTime='" . $addTime . "',";
		}
		if ($privileges != null) {
			$update_values .= "privileges='" . $privileges . "',";
		}
		if ($head_image != null) {
			$update_values .= "head_image='" . $head_image . "',";
		}
		$db->query("update " . USER_TABLE . " set {$imagename} " . substr($update_values, 0, $update_values . strlen - 1) . " where id=" . $id);
		return true;
	}

	function updatestate($db, $id, $state) {
		if ($state == 0) {
			$c_state = 1;
		} else
			if ($state == 1) {
				$c_state = 0;
			}
		$db->query("update " . USER_TABLE . " set status='" . ($c_state) . "' where id in (" . implode(",", $id) . ")");
		return true;
	}

	function update_pass($db, $pass, $userid) {
		$db->query("update " . USER_TABLE . " set pass='" . $pass . "' where id='" . $userid . "'");
		return true;
	}

	function update_integral($db, $integral, $userid) {
		$sql = "update " . USER_TABLE . " set integral=integral+'" . $integral . "' where id='" . $userid . "'";
		$db->query($sql);
		return true;
	}
	function update_name($db, $name, $id) {

		$sql = "update user set name='" . $name . "' where id=" . $id;
		$db->query($sql);
		return true;
	}
	function change_fminfo($db, $userid, $fminfo) {
		$sql = "update " . USER_TABLE . " set fminfo='" . $fminfo . "' where id='" . $userid . "'";
		//		echo $sql;
		$db->query($sql);
		return true;
	}

	function update_wxinfo($db, $name, $sex, $head_image, $userid) {
		$sql = "update " . USER_TABLE . " set name='" . $name . "',sex='" . intval($sex) . "',head_image='" . $head_image . "',is_attention=1 where id='" . $userid . "'";
		$db->query($sql);
		return true;
	}

	function update_add_type($db, $userid, $add_type) {
		$sql = "update " . USER_TABLE . " set add_type='" . $add_type . "' where id='" . $userid . "'";
		$db->query($sql);
		return true;
	}

	function add_redbag_number($db, $userid) {
		$sql = "update " . USER_TABLE . " set redbag_number=redbag_number+1 where id='" . $userid . "'";
		$db->query($sql);
		return true;
	}

	function minus_redbag_number($db, $userid) {
		$sql = "update " . USER_TABLE . " set redbag_number=redbag_number-1 where id='" . $userid . "'";
		$db->query($sql);
		return true;
	}

	function update_head_image($db, $id, $head_image) {
		$sql = "update " . USER_TABLE . " set head_image='" . $head_image . "' where id=" . $id;

		$db->query($sql);
		return true;
	}

	function update_source($db, $id, $source) {
		$sql = "update " . USER_TABLE . " set source='" . $source . "' where id=" . $id;
		$db->query($sql);
		return true;
	}

	function update_name_tel($db, $name, $tel, $id) {

		$sql = "update user set name='" . $name . "',tel='" . $tel . "' where id=" . $id;
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

			$strSQL = "UPDATE ".USER_TABLE." SET {$strVal} WHERE 1=1 {$strWhere}";
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
			$strSQL = "INSERT INTO ".USER_TABLE." ($strKey) VALUES({$strVal})";

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

		$strSQL = "SELECT {$strCol} FROM ".USER_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
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

		$strSQL = "DELETE FROM ".USER_TABLE." WHERE 1=1 {$strWhere} ";
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

		$strSQL = "SELECT {$strCol} FROM ".USER_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
		return $db->get_row($strSQL);
	}

}
?>