<?php
define('HN1', true);
require_once('../global.php');
require_once MODEL_DIR . '/UserModel.class.php';

$userModel = new UserModel($db);
$page = !isset ($_GET['page']) 	? 1 : intval($_GET['page']);
$keys = !isset ($_GET['keys']) 	? '' : trim($_GET['keys']);

$sql = "select id,openid,name from user";
$url = "?module=search_user";

if($keys != '')
{
	$sql .= " where name like '%{$keys}%' or openid like '{$keys}%'";
	$url .= "&keys={$keys}";
}
$url .= "&page=";


$pager = $userModel->query( $sql,false,true,$page,20 );


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理平台</title>
<link href="<?php echo __JS__;?>/highslide/highslide.css" rel="stylesheet" type="text/css" />
<link href="./css/list_style.css" rel="stylesheet" type="text/css" />
<link href="./css/from.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo __JS__;?>/jquery-1.9.0.min.js"></script>
<script language="javascript" src="<?php echo __JS__;?>/validator/jquery-validate.js"></script>
</head>
<body>
<form action="index.php" method="GET">
<input type="hidden" name="module" value="search_user" />
<input type="text" id="keys" name="keys" value="" class="STYLE1" style="width:180px;color:#A9A9A9" />
<input type="submit" value=" 搜索 " style="width:50px;" />
</form>

<div style="clear:both;"></div>
 <div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="search_user" />
        <table cellpadding="0" cellspacing="0" border="0" id="table" style="width:500px;" class="tinytable">
            <thead>
	            <tr>
					<th style="width:280px;"><h3>openid</h3></th>
					<th><h3>真实姓名</h3></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($pager['DataSet'] as $row) {
			?>
			<tr>
				<td><label><input id="user_id" name="user_id" type="radio" class="STYLE2" value="<?php echo $row->id; ?>"><span><?php echo $row->openid; ?></span></label></td>
				<td><?php echo $row->name; ?></td>
			</tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div >
            <div>
                <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $pager['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $pager['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $pager['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $pager['Last']; ?>">[最后一页]</a>
            </div>
            <div class="page"></div>
        </div>
    </div>

</div>
</body>
</html>