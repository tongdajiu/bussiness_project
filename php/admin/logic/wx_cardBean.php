<?php
	if ( !defined('SCRIPT_ROOT') )
		die("no permission");
define('WX_CARD_TABLE',"wx_card");
class wx_cardBean
{

	function search($db,$page,$per,$condition='',$keys='')
	{
		$sql = "select * from ".WX_CARD_TABLE." where id>0 ";

		if($condition == "reduce_value" && $keys>-1){

			$sql.=" and reduce_value=".$keys;
		}
		$sql.=" order by id desc";
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function get_results($db,$keys)
	{
		$sql = "select * from ".WX_CARD_TABLE;
		if($keys!=''){
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}



	function detail($db,$id)
	{
		$sql = "select * from ".WX_CARD_TABLE." where id =".$id;
		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_cardid($db,$card_id)
	{
		$sql = "select * from ".WX_CARD_TABLE." where card_id = '".$card_id."'";
		$obj = $db->get_row($sql);
		return $obj;
	}


	function deletedate($db,$id)
	{
		$db->query("delete from ".WX_CARD_TABLE." where id in (".implode(",",$id).")");
		return true;
	}

	function create($card_id,$reduce_cost,$db)
	{
		$db->query("insert into ".WX_CARD_TABLE." (card_id,reduce_cost) values ('".$card_id."','".$reduce_cost."')");
		return true;
	}

	function update($card_id=-1,$reduce_cost=-1,$db,$id)
	{
		$update_values="";

		if($card_id>-1){
			$update_values.="card_id='".$card_id."',";
		}
		if($reduce_cost>-1){
			$update_values.="reduce_cost='".$reduce_cost."',";
		}

		$db->query("update ".WX_CARD_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where id=".$id);
		return true;
	}
		function update_reduce_cost($reduce_cost=-1,$db,$card_id)
	{
		$update_values="";

		if($reduce_cost>-1){
			$update_values.="reduce_cost='".$reduce_cost."',";
		}

		$db->query("update ".WX_CARD_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where card_id='".$card_id."'");
		return true;
	}


}
?>
