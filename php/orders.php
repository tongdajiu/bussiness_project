<?php
define('HN1', true);
require_once('./global.php');
include "common.php";	//设置只能用微信窗口打开

$OrderModel = D('Order');
$OrderProductModel = D('OrderProduct');
$CommentModel = M('comment');

$user = $_SESSION['userInfo'];

if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=orders");
	return;
}

$act = !isset($_REQUEST['act']) ? '' : $_REQUEST['act'];

switch($act){
	case 'confirm':			
		$order_id = $_GET['order_id'] == null ? 0 : $_GET['order_id'];
	
		$OrderModel->startTrans();
	
		$success = true;
		try{
			
			$obj_order = $OrderModel->get(array('order_id'=>$order_id));
			
			if(empty($obj_order))
			{
				$success = false;
			}
			
			if($OrderModel->modify(array('order_status_id'=>3,'status_time'=>time()),array('order_id'=>$order_id)) === false)
			{
				$success = false;
			}
			
			//获取商品信息计算可获得积分
			$integralNum = 0;
			$rs_ops = $OrderProductModel->getAll(array('order_id'=>$order_id));
			
			$ProductModel = D('Product');
			
			foreach ($rs_ops as $rs_op)
			{
				$rs_p = $ProductModel->get(array('product_id'=>$rs_op->product_id));
				
				if(!empty($rs_p))
				{
					$integralNum += $rs_p->integral;
				}
			}
			
			
			$UserModel 	= D('User');
			
			//更新用户积分获取数
			if($integralNum != 0)
			{
				if($UserModel->update_integral($integralNum,$userid) === false)
				{
					$success = false;
				}
					
				$param = array(
						'type'		=>	1,
						'status'	=>	1,
						'userid'	=>	$userid,
						'order_id'	=>	$order_id,
						'integral'	=>	$integralNum,
						'addtime'	=>	time()
				);
					
				$IntegralRecordModel = D('IntegralRecord');
					
				//添加用户积分获取记录
				if($IntegralRecordModel->add($param) === false)
				{
					$success = false;
				}
			}
			
			
		}catch(Exception $e){
			$success = false;
		}
		
		if($success){
			$OrderModel->commit();
			$opmsg = '';
		}else{
			$OrderModel->rollback();
			$opmsg = '操作失败';
		}
		
		redirect('orders.php', $opmsg);
		return;
	break;

	default:
		$statusMap = array(1=>0, 2=>1, 3=>2, 4=>3);
	    $status = (isset($_GET['status']) && in_array($_GET['status'], array_keys($statusMap))) ? intval($statusMap[$_GET['status']]) : -1;

		$arrParam['customer_id']= $userid;
		if ( $status >= 0 )
		{
			$arrParam['order_status_id']= $status;
		}

	    $orderList = $OrderModel->gets($arrParam,array('addtime'=>'desc', 'order_id'=>'desc'));
	    include TEMPLATE_DIR.'/orders_web.php';
	break;
}
?>
