<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

$page 		= !isset($_GET['page']) 			? 1 : intval($_GET['page']);
$userid 	= !isset($_GET['userid']) 			? 0 : intval($_GET['userid']);
$act 		= !isset($_REQUEST['act']) 			? "list" : $_REQUEST['act'];
$condition 	= !isset($_REQUEST['condition']) 	? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 		= !isset($_REQUEST['keys']) 		? '' : sqlUpdateFilter($_REQUEST['keys']);



$AgentInfoModel        = D('AgentInfo');
$AgentApplicationModel = D('AgentApplication');
$UserModel             = D('User');

$id 		= !isset($_GET['id']) 		? 0 :  intval($_GET['id']);

 $url = "?module=agent_application_action";
 $sql = "select * from ".T('agent_application')." where 1=1 and author_status !=1 ";

if(!empty($keys)){
	switch($condition){
		case 'name':
			$sql .= " and name like '%{$keys}%'";
			break;

		case 'tel':
			$sql .= " and mobile='{$keys}'";
			break;

		case 'number':
			$sql .= " and id_number='{$keys}'";
			break;
			
		case 'email':
			$sql .= " and email='{$keys}'";
			break;
	}
	$url .= "&condition=$condition&keys=$keys";
}
  $sql .=" order by id desc";



switch ($act) {

/********修改页面********/
	case 'edit' :
       $id 	= !isset($_GET['id']) 	? 0 :  intval($_GET['id']);
       if($id !=0){
           $arrWhere = array(
             'id'=>$id
            );
          }
       $apply =$AgentApplicationModel->get($arrWhere);
       include "tpl/agent_application_edit.php";
		break;

/********修改页面处理********/
	case 'edit_save' :
    $userid        = $_REQUEST['userid']        == null ? '' : sqlUpdateFilter($_REQUEST['userid']);
	$name          = $_REQUEST['name']          == null ? '' : sqlUpdateFilter($_REQUEST['name']);
	$author_status = $_REQUEST['author_status'] == null ? '' : sqlUpdateFilter($_REQUEST['author_status']);
	$mobile        = $_REQUEST['mobile']        == null ? '' : sqlUpdateFilter($_REQUEST['mobile']);
	$id_number     = $_REQUEST['id_number']     == null ? '' : sqlUpdateFilter($_REQUEST['id_number']);
	$email = $_REQUEST['email'] == null ? '' : sqlUpdateFilter($_REQUEST['email']);

	$data = array(
		'name'		=>	$name,
  'author_status'	=>	$author_status,
        'mobile'	=>	$mobile,
		'id_number'	=>	$id_number,
		'email'		=>	$email
	);

	if($AgentApplicationModel->modify($data,array('id'=>$id,'userid'=>$userid)) === false)
	{
		redirect("?module=agent_application", "系统忙,操作失败");
		return;
	}
	createAdminLog($db,7,"编辑分销商【".$obj_ib->name."】申请信息,编号id:{$id}",'',$obj_ib,$data,'agent_application');

	if(!empty($obj_aib))
	{
		if($AgentInfoModel->modify($data,array('userid'=>$userid)))
		{
			createAdminLog($db,7,"更新分销商【".$obj_aib->name."】信息",'',$obj_aib,$data,'agent_info');
		}
	}

	redirect("?module=agent_application", "操作成功");
	return;
		break;

		
		
/********审核页面********/
	case 'ustatus' :
		
		$arrWhere = array (
	      'id' => $id
          );
        $obj_status = $AgentApplicationModel->get($arrWhere);
        include "tpl/agent_status.php";
        break;

/********审核处理********/
	case 'ustatus_save' :
		$author_status = isset ($_REQUEST['author_status']) ? intval($_REQUEST['author_status']) : '';
		$remark = isset ($_REQUEST['remark']) ? $_REQUEST['remark'] : '';
		$userid = isset ($_REQUEST['userid']) ? $_REQUEST['userid'] : '';
        $type   = isset ($_REQUEST['type']) ? $_REQUEST['type'] : '';
		$arrWhere1 = array (
			'userid' => $userid
		);

		$data = array (
			'author_status' => $author_status,
			'remark' => $remark
		);
        $ad = $AgentApplicationModel->modify($data, $arrWhere1);
        $rs = $AgentApplicationModel->get(array( 'userid' => $userid ));
        if($rs->author_status ==1){
          $data = array
          (
           'userid'=>$rs->userid,
           'type' =>1024,
           'name'=>$rs->name,
           'mobile'=>$rs->mobile,
           'email'=>$rs->email,
           'id_number'=>$rs->id_number,
           'pre_money'=>$pre_money,
           'join_money'=>$join_money,
           'status'=>1,
           'join_time'=>time(),
           'addTime'=>time()
          );
        $agent_info = $AgentInfoModel->add($data);

        $user_info  =$UserModel-> modify(array('type'=>1024), array('id'=>$userid));
        }
         if ($author_status == 1) {
				$state = '认证通过';
			} elseif ($author_status == 2) {
					$state = '认证不通过';
			}
        createAdminLog($db,7,"审核【".$rs->name."】的分销商申请信息,用户ID:".$userid.'更新状态为'.$state,'更新状态为'.$state);
		redirect('?module=agent_application_action', '操作成功！！');
		
    break;
/********删除处理********/
	case 'del' :
		$id        = $_REQUEST['id']        == null ? '' : sqlUpdateFilter($_REQUEST['id']);
		$arrWhere = array('id'=>$id);

		if ($AgentApplicationModel->delete($arrWhere)) {
			createAdminLog($db,7,"删除分销商申请信息,编号id:".implode(",", $id));
			redirect('?module=agent_application_action', "操作成功");
			return;
		} else {
			redirect('?module=agent_application_action', "系统忙");
			return;
		}
		break;
	    default :
	    	$url = $url . "&page=";

	    	$applicationList =$AgentApplicationModel->query( $sql,false, true, $page, 20 );
	    	include "tpl/agent_application_list.php";
}
?>
