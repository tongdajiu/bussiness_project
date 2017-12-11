<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('TP_TEXT_TABLE',"tp_text");
class tp_textBean
{
	function search($db,$page,$per,$type='',$condition='',$keys='')
	{
//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
//if($condition=='name'){
//$sql.=" and b.name like '%".$keys."%'";
//}
		$sql = "select * from ".TP_TEXT_TABLE." where id>0";
			if($type!=''){
				$sql.=" and type like '%".$type."%'";
			}
$sql.=" order by id desc";
//echo $sql;
		$pager = get_pager_data($db, $sql, $page,$per);
		return $pager;
	}
function get_results($db,$keys)
{
	$sql = "select * from ".TP_TEXT_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
}
	$sql.=" order by id desc";
			$list = $db->get_results($sql);
			return $list;
}
	function detail($db,$id)
{
		$sql = "select * from ".TP_TEXT_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db,$id)
{
	$db->query("delete from ".TP_TEXT_TABLE." where id in (".implode(",",$id).")");
	return true;
}
	function create($uid,$uname,$keyword,$type,$text,$createtime,$updatetime,$click,$token,$db)
	{
	//	echo "insert into ".TP_TEXT_TABLE." (uid,uname,keyword,type,text,createtime,updatetime,click,token) values ('".$uid."','".$uname."','".$keyword."','".$type."','".$text."','".$createtime."','".$updatetime."','".$click."','".$token."')";
		$db->query("insert into ".TP_TEXT_TABLE." (uid,uname,keyword,type,text,createtime,updatetime,click,token) values ('".$uid."','".$uname."','".$keyword."','".$type."','".$text."','".$createtime."','".$updatetime."','".$click."','".$token."')");
return true;
	}
	function update($uid=-1,$uname=null,$keyword=null,$type=null,$text=null,$createtime=null,$updatetime=null,$click=-1,$token=null,$db,$id)
	{
	$update_values="";
		if (!empty($image))
		{
			$imagename = "images='".$image."',";
		}
			if($uid>0){
				$update_values.="uid='".$uid."',";
			}
			if($uname!=null){
				$update_values.="uname='".$uname."',";
			}
			if($keyword!=null){
				$update_values.="keyword='".$keyword."',";
			}
			if($type!=null){
				$update_values.="type='".$type."',";
			}
			if($text!=null){
				$update_values.="text='".$text."',";
			}
			if($createtime!=null){
				$update_values.="createtime='".$createtime."',";
			}
			if($updatetime!=null){
				$update_values.="updatetime='".$updatetime."',";
			}
			if($click>0){
				$update_values.="click='".$click."',";
			}
			if($token!=null){
				$update_values.="token='".$token."',";
			}
		$db->query("update ".TP_TEXT_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".TP_TEXT_TABLE." set status='".($c_state)."' where id in (".implode(",",$id).")");
		return true;
	}
}
?>
