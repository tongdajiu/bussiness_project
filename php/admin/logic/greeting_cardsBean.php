<?php
if (!defined('SCRIPT_ROOT'))
	die("no permission");
define('GREETING_CARDS_TABLE', "greeting_cards");
class greeting_cardsBean {
	function search($db, $page, $per) {
		//$sql = "select a.*, b.title_s as name from ".INFO_TABLE." as a left outer join groups as b on a.type = b.id ";
		//if($condition=='name'){
		//$sql.=" and b.name like '%".$keys."%'";
		//}
		$sql = "select * from " . GREETING_CARDS_TABLE . " where id>0";
		$sql .= " order by id desc";
		$pager = get_pager_data($db, $sql, $page, $per);
		return $pager;
	}
	function get_results($db, $keys) {
		$sql = "select * from " . GREETING_CARDS_TABLE;
		if ($keys != '') {
			$sql .= " where classid=" . $keys;
		}
		$sql .= " order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function detail($db, $id) {
		$sql = "select * from " . GREETING_CARDS_TABLE . " where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db, $id) {
		$db->query("delete from " . GREETING_CARDS_TABLE . " where id in (" . implode(",", $id) . ")");
		return true;
	}
	function create($title, $background, $text_background, $pic1, $pic1_url, $pic2, $pic2_url, $pic3, $pic3_url, $writing, $music, $footer, $footer_url, $db) {
		$db->query("insert into " . GREETING_CARDS_TABLE . " (title,background,text_background,pic1,pic1_url,pic2,pic2_url,pic3,pic3_url,writing,music,footer,footer_url) values ('" . $title . "','" . $background . "','" . $text_background . "','" . $pic1 . "','" . $pic1_url . "','" . $pic2 . "','" . $pic2_url . "','" . $pic3 . "','" . $pic3_url . "','" . $writing . "','" . $music . "','" . $footer . "','" . $footer_url . "')");
		return true;
	}
	function update($title = null, $background = null, $text_background = null, $pic1 = null, $pic1_url = null, $pic2 = null, $pic2_url = null, $pic3 = null, $pic3_url = null, $writing = null, $music = null, $footer = null, $footer_url = null, $db, $id) {
		$update_values = "";
		if (!empty ($image)) {
			$imagename = "images='" . $image . "',";
		}
		if ($title != null) {
			$update_values .= "title='" . $title . "',";
		}
		if ($background != null) {
			$update_values .= "background='" . $background . "',";
		}
		if ($text_background != null) {
			$update_values .= "text_background='" . $text_background . "',";
		}
		if ($pic1 != null) {
			$update_values .= "pic1='" . $pic1 . "',";
		}
		if ($pic1_url != null) {
			$update_values .= "pic1_url='" . $pic1_url . "',";
		}
		if ($pic2 != null) {
			$update_values .= "pic2='" . $pic2 . "',";
		}
		if ($pic2_url != null) {
			$update_values .= "pic2_url='" . $pic2_url . "',";
		}
		if ($pic3 != null) {
			$update_values .= "pic3='" . $pic3 . "',";
		}
		if ($pic3_url != null) {
			$update_values .= "pic3_url='" . $pic3_url . "',";
		}
		if ($writing != null) {
			$update_values .= "writing='" . $writing . "',";
		}
		if ($music != null) {
			$update_values .= "music='" . $music . "',";
		}
		if ($footer != null) {
			$update_values .= "footer='" . $footer . "',";
		}
		if ($footer_url != null) {
			$update_values .= "footer_url='" . $footer_url . "',";
		}
		$db->query("update " . GREETING_CARDS_TABLE . " set {$imagename} " . substr($update_values, 0, $update_values . strlen - 1) . " where id=" . $id);
		return true;
	}
	function updatestate($db, $id, $state) {
		if ($state == 0) {
			$c_state = 1;
		} else
			if ($state == 1) {
				$c_state = 0;
			}
		$db->query("update " . GREETING_CARDS_TABLE . " set status='" . ($c_state) . "' where id in (" . implode(",", $id) . ")");
		return true;
	}
}
?>
