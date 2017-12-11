<?php

define('HN1', true);
require_once('global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

include "common.php";	//设置只能用微信窗口打开
require_once MODEL_DIR . '/AgentApplicationModel.class.php';
$act =!isset($_REQUEST['act'])  ? '' : $_REQUEST['act'];

$UserModel = D('User');
$agent_application = new AgentApplicationModel($db);

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=agent_application");
	return;
}

switch($act){
/***********处理页面**********/
case 'add_save':
    $userid          = $_SESSION['userInfo']->id;
	$name            = $_REQUEST['name']             == null ? '' : $_REQUEST['name'];
	$mobile          = $_REQUEST['mobile']           == null ? '' : $_REQUEST['mobile'];
	$id_number       = $_REQUEST['id_number']        == null ? '' : $_REQUEST['id_number'];
	$email           = $_REQUEST['email']            == null ? '' : $_REQUEST['email'];
    $addTime         = $_REQUEST['addTime']          == null ? '' : $_REQUEST['addTime'];
	   $data = array(
         'userid'   =>$userid,
         'name'     =>$name,
         'mobile'   =>$mobile,
         'id_number'=>$id_number,
         'email'    =>$email,
         'addTime'  =>time(),
	     'author_status'=>0
	    );

        $rs = $agent_application->get($arrWhere=array('userid'=>$userid));
	    if( $rs == null){
	    $agent_application->add($data);
	    }else{
	        $data = array(
	         'userid'   =>$userid,
	         'name'     =>$name,
	         'mobile'   =>$mobile,
	         'id_number'=>$id_number,
	         'email'    =>$email,
	         'addTime'  =>time(),
		     'author_status'=>0
		    );
        $agent_application->modify($data,$arrWhere=array('userid'=>$userid));
	    }
        redirect("user.php","申请成功，我们会及时与您联系！");
		return;


break;

/***********修改页面*********/
case 'edit':
$obj      = $agent_application->get($arrWhere=array('userid'=>$userid));
include TEMPLATE_DIR.'/agent_application_web2.php';
break;

/***********修改页面处理**********/
case 'edit_save':
    $id  = intval($_REQUEST['id']);
	$userid        = $_REQUEST['userid']        == null ? '' : sqlUpdateFilter($_REQUEST['userid']);
	$name          = $_REQUEST['name']          == null ? '' : sqlUpdateFilter($_REQUEST['name']);
	$mobile        = $_REQUEST['mobile']        == null ? '' : sqlUpdateFilter($_REQUEST['mobile']);
	$id_number     = $_REQUEST['id_number']     == null ? '' : sqlUpdateFilter($_REQUEST['id_number']);
	$email         = $_REQUEST['email']         == null ? '' : sqlUpdateFilter($_REQUEST['email']);
	$author_status = $_REQUEST['author_status'] == null ? '' : sqlUpdateFilter($_REQUEST['author_status']);
	$addTime       = $_REQUEST['addTime']       == null ? '' : sqlUpdateFilter($_REQUEST['addTime']);
    $data = array(
         'userid'   =>$userid,
         'name'     =>$name,
         'mobile'   =>$mobile,
         'id_number'=>$id_number,
         'email'    =>$email,
         'addTime'  =>time(),
	     'author_status'=>0
	    );

	if ($agent_application->modify($data,array('userid'=>$_SESSION['userInfo']->id))) {
		redirect("user.php","修改成功！");
		return;
	}
break;
default:/*********申请页面**********/
	$arrWhere =array(
		'id'=>$userid
	);
	$obj_user = $UserModel->get($arrWhere);
	include TEMPLATE_DIR.'/agent_application_web.php';
	break;
}
?>
