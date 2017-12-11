<?php
define('HN1', true);
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
require_once('global.php');
VersionModel::checkOpen('qrcodeGoodsUser');
require_once LIB_DIR."/phpqrcode/phpqrcode.php";

$act = !isset($_GET['act']) ? '' : $_GET['act'];
$product_id = !isset($_REQUEST['product_id']) ? '' : $_REQUEST['product_id'];

switch ($act) {
	case 'product' :
		$value = $site."product_detail.php?product_id=" . $product_id;
		break;
	default :
		$value = $site."index.php";
		break;
}
$errorCorrectionLevel = "L";
$matrixPointSize = "10";
QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);
exit;
?>