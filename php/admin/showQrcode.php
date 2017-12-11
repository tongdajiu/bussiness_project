<?php
define('HN1', true);
require_once('../global.php');
VersionModel::checkOpen('qrcodeGoodsUser');
require_once LIB_DIR."/phpqrcode/phpqrcode.php";

$act = !isset($_GET['act']) ? '' : $_GET['act'];
$shop_id = !isset($_REQUEST['shop_id']) ? '' : $_REQUEST['shop_id'];
$product_id = !isset($_REQUEST['product_id']) ? '' : $_REQUEST['product_id'];
$lottery_type = !isset($_REQUEST['lottery_type']) ? '' : $_REQUEST['lottery_type'];
switch ($act) {
	case 'shake' :
		$value = $site."shake_index.php?shop_id=" . $shop_id;
		break;
	case 'product' :
		$value = $site."product_detail.php?product_id=" . $product_id;
		break;
	case 'lottery' :
		if($lottery_type ==1){
		$value = $site."lottery.php";
		}elseif($lottery_type ==2){
			$value = $site."egg.php";
		}else{
			$value = $site."shake.php";
		}
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