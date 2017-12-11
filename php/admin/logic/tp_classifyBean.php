<?php
if (!defined('SCRIPT_ROOT'))
	die("no permission");
define('FOCUS_TABLE', "tp_classify");
class tp_classifyBean {
	function search($db, $page, $per, $status, $condition, $keys) {
		//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
		$sql = "select * from " . FOCUS_TABLE . " where id > 0 ";
		//		if($type>0){
		//			$sql.=" and type = '".$type."'";
		//		}
		if ($status >= 0) {
			$sql .= " and status = '" . $status . "'";
		}
		$sql .= " order by id desc";

		$pager = get_pager_data($db, $sql, $page, $per);
		return $pager;
	}
	function get_results($db, $type = null) {
		$sql = "select * from " . FOCUS_TABLE;
		if ($type != null) {
			$sql .= " where token = '" . $type . "'";
		}
		$sql .= " where status=1 order by id desc ";
		//echo $sql;
		$list = $db->get_results($sql);
		return $list;
	}
	function get_index_type($db, $type = 0, $limit = 0) {
		$sql = "select * from " . FOCUS_TABLE . " where id > 0 ";
		if ($type > 0) {
			$sql .= " and type = '" . $type . "' ";
		}
		$sql .= " order by sorting desc,id asc";
		if ($limit > 0) {
			$sql .= " limit " . $limit . "";
		}
		//	echo $sql;
		$list = $db->get_results($sql);
		return $list;
	}
	function detail($db, $id) {
		$sql = "select * from " . FOCUS_TABLE . " where id = {$id}";
		$obj = $db->get_row($sql);
		//echo $sql;
		return $obj;
	}
	function detail_focus($db, $id) {
		$sql = "select * from " . FOCUS_TABLE . " where type='" . $id . "' and status='1'  order by id desc";

		$obj = $db->get_row($sql);
		return $obj;
	}
	function detail_focus2($db, $id) {
		$sql = "select * from " . FOCUS_TABLE . " where type='" . $id . "' and status='0' order by sorting desc";
		//echo  $sql;

		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db, $id) {
		$db->query("delete from " . FOCUS_TABLE . " where id in (" . implode(",", $id) . ")");
		return true;
	}

	function updatestate($db, $id, $state) {
		if ($state == 0) {
			$c_state = 1;
		} else
			if ($state == 1) {
				$c_state = 0;
			}
		$db->query("update " . FOCUS_TABLE . " set status='" . ($c_state) . "' where id in (" . implode(",", $id) . ")");
		return true;
	}
	function create($keyword, $name, $info, $sorts, $img, $url, $status, $token, $db) {
		//		echo  "insert into ".FOCUS_TABLE." (keyword,name,info,sorts,img,url,status,token) values ('".$keyword."','".$name."','".$info."','".$sorts."','".$img."','".$url."','".$status."','".$token."')";
		$sql = "insert into " . FOCUS_TABLE . " (keyword,name,info,sorts,img,url,status,token) values ('" . $keyword . "','" . $name . "','" . $info . "','" . $sorts . "','" . $img . "','" . $url . "','" . $status . "','" . $token . "')";
		$db->query($sql);
		return true;
	}
	function update($keyword, $name, $info, $sorts, $img, $url, $status, $token, $db, $id) {
		$update_values = "";

		if ($name >= 0) {
			$update_values .= "name='" . $name . "',";
			$update_values .= "keyword='" . $keyword . "',";
		}
		//echo "update ".FOCUS_TABLE." set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		$db->query("update " . FOCUS_TABLE . " set {$imagename} " . substr($update_values, 0, $update_values . strlen - 1) . " where id=" . $id);
		return true;
	}

}
?>
