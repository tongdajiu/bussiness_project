<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('PRODUCT_TABLE',"product");
class productBean
{
	function search($db,$page,$per,$status=0,$range_s='',$condition='',$keys='',$type='0')
	{
		$sql = "select * from ".PRODUCT_TABLE." where product_id>0";
			if($status > -1){
				$sql .= " and status ='".$status."'";
			}
			if($range_s!=''){
				$sql .= " and range_s like '%".$range_s."%'";
			}
			if($keys != ''){
				$sql .= " and name like '%".$keys."%'";
			}
			if($type >0){
				$sql .= " and category_id = '".$type."'";
			}
		$sql.=" order by product_id desc";
		//echo $sql;
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function search_list($db,$page,$per,$category_id=-1,$hot=-1,$status=-1)
	{
		$sql = "select * from ".PRODUCT_TABLE." where product_id>0 and status=1";
			if($category_id > -1){
				$sql .= " and category_id = '".$category_id."'";
			}
			if($hot > -1){
				$sql .= " and hot = '".$hot."'";
			}
			if($status > -1){
				$sql .= " and status ='".$status."'";
			}
//			if($hot != 2){
//				$sql .= " and hot <> '2'";
//			}
		$sql.=" order by sorting asc,product_id desc";
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function search_list_oneyuan($db,$page,$per,$category_id=-1,$hot=-1)
	{
		$sql = "select (select count(id) from cart2_oneyuan c where c.product_id=p.product_id and c.phase_id=pp.id) buy_count,p.name,p.image,p.price,pp.* from ".PRODUCT_TABLE." p left join product_phase pp on p.product_id=pp.product_id where pp.product_id>0 and pp.status=1 and pp.sale_status=1";
			if($category_id > -1){
				$sql .= " and  FIND_IN_SET(".$category_id.",p.category_id)";
			}
			if($hot > -1){
				$sql .= " and p.hot = '".$hot."'";
			}
		$sql.=" order by p.sorting asc,pp.id desc";
//		echo $sql;
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function search2($db,$page,$per,$status=0,$range_s='',$condition='',$keys='',$type='0')
	{
		$sql = "select * from ".PRODUCT_TABLE." where product_id>0";
			if($status > -1){
				$sql .= " and status ='".$status."'";
			}
			if($range_s!=''){
				$sql .= " and range_s like '%".$range_s."%'";
			}
			if($keys != ''){
				$sql .= " and name like '%".$keys."%'";
			}
			if($type >0){
				$sql .= " and category_id = '".$type."'";
			}
		$sql.=" order by sorting asc, product_id desc";

		//echo $sql;
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".PRODUCT_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,product_id desc";
		$list = $db->get_results($sql);
		return $list;
	}

       function get_results_new($db,$keys='')
	{
		$sql = "select * from ".PRODUCT_TABLE;
		$sql.=" where 1=1 and status=1 order by product_id desc limit 4 ";

		$list = $db->get_results($sql);
		return $list;
	}



	function get_results_search($db,$key){

		$sql = "select * from ".PRODUCT_TABLE." where name like '%".$key."%' and status=1 order by sorting asc,product_id desc";
		return $db->get_results($sql);
	}

	function get_similar_product($db,$product_id){

		$sql = "select * from ".PRODUCT_TABLE." as a where a.product_id <> '".$product_id."' and a.category_id = (select b.category_id from ".PRODUCT_TABLE." as b where b.product_id = '".$product_id."') and a.status>0 order by rand(),product_id desc limit 3";
		//echo $sql;
		return $db->get_results($sql);
	}
	function get_hot3_product($db){

		$sql = "select * from ".PRODUCT_TABLE." where hot=1 and status=1 order by sorting limit 0,3";
		//echo $sql;
		return $db->get_results($sql);
	}
	function get_some_product($db,$some,$altitude){

		$sql = "select * from ".PRODUCT_TABLE." where altitude=".$altitude." and status=1 ";
		$sql .=" order by sorting limit 0,".intval($some);
		//echo $sql;
		return $db->get_results($sql);
	}

	function detail($db,$id)
	{
		$sql = "select * from ".PRODUCT_TABLE." where product_id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_phase($db,$product_id,$phase_id){
		$sql = "select (select count(id) from cart2_oneyuan c where c.product_id=p.product_id and c.phase_id=pp.id) buy_count,p.name,p.image,p.price,pp.* from ".PRODUCT_TABLE." p left join product_phase pp on p.product_id=pp.product_id where pp.product_id='".$product_id."' and pp.id=".$phase_id;
		$obj = $db->get_row($sql);
		return $obj;
	}


	function deletedate($db,$id)
	{
		$db->query("delete from ".PRODUCT_TABLE." where product_id in (".implode(",",$id).")");
		return true;
	}

	function create($name,$title,$model,$image,$category_id,$category_id2,$category_big,$price,$price_old,$status,$viewed,$description,$sorting,$hot,$inventory,$unit,$standard,$brand,$origin_place,$range_s,$distribution_date,$integral,$random,$sell_number,$altitude,$notes,$teapot,$teacup,$db)
	{
		$sql = "insert into ".PRODUCT_TABLE." (name,title,model,image,category_id,category_id2,category_big,price,price_old,status,viewed,description,sorting,hot,inventory,unit,standard,brand,origin_place,range_s,distribution_date,integral,random,sell_number,altitude,notes,teapot,teacup) values ('".$name."','".$title."','".$model."','".$image."','".$category_id."','".$category_id2."','".$category_big."','".$price."','".$price_old."','".$status."','".$viewed."','".$description."','".$sorting."','".$hot."','".$inventory."','".$unit."','".$standard."','".$brand."','".$origin_place."','".$range_s."','".$distribution_date."','".$integral."','".$random."','".$sell_number."','".$altitude."','".$notes."','".$teapot."','".$teacup."')";
//		echo $sql;
		$db->query($sql);
		$pid = $db->insert_id;
		return $pid;
	}

	function update($name=null,$title=null,$model=null,$image=null,$category_id=-1,$category_id2=-1,$category_big=-1,$price=-1,$price_old=-1,$status=-1,$viewed=-1,$description=null,$sorting=-1,$hot=-1,$inventory=-1,$unit=null,$standard=null,$brand=null,$origin_place=null,$range_s=null,$distribution_date=null,$integral=-1,$random=-1,$sell_number=-1,$altitude=-1,$notes=null,$teapot=null,$teacup=null,$db,$id)
	{
		$update_values="";
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($model!=null){
			$update_values.="model='".$model."',";
		}
		if($image!=null){
			$update_values.="image='".$image."',";
		}
		if($category_id>-1){
			$update_values.="category_id='".$category_id."',";
		}
		if($category_id2>0){
			$update_values.="category_id2='".$category_id2."',";
		}
		if($category_big>0){
			$update_values.="category_big='".$category_big."',";
		}
		if($price>-1){
			$update_values.="price='".$price."',";
		}
		if($price_old>-1){
			$update_values.="price_old='".$price_old."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($viewed>0){
			$update_values.="viewed='".$viewed."',";
		}
		if($description!=null){
			$update_values.="description='".$description."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($hot>-1){
			$update_values.="hot='".$hot."',";
		}
		if($inventory>0){
			$update_values.="inventory='".$inventory."',";
		}
		if($unit!=null){
			$update_values.="unit='".$unit."',";
		}
		if($standard!=null){
			$update_values.="standard='".$standard."',";
		}
		if($brand!=null){
			$update_values.="brand='".$brand."',";
		}
		if($origin_place!=null){
			$update_values.="origin_place='".$origin_place."',";
		}
		if($range_s!=null){
			$update_values.="range_s='".$range_s."',";
		}
		if($distribution_date!=null){
			$update_values.="distribution_date='".$distribution_date."',";
		}
		if($integral>0){
			$update_values.="integral='".$integral."',";
		}
		if($random>0){
			$update_values.="random='".$random."',";
		}
		if($sell_number>-1){
			$update_values.="sell_number='".$sell_number."',";
		}
		if($altitude>-1){
			$update_values.="altitude='".$altitude."',";
		}
		if($notes!=null){
			$update_values.="notes='".$notes."',";
		}

		if($teapot!=null){
			$update_values.="teapot='".$teapot."',";
		}
		if($teacup!=null){
			$update_values.="teacup='".$teacup."',";
		}
		$db->query("update ".PRODUCT_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where product_id=".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PRODUCT_TABLE." set status='".($c_state)."' where product_id in (".implode(",",$id).")");
		return true;
	}

	function update_viewed($db,$product_id){
		$sql = "update ".PRODUCT_TABLE." set viewed=viewed+1 where product_id='".$product_id."'";
		$db->query($sql);
		return true;
	}

	function update_sell_number($db,$number,$product_id){
		$sql = "update ".PRODUCT_TABLE." set sell_number=sell_number+".$number." where product_id='".$product_id."'";
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

			$strSQL = "UPDATE ".PRODUCT_TABLE." SET {$strVal} WHERE 1=1 {$strWhere}";
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
			$strSQL = "INSERT INTO ".PRODUCT_TABLE." ($strKey) VALUES({$strVal})";

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

		$strSQL = "SELECT {$strCol} FROM ".PRODUCT_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
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

		$strSQL = "DELETE FROM ".PRODUCT_TABLE." WHERE 1=1 {$strWhere} ";
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

			$strSQL = "SELECT {$strCol} FROM ".PRODUCT_TABLE." WHERE 1=1 {$strWhere} {$OrderBy}";
			return $db->get_row($strSQL);
		}


}
?>
