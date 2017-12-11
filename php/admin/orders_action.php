<?php
!defined('HN1') && exit('Access Denied.');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
include(LIB_DIR."/PHPExcel.php");
$OrderProductModel = D('OrderProduct');
$OrderModel = D('Order');
$UserModel 	= D('User');

$page		= !isset($_GET['page'])  			? 1 : intval($_GET['page']);
$act 		= !isset($_REQUEST['act']) 			? "list" : $_REQUEST['act'];
$condition 	= !isset($_REQUEST['condition']) 	? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 		= !isset($_REQUEST['keys'])  		? '' : sqlUpdateFilter($_REQUEST['keys']);

$order_status_id =!isset($_REQUEST['order_status_id']) ? -1 : sqlUpdateFilter($_REQUEST['order_status_id']);
$settledStatus = (!isset($_GET['settled_status']) || ($_GET['settled_status'] == '')) ? -1 : intval($_GET['settled_status']);


$start_time = !isset($_REQUEST['starttime'])  || $_REQUEST['starttime'] == '开始时间' ? '' : sqlUpdateFilter($_REQUEST['starttime']);

if($start_time != '')
{
	$starttime = strtotime($start_time.' 00:00:00');
}
else
{
	$starttime = 0;
}

$end_time = !isset($_REQUEST['endtime'])  || $_REQUEST['endtime'] == '结束时间' ? '' : sqlUpdateFilter($_REQUEST['endtime']);
if($end_time != '')
{
	$endtime = strtotime($end_time.' 23:59:59'	);
}
else
{
	$endtime = 0;
}


define('nowmodule',"orders_action");

$url = "?module=".nowmodule;

$sql = "select o.*,u.name as customer from ".T('orders')." as o left join ".T('user')." as u on o.customer_id=u.id where user_del=0";

if(!empty($keys)){
	switch($condition){
		case 'order_number':
			$sql .= " and o.order_number='{$keys}'";
			break;

		case 'phone':
			$sql .= " and (o.telephone='{$keys}' OR o.cellphone='{$keys}')";
			break;

		case 'username':
			$sql .=" and u.name like '%{$keys}%'";
			break;

		case 'shipping_firstname':
			$sql .= " and o.shipping_firstname='{$keys}'";
			break;
	}
	$url .= "&condition=$condition&keys=$keys";
}

if($starttime > 0){
	$sql .= ' and o.addtime>='.$starttime;
	$url .= "&starttime={$start_time}";
}
if($endtime > 0){
	$sql .= ' and o.addtime<='.$endtime;
	$url .= "&endtime={$end_time}";
}

if($settledStatus > -1){
	$sql .= ' and o.settled='.$settledStatus;
	$url .= "&settled_status={$settledStatus}";
}

if($order_status_id > -1)
{
	$sql .= ' and o.order_status_id='.$order_status_id;
	$url .= "&order_status_id=".$order_status_id;
}



$sql .=" order by o.order_id desc";


