<?php
!defined('HN1') && exit ('Access Denied.');

$page 		= !isset ($_GET['page']) 			? 1 : intval($_GET['page']);
$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$condition 	= !isset ($_REQUEST['condition']) 	? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys 		= !isset ($_REQUEST['keys']) 		? '' : sqlUpdateFilter($_REQUEST['keys']);

define('nowmodule', "comment_action");

$CommentModel = M('comment');

switch ($act) 
{
	case 'del' :
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect('?module=' . nowmodule, "您没选中任何条目");
			return;
		}
		
		if($CommentModel->delete(array('__IN__'=>array('id'=>$id))) === false)
		{
			redirect('?module=' . nowmodule, "系统忙");
			return;
		}
						
		createAdminLog($db,2,"删除订单评价信息,编号id:".implode(",", $id));

		redirect('?module=' . nowmodule, "操作成功");
		return;
		
	break;
	
	default :
		$sql = "select c.*,u.name as username,(select name from ".T('product')." where product_id = c.product_id) as product_name from ".T('comment')." as c left join ".T('user')." as u on c.customer_id=u.id where 1=1";
		$url = "?module=" . nowmodule;
		
		if(!empty($condition))
		{
			$sql .= " and c.{$condition} like '%{$keys}%'";
			$url .= "&condition=$condition&keys=$keys";
		}
		$sql .=" order by id desc";	
		$url .= "&page=";
	
		$pager = $CommentModel->query( $sql,false, true, $page, 40 );
		
		include "tpl/comment_list.php";
	break;
}
?>