<?php
// QR Code + Logo Generator QR图片中间加logo
$size = isset($_GET['size']) ? $_GET['size'] : '160x160';
$logo = isset($_GET['logo']) ? $_GET['logo'] : 'http://weixin16.struiyu.com/index.php';//中间那logo图

$chl = urlencode($logo);
$png = "http://chart.googleapis.com/chart?chs=$size&cht=qr&chl=$chl&chld=L|1&choe=UTF-8";
$QR = imagecreatefrompng($png);//外面那QR图
if ($logo !== FALSE) {
  $logo = imagecreatefromstring(file_get_contents($logo));
  $QR_width = imagesx($QR);
  $QR_height = imagesy($QR);
  $logo_width = imagesx($logo);
  $logo_height = imagesy($logo);
  $logo_qr_width = $QR_width/5;
  $scale = $logo_width/$logo_qr_width;
  $logo_qr_height = $logo_height/$scale;
  $from_width = ($QR_width-$logo_qr_width)/2;
  imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
}
header('Content-type: image/png');
imagepng($QR);
imagedestroy($QR);
?>