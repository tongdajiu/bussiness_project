<?php
/**
 * 微信消息模板
 */
!defined('HN1') && exit ('Access Denied.');
require_once ('../global.php');
include_once(MODEL_DIR.'/WeixinMessageTemplateModel.class.php');

$Tpl = new WeixinMessageTemplateModel($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $flag = trim($_POST['flag']);
    empty($flag) && redirect('?module=wx_msg_tpl', '参数错误');
    $tplId = trim($_POST['tplid']);
    empty($tplId) && redirect('?module=wx_msg_tpl&f='.$flag, '请输入模板ID');

    $sysFlags = $_POST['data_sysflag'];
    $wxFlags = $_POST['data_wxflag'];
    $colors = $_POST['data_color'];
    $contents = $_POST['data_content'];
    $data = array();
    foreach($sysFlags as $k => $sf){
        $data[$sf] = array('key'=>$wxFlags[$k], 'color'=>$colors[$k], 'content'=>$contents[$k]);
    }
    $saveData = array('tplId'=>$tplId, 'data'=>$data);
    $Tpl->save($flag, $saveData) ? redirect('?module=wx_msg_tpl', '编辑成功') : redirect('?module=wx_msg_tpl&f='.$flag, '编辑失败');
}

$flag = trim($_GET['f']);
if(empty($flag)){//列表
    $list = $Tpl->getAll();
    include "tpl/wx_msg_tpl_web.php";
}else{
    $map = $Tpl->getMapDict();
    $tpl = $Tpl->get(array('flag'=>$flag));
    $dataJson = json_encode($tpl->data);
    include "tpl/wx_msg_tpl_form_web.php";
}
