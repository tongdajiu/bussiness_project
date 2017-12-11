<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('AD_TABLE',"ad");
class adBean
{
	function search($db,$page,$per,$type=0,$status=0)
	{
		$sql = "select * from ".AD_TABLE." where id > 0 ";
		if($type>0){
			$sql.=" and type = '".$type."'";
		}
		if($status>=0){
			$sql.=" and status = '".$status."'";
		}
		$sql.=" order by id desc";

		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}

	function get_results($db,$keys='')
	{
		$sql = "select * from ".AD_TABLE;
		$sql.=" where status=1 and type=1  order by id desc ";

		$list = $db->get_results($sql);
		return $list;
	}

     function get_results_new($db,$keys='')
	{
		$sql = "select  distinct typeclass from ".AD_TABLE;
		$sql.=" where status=1 and typeclass !=0  order by id desc ";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_type($db,$keys='')
	{
		$sql = "select * from ".AD_TABLE;
		$sql.=" where status=1 and type !=0  order by id desc ";
		$list = $db->get_results($sql);
		return $list;
	}


    function get_ad_img($db)
	{
		$sql = "select * from ".AD_TABLE ." WHERE `status`=1 and `type` =4 ORDER BY id DESC LIMIT 5";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_ad_background($db)
	{
		$sql = "select * from ".AD_TABLE ." WHERE `status`=1 and `type` =1 ORDER BY id DESC LIMIT 1";
		$list = $db->get_row($sql);
		return $list;
	}





     function get_ad_img_nwe($db)
	{
		$sql = "select * from ".AD_TABLE ." WHERE `status`=1 and `typeclass`!=0 ORDER BY id DESC ";
		$list = $db->get_results($sql);

		return $list;
	}




//    function get_ad_type($db,$type)
//	{
//		$sql = "select * from ".AD_TABLE ." WHERE `status`=1 and `type`!='' ORDER BY id DESC LIMIT 4";
//		$list = $db->get_row($sql);
//		return $list;
//	}
	function get_index_type($db,$type=0)
	{
		$sql = "select * from ".AD_TABLE." where id > 0 ";
		if($type>0){
			$sql.=" and type = '".$type."' ";
		}
		$sql.=" order by sorting desc,id asc";
		$list = $db->get_results($sql);
		return $list;

	}

    function get_index_class($db,$class=0)
	{
		$sql = "select * from ".AD_TABLE." where id > 0 ";
		if($class>0){
			$sql.=" and class = '".$class."' ";
		}
		$sql.=" order by sorting desc,id asc";
		$list = $db->get_results($sql);
		return $list;

	}

    function get_index_typeclass($db,$typeclass)
	{

		$sql = "select * from ".AD_TABLE." where typeclass ='".$typeclass."' ";
		$sql.=" order by sorting desc,id asc";
		$list = $db->get_results($sql);
		return $list;

	}



	function detail($db,$id)
	{
		$sql = "select * from ".AD_TABLE." where id = {$id} ";
//	$sql =	"select  ".PRODUCT_TYPE_TABLE.".id,".PRODUCT_TYPE_TABLE.".name,".PRODUCT_TYPE_TABLE.".classid from ".PRODUCT_TYPE_TABLE." LEFT join ".AD_TABLE." on ".PRODUCT_TYPE_TABLE.".id = ".AD_TABLE.".typeclass WHERE ".PRODUCT_TYPE_TABLE.".classid=0 AND id = {$id} ";

		$obj = $db->get_row($sql);

		return $obj;
	}
	function detail_focus($db,$id)
	{
		$sql = "select * from ".AD_TABLE." where type='".$id."' and status='1'";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function detail_focus2($db,$id)
	{
		$sql = "select * from ".AD_TABLE." where type='".$id."' and status='0' order by sorting desc";
		$obj = $db->get_row($sql);
		return $obj;
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".AD_TABLE." where id in (".implode(",",$id).")");
		return true;
	}
	function delete($db,$id)
	{
		$db->query("delete from ".AD_TABLE." where id =".$id);
		return true;
	}

	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".AD_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}

	function create($images,$url,$title,$type,$typeclass,$status,$size_tips ,$background_color,$db)
	{
		$db->query("insert into ".AD_TABLE." (status,type,title,url,size_tips,typeclass,background_color,images,create_by,create_date) values ('$status','$type','".$title."','".$url."','".$size_tips."','$typeclass','".$background_color."','".$images."','1','".date('Y-m-d h:i',time())."')");
        return true;
	}

	function update($images='',$title=null,$url=null,$type=null,$typeclass=null,$status=null,$size_tips=null,$background_color=null,$db,$id)
	{
		$update_values="";
		if (!empty($images))
		{
			$images = "images='".$images."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($url!=null){
			$update_values.="url='".$url."',";
		}
		if($type!=null){
			$update_values.="type='".$type."',";
		}
		if($typeclass!=null){
			$update_values.="typeclass='".$typeclass."',";
		}
		if($status!=null){
			$update_values.="status='".$status."',";
		}
		if($size_tips!=null){
			$update_values.="size_tips='".$size_tips."',";
		}
		if($background_color!=null){
			$update_values.="background_color='".$background_color."',";
		}


//	echo 	"update ".AD_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		$db->query("update ".AD_TABLE." set {$images} ".substr($update_values,0,$update_values.'strlen'-1)." where id=".$id);
		return true;
	}

}

?>
