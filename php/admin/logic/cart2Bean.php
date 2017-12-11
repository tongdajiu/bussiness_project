<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('CART2_TABLE',"cart2");
class cart2Bean
{
	function search($db,$page,$per,$userid=0,$type=0,$condition='',$keys='')
	{
		$sql = "select * from ".CART2_TABLE." where id>0";
			if($userid>0){
				$sql.=" and userid ='".$userid."'";
			}
			if($type>0){
				$sql.=" and type ='".$type."'";
			}
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".CART2_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_order($db,$order_id){
		$sql = "select * from ".CART2_TABLE." where order_id='".$order_id."'";
		return $db->get_results($sql);
	}
	function get_results_orderSum($db,$order_id){
		$sql = "select SUM(shopping_number) from ".CART2_TABLE." where order_id='".$order_id."'";
//		echo $sql.";";
		$row=$db->get_var($sql);
//		echo $row;
		return $row;
	}
	function get_results_pic($db,$order_id){
		$sql = "select * from ".CART2_TABLE." where order_id='".$order_id."' order by id limit 1";
		return $db->get_row($sql);
	}
	function detail($db,$id)
	{
		$sql = "select * from ".CART2_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_product($db,$order_id,$product_id){
		$sql = "select * from ".CART2_TABLE." where order_id='".$order_id."' and product_id='".$product_id."'";
		//echo $sql;
		return $db->get_row($sql);
	}

	function get_count_time($db,$product_id,$start_time,$end_time){
		$sql = "select sum(shopping_number) from ".CART_TABLE." where product_id='".$product_id."' addTime>='".$start_time."' and addTime<='".$end_time."'";
		return $db->get_var($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".CART2_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($userid,$product_id,$product_name,$product_model,$product_price,$product_price_old,$product_image,$order_id,$shopping_number,$shopping_size,$shopping_colorid,$integral,$paying_status,$product_type,$type,$promotions_content,$addTime,$db)
	{
		$db->query("insert into ".CART2_TABLE." (userid,product_id,product_name,product_model,product_price,product_price_old,product_image,order_id,shopping_number,shopping_size,shopping_colorid,integral,paying_status,product_type,type,promotions_content,addTime) values ('".$userid."','".$product_id."','".$product_name."','".$product_model."','".$product_price."','".$product_price_old."','".$product_image."','".$order_id."','".$shopping_number."','".$shopping_size."','".$shopping_colorid."','".$integral."','".$paying_status."','".$product_type."','".$type."','".$promotions_content."','".$addTime."')");
		return true;
	}

	function update($userid=-1,$product_id=-1,$product_name=null,$product_model=null,$product_price=null,$product_price_old=null,$product_image=null,$order_id=null,$shopping_number=-1,$shopping_size=null,$shopping_colorid=-1,$integral=-1,$paying_status=-1,$product_type=-1,$type=-1,$promotions_content=null,$addTime=null,$db,$id)
	{
		$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
		if($userid>0){
			$update_values.="userid='".$userid."',";
		}
		if($product_id>0){
			$update_values.="product_id='".$product_id."',";
		}
		if($product_name!=null){
			$update_values.="product_name='".$product_name."',";
		}
		if($product_model!=null){
			$update_values.="product_model='".$product_model."',";
		}
		if($product_price!=null){
			$update_values.="product_price='".$product_price."',";
		}
		if($product_price_old!=null){
			$update_values.="product_price_old='".$product_price_old."',";
		}
		if($product_image!=null){
			$update_values.="product_image='".$product_image."',";
		}
		if($order_id!=null){
			$update_values.="order_id='".$order_id."',";
		}
		if($shopping_number>0){
			$update_values.="shopping_number='".$shopping_number."',";
		}
		if($shopping_size!=null){
			$update_values.="shopping_size='".$shopping_size."',";
		}
		if($shopping_colorid>0){
			$update_values.="shopping_colorid='".$shopping_colorid."',";
		}
		if($integral>0){
			$update_values.="integral='".$integral."',";
		}
		if($paying_status>0){
			$update_values.="paying_status='".$paying_status."',";
		}
		if($product_type>0){
			$update_values.="product_type='".$product_type."',";
		}
		if($type>0){
			$update_values.="type='".$type."',";
		}
		if($promotions_content!=null){
			$update_values.="promotions_content='".$promotions_content."',";
		}
		if($addTime!=null){
			$update_values.="addTime='".$addTime."',";
		}
		$db->query("update ".CART2_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".CART2_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function update_paying_status($db,$status,$cart_id){
		$sql = "update ".CART2_TABLE." set paying_status='".$status."' where id='".$cart_id."'";
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

			$strSQL = "UPDATE ".CART2_TABLE." SET {$strVal} WHERE 1=1 {$strWhere}";
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
			$strSQL = "INSERT INTO ".CART2_TABLE." ($strKey) VALUES({$strVal})";

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

		$strSQL = "SELECT {$strCol} FROM ".CART2_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
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

		$strSQL = "DELETE FROM ".CART2_TABLE." WHERE 1=1 {$strWhere} ";
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

		$strSQL = "SELECT {$strCol} FROM ".CART2_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
		return $db->get_row($strSQL);
	}

}
?>