<?php
!defined('HN1') && exit('Access Denied.');
VersionModel::checkOpen('integralExchangeManagement');
include(LIB_DIR."/PHPExcel.php");
define('nowmodule',"integral_orders_action");
define('nowmodule_',"integral_orders");
$IntegralOrdersModel 		= D('IntegralOrders');
$IntegralOrdersDetailModel 	= M('integral_orders_detail');


$page		= !isset($_GET['page'])  			? 1 : intval($_GET['page']);
$act 		= !isset($_REQUEST['act']) 			? "list" : $_REQUEST['act'];
$condition 	= !isset($_REQUEST['condition']) 	? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 		= !isset($_REQUEST['keys'])  		? '' : sqlUpdateFilter($_REQUEST['keys']);
$order_type = !isset($_REQUEST['order_type']) 	? 0 : sqlUpdateFilter($_REQUEST['order_type']);

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

$url = "?module=".nowmodule;

if($order_type > -1){
	$url .= "&order_type=".$order_type;
}

$strSQL = "select io.*,u.name as customer from integral_orders as io left join user as u on io.customer_id=u.id where 1=1";

$arrCond[] = 'io.user_del=0';

if(!empty($order_type))
{
	switch($order_type)
	{
		//待发货
		case 1:
			$arrCond[] = 'io.delivery_status=0';
			break;

			//已发货
		case 2:
			$arrCond[] = 'io.delivery_status=1';
			break;

			//待确认
		case 3:
			$arrCond[] = 'io.delivery_status=1';
			$arrCond[] = 'io.receiving_state=0';
			break;

			//已确认
		case 4:
			$arrCond[] = 'io.delivery_status=1';
			$arrCond[] = 'io.receiving_state=1';
			break;
	}
}

if(!empty($keys)){
	switch($condition){
		case 'order_number':
			$arrCond[] = 'io.order_number='.$keys;
			break;

		case 'phone':
			$arrCond[] = "io.phone='{$keys}'";
			break;

		case 'customer':
			$arrCond[] = "u.name like '%{$keys}%'";
			break;

		case 'receiver':
			$arrCond[] = "io.receiver like '%{$keys}%'";
			break;
	}
	$url .= "&condition=$condition&keys=$keys";
}


if($starttime > 0){
	$arrCond[] = 'io.create_time>='.$starttime;
	$url .= "&starttime={$start_time}";
}
if($endtime > 0){
	$arrCond[] = 'io.create_time<='.$endtime;
	$url .= "&endtime={$end_time}";
}


$arrWhere = implode(' AND ', $arrCond);

if(!empty($arrWhere))
{
	$strSQL .= " AND ".$arrWhere." order by io.id desc";
}

