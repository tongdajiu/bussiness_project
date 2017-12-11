<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('TP_DIYMEN_CLASS_TABLE',"tp_diymen_class");
class tp_diymen_classBean
{

	function search($db,$page,$per,$pid=-1,$condition='',$keys='')
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".TP_DIYMEN_CLASS_TABLE." where id>0";

			if($pid > -1){
				$sql.=" and pid='".$pid."'";
			}
			if($keys!=null){
				$sql.=" and ".$condition."  like '%".$keys."%'";
			}

		$sql.=" order by sort asc,id desc";

		$pager = get_pager_data($db, $sql, $page,$per);
	//echo $sql;
		return $pager;
	}

function get_results_menu($db,$keys,$num)

{
	$sql = "select * from ".TP_DIYMEN_CLASS_TABLE." where is_show=1";
	if($keys>=0){

			$sql.=" and pid='".$keys."' ";
}


			$sql.=" order by sort limit $num";

//echo  $sql;
$list = $db->get_results($sql);

			return $list;
}
function get_results($db,$keys,$levelType,$num)

{

	$sql = "select * from ".TP_DIYMEN_CLASS_TABLE;

		if($keys!=''){
			$sql.=" where id=".$keys;
}
		if($levelType!=''){
			$sql.=" where levelType=".$levelType
			;
}
         if($num>0){
			$sql.=" order by hits desc limit $num";

			}else{
				$sql.=" order by id desc";
			}


			$list = $db->get_results($sql);

			return $list;
}
function get_results_pid($db)

{

	$sql = "select * from ".TP_DIYMEN_CLASS_TABLE." ";




			$list = $db->get_results($sql);
   //echo $sql;
			return $list;
}
function get_results_in($db,$keys,$siteIns,$num)

{

	$sql = "select * from ".TP_DIYMEN_CLASS_TABLE;

		if($keys!=''){
			$sql.=" where id=".$keys;
}
		if($siteIns!=''){
			$sql.=" where siteIns=".$siteIns
			;
}
         if($num>0){
			$sql.=" order by hits desc limit $num";

			}else{
				$sql.=" order by id desc";
			}


			$list = $db->get_results($sql);


			return $list;
}
function get_comType($db,$keys,$siteIns,$comType,$num)

{

	$sql = "select * from ".TP_DIYMEN_CLASS_TABLE;

		if($keys!=''){
			$sql.=" where id=".$keys;
}
		if($siteIns!=''){
			$sql.=" where siteIns=".$siteIns
			;
}
	if($comType!=''){
			$sql.=" where comType=".$comType
			;
}
         if($num>0){
			$sql.=" order by hits desc limit $num";

			}else{
				$sql.=" order by id desc";
			}


			$list = $db->get_results($sql);
echo "$sql";

			return $list;
}



	function detail($db,$id)
{

		$sql = "select * from ".TP_DIYMEN_CLASS_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db,$id)
{
	$db->query("delete from ".TP_DIYMEN_CLASS_TABLE." where id in (".implode(",",$id).")");

	return true;
}
	function create($token,$pid,$title,$keyword,$is_show,$sort,$url,$db)
	{
   //echo "insert into ".TP_DIYMEN_CLASS_TABLE." (token,pid,title,keyword,is_show,sort,url) values ('".$token."','".$pid."','".$title."','".$keyword."','".$is_show."','".$sort."','".$url."')";
		$db->query("insert into ".TP_DIYMEN_CLASS_TABLE." (token,pid,title,keyword,is_show,sort,url) values ('".$token."','".$pid."','".$title."','".$keyword."','".$is_show."','".$sort."','".$url."')");

return true;

	}
	function update($token,$pid,$title,$keyword,$is_show,$sort,$url=null,$db,$id)
	{

	$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
			if($token!=null){
				$update_values.="token='".$token."',";
			}
			if($pid!=null){
				$update_values.="pid='".$pid."',";
			}
			if($title!=null){
				$update_values.="title='".$title."',";
			}
			if($keyword!=null){
				$update_values.="keyword='".$keyword."',";
			}

			if($is_show!=null){
				$update_values.="is_show='".$is_show."',";
			}
			if($sort>0){
				$update_values.="sort='".$sort."',";
			}
			if($url!=null){
				$update_values.="url='".$url."',";
			}

//echo "update ".TP_DIYMEN_CLASS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		$db->query("update ".TP_DIYMEN_CLASS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);

		return true;

	}
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".TP_DIYMEN_CLASS_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
