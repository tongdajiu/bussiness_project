<?php
if (!defined('SCRIPT_ROOT'))
	die("no permission");
define('ORDERS_TABLE', "orders");
class ordersBean {
	function search($db, $page, $per, $condition, $keys, $starttime = 0, $endtime = 0, $order_type = 0, $order_status_id = '') {
		$sql = "select * from " . ORDERS_TABLE . " where user_del<2";
		if ($condition == 'order_number') {
			$sql .= " and order_number=" . $keys;
		}
		if ($condition == 'phone') {
			$sql .= " and (telephone='" . $keys . "' or cellphone='" . $keys . "')";
		}
		if ($condition == 'shipping_firstname') {
			$sql .= " and shipping_firstname='" . $keys . "'";
		}
		if ($condition == 'username') {
			$users = $db->get_col("select id from user where name like '%" . $keys . "%'");
			$id_str = implode(',', $users);
			$sql .= " and customer_id in(" . $id_str . ")";
		}
		if ($starttime > 0) {
			$sql .= " and addtime>=" . $starttime;
		}
		if ($endtime > 0) {
			$sql .= " and addtime<=" . $endtime;
		}
		if ($order_type > 0) {
			$sql .= " and user_del=" . $order_type;
		}
		if ($order_status_id != null) {
			$sql .= " and order_status_id=" . $order_status_id;
		}

		$sql .= " order by order_id desc";
		$pager = get_pager_data($db, $sql, $page, $per);
		return $pager;
	}
	function search2($db, $page, $per, $settled = null) {
		$sql = "select o.* from " . ORDERS_TABLE . " as o where (select count(c.id) from comment c where c.order_id = o.order_id)>0 and order_status_id=3 and user_del<>2";
		(!is_null($settled) && ($settled != '')) && $sql .= ' AND `settled`=' . $settled;
		$sql .= " order by order_id desc";

		$pager = get_pager_data($db, $sql, $page, $per);
		return $pager;
	}
	function search_user_del($db, $page, $per, $condition, $keys, $starttime = 0, $endtime = 0, $order_type = 0) {
		$sql = "select * from " . ORDERS_TABLE . " where user_del=2";
		if ($condition == 'order_number') {
			$sql .= " and order_number=" . $keys;
		}
		if ($condition == 'phone') {
			$sql .= " and (telephone='" . $keys . "' or cellphone='" . $keys . "')";
		}
		if ($condition == 'shipping_firstname') {
			$sql .= " and shipping_firstname='" . $keys . "'";
		}
		if ($condition == 'username') {
			$users = $db->get_col("select id from user where name like '%" . $keys . "%'");
			$id_str = implode(',', $users);
			$sql .= " and customer_id in(" . $id_str . ")";
		}
		if ($starttime > 0) {
			$sql .= " and addtime>=" . $starttime;
		}
		if ($endtime > 0) {
			$sql .= " and addtime<=" . $endtime;
		}
		$sql .= " order by order_id desc";
		$pager = get_pager_data($db, $sql, $page, $per);
		return $pager;
	}
	function get_excel_results($db, $condition, $keys, $starttime = 0, $endtime = 0) {
		$sql = "select a.product_name,a.product_model,a.product_price,b.* from order_product as a " .
		"left join " . ORDERS_TABLE . " as b on a.order_id = b.order_id where b.order_id>0 and b.user_del<>2 and b.abolishment_status=0";
		if ($condition == 'order_number') {
			$sql .= " and b.order_number=" . $keys;
		}
		if ($condition == 'phone') {
			$sql .= " and (b.telephone='" . $keys . "' or b.cellphone='" . $keys . "')";
		}
		if ($condition == 'shipping_firstname') {
			$sql .= " and b.shipping_firstname='" . $keys . "'";
		}
		if ($starttime > 0) {
			$sql .= " and b.addtime>=" . $starttime;
		}
		if ($endtime > 0) {
			$sql .= " and b.addtime<=" . $endtime;
		}
		$sql .= " order by b.order_id desc";
		return $db->get_results($sql);
	}

