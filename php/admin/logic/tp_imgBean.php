<?php
if (!defined('SCRIPT_ROOT'))
	die("no permission");
define('TP_IMG_TABLE', "tp_img");
class tp_imgBean {
	function search($db, $page, $per, $type = '', $condition = '', $keys = '', $classid = '') {
		$sql = "select * from " . TP_IMG_TABLE . " where id>0";
		if ($type != '') {
			$sql .= " and type like '%" . $type . "%'";
		}
		$sql .= " order by id desc";
		$pager = get_pager_data($db, $sql, $page, $per);
		return $pager;
	}
	function get_results($db, $keys) {
		$sql = "select * from " . TP_IMG_TABLE;
		if ($keys != '') {
			$sql .= " where classid=" . $keys;
		}
		$sql .= " order by id desc";
		$list = $db->get_results($sql);
		return $list;
	}
	function get_results_type($db, $keys) {
		$sql = "select * from " . TP_IMG_TABLE;
		if ($keys != '') {
			$sql .= " where id='" . $keys . "'";
		}
		$sql .= " order by id desc";
		$list = $db->get_row($sql);
		return $list;
	}
	function detail($db, $id) {
		$sql = "select * from " . TP_IMG_TABLE . " where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}
	function deletedate($db, $id) {
		$db->query("delete from " . TP_IMG_TABLE . " where id in (" . implode(",", $id) . ")");
		return true;
	}
	function create($uid, $uname, $keyword, $type, $text, $classid, $classname, $pic, $showpic, $info, $url, $createtime, $uptatetime, $click, $token, $title, $db) {
		//		echo "insert into ".TP_IMG_TABLE." (uid,uname,keyword,type,text,classid,classname,pic,showpic,info,url,createtime,uptatetime,click,token,title) values ('".$uid."','".$uname."','".$keyword."','".$type."','".$text."','".$classid."','".$classname."','".$pic."','".$showpic."','".$info."','".$url."','".$createtime."','".$uptatetime."','".$click."','".$token."','".$title."')";
		$db->query("insert into " . TP_IMG_TABLE . " (uid,uname,keyword,type,text,classid,classname,pic,showpic,info,url,createtime,uptatetime,click,token,title) values ('" . $uid . "','" . $uname . "','" . $keyword . "','" . $type . "','" . $text . "','" . $classid . "','" . $classname . "','" . $pic . "','" . $showpic . "','" . $info . "','" . $url . "','" . $createtime . "','" . $uptatetime . "','" . $click . "','" . $token . "','" . $title . "')");

		return $db->insert_id;
	}
	function update($uid = -1, $uname = null, $keyword = null, $type = null, $text = null, $classid = -1, $classname = null, $pic = null, $showpic = null, $info = null, $url = null, $createtime = null, $uptatetime = null, $click = -1, $token = null, $title = null, $db, $id) {
		$update_values = "";
		if (!empty ($image)) {
			$imagename = "images='" . $image . "',";
		}
		if ($uid > 0) {
			$update_values .= "uid='" . $uid . "',";
		}
		if ($uname != null) {
			$update_values .= "uname='" . $uname . "',";
		}
		if ($keyword != null) {
			$update_values .= "keyword='" . $keyword . "',";
		}
		if ($type != null) {
			$update_values .= "type='" . $type . "',";
		}
		if ($text != null) {
			$update_values .= "text='" . $text . "',";
		}
		if ($classid > 0) {
			$update_values .= "classid='" . $classid . "',";
		}
		if ($classname != null) {
			$update_values .= "classname='" . $classname . "',";
		}
		if ($pic != null) {
			$update_values .= "pic='" . $pic . "',";
		}
		if ($showpic != null) {
			$update_values .= "showpic='" . $showpic . "',";
		}
		if ($info != null) {
			$update_values .= "info='" . $info . "',";
		}
		if ($url != null) {
			$update_values .= "url='" . $url . "',";
		}
		if ($createtime != null) {
			$update_values .= "createtime='" . $createtime . "',";
		}
		if ($uptatetime != null) {
			$update_values .= "uptatetime='" . $uptatetime . "',";
		}
		if ($uptatetime != null) {
			$update_values .= "uptatetime='" . $uptatetime . "',";
		}
		if ($click > 0) {
			$update_values .= "click='" . $click . "',";
		}
		if ($token != null) {
			$update_values .= "token='" . $token . "',";
		}
		if ($title != null) {
			$update_values .= "title='" . $title . "',";
		}
		$db->query("update " . TP_IMG_TABLE . " set {$imagename} " . substr($update_values, 0, $update_values . strlen - 1) . " where id=" . $id);

		return true;
	}
	function update_lottery($keyword, $info, $txt, $statdate, $enddate, $fist, $third, $second, $fistnums, $secondnums, $thirdnums, $allpeople, $title, $db, $id) {
		$update_values = "";
		if (!empty ($image)) {
			$imagename = "images='" . $image . "',";
		}

		if ($keyword != null) {
			$update_values .= "keyword='" . $keyword . "',";
		}

		if ($info != null) {
			$update_values .= "info='" . $info . "',";
		}

		if ($txt != null) {
			$update_values .= "txt='" . $txt . "',";
		}
		if ($statdate != null) {
			$update_values .= "statdate='" . $statdate . "',";
		}
		if ($enddate != null) {
			$update_values .= "enddate='" . $enddate . "',";
		}
		if ($fist != null) {
			$update_values .= "fist='" . $fist . "',";
		}
		if ($third != null) {
			$update_values .= "third='" . $third . "',";
		}
		if ($second != null) {
			$update_values .= "second='" . $second . "',";
		}
		if ($fistnums != null) {
			$update_values .= "fistnums='" . $fistnums . "',";
		}

		if ($secondnums != null) {
			$update_values .= "secondnums='" . $secondnums . "',";
		}
		if ($thirdnums != null) {
			$update_values .= "thirdnums='" . $thirdnums . "',";
		}
		if ($allpeople != null) {
			$update_values .= "allpeople='" . $allpeople . "',";
		}
		if ($title != null) {
			$update_values .= "title='" . $title . "',";
		}
		//	echo "update tp_lottery  set {$imagename} ".substr($update_values,0,$update_values.strlen-1)." where id=".$id;
		$db->query("update tp_lottery  set {$imagename} " . substr($update_values, 0, $update_values . strlen - 1) . " where id=" . $id);
		return true;
	}
	function updatestate($db, $id, $state) {
		if ($state == 0) {
			$c_state = 1;
		} else
			if ($state == 1) {
				$c_state = 0;
			}
		$db->query("update " . TP_IMG_TABLE . " set status='" . ($c_state) . "' where id in (" . implode(",", $id) . ")");
		return true;
	}
}
?>