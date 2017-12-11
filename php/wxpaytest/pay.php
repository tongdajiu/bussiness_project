<?php
/**
 * 微信支付
 */
define('HN1', true);
require_once('../global.php');
define('CUR_DIR_PATH', dirname(__FILE__));

$orderId = (isset($_GET['oid']) && !empty($_GET['oid'])) ? intval($_GET['oid']) : 0;
empty($orderId) && redirect('/orders.php', '参数错误');

include_once(MODEL_DIR.'/OrderModel.class.php');
$Order = new OrderModel($db, 'orders');
$order = $Order->get(array('order_id'=>$orderId));
empty($order) && redirect('/orders.php', '订单不存在');
($order->order_status_id > 0) && redirect('/orders.php', '订单已支付');

$time = time();

require_once "lib/WxPay.Api.php";
require_once "pay_cls/WxPay.JsApiPay.php";
require_once 'log.php';

$logDir = LOG_DIR.'/wx/';
!file_exists($logDir) && mkdir($logDir, 0777, true);
$logFile = $logDir.'pay_'.date('Y-m-d', $time).'.log';

//初始化日志
$logHandler= new CLogFileHandler($logFile);
$log = Log::Init($logHandler, 15);

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody('产品购买');
$input->SetOut_trade_no($order->order_number);
$input->SetTotal_fee($order->all_price*100);
$input->SetTime_start(date('YmdHis', $time));
$input->SetNotify_url($site.'wxpaytest/notify.php');
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
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
                            location.href='../success_pay.php?order_id=<?php echo $order_id;?>';
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
