<?php
!defined('HN1') && exit ('Access Denied.');
VersionModel::checkOpen('distributorSubordinateInfo');

$UserChainModel = D('UserChain');

$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);

$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$name 		= !isset ($_REQUEST['name']) ||  $_REQUEST['name'] == '请输入姓名'	? '' : sqlUpdateFilter($_REQUEST['name']);

define('nowmodule', "user_connection_action");

switch ($act) 
{
	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule, "您没选中任何条目");
			return;
		}
		
		if($UserChainModel->delete(array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙");
			return;
		}
		
		createAdminLog($db,1,"删除用户推荐关系信息,编号id:".implode(",", $id));
		redirect('?module=' . nowmodule, "操作成功");
		return;
	
	break;
	
	case 'chain'://上/下线用户
		global $db;
		$uid = intval($_GET['uid']);
		empty($uid) && redirect('?module=user_action', '参数错误');
		
		$isUpUser = isset($_GET['up']) ? true : false;//是否显示上线会员
		
		$UserModel = D('User');
		$user = $UserModel->get(array('id'=>$uid));
		if($isUpUser){//上线会员
			$users = $UserChainModel->getUpUids($uid);
			if(!empty($users)){
				$rs = $UserModel->getAll(array('__IN__'=>array('id'=>array_keys($users))));
				foreach($rs as $v){
					$users[$v->id]['info'] = $v;
				}
			}
		}else{//下线会员
			$users = $UserChainModel->getDownUids($uid);
			if(!empty($users)){
				$rs = $UserModel->getAll(array('__IN__'=>array('id'=>array_keys($users))));
				foreach($rs as $v){
					$users[$v->id]['info'] = $v;
				}
			}
		}
		include_once('tpl/user_chain_web.php');
		exit();
	break;
	
	default :
		
		$url = "?module=" . nowmodule;
		$sql = "select * from (select *,(select `name` from `".T('user')."` where `user`.id=uc.userid) as username,(select `name` from `".T('user')."` where `user`.id=uc.fuserid) as fuser from ".T('user_connection')." as uc) as u where 1=1";
		
		if(!empty($name))
		{
			$sql .= " and u.username like '%{$name}%' or u.fuser like '%{$name}%'";
			
			$url .= "&name={$name}";
		}
		
		$sql .= " order by u.addtime desc,u.id desc";
		$url = $url . "&page=";
		
		$pager = $UserChainModel->query($sql,false, true, $page, 40);

		include "tpl/user_connection_list.php";
	break;
}
?>