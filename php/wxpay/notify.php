<?php
/**
 * 微信支付后台通知
 */
define('HN1', true);
require_once('../global.php');
define('CUR_DIR_PATH', dirname(__FILE__));

$time = time();

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'log.php';

$logDir = LOG_DIR.'/wx/';
!file_exists($logDir) && mkdir($logDir, 0777, true);
$logFile = $logDir.'pay_notify_'.date('Y-m-d', $time).'.log';

//初始化日志
$logHandler= new CLogFileHandler($logFile);
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        global $db;

        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            Log::DEBUG('输入参数不正确');
            $msg = '输入参数不正确';
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            Log::DEBUG('微信订单查询失败');
            $msg = '订单查询失败';
            return false;
        }

        $WxPayInfoModel     =  D('WxPayInfo');
        $OrderModel         =  D('Order');
        $PayRecordsModel    =  D('PayRecords');

        //处理本系统订单
        $arrWxPayInfo = $WxPayInfoModel->get(array('out_trade_no'=>$data['out_trade_no']));
        $arrOrderInfo = $OrderModel->get( array('order_id'=> $arrWxPayInfo->order_id ) );



        if(empty($arrWxPayInfo)){
            Log::DEBUG('没有相关订单：'.$data['out_trade_no']);
            $msg = '没有相关订单';
            return false;
        }

        if ( $arrWxPayInfo->is_paid == 1 )
        {
            Log::DEBUG($data['out_trade_no']. '该订单已成功支付，请不要重复支付');
            $msg = '该订单已成功支付，请不要重复支付';
            return false;
        }

        $allNeedPay = $arrWxPayInfo->total_fee - $arrWxPayInfo->coupon_fee;

        if( ($data['total_fee']) != $allNeedPay )
        {
            Log::DEBUG('订单支付金额不一致：订单应付金额为' . $allNeedPay . '，支付金额为'.($data['total_fee']/100));
            $msg = '订单支付金额不一致';
            return false;
        }

        // 如果未付款
        if( $arrOrderInfo->order_status_id == 0)
        {
            $OrderModel->startTrans();

            $arrParam = array(
                'userid'    => $arrOrderInfo->customer_id,
                'order_num' => $arrOrderInfo->order_number,
                'status'    => 1,
                'money'     => $data['total_fee']/100,
                'addtime'   => $data['time_end']
            );
        
            $rs = $PayRecordsModel->add( $arrParam );
            $success = $rs > 0 ? true : false;

            if ( ! $success )
            {
                $arrOrderInfo->rollback();
                Log::DEBUG('添加支付记录失败');
                return false;
            }    
 

            //更改订单状态
            $success = $OrderModel->modify(array('order_status_id'=>1,'paid_price'=>$data['total_fee']/100), array('order_id'=>$arrOrderInfo->order_id)) ? true : false;
            !$success && Log::DEBUG('更改订单状态失败');

            //记录支付信息
            if($success){

                $payInfo = array(
                    'time_end'  => $data['time_end'],
                    'openid'    => $data['openid'],
                    'is_paid'   => 1,
                    'paid_time' => time()
                );

                $rs = $WxPayInfoModel->modify( $payInfo, array('out_trade_no'=>$data['out_trade_no']) );
                
                $success =  $rs>0 ? true : false;
                !$success && Log::DEBUG("添加微信支付记录信息失败\r\n支付信息内容：".var_export($payInfo, true));
            }

            if(!$success){
                $arrOrderInfo->rollback();
                Log::DEBUG('订单处理失败');
                $msg = '订单处理失败';
                return false;
            }

            $OrderModel->commit();
        }
        Log::DEBUG('订单处理成功');
        return true;
    }
}

Log::DEBUG("\r\nbegin notify");
$notify = new PayNotifyCallBack();

/*
$data = array(
    'out_trade_no' => '20170517003225685087099411',
    'total_fee'    => 20,
    'time_end'     => time(),
    'openid'       => 123
);


$rs = $notify->NotifyProcess($data, $msg);

var_dump($rs);
echo $msg;
*/

$notify->Handle(false);

