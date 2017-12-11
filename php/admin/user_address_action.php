<?php
! defined ( 'HN1' ) && exit ( 'Access Denied.' );

$UserAddressModel = D ( 'UserAddress' );

$page 	= ! isset ( $_GET ['page'] ) 	? 1 : intval ( $_GET ['page'] );
$act 	= ! isset ( $_REQUEST ['act'] ) ? "list" : $_REQUEST ['act'];
$name 	= ! isset ( $_REQUEST ['name'] ) || $_REQUEST ['name'] == '请输入姓名' ? '' : sqlUpdateFilter ( $_REQUEST ['name'] );

define ( 'nowmodule', "user_address_action" );

switch ($act) 
{
	case 'edit' :
		$id = !isset($_GET['id'])  	? 0 : intval($_GET['id']);
		
		if(empty($id))
		{
			redirect ( "?module=".nowmodule, "ID不能为空" );
			return;
		}
		
		$obj = $UserAddressModel->get(array('id'=>$id));
		include "tpl/user_address_edit.php";
	break;
	
	case 'edit_save' :

		$id = intval ( $_REQUEST ['id'] );
		
		if (empty ( $id )) 
		{
			redirect ( "?module=".nowmodule, "ID不能为空" );
			return;
		}
		
		$city = $_REQUEST ['city'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['city'] );
		$area = $_REQUEST ['area'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['area'] );
		$address = $_REQUEST ['address'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['address'] );
		$arrParam = array (
				'city' => $city,
				'area' => $area,
				'address' => $address 
		);
		
		$obj = $UserAddressModel->get(array('id'=>$id));
		
		if($UserAddressModel->modify($arrParam,array('id'=>$id)) === false)
		{
			redirect ( "?module=".nowmodule."&act=edit&id={$id}", "系统忙,操作失败" );
			return;
		}
						
		createAdminLog ( $db, 1, "编辑用户【id:" . $obj->userid . "】地址信息,编号id:{$id}", '', $obj, $arrParam, 'user_address' );		
		redirect ( "?module=".nowmodule."&act=edit&id={$id}", "操作成功" );
		return;
		
	break;
	
	case 'update_status' :

		$id = array ();
		$id = $_REQUEST ['id'];
		if (empty ( $id )) {
			redirect ( '?module=' . nowmodule, "ID不能为空" );
			return;
		}
		$status = intval ( $_REQUEST ['status'] );
		
		if ($UserAddressModel->modify(array('status'=>$status),array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙,操作失败");
			return;
		}
						
		if ($status == 1) {
			$state = '已审核';
		} elseif ($status == 0) {
			$state = '待审核';
		}
		createAdminLog ( $db, 1, "审核用户地址信息,编号id:" . implode ( ",", $id ) . '更新状态为' . $state, '更新状态为' . $state );
		redirect ( '?module=' . nowmodule, "操作成功" );
		return;
		
	break;
	
	case 'del' :
		$id = array ();
		$id = $_REQUEST ['id'];
		if (empty ( $id )) {
			redirect ( '?module=' . nowmodule, "您没选中任何条目" );
			return;
		}
		
		
		if($UserAddressModel->delete(array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙");
			return;
		}
		
		createAdminLog ( $db, 1, "删除用户地址信息,编号id:" . implode ( ",", $id ) );
		redirect ( '?module=' . nowmodule, "操作成功" );
		return;
		
	break;
	
	default :
	
		$url = "?module=" . nowmodule;
		
		$sql = "select ua.*,u.name as username from ".T('user_address')." as ua left join ".T('user')." as u on ua.userid=u.id";
		
		if(!empty($name))
		{
			$sql .= " where u.name like '%{$name}%'";
			$url .= "&name={$name}";
		}
		$sql .= " order by id desc";
		$url .= "&page=";
		
		$pager = $UserAddressModel->query($sql,false, true, $page, 40);
		include "tpl/user_address_list.php";
	break;
}
?>