<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
include(LIB_DIR."/PHPExcel.php");
$UserModel 	= D('User');

$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$type 		= !isset ($_GET['type']) 			? -1 : intval($_GET['type']);
$add_type 	= !isset ($_GET['add_type']) 		? -1 : intval($_GET['add_type']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$minfo 		= !isset ($_REQUEST['minfo']) || $_REQUEST['minfo'] == '邀请码搜索' ? '' : sqlUpdateFilter($_REQUEST['minfo']);
$name 		= !isset ($_REQUEST['name']) || $_REQUEST['name'] == '请输入姓名' ? '' : sqlUpdateFilter($_REQUEST['name']);

$start_time = !isset ($_REQUEST['starttime']) || $_REQUEST['starttime'] == '开始时间' ? '' : sqlUpdateFilter($_REQUEST['starttime']);
if ($start_time != '')
{
	$starttime = strtotime($start_time . ' 00:00:00');
}
else
{
	$starttime = 0;
}

$end_time = !isset ($_REQUEST['endtime']) || $_REQUEST['endtime'] == '结束时间' ? '' : sqlUpdateFilter($_REQUEST['endtime']);
if ($end_time != '')
{
	$endtime = strtotime($end_time . ' 23:59:59');
}
else
{
	$endtime = 0;
}

define('nowmodule', "user_action");

$url = "?module=" . nowmodule;

$sql = "select * from ".T('user')." where 1=1";

if($type > -1)
{
	$sql .= " and type={$type}";
	$url .= "&type={$type}";
}

if($add_type > -1)
{
	$sql .= " and add_type={$add_type}";
	$url .= "&add_type={$add_type}";
}

if(!empty($name))
{
	$sql .= " and name like '%{$name}%'";
	$url .= "&name={$name}";
}

if(!empty($minfo))
{
	$sql .= " and minfo like '%{$minfo}%'";
	$url .= "&minfo={$minfo}";
}

if($starttime > 0)
{
	$sql .= ' and addTime>='.$starttime;
	$url .= "&starttime={$start_time}";
}
if($endtime > 0)
{
	$sql .= ' and addTime<='.$endtime;
	$url .= "&endtime={$end_time}";
}

$sql .= " order by sorting desc,id asc";

switch ($act) 
{
	/****************编辑页******************/	
	case 'edit' :
		$id = !isset($_GET['id']) ? 0 :  intval($_GET['id']);
		
		if(empty($id))
		{
			redirect('?module='.nowmodule,"id不可用空");
			return;
		}
		
		$obj = $UserModel->get(array('id'=>$id));
		include ("tpl/user_edit.php");
	break;
	
	/*****************编辑保存*******************/
	case 'edit_save' :
		$id = intval($_REQUEST['id']);
		if (empty ($id)) {
			redirect('?module='.nowmodule."&act=edit&id=" . $id, "ID不能为空");
			return;
		}
		$level = $_REQUEST['level'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['level']));
		$name = $_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$sex = $_REQUEST['sex'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['sex']));
		$birthday = $_REQUEST['birthday'] == null || $_REQUEST['birthday'] == '生日' ? '' : sqlUpdateFilter($_REQUEST['birthday']);
		$birthday = strtotime($birthday);
		$email = $_REQUEST['email'] == null ? '' : sqlUpdateFilter($_REQUEST['email']);
		$tel = $_REQUEST['tel'] == null ? '' : sqlUpdateFilter($_REQUEST['tel']);
		$phone = $_REQUEST['phone'] == null ? '' : sqlUpdateFilter($_REQUEST['phone']);		
		$invitation_name = $_REQUEST['invitation_name'] == null ? '' : sqlUpdateFilter($_REQUEST['invitation_name']);
	
		$arrParam = array(
			'level'=>$level,
			'name'=>$name,
			'sex'=>$sex,
			'birthday'=>$birthday,
			'email'=>$email,
			'tel'=>	$tel,
			'phone'=>$phone,
			'invitation_name'=>$invitation_name
		);
	
		$obj = $UserModel->get(array('id'=>$id));

		if($UserModel->modify($arrParam,array('id'=>$id)) === false)
		{
			redirect('?module='.nowmodule."&act=edit&id=" . $id, "系统忙,操作失败");
			return;
		}
		
		createAdminLog($db,1,"编辑用户【".$obj->name."】信息,编号id:$id",'',$obj,$arrParam,'user');
		redirect('?module='.nowmodule."&act=edit&id=" . $id, "操作成功");
		return;
		
	break;
	
	/**************更新用户信息***************/
	case 'update_info' :
		$B_NEXT_OPENID = true;
		$NEXT_OPENID = "";
	
		while ($B_NEXT_OPENID) {
			$users = get_user_guanzhu(get_token(), $NEXT_OPENID);
			$openids = $users['data']['openid'];
			$NEXT_OPENID = $users['next_openid'];
			foreach ($openids as $a_openid) {
				
				$obj_user = $UserModel->get(array('openid'=>$a_openid));
				
				if ($obj_user != null && $obj_user->name == null && $obj_user->is_attention == 0) {
					$access_token = get_token();
					$openid_userinfo = get_userinfo($access_token, $a_openid);
					
					$arrParam = array(
						'name'			=>	$openid_userinfo['nickname'],
						'sex'			=>	intval($openid_userinfo['sex']),
						'head_image'	=>	$openid_userinfo['headimgurl'],
						'is_attention'	=>	1
					);
					$UserModel->modify($arrParam,array('id'=> $obj_user->id));								
				}
				
			}
			if ($NEXT_OPENID == '') {
				$B_NEXT_OPENID = false;
			}
		}
	
		redirect('?module=' . nowmodule, "更新成功！");
		return;
	break;
	
	/*****************删除用户信息*****************/
	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule, "您没选中任何条目");
			return;
		}
		
		if($UserModel->delete(array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙");
			return;
		}
		
		createAdminLog($db,1,"删除用户信息,编号id:".implode(",", $id));
		redirect('?module=' . nowmodule, "操作成功");
		return;	
	break;
	
	/***********导出功能**********/
	case 'excel_out':
	
		$result = $UserModel->query($sql);
	
		$objPHPExcel = new PHPExcel();
		$objSheet    = $objPHPExcel->getActiveSheet();
		$objSheet->setTitle('订单数据EXCEL导出');
	
		$objSheet->setCellValue('A1',"序号");
		$objSheet->setCellValue('B1',"姓名");
		$objSheet->setCellValue('C1',"电话");
		$objSheet->setCellValue('D1',"手机号码");
		$objSheet->setCellValue('E1',"添加时间");
		
	
		$i = 1;
		foreach( $result as $key=>$row )
		{
						
			$objSheet->setCellValue('A'.($key+2),$i);
			$objSheet->setCellValue('B'.($key+2),$row->name);	
			$objSheet->setCellValueExplicit('C'.($key+2),$row->tel,PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('D'.($key+2),$row->phone,PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('E'.($key+2),date('Y-m-d H:i:s',$row->addTime));
				
			$i++;
		}
	
		@ob_end_clean();//清除缓冲区,避免乱码
	
	
		// 输出
		header( "Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
		header('Content-Disposition: attachment;filename="用户信息' . date('Y-m-d-His',time()) . '.xls"');
		header('Cache-Control: max-age=0');
	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
		break;
	/*******************默认列表页**********************/
	default :
				
		
		
		$url .= "&page=";
		
		$pager = $UserModel->query( $sql,false, true, $page, 40 );
		
		include "tpl/user_list.php";
	break;
}
?>