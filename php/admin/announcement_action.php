<?php
!defined('HN1') && exit('Access Denied.');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once MODEL_DIR . '/AnnouncementModel.class.php';

$page      =! isset($_GET['page'])         ?  1 : intval($_GET['page']);
$userid    =! isset($_GET['userid'])       ? 0 :  intval($_GET['userid']);
$act       =! isset($_REQUEST['act'])      ? "list" : $_REQUEST['act'];
$announcement = new AnnouncementModel($db);

$annList = $announcement->gets('',array('id'=>'desc'),$page, $perpage = 20);


$url = "?module=announcement_action";

$url = $url."&page=";




switch($act){
/******添加列表*******/
case 'add':
   include "tpl/announcement_add.php";
break;


/******添加处理*******/
case 'add_save':

    $type    =$_REQUEST['type']    == null ? '' : sqlUpdateFilter($_REQUEST['type']);
	$title   =$_REQUEST['title']   == null ? '' : sqlUpdateFilter($_REQUEST['title']);
	$url     =$_REQUEST['url']     == null ? '' : sqlUpdateFilter($_REQUEST['url']);
	$content =$_REQUEST['content'] == null ? '' : sqlUpdateFilter($_REQUEST['content']);
	$status  =$_REQUEST['status']   == null ? '' : sqlUpdateFilter($_REQUEST['status']);
	$data=array(
	'type'=>1,
	'title'=>$title,
    'url'  =>$url,
    'content'=>$content,
	'status'=>$status,
	'addtime'=>time()
	);
    $re = $announcement->add($data);


    redirect('?module=announcement_action',"添加成功！");
    return;
    break;



/********修改页面*******/
case 'edit':
    $id    =$_REQUEST['id']    == null ? 0  : sqlUpdateFilter(intval($_REQUEST['id']));
	$arrWhere=array(
	'id'=>$id
	);
    $list = $announcement->get($arrWhere);
	 include "tpl/announcement_edit.php";
	 break;




/********修改处理*******/
case 'edit_save':
    $id      =$_REQUEST['id']       == null ? 0  : sqlUpdateFilter(intval($_REQUEST['id']));
	$type    =$_REQUEST['type']     == null ? '' : sqlUpdateFilter($_REQUEST['type']);
	$title   =$_REQUEST['title']    == null ? '' : sqlUpdateFilter($_REQUEST['title']);
	$url     =$_REQUEST['url']      == null ? '' : sqlUpdateFilter($_REQUEST['url']);
	$status  =$_REQUEST['status']   == null ? '' : sqlUpdateFilter($_REQUEST['status']);
	$content =$_REQUEST['content']  == null ? '' : sqlUpdateFilter($_REQUEST['content']);
	  $data=array(
	     'type'=>1,
	     'title'=>$title,
         'url'  =>$url,
         'content'=>$content,
	     'status'=>$status,
	     'addtime'=>time()
	  );
	  $arrWhere=array(
	     'id'=>$id
	   );
    $rs = $announcement->modify($data,$arrWhere);
    redirect('?module=announcement_action',"修改成功！");
    return;
    break;

/********删除处理*******/
case 'del':
   $id       =$_REQUEST['id']        == null ? 0  : sqlUpdateFilter(intval($_REQUEST['id']));
   $arrWhere=array(
     'id'=>$id
   );
    $rd = $announcement->delete($arrWhere);
    redirect('?module=announcement_action',"删除成功！");
    return;
    break;

    default:
include "tpl/announcement_list.php";
}
?>