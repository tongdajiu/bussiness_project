<?php
!defined('HN1') && exit('Access Denied.');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
$AdModel = D('Ad');


$page      =! isset($_GET['page'])         ?  1 : intval($_GET['page']);
$status    =! isset($_GET['status'])       ? -1 :  intval($_GET['status']);
$type      =! isset($_GET['type'])         ? '' :  intval($_GET['type']);
$userid    =! isset($_GET['userid'])       ? 0 :  intval($_GET['userid']);
$act       =! isset($_REQUEST['act'])      ? "list" : $_REQUEST['act'];
$condition =! isset($_REQUEST['condition'])? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys      =! isset($_REQUEST['keys'])     ? '' : sqlUpdateFilter($_REQUEST['keys']);


$ProductTypeModel = D('ProductType');
$classid     =! isset($_REQUEST['classid'])  ? '' : $_REQUEST['classid'];
$productType = $ProductTypeModel->getList( 0 );


switch($act)
{
	/*********添加页面*********/
	case 'add':
    include "tpl/ad_add.php";
	break;

    /*********添加页面处理********/
	case 'add_save':
	$images = uploadfile('images','../upfiles/adindex/');
	$url             =$_REQUEST['url']               == null ? '' : sqlUpdateFilter($_REQUEST['url']);
	$title           =$_REQUEST['title']             == null ? '' : sqlUpdateFilter($_REQUEST['title']);
    $type            =$_REQUEST['type']              == null ? '' : sqlUpdateFilter($_REQUEST['type']);
	$typeclass       =$_REQUEST['typeclass']         == null ? '' : sqlUpdateFilter($_REQUEST['typeclass']);
	$status          =$_REQUEST['status']            == null ? '' : sqlUpdateFilter($_REQUEST['status']);
	$size_tips       =$_REQUEST['size_tips']         == null ? '' : sqlUpdateFilter($_REQUEST['size_tips']);
	$background_color=$_REQUEST['background_color']  == null ? '' : sqlUpdateFilter($_REQUEST['background_color']);


    $data =array(
				  'images'=>$images,
				  'url'=>$url,
				  'title'=>$title,
				  'type'=>$type,
				  'typeclass'=>$typeclass,
				  'status'=>$status,
				  'size_tips'=>$size_tips,
				  'background_color'=>$background_color
		        );

	if($AdModel->add($data))
	{
		createAdminLog($db,5,"添加首页图片【{$title}】");
		redirect('?module=ad_action',"操作成功");
		return;
	}else{
		redirect('?module=ad_action',"系统忙,操作失败");
		return;
	}
	break;


   /***********修改页面*********/
    case 'edit':
    $id   = $_REQUEST['id'] == null ? '' : $_REQUEST['id'];
    $list = $AdModel->get($arrWhere=array('id'=>$id));

    include "tpl/ad_edit.php";
	break;


    /**********修改页面处理**********/
	case 'edit_save':
    $image_before    =$_REQUEST['image_before']      == null ? '' : sqlUpdateFilter($_REQUEST['image_before']);
	$images  = uploadfile('images','../upfiles/adindex/');

	if($images == null)
	{
		$images = $image_before ;
	}
	
    $id              = $_REQUEST['id']                 == null ? '' : $_REQUEST['id'];
    $url             =$_REQUEST['url']                 == null ? '' : sqlUpdateFilter($_REQUEST['url']);
	$title           =$_REQUEST['title']               == null ? '' : sqlUpdateFilter($_REQUEST['title']);
    $type            =$_REQUEST['type']                == null ? '' : sqlUpdateFilter($_REQUEST['type']);
	$typeclass       =$_REQUEST['typeclass']           == null ? '' : sqlUpdateFilter($_REQUEST['typeclass']);
    $status          =$_REQUEST['status']              == null ? '' : sqlUpdateFilter($_REQUEST['status']);
    //$size_tips     =$_REQUEST['size_tips']           == null ? '' : sqlUpdateFilter($_REQUEST['size_tips']);
	//$background_color=$_REQUEST['background_color']  == null ? '' : sqlUpdateFilter($_REQUEST['background_color']);

	$data = array(
				  'status' 	=> 	$status,
				  'type'		=>	$type,
				  'typeclass'	=>	$typeclass,
				  //'size_tips'	=>	$size_tips,
				  'title'		=>	$title,
				  //'background_color'	=>	$background_color,
				  'url'		=>	$url,
				  'images'	=>	$images,
	            );


	if($AdModel->modify($data,array('id'=>$id)) === false)
	{
		redirect("?module=ad_action","系统忙,操作失败");
		return;
	}

	createAdminLog($db,5,"编辑首页图片",'',$obj,$data,'ad');

	redirect("?module=ad_action","操作成功");
	return;

	break;

   /***********删除处理**********/
	case 'del':
		$id   = $_REQUEST['id'] == null ? '' : $_REQUEST['id'];
		if($AdModel->delete($arrWhere=array('id'=>$id)))
		{
			createAdminLog($db,5,"删除首页图片信息,编号id:".implode(",", $id));
			redirect('?module=ad_action',"操作成功");
			return;
		}
		else
		{
			redirect('?module=ad_action',"系统忙");
			return;
		}
	break;

	default:
if($type !=0){
	$arrWhere=array('type'=>$type);
}
		$adList = $AdModel->gets($arrWhere,array('id'=>'desc'),$page, $perpage = 20);

		$url = "?module=ad_action";

		if($status!=''){
			$url = $url."&status=".$status;
		}
		if($type!=''){
			$url = $url."&type=".$type;
		}

		$url = $url."&condition=$condition&keys=$keys&page=";
	    include "tpl/ad_list.php";
}
?>