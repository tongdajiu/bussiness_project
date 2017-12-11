<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
VersionModel::checkOpen('goodsTag');
require_once MODEL_DIR . '/GoodsTagModel.class.php';
$act      =!isset ($_REQUEST['act']) ? "list" : $_REQUEST['act'];
$type     =! isset ($_REQUEST['type'])? '' : $_REQUEST['type'];
$page     =! isset($_GET['page'])     ?  1 : intval($_GET['page']);

$goods_tag = new GoodsTagModel($db);
if($type !=null){
$arrWhere = array('type'=>$type);
}
$tagList   = $goods_tag->gets($arrWhere,array('id'=>'desc'),$page, $perpage = 20);
$url = "?module=goods_tag_action";

$url = $url."&page=";

switch($act){
  /*********添加页面********/
     case 'add':
     $List = $goods_tag->getALL();
     include "tpl/goods_tag_add.php";
     break;
  /*********添加处理********/
     case 'add_save':
     $title  =$_REQUEST['title']  == null ? '' : $_REQUEST['title'];
     $images = uploadfile('images','../upfiles/label/');
     $size   =$_REQUEST['size']  == null ? '' : $_REQUEST['size'];
     $type   =$_REQUEST['type']  == null ? '' : $_REQUEST['type'];
     $data =array(
       'title'   =>$title,
       'images'  =>$images,
       'size'    =>$size,
       'type'    =>$type,
       'add_time'=>time()
     );
    $re = $goods_tag->add($data);
    redirect('?module=goods_tag_action',"添加成功！");
    return;

    break;

 /**********修改页面***********/
    case 'edit':
    $id      =$_REQUEST['id']  == null ? '' : $_REQUEST['id'];
    $tagInfo = $goods_tag->get(array('id'=>$id));
    include "tpl/goods_tag_edit.php";
    break;


/*********修改处理********/
    case 'edit_save':
    $id              =$_REQUEST['id']           == null ? '' : $_REQUEST['id'];
    $image_before    =$_REQUEST['image_before'] == null ? '' : sqlUpdateFilter($_REQUEST['image_before']);
    $images  = uploadfile('images','../upfiles/label/');
	if($images == null)
	{
		$images = $image_before ;
	}
     $title  =$_REQUEST['title']  == null ? '' : $_REQUEST['title'];
     $size   =$_REQUEST['size']   == null ? '' : $_REQUEST['size'];
     $type   =$_REQUEST['type']   == null ? '' : $_REQUEST['type'];

     $data =array(
       'title'   =>$title,
       'images'  =>$images,
       'size'    =>$size,
       'type'    =>$type,
       'add_time'=>time()
     );
    $rs =$goods_tag->modify($data,array('id'=>$id));
    redirect('?module=goods_tag_action',"修改成功！");
    return;
    break;

/********删除处理********/
    case 'del':
    $id   =$_REQUEST['id']  == null ? '' : $_REQUEST['id'];
    $rd  = $goods_tag->delete(array('id'=>$id));

    redirect('?module=goods_tag_action',"删除成功！");
    return;
    break;

    default:

    include "tpl/goods_tag_list.php";
}
?>