	function get_results($db, $keys) {
		$sql = "select * from " . ORDERS_TABLE;
		if ($keys != '') {
			$sql .= " where classid=" . $keys;
		}
		$sql .= " order by order_id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	//*备份查询6/4
	//	function get_results_userid($db,$userid){
	//		$sql = "select * from ".ORDERS_TABLE." where customer_id='".$userid."' order by order_id desc";
	//		return $db->get_results($sql);
	//	}
	//
	function get_results_userid($db, $userid) {
		//		$sql = "select * from ".ORDERS_TABLE." where customer_id='".$userid."'";
		////		if($user_del>0){
		//			$sql.=" and user_del=".$user_del;
		//		}
		$sql = "select * from " . ORDERS_TABLE . " where customer_id='" . $userid . "' and user_del<>2 order by order_id desc";
		//echo $sql;
		return $db->get_results($sql);
	}

	function get_results_not_comment($db, $userid) {
		$sql = "select a.* from " . ORDERS_TABLE . " as a where a.customer_id='" . $userid . "'  and  order_status_id=3  and user_del<>2 ";
		$sql .= " and not EXISTS(select 1 from comment as b where b.order_id = a.order_id)";
		return $db->get_results($sql);
	}

	function get_results_onway($db, $userid) {
		$sql = "select * from " . ORDERS_TABLE . " where customer_id='" . $userid . "' and order_status_id=2 and user_del<>2";
		return $db->get_results($sql);
	}

	function get_order_share_record($db, $userid, $order_id) {
		$sql = "select * from " . INTEGRAL_RECORD_TABLE . " where userid='" . $userid . "' and order_id='" . $order_id . "' and type=5 limit 1";
		return $db->get_row($sql);
	}

	//代理订单
	function get_results_agent($db, $userid, $status = -1, $start_time = 0, $end_time = 0) {
		$join_time = $db->get_var("select join_time from agent_info where userid=" . $userid . " and status=1");
		if ($join_time == null) {
			return null;
		}
		$sql = "select a.* from " . ORDERS_TABLE . " a where (a.customer_id='" . $userid . "' or a.customer_id in (select c.userid from user_connection c where c.fuserid='" . $userid . "')) and a.user_del<>2";
		if ($join_time != null && $join_time > 0) {
			$sql .= " and a.addtime>" . $join_time;
		}
		if ($status > -1) {
			$sql .= " and a.order_status_id='" . $status . "'";
		}
		if ($start_time > 0 && $status == 3) {
			$sql .= " and a.status_time>=" . $start_time;
		} else
			if ($start_time > 0) {
				$sql .= " and a.addtime>=" . $start_time;
			}
		if ($end_time > 0 && $status == 3) {
			$sql .= " and a.status_time<=" . $end_time;
		} else
			if ($start_time > 0) {
				$sql .= " and a.addtime<=" . $end_time;
			}
		$sql .= " order by a.order_id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	//代理订单金额
	function get_all_price_agent($db, $userid, $status = -1, $start_time = 0, $end_time = 0) {
		$join_time = $db->get_var("select join_time from agent_info where userid=" . $userid . " and status=1");
		if ($join_time == null) {
			return null;
		}
		$sql = "select SUM(a.all_price) from " . ORDERS_TABLE . " a where (a.customer_id='" . $userid . "' or a.customer_id in (select c.userid from user_connection c where c.fuserid='" . $userid . "')) and a.user_del<>2";
		if ($join_time != null && $join_time > 0) {
			$sql .= " and a.addtime>" . $join_time;
		}
		if ($status > -1) {
			$sql .= " and a.order_status_id='" . $status . "'";
		}
		if ($start_time > 0 && $status == 3) {
			$sql .= " and a.status_time>=" . $start_time;
		} else
			if ($start_time > 0) {
				$sql .= " and a.addtime>=" . $start_time;
			}
		if ($end_time > 0 && $status == 3) {
			$sql .= " and a.status_time<=" . $end_time;
		} else
			if ($start_time > 0) {
				$sql .= " and a.addtime<=" . $end_time;
			}
		return $db->get_var($sql);
	}

	function detail($db, $id) {
		$sql = "select * from " . ORDERS_TABLE . " where order_id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db, $id) {
		$db->query("update " . ORDERS_TABLE . " set user_del=2 where order_id in (" . implode(",", $id) . ")");
		//$db->query("delete from ".ORDERS_TABLE." where order_id in (".implode(",",$id).")");
		return true;
	}

	function create($customer_id, $customer_group_id, $email, $telephone, $cellphone, $shipping_firstname, $shipping_address_1, $shipping_address_2, $shipping_city, $shipping_postcode, $shipping_method, $remark, $order_status_id, $date_added, $date_modified, $ip, $order_number, $pay_method, $rebate, $coupon, $abolishment_status, $paid_price, $isread, $status_time, $all_price, $group_buy_price, $sign_userid, $status_bu, $huodong_order_status, $pay_online, $promotions_price, $express_type, $express_number, $db) {
		$db->query("insert into " . ORDERS_TABLE . " (customer_id,customer_group_id,email,telephone,cellphone,shipping_firstname,shipping_address_1,shipping_address_2,shipping_city,shipping_postcode,shipping_method,remark,order_status_id,date_added,date_modified,ip,order_number,pay_method,rebate,coupon,addtime,abolishment_status,paid_price,isread,status_time,all_price,group_buy_price,sign_userid,status_bu,huodong_order_status,pay_online,promotions_price,express_type,express_number) values ('" . $customer_id . "','" . $customer_group_id . "','" . $email . "','" . $telephone . "','" . $cellphone . "','" . $shipping_firstname . "','" . $shipping_address_1 . "','" . $shipping_address_2 . "','" . $shipping_city . "','" . $shipping_postcode . "','" . $shipping_method . "','" . $remark . "','" . $order_status_id . "','" . $date_added . "','" . $date_modified . "','" . $ip . "','" . $order_number . "','" . $pay_method . "','" . $rebate . "','" . $coupon . "','" . time() . "','" . $abolishment_status . "','" . $paid_price . "','" . $isread . "','" . $status_time . "','" . $all_price . "','" . $group_buy_price . "','" . $sign_userid . "','" . $status_bu . "','" . $huodong_order_status . "','" . $pay_online . "','" . $promotions_price . "','" . $express_type . "','" . $express_number . "')");
		$order_id = $db->insert_id;
		return $order_id;
	}

	function update($customer_id = -1, $customer_group_id = -1, $email = null, $telephone = null, $cellphone = null, $shipping_firstname = null, $shipping_address_1 = null, $shipping_address_2 = null, $shipping_city = null, $shipping_postcode = null, $shipping_method = null, $remark = null, $order_status_id = -1, $date_added = null, $date_modified = null, $ip = null, $order_number = -1, $pay_method = null, $rebate = null, $coupon = null, $abolishment_status = -1, $paid_price = null, $isread = -1, $status_time = -1, $all_price = null, $group_buy_price = null, $sign_userid = -1, $status_bu = -1, $huodong_order_status = -1, $pay_online = null, $promotions_price = -1, $express_type = '', $express_number = '', $status_introduce = -1, $db, $id) {
		$update_values = "";
		if (!empty ($image)) {
			$imagename = "images='" . $image . "',";
		}
		if ($customer_id > 0) {
			$update_values .= "customer_id='" . $customer_id . "',";
		}
		if ($customer_group_id > 0) {
			$update_values .= "customer_group_id='" . $customer_group_id . "',";
		}
		if ($email != null) {
			$update_values .= "email='" . $email . "',";
		}
		if ($telephone != null) {
			$update_values .= "telephone='" . $telephone . "',";
		}
		if ($cellphone != null) {
			$update_values .= "cellphone='" . $cellphone . "',";
		}
		if ($shipping_firstname != null) {
			$update_values .= "shipping_firstname='" . $shipping_firstname . "',";
		}
		if ($shipping_address_1 != null) {
			$update_values .= "shipping_address_1='" . $shipping_address_1 . "',";
		}
		if ($shipping_address_2 != null) {
			$update_values .= "shipping_address_2='" . $shipping_address_2 . "',";
		}
		if ($shipping_city != null) {
			$update_values .= "shipping_city='" . $shipping_city . "',";
		}
		if ($shipping_postcode != null) {
			$update_values .= "shipping_postcode='" . $shipping_postcode . "',";
		}
		if ($shipping_method != null) {
			$update_values .= "shipping_method='" . $shipping_method . "',";
		}
		if ($remark != null) {
			$update_values .= "remark='" . $remark . "',";
		}
		if ($order_status_id > 0) {
			$update_values .= "order_status_id='" . $order_status_id . "',";
		}
		if ($date_added != null) {
			$update_values .= "date_added='" . $date_added . "',";
		}
		if ($date_modified != null) {
			$update_values .= "date_modified='" . $date_modified . "',";
		}
		if ($ip != null) {
			$update_values .= "ip='" . $ip . "',";
		}
		if ($order_number > 0) {
			$update_values .= "order_number='" . $order_number . "',";
		}
		if ($pay_method != null) {
			$update_values .= "pay_method='" . $pay_method . "',";
		}
		if ($rebate != null) {
			$update_values .= "rebate='" . $rebate . "',";
		}
		if ($coupon != null) {
			$update_values .= "coupon='" . $coupon . "',";
		}
		if ($abolishment_status > 0) {
			$update_values .= "abolishment_status='" . $abolishment_status . "',";
		}
		if ($paid_price != null) {
			$update_values .= "paid_price='" . $paid_price . "',";
		}
		if ($isread > 0) {
			$update_values .= "isread='" . $isread . "',";
		}
		if ($status_time > 0) {
			$update_values .= "status_time='" . $status_time . "',";
		}
		if ($all_price != null) {
			$update_values .= "all_price='" . $all_price . "',";
		}
		if ($group_buy_price != null) {
			$update_values .= "group_buy_price='" . $group_buy_price . "',";
		}
		if ($sign_userid > 0) {
			$update_values .= "sign_userid='" . $sign_userid . "',";
		}
		if ($status_bu > 0) {
			$update_values .= "status_bu='" . $status_bu . "',";
		}
		if ($huodong_order_status > 0) {
			$update_values .= "huodong_order_status='" . $huodong_order_status . "',";
		}
		if ($pay_online != null) {
			$update_values .= "pay_online='" . $pay_online . "',";
		}
		if ($promotions_price > 0) {
			$update_values .= "promotions_price='" . $promotions_price . "',";
		}
		if ($express_type != '') {
			$update_values .= "express_type='" . $express_type . "',";
		}
		if ($express_number != '') {
			$update_values .= "express_number='" . $express_number . "',";
		}
		if ($status_introduce > -1) {
			$update_values .= "status_introduce='" . $status_introduce . "',";
		}
		$db->query("update " . ORDERS_TABLE . " set {$imagename} " . substr($update_values, 0, $update_values . strlen - 1) . " where order_id=" . $id);
		return true;
	}

	function update1($order_status_id = -1, $express_type = '') {
		if ($order_status_id > 0) {
			$update_values .= "order_status_id='" . $order_status_id . "',";
		}
		if ($express_type != '') {
			$update_values .= "express_type='" . $express_type . "',";
		}
	}

	function updatestate($db, $id, $state) {
		if ($state == 0) {
			$c_state = 1;
		} else
			if ($state == 1) {
				$c_state = 0;
			}
		$db->query("update " . ORDERS_TABLE . " set status='" . ($c_state) . "' where order_id in (" . implode(",", $id) . ")");
		return true;
	}
	//更新用户删除状态
	function user_del($db, $order_id, $user_del) {

		$db->query("update " . ORDERS_TABLE . " set user_del='" . ($user_del) . "' where order_id='" . ($order_id) . "'");
		return true;
	}

	function update_order_status($db, $status, $order_id) {
		$sql = "update " . ORDERS_TABLE . " set order_status_id='" . $status . "' where order_id='" . $order_id . "'";
		$db->query($sql);
		return true;
	}

	function update_pay_online($db, $pay_money, $order_id) {
		$sql = "update " . ORDERS_TABLE . " set pay_online='" . $pay_money . "' where order_id='" . $order_id . "'";
		$db->query($sql);
		return true;
	}

	function update_coupon($db, $coupon_number, $order_id) {
		$sql = "update " . ORDERS_TABLE . " set coupon='" . $coupon_number . "' where order_id='" . $order_id . "'";
		$db->query($sql);
		return true;
	}

	function update_pay_method($db, $pay_method, $order_id) {
		$sql = "update " . ORDERS_TABLE . " set pay_method='" . $pay_method . "' where order_id='" . $order_id . "'";
		$db->query($sql);
		return true;
	}

	function update_integral_used($db, $order_id, $integral_used) {
		$sql = "update " . ORDERS_TABLE . " set integral_used='" . $integral_used . "' where order_id='" . $order_id . "'";
		$db->query($sql);
		return true;
	}

	function update_rebate($db, $discount, $order_id) {
		$sql = "update " . ORDERS_TABLE . " set rebate='" . $discount . "' where order_id='" . $order_id . "'";
		$db->query($sql);
		return true;
	}

	function update_status_time($db, $order_id) {
		$sql = "update " . ORDERS_TABLE . " set status_time='" . time() . "' where order_id='" . $order_id . "'";
		$db->query($sql);
		return true;
	}

	function update_is_send($db, $order_id) {
		$sql = "update " . ORDERS_TABLE . " set is_send=1 where order_id='" . $order_id . "'";
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

			$strSQL = "UPDATE ".ORDERS_TABLE." SET {$strVal} WHERE 1=1 {$strWhere}";
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
			$strSQL = "INSERT INTO ".ORDERS_TABLE." ($strKey) VALUES({$strVal})";

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

		$strSQL = "SELECT {$strCol} FROM ".ORDERS_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
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

		$strSQL = "DELETE FROM ".ORDERS_TABLE." WHERE 1=1 {$strWhere} ";
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

		$strSQL = "SELECT {$strCol} FROM ".ORDERS_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
		return $db->get_row($strSQL);
	}



}
?>