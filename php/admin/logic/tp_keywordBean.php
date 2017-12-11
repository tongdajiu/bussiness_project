<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('TP_KEYWORD_TABLE',"tp_keyword");
class tp_keywordBean
{
	function search($db,$page,$per)
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".TP_KEYWORD_TABLE." where id>0";
		$sql.=" order by id desc";
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
function get_results($db,$keys)
{
	$sql = "select * from ".TP_KEYWORD_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}
	function get_keyword($db,$id)
{
		$sql = "select * from ".TP_KEYWORD_TABLE." where keyword = '".$id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}

			function detail_keyword($db,$id)
{
		$sql = "select * from ".TP_KEYWORD_TABLE." where keyword = '".$id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail($db,$id)
{
		$sql = "select * from ".TP_KEYWORD_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db,$id)
{
	$db->query("delete from ".TP_KEYWORD_TABLE." where pid in (".implode(",",$id).")");
	return true;
}
	function create($keyword,$pid,$token,$module,$db)
	{
		$db->query("insert into ".TP_KEYWORD_TABLE." (keyword,pid,token,module) values ('".$keyword."','".$pid."','".$token."','".$module."')");
return true;
	}
	function update($keyword=null,$db,$id)
	{
	$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
			if($keyword!=null){
				$update_values.="keyword='".$keyword."',";
			}
//			if($pid>0){
//				$update_values.="pid='".$pid."',";
//			}
//			if($token!=null){
//				$update_values.="token='".$token."',";
//			}
//			if($module!=null){
//				$update_values.="module='".$module."',";
//			}
		$db->query("update ".TP_KEYWORD_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where pid='".$id."'");
		return true;
	}
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".TP_KEYWORD_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
