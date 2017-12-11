<?php
define('HN1', true);
require_once('../global.php');

$keyword = $_GET['keyword'] == null ? "0" : $_GET['keyword'];
/**
 * 生成带参数的二维码
 */
$access_token=get_token();    //获取access_token
    $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
    $array=array(
            "action_name"=> "QR_LIMIT_SCENE",
            "action_info"=>array(
            "scene"=> array("scene_id"=> $keyword)
            )
    );
	//echo json_encode($array);
    $res=http_post_data($url, json_encode($array));    //通过CURL传入json到微信接口获取ticket
	//print_R($res);
   // $res=json_decode($res,true);
   	$temp_res = explode(",",$res[1]);
    $res =explode(":",$temp_res[0]);
    $ticket=str_replace('"','',$res[1]);                    //获取到用于生成验证码的ticket
    $url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket"; 
      //得到的二维码链接
    echo $url;
    echo "<img src='$url'/>";

?>