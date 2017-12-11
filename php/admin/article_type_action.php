<?php
! defined ( 'HN1' ) && exit ( 'Access Denied.' );

$page = ! isset ( $_GET ['page'] ) ? 1 : intval ( $_GET ['page'] );
$act = ! isset ( $_REQUEST ['act'] ) ? "list" : $_REQUEST ['act'];

$ArticleTypeModel = M('article_type',$db);
define('nowmodule', 'article_type_action');


$url = "?module=article_type_action";

switch ($act) {
	//添加列表
	case 'add' :
		include "tpl/article_type_add.php";
	break;
	
	//添加处理
	case 'add_save' :
		
		$type = $_REQUEST ['type'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['type'] ) );
		$title = $_REQUEST ['name'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['name'] );
		
		$data = array (
			'type' => $type,
			'name' => $title,
			'pid' => 0,
			'addtime' => time () 
		);
		
		if($ArticleTypeModel->add ($data) === false)
		{
			redirect ( $url.'&act=add', "添加失败！" );
			return;
		}
		
		createAdminLog($db, 6, "添加文章分类【".$title."】");
		redirect ( $url, "添加成功！" );
		return;
	break;
	
	//修改页面
	case 'edit' :
		$id = $_REQUEST ['id'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['id'] ) );
		
		if(empty($id))
		{
			redirect ( $url, "id不能为空！" );
			return;
		}		
		
		$obj = $ArticleTypeModel->get ( array('id' => $id) );
		include "tpl/article_type_edit.php";
	break;
	
	//修改处理
	case 'edit_save' :
		$id = $_REQUEST ['id'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['id'] ) );		
		if(empty($id))
		{
			redirect ( $url, "id不能为空！" );
			return;
		}
		
		
		$type = $_REQUEST ['type'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['type'] ) );
		$title = $_REQUEST ['name'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['name'] );

		$oldInfo = $ArticleTypeModel->get(array('id'=>$id));
		$data = array (
			'type' 	=> $type,
			'name' 	=> $title,
			'pid' 	=> 0
		);

		if($ArticleTypeModel->modify ( $data, array ('id' => $id)) === false)
		{
			redirect ( $url, "修改失败！" );
			return;
		}

		//更改所属栏目，同时更改文章所属栏目
		if($oldInfo->type != $type){
			$Article = M('article');
			$Article->modify(array('channel'=>$type), array('channel'=>$oldInfo->type));
		}
		
		createAdminLog($db, 6, "修改文章分类,编号id:{$id}");
		redirect ( $url, "修改成功！" );
		return;
	break;
	
	//删除处理
	case 'del' :
		
		$id = array ();
		$id = $_REQUEST['id'];
		if (empty ($id)) {
			redirect($url, "您没选中任何条目");
			return;
		}
		
		if ($ArticleTypeModel->delete(array('__IN__'=>array('id'=>$id))) === false) 
		{				
			redirect($url, "系统忙");
			return;
		}
		
		createAdminLog($db, 6, "删除文章分类,编号id:" . implode(",", $id));	
		redirect($url, "操作成功");
		return;
		
	break;

	//默认列表页
	default :

		$url = $url . "&page=";
		
		$pager = $ArticleTypeModel->gets( '', array('addtime' => 'desc'), $page, $perpage = 20 );
		include "tpl/article_type_list.php";
}
?>