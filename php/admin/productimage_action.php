<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');



$ProductImageModel = M('productimage');
$ProductModel      = D('product');



$page      = !isset ($_GET['page'])          ? 1 : intval($_GET['page']);
$status    = !isset ($_GET['status'])        ? -1 : intval($_GET['status']);
$act       = !isset ($_REQUEST['act'])       ? "list" : $_REQUEST['act'];
$condition = !isset ($_REQUEST['condition']) ? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys      = !isset ($_REQUEST['keys'])      ? '' : sqlUpdateFilter($_REQUEST['keys']);
$name      = !isset ($_REQUEST['name']) || $_REQUEST['name'] == '请输入产品名称' ? '' : sqlUpdateFilter($_REQUEST['name']);
$product_id   = !isset ($_REQUEST['product_id']) ? 0 : $_REQUEST['product_id'];



$url = "?module=productimage_action";
if ($status != '') {
	$url = $url . "&status=" . $status;
}
if ($name != '') {
	$url = $url . "&name=" . $name;
}
if ($product_id > 0) {
	$url = $url . "&product_id=" . $product_id;
}
$url = $url . "&condition=$condition&keys=$keys&page=";


switch ($act) {
	case 'add' :
		$obj_product  = $ProductModel->get($arrWhere=array('product_id'=>$product_id));
		include "tpl/productimage_add.php";
	break;
	
	case 'add_save' :
		$image        = uploadfile('image', '../upfiles/');
		$product_id   = !isset ($_REQUEST['product_id']) ? 0 : $_REQUEST['product_id'];
		$status       = $_REQUEST['status'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['status']));
		$rs = $ProductImageModel->add($data=array('image'=>$image,'addTime'=>time(),'status'=>$status,'productId'=>$product_id));
		if ( $rs ) {		
				createAdminLog($db,3,"添加产品【id:{$product_id}】的产品图片");
				redirect('?module=productimage_action'. "&product_id=" . $product_id, "添加成功");
				return;
			} else {
				redirect('?module=productimage_action' . "&product_id=" . $product_id, "系统忙,操作失败");
				return;
			}		
	break;
	
	case 'edit' :
		$id   = !isset ($_REQUEST['id']) ? 0 : $_REQUEST['id'];
		$obj  =  $ProductImageModel -> get($arrWhere=array('id'=>$id));
		$obj_product  = $ProductModel->get($arrWhere=array('product_id'=>$obj->productId));
		include "tpl/productimage_edit.php";
	break;
   
    case 'edit_save' :
   	    $image_before = $_REQUEST['image_before'] == null ? '' : sqlUpdateFilter($_REQUEST['image_before']);
   		$image = uploadfile('image', '../upfiles/');
   		if ($image == null) {
   			$image = $image_before;
   		}
   		$productId = $_REQUEST['product_id'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['product_id']));
   		$status = $_REQUEST['status'] == null ? '0' : sqlUpdateFilter(intval($_REQUEST['status']));
   		if ($ProductImageModel->modify($data=array('image'=>$image,'addTime'=>time(),'status'=>$status,'product_id'=>$product_id),$arrWhere=array('id'=>$id))) {	
   			createAdminLog($db,3,"修改产品【id:{$productId}】的产品图片【{$image_before}】信息","当前产品图片:{$image}");
   	
   			redirect("?module=productimage_action"."&product_id=" . $product_id, "修改成功");
   			return;
   		} else {
   			redirect("?module=productimage_action&act=edit&product_id=" . $product_id, "系统忙,操作失败");
   			return;
   		}
   	break;	
	case 'del' :
		$id   = !isset ($_REQUEST['id']) ? 0 : $_REQUEST['id'];
		$ProductImageModel->delete($arrWhere=array('id'=>$id));
		redirect('?module=productimage_action',"操作成功");
		return;
	
	break;
    default:
    	
    	$productList  = $ProductImageModel->gets($arrWhere=array('productId'=>$product_id),array('id'=>'desc'),$page, $perpage = 20);
    	include "tpl/productimage_list.php";

}
?>
