<?php
/**
 * 微信支付
 */
define('HN1', true);
require_once('../global.php');
define('CUR_DIR_PATH', dirname(__FILE__));

$orderId = (isset($_GET['oid']) && !empty($_GET['oid'])) ? intval($_GET['oid']) : 0;
empty($orderId) && redirect('/orders.php', '参数错误');

$coupon_sn = (isset($_GET['coupon_id']) && !empty($_GET['coupon_id'])) ? $_GET['coupon_id'] : '';

include_once(MODEL_DIR.'/OrderModel.class.php');
$Order = new OrderModel($db, 'orders');
$order_number = OrderModel::genNo();
$out_trade_no = $order_number . create_number_randomstr(6);    // 微信支付订单编码
$order = $Order->get(array('order_id'=>$orderId, 'customer_id'=>$_SESSION['userInfo']->id));

empty($order) && redirect('/orders.php', '订单不存在');
($order->order_status_id > 0) && redirect('/orders.php', '订单已支付');
$all_price = $order->all_price;
$total_pay = $order->pay_online;

if ($coupon_sn == '')
{
    //有使用优惠券的订单没有在下单时立即支付
    if(!empty($order->coupon))
    {
        include_once(MODEL_DIR.'/UserCouponModel.class.php');
        $UserCoupon = new UserCouponModel($db);
        $coupon = $UserCoupon->get(array('coupon_num'=>$coupon_sn, 'user_id'=>$_SESSION['userInfo']->id));

        $UserCoupon->setTable('coupon');
        $coupon_id = $coupon->coupon_id;
        $coupon_info = $UserCoupon->get(array('id'=>$coupon_id),array('max_use','discount'));

        $discount = $coupon_info->discount;					// 减少的价格
        $total_pay = $order->pay_online - $discount;		// 需付的价格
    }
}
else
{
    $UserCoupon = D('UserCoupon');
	$coupon = $UserCoupon->get(array('coupon_num'=>$coupon_sn, 'user_id'=>$_SESSION['userInfo']->id));

	$UserCoupon->setTable('coupon');
	$coupon_id = $coupon->coupon_id;
	$coupon_info = $UserCoupon->get(array('id'=>$coupon_id),array('max_use','discount'));
	$max_use = $coupon_info->max_use;
	( $all_price < $max_use ) && redirect('/orders.php', '您的金额未达到优惠券的使用起点');

	$discount = $coupon_info->discount;					// 减少的价格
	$total_pay = $order->pay_online - $discount;		// 需付的价格

	$arrParam = array( 'coupon' => $coupon_sn,'discount_price'=>$discount );
	$arrWhere = array('order_id'=>$orderId );
	$rs = $Order->modify( $arrParam, $arrWhere );

	$UserCoupon->setTable('user_coupon');
	$rs = $UserCoupon->modify( array( 'is_used'=>1, 'use_time'=>time() ), array('coupon_num'=> $coupon_sn, 'is_used'=>0) );

    /*微信支付信息修改*/
    $arrWxPayInfoParam = array(
        'total_fee'     => $order->pay_online * 100,
        'coupon_fee'    => $discount * 100,
        'coupon_count'  => 1,
        'coupon_ids'    => $coupon_sn,
        'coupon_fees'   => $discount * 100,
        'time'          => time(),
    ); 
}


$WxPayInfoModel     = D('WxPayInfo');
$arrWxPayInfoParam['out_trade_no'] = $out_trade_no;
$rs = $WxPayInfoModel->modify( $arrWxPayInfoParam, array( 'order_id'=> $orderId ) );

$time = time();

require_once "lib/WxPay.Api.php";
require_once "pay_cls/WxPay.JsApiPay.php";
require_once 'log.php';

$logDir = LOG_DIR.'/wx/';
!file_exists($logDir) && mkdir($logDir, 0777, true);
$logFile = $logDir.'pay_'.date('Y-m-d', $time).'.log';

//初始化日志
$logHandler= new CLogFileHandler($logFile);
//$log = Log::Init($logHandler, 15);

$log = Log::Init($logHandler, 1);
$log->DEBUG("优惠券号为：" . $coupon_sn);
if ( $coupon_sn != '' )
{
    $conpon_desc = '使用了优惠券:' .  $coupon_sn . '，优惠金额为：' . $discount;
	$log->DEBUG("优惠券金额为：" . $discount);
}
else
{
    $conpon_desc = '该订单无优惠金额';
}
$log->DEBUG("应付金额为：" . $total_pay);


//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody('产品购买');
//$input->SetOut_trade_no($order->order_number);
$input->SetOut_trade_no($out_trade_no);
$input->SetTotal_fee(($total_pay)*100);
$input->SetTime_start(date('YmdHis', $time));
$input->SetNotify_url($gSetting['site_url'].$gSetting['wx_pay_dir'].'notify.php');
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$input->SetAttach($conpon_desc);
$order = WxPayApi::unifiedOrder($input);
$jsApiParameters = $tools->GetJsApiParameters($order);
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $gSetting['site_name'];?>-支付</title>
    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function(res){
                    switch(res.err_msg){
                        case "get_brand_wcpay_request:ok":
                            location.href='<?php echo $site;?>success_pay.php';
                            break;
                        case "get_brand_wcpay_request:cancel":
                        case "get_brand_wcpay_request:fail":
                            location.href = "<?php echo $site;?>orders.php";
                            break;
                    }
                }
            );
        }

        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    </script>
</head>
<body>
</body>
</html>