switch($act)
{

	/***************************************订单详情编辑页**************************************************/
	case 'edit':
		
		$id = !isset ($_GET['id']) 	? 0 : intval($_GET['id']);
		
		if (empty($id))
		{
			redirect('?module='.nowmodule,"id不能为空");
			return;
		}
		
		$obj = $OrderModel->get(array('order_id' => $id));
		
		$obj_customer = $UserModel->get(array('id'=>$obj->customer_id));
		
		$sql = "select op.*,p.model from ".T('order_product')." as op left join ".T('product')." as p on op.product_id=p.product_id where op.order_id={$id}";
		
		$cartList = $OrderModel->query($sql);
		
		include ("tpl/orders_edit.php");
	break;
	
	/***************************************编辑保存**************************************************/
	case 'edit_save':
	
		$id=intval($_REQUEST['id']);
		if (empty($id))
		{
			redirect("?module=".nowmodule,"ID不能为空");
			return;
		}
		
		$email 				=	$_REQUEST['email'] 				== null ? '' : sqlUpdateFilter($_REQUEST['email']);
		$telephone 			=	$_REQUEST['telephone'] 			== null ? '' : sqlUpdateFilter($_REQUEST['telephone']);
		$cellphone 			=	$_REQUEST['cellphone'] 			== null ? '' : sqlUpdateFilter($_REQUEST['cellphone']);
		$shipping_firstname =	$_REQUEST['shipping_firstname'] == null ? '' : sqlUpdateFilter($_REQUEST['shipping_firstname']);
		$shipping_address_1 =	$_REQUEST['shipping_address_1'] == null ? '' : sqlUpdateFilter($_REQUEST['shipping_address_1']);
		$shipping_address_2 =	$_REQUEST['shipping_address_2'] == null ? '' : sqlUpdateFilter($_REQUEST['shipping_address_2']);
		$shipping_postcode 	=	$_REQUEST['shipping_postcode'] 	== null ? '' : sqlUpdateFilter($_REQUEST['shipping_postcode']);
		$shipping_method 	=	$_REQUEST['shipping_method'] 	== null ? '' : sqlUpdateFilter($_REQUEST['shipping_method']);
		$remark 			=	$_REQUEST['remark'] 			== null ? '' : sqlUpdateFilter($_REQUEST['remark']);
		$order_status_id 	=	$_REQUEST['order_status_id'] 	== null ? '0' : sqlUpdateFilter(intval($_REQUEST['order_status_id']));
		$pay_method 		=	$_REQUEST['pay_method'] 		== null ? '' : sqlUpdateFilter($_REQUEST['pay_method']);
		$express_type 		=	$_REQUEST['express_type'] 		== null ? '' : sqlUpdateFilter($_REQUEST['express_type']);
		$express_number 	=	$_REQUEST['express_number'] 	== null ? '' : sqlUpdateFilter($_REQUEST['express_number']);
		$status_introduce 	= 	$_REQUEST['status_introduce'] 	== null ? '' : sqlUpdateFilter($_REQUEST['status_introduce']);
		
		$arrParam = array(
				'email'=>$email,
				'telephone'=>$telephone,
				'cellphone'=>$cellphone,
				'shipping_firstname'=>$shipping_firstname,
				'shipping_address_1'=>$shipping_address_1,
				'shipping_address_2'=>$shipping_address_2,
				'shipping_postcode'=>$shipping_postcode,
				'shipping_method'=>$shipping_method,
				'remark'=>$remark,
				'order_status_id'=>$order_status_id,
				'pay_method'=>$pay_method,
				'express_type'=>$express_type,
				'express_number'=>$express_number,
				'status_introduce'=>$status_introduce,
				'date_modified'=>date("Y-m-d H:i:s",time())
		);
		
		$obj = $OrderModel->get(array('order_id'=>$id));
		
		if($OrderModel->modify($arrParam,array('order_id'=>$id)) === false)
		{
			redirect("?module=".nowmodule."&act=edit&id=".$id,"系统忙,操作失败");
			return;
		}
			
		$str = '';
		if($obj->order_status_id != $order_status_id)
		{
			global $OrderStatus;
			$str = '订单状态变更为:'.$OrderStatus[$order_status_id];
	
			//发货，发送微信通知
			if($order_status_id == 2){
				global $objWX, $site;								
				$WeixinMessageTemplateModel = D('WeixinMessageTemplate');				
				$buyer = $UserModel->get(array('id'=>$obj->customer_id),'openid');
				$msgTplData = array('orderNo'=>$obj->order_number);
				$orderUrl = $site.'orders_info.php?order_id='.$id;
				$wxMsgTpl = $WeixinMessageTemplateModel->genTemplateData('delivery_notice', $buyer->openid, $orderUrl, $msgTplData);
				$objWX->sendTemplateMessage($wxMsgTpl);
			}
		}
		
		createAdminLog($db,2,"编辑订单【".$obj->order_number."】信息,编号id:{$id}".$str,'',$obj,$arrParam,'orders');
		
		if($order_status_id==3){
	
			//新增消费记录
			$obj_order= $OrderModel->get(array('order_id'=>$id));
	
			if(($pay_method=="3" && $obj_order->cashStatus!="1") || $pay_method=="1"){
				
				if($pay_method=="3"){
					$OrderModel->modify(array('cashStatus'=>1),array('order_id'=>$id));
				}
																
				$IntegralRecordModel = D('IntegralRecord');
				$integral_buy_record = $IntegralRecordModel->get(array('userid'=>$obj_order->customer_id,'order_id'=>$id,'type'=>1));
				
				
				if(empty($integral_buy_record)){
					
					
					//获取商品信息计算可获得积分
					$integralNum = 0;
					$rs_ops = $OrderProductModel->getAll(array('order_id'=>$id));
						
					$ProductModel = D('Product');
						
					foreach ($rs_ops as $rs_op)
					{
						$rs_p = $ProductModel->get(array('product_id'=>$rs_op->product_id));
					
						if(!empty($rs_p))
						{
							$integralNum += $rs_p->integral;
						}
					}
							
					
					$UserModel->update_integral(intval($integralNum),$obj_order->customer_id);
					
					$param = array(
						'type'		=>	1,
						'status'	=>	1,
						'userid'	=>	$obj_order->customer_id,
						'order_id'	=>	$id,
						'integral'	=>	intval($integralNum),
						'addtime'	=>	time()
					);
					
					$IntegralRecordModel->add($param);
				}
				
				$PayRecordModel = M('pay_records');
				
				$rs_pay_record = $PayRecordModel->get(array('userid'=>$obj_order->customer_id,'order_num'=>$obj_order->order_number));
				
				if(empty($rs_pay_record))
				{
					$paramPay = array(
							'userid'	=>	$obj_order->customer_id,
							'order_num'	=>	$obj_order->order_number,
							'status'	=>	1,
							'money'		=>	$obj_order->pay_online,
							'addtime'	=>	time()
					);
					
					$PayRecordModel->add($paramPay);
				}
			}
			
		}
		redirect("?module=".nowmodule."&act=edit&id=".$id,"操作成功");
		return;
	break;
	
	/***************************************订单发货**************************************************/
	case 'deliveredit':
		$id = !isset ($_GET['id']) 	? 0 : intval($_GET['id']);
		$rebackUrl = '?module='.nowmodule;
		empty($id) && redirect($rebackUrl, '参数错误');
		
		$order = $OrderModel->get(array('order_id'=>$id));
		
		empty($order) && redirect($rebackUrl, '订单不存在');
		($order->order_status_id > 1) && redirect($rebackUrl, '订单已发货');
						
		$products = $OrderProductModel->getAll(array('order_id'=>$id));
		
		
		include ("tpl/deliver_goods_edit.php");
	break;
		
	case 'deliveredit_save':
		global $ExpressType,$OrderStatus;
		$id = intval($_POST['id']);
		if (empty($id))
		{
			redirect(nowmodule,"ID不能为空");
			return;
		}
		
		$order_status_id =$_REQUEST['order_status_id'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['order_status_id']));
		$express_type =$_REQUEST['express_type'] == null ? '' : sqlUpdateFilter($_REQUEST['express_type']);
			
		if($OrderModel->modify(array('order_status_id'=>$order_status_id, 'express_type'=>$express_type), array('order_id'=>$id)) === false)
		{
			redirect('?module='.nowmodule.'&act=deliveredit&id='.$id, '操作失败');
			return;
		}
	
		$obj = $OrderModel->get(array('order_id'=>$id));
	
		//发货，发送微信通知
		if($order_status_id == 2){
			global $objWX, $site;
			include_once(MODEL_DIR.'/WeixinMessageTemplateModel.class.php');
			include_once(MODEL_DIR.'/UserModel.class.php');
			$WXMsgTpl = new WeixinMessageTemplateModel($db);
			$User = new UserModel($db);
			$buyer = $User->get(array('id'=>$obj->customer_id),'openid');
			$msgTplData = array('orderNo'=>$obj->order_number);// array('order_no'=>$obj->order_number, 'money'=>$obj->all_price, 'buy_time'=>date('Y-m-d H:i:s', $obj->addtime));
			$orderUrl = $site.'orders_info.php?order_id='.$id;
			$wxMsgTpl = $WXMsgTpl->genTemplateData('delivery_notice', $buyer->openid, $orderUrl, $msgTplData);
			$objWX->sendTemplateMessage($wxMsgTpl);
		}
	
		createAdminLog($db,2,"订单【".$obj->order_number."】发货","订单状态变更为{$OrderStatus[$order_status_id]},物流类型:{$ExpressType[$express_type]}");
	
	
		redirect('?module='.nowmodule, '操作成功');
	break;
		
			
	/***************************************删除订单************************************************/
	case 'del':
		$id = array();
		$id = $_REQUEST['id'];
		if (empty($id))
		{
			redirect('?module='.nowmodule,"您没选中任何条目");
			return;
		}
		
		$id = implode(",", $id);

		$arrParam = array('user_del'=>2);
		$arrWhere = array(
			'order_id'	=>	array('IN'=>"$id")	
		);
		
		if($OrderModel->modify($arrParam,$arrWhere) === false)
		{
			redirect('?module='.nowmodule,"系统忙");
			return;
		}
		
		createAdminLog($db,2,"删除订单信息,编号id:".implode(",", $id));
		redirect('?module='.nowmodule,"操作成功");
		return;
		
	break;
		
		
	case 'balance'://结算
		VersionModel::isOpen('distributorWalletManagement');		
		global $db, $gSetting, $distributionMaxLevel;
		$rebackUrl = '?module='.nowmodule;
		$orderId = intval($_GET['id']);				
		empty($orderId) && redirect($rebackUrl, '参数错误');
		$order = $OrderModel->get(array('order_id'=>$orderId));								
		empty($order) && redirect($rebackUrl, '要结算的订单不存在');
		($order->order_status_id != 3) && redirect($rebackUrl, '订单还未确认，不能进行结算');
		($order->abolishment_status == 1) && redirect($rebackUrl, '订单已被删除，不能进行结算');
		($order->settled == 1) && redirect($rebackUrl, '此订单已结算过，不能重复进行结算');
		($order->paid_price <= 0) && redirect($rebackUrl, '订单实付金额为0，不能进行结算');
	
		//返利给上级用户
		
		include_once(MODEL_DIR.'/UserChainModel.class.php');
		$UserChainModel = D('UserChain');
		
		$userChain = $UserChainModel->get(array('userid'=>$order->customer_id));
		
		empty($userChain) && redirect($rebackUrl, '没有上线用户，无需结算');
	
		include_once(LIB_DIR.'/Utils.class.php');
		
		$MoneyModel = D('Money');
		
		$CommissionModel = D('Commission');
		
		$userRebate = $UserChainModel->getBrokerage($order->customer_id, $order->paid_price, Utils::getValidLevelRebateRate($gSetting['distribution_rebate'], $distributionMaxLevel));
		
		empty($userRebate) && redirect($rebackUrl, '没有上线用户，无需结算');
		$success = true;
		$UserModel->startTrans();
		foreach($userRebate as $_uid => $_money){
			if($UserModel->opMoney($_uid, $_money)) {
				$log = array(
					'uid' => $_uid,
					'money' => $_money,
					'type' => MoneyModel::LOG_TYPE_REBATE,
					'remark' => '下级用户【id：'.$order->customer_id.'】订单【'.$order->order_number.'】返利',
				);
				$clog = $log;
				unset($clog['type']);
				$clog['orderno'] = $order->order_number;
				if(!$MoneyModel->addLog($log) || !$CommissionModel->addLog($clog)){
					$success = false;
					break;
				}
			}else{
				$success = false;
				break;
			}
		}
		if($success){
			$success = ($OrderModel->modify(array('settled'=>1), array('order_id'=>$orderId)) === false) ? false : true;
		}
		if($success){
			createAdminLog($db,2,"订单【".$order->order_number."】结算");
			$UserModel->commit();
			redirect($rebackUrl, '结算成功');
		}else{
			$UserModel->rollback();
			redirect($rebackUrl, '结算失败');
		}
		
	break;
	
	case 'order_print':
		$order_id = !isset ($_GET['order_id']) ? 0 : intval($_GET['order_id']);
		$obj_order = $OrderModel->get(array('order_id'=>$order_id));		
		$cartlist = $OrderProductModel->getAll('order_id='.$order_id);
		
		$coupon_num = $obj_order->coupon;
		if(!empty($coupon_num))
		{
			$obj_user_coupon = M('user_coupon')->get(array('coupon_num'=>$coupon_num));
			
			if(!empty($obj_user_coupon))
			{
				$obj_coupon = M('coupon')->get(array('id'=>$obj_user_coupon->coupon_id));
				
				if(!empty($obj_coupon))
				{
					$discount = $obj_coupon->discount;
				}
			}
			
		}
		
		include ("tpl/order_print_web.php");
	break;
	
	//导出excel
	case 'excel_out':
		
		$result = $OrderModel->query($sql);
		
		$objPHPExcel = new PHPExcel();
		$objSheet    = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('订单数据EXCEL导出');
		
		$objSheet->setCellValue('A1',"序号");
		$objSheet->setCellValue('B1',"订单号");
		$objSheet->setCellValue('C1',"商品名称");
		$objSheet->setCellValue('D1',"商品规格");
		$objSheet->setCellValue('E1',"商品价格");
		$objSheet->setCellValue('F1',"顾客");
		$objSheet->setCellValue('G1',"手机号码");
		$objSheet->setCellValue('H1',"收货人");
		$objSheet->setCellValue('I1',"订单状态");
		$objSheet->setCellValue('J1',"付款方式");
		$objSheet->setCellValue('K1',"订单价格");
		$objSheet->setCellValue('L1',"添加时间");
		
		$i = 1;
		$k = 2;
		foreach( $result as $key=>$row )
		{
			$str = '';
				
			$op_details = $OrderProductModel->getAll(array('order_id'=>$row->order_id));
		
			$num = count($op_details);
			$rowStart = $k;
			$rowEnd = ($num > 0) ? ($rowStart+$num-1) : $rowStart;
		
			$objSheet->setCellValue('A'.$rowStart,$i);
			$objSheet->setCellValueExplicit('B'.$rowStart,$row->order_number,PHPExcel_Cell_DataType::TYPE_STRING);					
			$objSheet->setCellValue('F'.$rowStart,$row->customer);
			$objSheet->setCellValueExplicit('G'.$rowStart,$row->telephone,PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('H'.$rowStart,$row->shipping_firstname);			
			$objSheet->setCellValue('I'.$rowStart,$OrderStatus[$row->order_status_id]);
			$objSheet->setCellValue('J'.$rowStart,$PayMethod[$row->pay_method]);
			$objSheet->setCellValue('K'.$rowStart,$row->all_price);
			$objSheet->setCellValue('L'.$rowStart,date('Y-m-d H:i:s',$row->addtime));
		
			if($num > 0){
				$j = $rowStart;
				foreach ($op_details as $op_detail)
				{
					$objSheet->setCellValue('C'.$j,$op_detail->product_name);
					$objSheet->setCellValue('D'.$j,$op_detail->attribute);
					$objSheet->setCellValue('E'.$j,$op_detail->product_price);
					$j++;
				}
			}
		
			if($num > 1){
				//合并单元格
				$objSheet->mergeCells('A'.$rowStart.':A'.$rowEnd);
				$objSheet->mergeCells('B'.$rowStart.':B'.$rowEnd);
				$objSheet->mergeCells('F'.$rowStart.':F'.$rowEnd);
				$objSheet->mergeCells('G'.$rowStart.':G'.$rowEnd);
				$objSheet->mergeCells('H'.$rowStart.':H'.$rowEnd);
				$objSheet->mergeCells('I'.$rowStart.':I'.$rowEnd);
				$objSheet->mergeCells('J'.$rowStart.':J'.$rowEnd);
				$objSheet->mergeCells('K'.$rowStart.':K'.$rowEnd);
				$objSheet->mergeCells('L'.$rowStart.':L'.$rowEnd);
			}
		
			$k = ($num > 1) ? $rowEnd : ($rowEnd+1);
			$i++;
		}
		
		@ob_end_clean();//清除缓冲区,避免乱码
		
		
		// 输出
		header( "Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
		header('Content-Disposition: attachment;filename="订单信息' . date('Y-m-d-His',time()) . '.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	break;

		
	/********************************默认列表页**************************************/	
	default:
		
		$url .= "&page=";
		
		$pager = $OrderModel->query( $sql,false, true, $page, 40 );

		include "tpl/orders_list.php";
	break;
}
?>