switch($act)
{
	//编辑页
	case 'edit':
		
		$id = !isset ($_GET['id']) 		? 0 : intval($_GET['id']);
		$rebackUrl = '?module='.nowmodule;
		$sql = "select io.*,u.name as customer from integral_orders as io left join user as u on io.customer_id=u.id where io.id={$id}";
		$obj = $IntegralOrdersModel->query($sql,true);
		empty($obj) && redirect($rebackUrl, "订单不存在!");
		
		$obj_details = $IntegralOrdersDetailModel->getAll(array('integral_orders_id'=>$obj->id));
		
		empty($obj_details) && redirect($rebackUrl, '订单的商品详情不存在');
		include ("tpl/integral_orders_edit.php");
	break;
	
	
	//编辑保存
	case 'edit_save':
		$order_id = intval($_REQUEST['id']);

		if (empty($order_id))
		{
			redirect('?module='.nowmodule,"ID不能为空");
			return;
		}
		$obj = $IntegralOrdersModel->get(array('id'=>$order_id));

		empty($obj) && redirect('?module='.nowmodule,'订单不存在');
		
		if($obj->delivery_status == 0)
		{
			$phone = $_REQUEST['phone'] == null ? '' : sqlUpdateFilter($_REQUEST['phone']);
			$receiver = $_REQUEST['receiver'] == null ? '' : sqlUpdateFilter($_REQUEST['receiver']);
			$address = $_REQUEST['address'] == null ? '' : sqlUpdateFilter($_REQUEST['address']);
	
			$data = array(
				'phone'	=>	$phone,
				'receiver'	=>	$receiver,
				'address'	=>	$address
			);
		}
		if($obj->delivery_status == 1)
		{
			$express_type =$_REQUEST['express_type'] == null ? '' : sqlUpdateFilter($_REQUEST['express_type']);
			$express_number =$_REQUEST['express_number'] == null ? '' : sqlUpdateFilter($_REQUEST['express_number']);

			$data['express_type'] 	= $express_type;
			$data['express_number'] = $express_number;
		}

		if($IntegralOrdersModel->modify($data, array('id'=>$order_id)) === false)
		{
			redirect('?module='.nowmodule.'&act=edit&id='.$order_id, '操作失败');
			return;
		}

		createAdminLog($db,9,"编辑积分兑换订单【".$obj->order_number."】",'',$obj,$data,"integral_orders");

		redirect('?module='.nowmodule, '操作成功');

	break;
	
	//订单详情
	case 'detail':
		$id = !isset ($_GET['id']) 		? 0 : intval($_GET['id']);
		$rebackUrl = '?module='.nowmodule;
		$sql = "select io.*,u.name as customer from integral_orders as io left join user as u on io.customer_id=u.id where io.id={$id}";
		$obj = $IntegralOrdersModel->query($sql,true);
		empty($obj) && redirect($rebackUrl, "订单不存在!");
		
		$obj_details = $IntegralOrdersDetailModel->getAll(array('integral_orders_id'=>$obj->id));
		
		empty($obj_details) && redirect($rebackUrl, '订单的商品详情不存在');
		
		include "tpl/integral_orders_detail.php";
	break;
	
	//发货编辑
	case 'deliver':
		$id = !isset ($_GET['id']) 		? 0 : intval($_GET['id']);
		$rebackUrl = '?module='.nowmodule;
		$sql = "select io.*,u.name as customer from integral_orders as io left join user as u on io.customer_id=u.id where io.id={$id}";
		$obj = $IntegralOrdersModel->query($sql,true);
		empty($obj) && redirect($rebackUrl, "订单不存在!");
		
		$obj_details = $IntegralOrdersDetailModel->getAll(array('integral_orders_id'=>$obj->id));
		
		empty($obj_details) && redirect($rebackUrl, '订单的商品详情不存在');
		($obj->delivery_status == 1) && redirect($rebackUrl, '订单已发货');
		
		include ("tpl/deliver_integral_goods.php");
	break;
	

	//发货保存
	case 'deliver_save':
		global $ExpressType,$OrderStatus;

		$order_id = intval($_REQUEST['id']);

		if (empty($order_id))
		{
			redirect('?module='.nowmodule,"ID不能为空");
			return;
		}

		$express_type =$_REQUEST['express_type'] == null ? '' : sqlUpdateFilter($_REQUEST['express_type']);
		$express_number =$_REQUEST['express_number'] == null ? '' : sqlUpdateFilter($_REQUEST['express_number']);


		if($IntegralOrdersModel->modify(array('delivery_status'=>1, 'express_type'=>$express_type,'express_number'=>$express_number,'delivery_time'=>time()), array('id'=>$order_id)) === false)
		{
			redirect('?module='.nowmodule_.'&act=deliver&id='.$order_id, '操作失败');
			return;
		}

		$obj = $IntegralOrdersModel->get(array('id'=>$order_id));

		//发货，发送微信通知

		global $objWX, $site;
		include_once(MODEL_DIR.'/WeixinMessageTemplateModel.class.php');
		include_once(MODEL_DIR.'/UserModel.class.php');
		$WXMsgTpl = new WeixinMessageTemplateModel($db);
		$User = new UserModel($db);
		$buyer = $User->get(array('id'=>$obj->customer_id),'openid');
		$msgTplData = array('orderNo'=>$obj->order_number);
		$orderUrl = $site.'integral_orders_info.php?id='.$order_id;
		$wxMsgTpl = $WXMsgTpl->genTemplateData('integral_delivery_notice', $buyer->openid, $orderUrl, $msgTplData);
		$objWX->sendTemplateMessage($wxMsgTpl);


		createAdminLog($db,9,"积分兑换订单【".$obj->order_number."】发货","订单状态变更为已发货,物流类型:{$ExpressType[$express_type]}");

		redirect('?module='.nowmodule, '操作成功');

	break;

	//确认收货
	case 'confirm':
		$id = $_REQUEST['order_id'];
		if (empty($id))
		{
			redirect('?module='.nowmodule,"ID不能为空");
			return;
		}

		$obj = $IntegralOrdersModel->get(array('id'=>$id));

		empty($obj) && redirect('?module='.nowmodule,'订单不存在');

		($obj->delivery_status == 0) && redirect('?module='.nowmodule, '订单未发货');
		($obj->receiving_state == 1) && redirect('?module='.nowmodule, '订单已确认');

		if($IntegralOrdersModel->modify(array('receiving_state'=>1, 'receiving_time'=>time()), array('id'=>$id)) === false)
		{
			redirect('?module='.nowmodule, '操作失败');
			return;
		}

		createAdminLog($db,9,"积分兑换订单【".$obj->order_number."】确认收货","订单状态变更为已确认");

		redirect('?module='.nowmodule,"操作成功");
		return;

	break;
	
	case 'print':
		$rebackUrl = '?module='.nowmodule;
		$order_id = !isset ($_GET['order_id']) ? 0 : intval($_GET['order_id']);
		
		empty($order_id) && redirect($rebackUrl, '参数错误');
		
		$sql = "select io.*,u.name as customer from integral_orders as io left join user as u on io.customer_id=u.id where io.id={$order_id}";
		$obj = $IntegralOrdersModel->query($sql,true);
		
		empty($obj) && redirect($rebackUrl, "订单不存在!");
		
		$obj_details = $IntegralOrdersDetailModel->getAll(array('integral_orders_id'=>$obj->id));
		
		empty($obj_details) && redirect($rebackUrl, '订单的商品详情不存在');
		
		
		include ("tpl/integral_order_print_web.php");
	break;
	

	//导出excel
	case 'excel_out':
		
		$result = $IntegralOrdersModel->query($strSQL);
		
		
		$objPHPExcel = new PHPExcel();
		$objSheet    = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('订单数据EXCEL导出');
		
		$objSheet->setCellValue('A1',"序号");
		$objSheet->setCellValue('B1',"订单号");
		$objSheet->setCellValue('C1',"商品名称");
		$objSheet->setCellValue('D1',"商品兑换积分");
		$objSheet->setCellValue('E1',"顾客");
		$objSheet->setCellValue('F1',"手机号码");
		$objSheet->setCellValue('G1',"收货人");
		$objSheet->setCellValue('H1',"订单状态");
		$objSheet->setCellValue('I1',"订单总积分");
		$objSheet->setCellValue('J1',"添加时间");

		$i = 1;
		$k = 2;
		foreach( $result as $key=>$row )
		{
			$str = '';
			switch($row->delivery_status){
				case 0:
					$str = '等待发货';
					break;
				case 1:
					switch($row->receiving_state){
						case 0:
							$str = '已发货';
							break;
						case 1:
							$str = '已确认';
							break;
					}
					break;
			}
			
 			$obj_details = $IntegralOrdersDetailModel->getAll(array('integral_orders_id'=>$row->id));
 			
 			$num = count($obj_details);
			$rowStart = $k;
			$rowEnd = ($num > 0) ? ($rowStart+$num-1) : $rowStart;

			$objSheet->setCellValue('A'.$rowStart,$i);
			$objSheet->setCellValueExplicit('B'.$rowStart,$row->order_number,PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('E'.$rowStart,$row->customer);
			$objSheet->setCellValueExplicit('F'.$rowStart,$row->phone,PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('G'.$rowStart,$row->receiver);
			$objSheet->setCellValue('H'.$rowStart,$str);
			$objSheet->setCellValue('I'.$rowStart,$row->all_integral);
			$objSheet->setCellValue('J'.$rowStart,date('Y-m-d H:i:s',$row->create_time));

			if($num > 0){
				$j = $rowStart;
				foreach ($obj_details as $obj_detail)
				{
					$objSheet->setCellValue('C'.$j,$obj_detail->product_name);
					$objSheet->setCellValue('D'.$j,$obj_detail->product_integral);
					$j++;
				}
			}

			if($num > 1){
				//合并单元格
				$objSheet->mergeCells('A'.$rowStart.':A'.$rowEnd);
				$objSheet->mergeCells('B'.$rowStart.':B'.$rowEnd);
				$objSheet->mergeCells('E'.$rowStart.':E'.$rowEnd);
				$objSheet->mergeCells('F'.$rowStart.':F'.$rowEnd);
				$objSheet->mergeCells('G'.$rowStart.':G'.$rowEnd);
				$objSheet->mergeCells('H'.$rowStart.':H'.$rowEnd);
				$objSheet->mergeCells('I'.$rowStart.':I'.$rowEnd);
				$objSheet->mergeCells('J'.$rowStart.':J'.$rowEnd);
			}

			$k = ($num > 1) ? $rowEnd : ($rowEnd+1);
			$i++;
		}
		
		//设置导出数据的列宽
		//$objSheet->getColumnDimension('A')->setWidth(20);

		@ob_end_clean();//清除缓冲区,避免乱码
		
		
		// 输出
		header( "Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
		header('Content-Disposition: attachment;filename="积分兑换订单信息' . date('Y-m-d-His',time()) . '.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	break;
	

	//默认列表页
	default:
	
		$url .= "&page=";
		$pager = $IntegralOrdersModel->query( $strSQL,false,true, $page, 40 );

		include "tpl/integral_orders_list.php";

	break;
}
?>