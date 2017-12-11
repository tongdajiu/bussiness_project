<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
$page         =! isset($_GET['page'])         ?  1 : intval($_GET['page']);
$status       =! isset($_GET['status'])       ? -1 :  intval($_GET['status']);
$lottery_type =! isset($_GET['lottery_type']) ? '' :  intval($_GET['lottery_type']);
$setting_id   =! isset($_GET['setting_id'])   ? '' :  intval($_GET['setting_id']);
$userid       =! isset($_GET['userid'])       ?  0 :  intval($_GET['userid']);
$activity     =! isset($_GET['activity'])     ?  0 :  intval($_GET['activity']);
$act          =! isset($_REQUEST['act'])      ? "list" : $_REQUEST['act'];
$condition    =! isset($_REQUEST['condition'])? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys         =! isset($_REQUEST['keys'])     ? '' : sqlUpdateFilter($_REQUEST['keys']);
include_once(  LIB_DIR . '/GameModel.class.php');
$Lottery = GameFactoryModel::create('All');


/*******相关活动设置*******/


switch ($act) {

    /******活动设置添加页面*******/
    case 'add' :
     	include "tpl/lottery_add.php";
     break;

     /******活动设置添加处理*******/
	case 'add_save' :
		$image = "";
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {		
			!file_exists(STORE_IMG_DIR) && mkdir(STORE_IMG_DIR, 0777, true);
			!file_exists(STORE_IMG_DIR."large/") && mkdir(STORE_IMG_DIR."large/", 0777, true);
			!file_exists(STORE_IMG_DIR."small/") && mkdir(STORE_IMG_DIR."small/", 0777, true);
		
			$image = uploadfile("image", STORE_IMG_DIR);
			ResizeImage(STORE_IMG_DIR, STORE_IMG_DIR."large/", $image, "600");
			ResizeImage(STORE_IMG_DIR, STORE_IMG_DIR."small/", $image, "250");
	
		}
		
				
		$picDir = ROOT_DIR.UPLOAD_DIR.'lottery/turntable/';
		!file_exists($picDir) && mkdir($picDir, 0777, true);

		$lottery_id   = isset ($_REQUEST['lottery_id'])   ? $_REQUEST['lottery_id']   : '';
		$subject      = isset ($_REQUEST['subject'])      ? $_REQUEST['subject']      : '';
		$status       = isset ($_REQUEST['status'])       ? $_REQUEST['status']       : '';
		$lottery_type = isset ($_REQUEST['lottery_type']) ? $_REQUEST['lottery_type'] : '';
		$start_time   = isset ($_REQUEST['start_time'])   ? $_REQUEST['start_time']   : '';
		$end_time     = isset ($_REQUEST['end_time'])     ? $_REQUEST['end_time']     : '';
        $number       = isset ($_REQUEST['number'])       ? $_REQUEST['number']       : '';

		$background    = uploadfile('background', $picDir.'a');
		$title_image   = uploadfile('title_image', $picDir.'b');
		$turntable     = uploadfile('turntable', $picDir.'c');
		$pointer       = uploadfile('pointer', $picDir.'d');
		$explain_image = uploadfile('explain_image', $picDir.'e');


		$arrImage = array(
			'background'   => $background,
		    'title_image'  => $title_image,
		    'turntable'    => $turntable,
		    'pointer'      => $pointer,
		    'explain_image'=> $explain_image
		);

		$data = array (
			'subject'       => $subject,
			'status'        => $status,
            'lottery_type'  => $lottery_type,
            'start_time'    => strtotime($start_time),
            'end_time'      => strtotime($end_time),
            'lottery_image' => json_encode($arrImage),
		    'number'        => $number
		);

		$rs = $Lottery->addGameInfo( $data );

		if ( $rs )
		{
			createAdminLog($db, 4, "编辑转盘抽奖活动设置");
			redirect('?module=lottery_action', '操作成功！！');
		}
		else
		{
			redirect('?module=lottery_action&act=add', '操作失败！！');
		}


    	return;
    break;

    /******活动设置修改页面*******/
    case 'edit' :
    	$lottery_id  =$_REQUEST['lottery_id']  == null ? '' : $_REQUEST['lottery_id'];
    	$lotteryInfo = $Lottery->getGameInfo( $lottery_id );
    	$lotteryInfo->lottery_image;
    	$arrLotterImg = json_decode($lotteryInfo->lottery_image);

    	include "tpl/lottery_edit.php";
    break;

   /******活动设置修改处理*******/
    case 'edit_save' :

    	$picDir = ROOT_DIR.UPLOAD_DIR.'lottery/turntable/';
		!file_exists($picDir) && mkdir($picDir, 0777, true);
		
		$lottery_id   = isset ($_REQUEST['lottery_id'])   ? $_REQUEST['lottery_id']   : '';
		$subject      = isset ($_REQUEST['subject'])      ? $_REQUEST['subject']      : '';
		$status       = isset ($_REQUEST['status'])       ? $_REQUEST['status']       : '';
		$lottery_type = isset ($_REQUEST['lottery_type']) ? $_REQUEST['lottery_type'] : '';
		$start_time   = isset ($_REQUEST['start_time'])   ? $_REQUEST['start_time']   : '';
		$end_time     = isset ($_REQUEST['end_time'])     ? $_REQUEST['end_time']     : '';
        $number       = isset ($_REQUEST['number'])       ? $_REQUEST['number']       : '';

        $background_before   = isset ($_REQUEST['background_before'])   ? $_REQUEST['background_before']     : '';
            $background    = uploadfile('background', $picDir.'a');
        if($background ==''){
        	$background = $background_before;
        }
            
        $title_image_before   = isset ($_REQUEST['title_image_before'])  ? $_REQUEST['title_image_before']    : '';
            $title_image   = uploadfile('title_image', $picDir.'b');
        if($title_image ==''){
        	$title_image = $title_image_before;
        }
        
        $turntable_before     = isset ($_REQUEST['turntable_before'])    ? $_REQUEST['turntable_before']      : '';
            $turntable   = uploadfile('turntable', $picDir.'c');
        if($turntable ==''){
        	$turntable = $turntable_before;
        }
        
        $pointer_before     = isset ($_REQUEST['pointer_before'])    ? $_REQUEST['pointer_before']      : '';
            $pointer   = uploadfile('pointer', $picDir.'d');
        if($pointer ==''){
        	$pointer = $pointer_before;
        }
        
        $explain_image_before = isset ($_REQUEST['explain_image_before'])? $_REQUEST['explain_image_before']  : '';
            $explain_image   = uploadfile('explain_image', $picDir.'e');
        if($explain_image ==''){
        	$explain_image = $explain_image_before;
        }
        

		
		$arrImage = array(
			'background'   => $background,
		    'title_image'  => $title_image,
		    'turntable'    => $turntable,
		    'pointer'      => $pointer,
		    'explain_image'=> $explain_image
		);
	 
       $data = array (
			'subject'      => $subject,
			'status'       => $status,
            'lottery_type' => $lottery_type,
            'start_time'   => strtotime($start_time),
            'end_time'     => strtotime($end_time),
            'lottery_image'=> json_encode($arrImage),
		    'number'       => $number
		);  

       $Lottery->editGameInfo(array('status'=>0),array( 'lottery_type'=>$lottery_type ));
	$rs = $Lottery->editGameInfo( $data,array('lottery_id'=>$lottery_id ) );
	redirect('?module=lottery_action',"修改成功！");
    return;
    break;

    /******活动设置删除处理*******/
    case 'del':
	    $lottery_id   = $_REQUEST['lottery_id']  == null ? '' : $_REQUEST['lottery_id'];
	    $rs = $Lottery->delGameInfo( array('lottery_id'=>$lottery_id) );
	    redirect('?module=lottery_action',"删除成功！");
	    return;
    break;

    default:
		$lotteryList = $Lottery->getGameList( $page, $lottery_type,TRUE );

		$url = "?module=lottery_action";

        if($lottery_type!='')
		  {
		     $url = $url."&lottery_type=".$lottery_type;
		  }

		if($userid!='')
		  {
	        $url = $url."&userid=".$userid;
          }

           $url = $url."&condition=$condition&keys=$keys&page=";
		include "tpl/lottery_list.php";
}
?>