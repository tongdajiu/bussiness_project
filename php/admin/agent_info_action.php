<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

require_once MODEL_DIR . '/AgentModel.class.php';

$page 		= !isset($_GET['page'])  			? 1 : intval($_GET['page']);
$userid 	= !isset($_GET['userid']) 			? 0 : intval($_GET['userid']);
$type 		= !isset($_GET['type']) 			? 0 : intval($_GET['type']);
$status 	= !isset($_GET['status']) 			? -1 : intval($_GET['status']);
$act 		= !isset($_REQUEST['act']) 			? "list" : $_REQUEST['act'];
$condition 	= !isset($_REQUEST['condition']) 	? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 		= !isset($_REQUEST['keys']) 		? '' : sqlUpdateFilter($_REQUEST['keys']);

$AgentApplicationModel = D('AgentApplication');
$AgentInfoModel = D('AgentInfo');
$DistributorApplicationModel = D('DistributorApplication');
$UserModel = D('User') ;


$url = "?module=agent_info_action";
$sql = "select * from ".T('agent_info')." where 1=1 ";

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

	/*********修改页面********/
	case 'edit' :
        $id = $_REQUEST['id'] == null ? '' : sqlUpdateFilter($_REQUEST['id']);
        if($id !=''){
           $arrWhere =array(
             'id'=>$id
            );
        }
        $infoList =$AgentInfoModel->get($arrWhere);
        include "tpl/agent_info_edit.php";
		break;

    /**********修改页面处理**********/
	case 'edit_save' :
    $userid = $_REQUEST['userid'] == null ? '' : sqlUpdateFilter($_REQUEST['userid']);
	//$type = $_REQUEST['type'] == null ? '' : sqlUpdateFilter($_REQUEST['type']);
	$name = $_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
	$mobile = $_REQUEST['mobile'] == null ? '' : sqlUpdateFilter($_REQUEST['mobile']);
	$email = $_REQUEST['email'] == null ? '' : sqlUpdateFilter($_REQUEST['email']);
	$id_number = $_REQUEST['id_number'] == null ? '' : sqlUpdateFilter($_REQUEST['id_number']);
	$pre_money = $_REQUEST['pre_money'] == null ? '' : sqlUpdateFilter($_REQUEST['pre_money']);
	$join_money = $_REQUEST['join_money'] == null ? '' : sqlUpdateFilter($_REQUEST['join_money']);
	//$city = $_REQUEST['city'] == null ? '' : sqlUpdateFilter($_REQUEST['city']);
	//$join_time = $_REQUEST['join_time'] == null ? '' : sqlUpdateFilter($_REQUEST['join_time']);
	//$status = $_REQUEST['status'] == null ? '' : sqlUpdateFilter($_REQUEST['status']);
	//$addTime = $_REQUEST['addTime'] == null ? '' : sqlUpdateFilter($_REQUEST['addTime']);


	$data = array(
		'name'		=>	$name,
		'mobile'	=>	$mobile,
		'id_number'	=>	$id_number,
		'email'		=>	$email,
		'pre_money'	=>	$pre_money,
		'join_money'=>	$join_money,

	);

	if($AgentInfoModel->modify($data,array('id'=>$id,'userid'=>$userid)) === false)
	{
		redirect("?module=agent_info_action", "系统忙,操作失败");
		return;
	}
	createAdminLog($db,7,"编辑加盟分销商【".$obj_ib->name."】信息,编号id:{$id}",'',$obj_ib,$data,'agent_info');

	redirect('?module=agent_info_action' , "操作成功");
	return;
	break;

    /********删除处理********/
	case 'del' :
		$id = $_REQUEST['id'] == null ? '' : sqlUpdateFilter($_REQUEST['id']);
             if($id !=''){
               $arrWhere =array(
                 'id'=>$id
               );
              }
            $res = $AgentInfoModel->get($arrWhere);

           $user_id = $res->userid;
           $data =array(
              'type' => 0,
              'id'   => $user_id
           );

           $UserModel->modify($data,array('id'=>$user_id)); //删除分销商信息的同时更改用户信息的状态
           $AgentApplicationModel ->delete(array('userid'=>$res->userid));  //删除分销商信息的同时删除分销商申请信息
           $DistributorApplicationModel ->delete(array('userid'=>$res->userid)); //删除分销商信息的同时删除二维码权限申请信息
		if ($AgentInfoModel->delete($arrWhere)) {

			createAdminLog($db,7,"删除加盟分销商信息,编号id:".implode(",", $id));

			redirect('?module=agent_info_action', "操作成功");
			return;
		} else {
			redirect('?module=agent_info_action', "系统忙");
			return;
		}
		break;
	case 'commission'://佣金记录
		VersionModel::checkOpen('distributorWalletManagement');
		$rebackUrl = '?module=agent_info_action';
		$agentId = intval($_GET['id']);
		empty($agentId) && redirect($rebackUrl, '参数错误');

		include_once(MODEL_DIR.'/AgentModel.class.php');
		$Agent = new AgentModel($db, 'agent_info');
		$agent = $Agent->get(array('id'=>$agentId));
		empty($agent) && redirect($rebackUrl, '分销商不存在');

		include_once(MODEL_DIR.'/CommissionModel.class.php');
		$Commission = new CommissionModel($db, 'commission_log');
		$pager = $Commission->gets(array('user_id'=>$agent->userid), array('time'=>'desc'), $page, 40);
		$pageUrl = "?module=agent_info_action&act=commission&id={$agentId}&page=";
		include "tpl/agent_commission_log.php";
		exit();
		break;
		
	case 'view'://下线消费记录
			$uid = intval($_GET['id']);
			empty($uid) && redirect('?module=agent_info_list', '参数错误');
			
			$page = intval($_GET['page']);
			$pagesize = 20;
			
			include_once(MODEL_DIR.'/AgentModel.class.php');
			$Agent = new AgentModel($db, 'agent_info');
			$agent = $Agent->get(array('userid'=>$uid));
			
			$pager = array();
			include_once(MODEL_DIR.'/UserChainModel.class.php');
			$UserChain = new UserChainModel($db, 'user_connection');
			$subUserIds = $UserChain->getDownUids($uid);
			$subUsers = array();
			if(!empty($subUserIds)){
			    include_once(MODEL_DIR.'/OrderModel.class.php');
			//    $Order = new OrderModel($db, 'orders');
			    $PayRecord = new Model($db, 'pay_records');
			    $cond = array('__IN__'=>array('userid'=>array_keys($subUserIds)));
			    $pager = $PayRecord->gets($cond, array('addtime'=>'desc'), $page, $pagesize);
			    $_uids = array();
			    foreach($pager['DataSet'] as $k => $v){
			        $pager['DataSet'][$k]->user_level = $subUserIds[$v->userid]['level'];
			        $_uids[] = $v->userid;
			    }
			
			    include_once(MODEL_DIR.'/UserModel.class.php');
			    $User = new UserModel($db);
			    $rs = $User->getAll(array('__IN__'=>array('id'=>$_uids)));
			    foreach($rs as $v){
			        $subUsers[$v->id] = $v;
			    }
			}
			
			$url = "?module=subordinate_consume&id={$uid}&page=";
			include 'tpl/subordinate_consume_web.php';
			exit();
		
			break;
	    default :

/*********列表页面********/
$url = $url . "&page=";
$agentinfoList =$AgentInfoModel->query( $sql,false, true, $page, 20 );

include "tpl/agent_info_list.php";
}
?>