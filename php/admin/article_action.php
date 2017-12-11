<?php
! defined ( 'HN1' ) && exit ( 'Access Denied.' );
define ( 'SCRIPT_ROOT', dirname ( __FILE__ ) . '/' );
require_once MODEL_DIR . '/ArticleModel.class.php';

$page = ! isset ( $_GET ['page'] ) ? 1 : intval ( $_GET ['page'] );
$userid = ! isset ( $_GET ['userid'] ) ? 0 : intval ( $_GET ['userid'] );
$act = ! isset ( $_REQUEST ['act'] ) ? "list" : $_REQUEST ['act'];
$type = ! isset ( $_REQUEST ['type'] ) ? 0 : intval ( $_REQUEST ['type'] );

$article = new ArticleModel ( $db );

$url = "?module=article_action";

$ArticleTypeModel = M('article_type');
$ArticleTypeList = $ArticleTypeModel->getAll();

switch ($act) {
	/**
	 * ****添加列表******
	 */
	case 'add' :
		$channels = $ArticleType;
		$map = $article->getTypeCateMap();
		include "tpl/article_add.php";
		break;
	
	/**
	 * ****添加处理******
	 */
	case 'add_save' :
		
		$type = $_REQUEST ['type'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['type'] ) );
		$title = $_REQUEST ['title'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['title'] );
		$content = $_REQUEST ['content'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['content'] );
		$status = $_REQUEST ['status'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['status'] );
		$image = "";
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			!file_exists(ARTICLE_IMG_DIR) && mkdir(ARTICLE_IMG_DIR, 0777, true);
			!file_exists(ARTICLE_IMG_DIR."large/") && mkdir(ARTICLE_IMG_DIR."large/", 0777, true);
			!file_exists(ARTICLE_IMG_DIR."small/") && mkdir(ARTICLE_IMG_DIR."small/", 0777, true);
		
			$image = uploadfile("image", ARTICLE_IMG_DIR);
			ResizeImage(ARTICLE_IMG_DIR, ARTICLE_IMG_DIR."large/", $image, "600");
			ResizeImage(ARTICLE_IMG_DIR, ARTICLE_IMG_DIR."small/", $image, "250");
		}
		
		
		$data = array (
			'channel' => intval($_POST['channel']),
			'type' => $type,
			'title' => $title,
			'image'	=> $image,
			'content' => $content,
			'status' => $status,
			'addtime' => time()
		);
		if($article->add ( $data ) === false)
		{
			redirect ('?module=article_action', "添加失败！" );
			return;
		}
		
		createAdminLog($db, 6, "添加文章【".$title."】");
		
		redirect ( '?module=article_action', "添加成功！" );
		return;
	break;
	
	/**
	 * ******修改页面******
	 */
	case 'edit' :
		$id = $_REQUEST ['id'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['id'] ) );
		$arrWhere = array (
				'id' => $id 
		);
		
		$list = $article->get ( $arrWhere );

		if($list->type){
			$channel = $ArticleTypeModel->get(array('id'=>$list->type));
			$channelId = $channel->type;
		}elseif($list->channel){
			$channelId = $list->channel;
		}

		$channels = $ArticleType;
		$map = $article->getTypeCateMap();
		include "tpl/article_edit.php";
		break;
	
	/**
	 * ******修改处理******
	 */
	case 'edit_save' :
		$id = $_REQUEST ['id'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['id'] ) );
		
		if(empty($id))
		{
			redirect('?module=article_action',"id不能为空");
			return;
		}
		
		$obj_old = $article->get(array('id'=>$id));

		$type = $_REQUEST ['type'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['type'] ) );
		$title = $_REQUEST ['title'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['title'] );
		$status = $_REQUEST ['status'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['status'] );
		$content = $_REQUEST ['content'] == null ? '' : sqlUpdateFilter ( $_REQUEST ['content'] );
		$data = array (
			'channel' => intval($_POST['channel']),
			'type' => $type,
			'title' => $title,
			'content' => $content,
			'status' => $status,
			'addtime' => time()
		);
		
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			//检查图片文件是否存在
			if (file_exists(ARTICLE_IMG_DIR . $image)) {
		
				unlink(ARTICLE_IMG_DIR . $image);
				unlink(ARTICLE_IMG_DIR."large/" . $image);
				unlink(ARTICLE_IMG_DIR."small/". $image);
			}
		
			!file_exists(ARTICLE_IMG_DIR) && mkdir(ARTICLE_IMG_DIR, 0777, true);
			!file_exists(ARTICLE_IMG_DIR."large/") && mkdir(ARTICLE_IMG_DIR."large/", 0777, true);
			!file_exists(ARTICLE_IMG_DIR."small/") && mkdir(ARTICLE_IMG_DIR."small/", 0777, true);
		
			$image = uploadfile("image", ARTICLE_IMG_DIR);
		
			ResizeImage(ARTICLE_IMG_DIR, ARTICLE_IMG_DIR."large/", $image, "600");
			ResizeImage(ARTICLE_IMG_DIR, ARTICLE_IMG_DIR."small/", $image, "250");

			$data['image'] = $image;
		}
		
		if($article->modify ( $data,array ('id' => $id)) === false)
		{
			redirect ( '?module=article_action', "修改失败！" );
			return;
		}
			
		createAdminLog($db, 6, "修改文章，编号id:{$id}");
		redirect ( '?module=article_action', "修改成功！" );
		return;
	break;
	
	/**
	 * ******删除处理******
	 */
	case 'del' :
		$id = $_REQUEST ['id'] == null ? 0 : sqlUpdateFilter ( intval ( $_REQUEST ['id'] ) );
		
		if(empty($id))
		{
			redirect('?module=article_action',"id不能为空");
			return;
		}

		if($article->delete (array('id' => $id )) === false)
		{
			redirect ( '?module=article_action', "删除失败！" );
			return;
		}
			
		createAdminLog($db, 6, "删除文章，编号id:{$id}");
		
		redirect ( '?module=article_action', "删除成功！" );
		return;
	break;
	
	default :
		if ($type != '') {
			$url = $url . "&type=" . $type;
		}
		
		$url = $url . "&page=";
		$articleList = $article->gets ( '', array ('addtime' => 'desc'), $page, $perpage = 20 );

		$typeIds = array();
		$mapCateArt = array();
		foreach($articleList['DataSet'] as $k => $v){
			if($v->type){
				$typeIds[] = $v->type;
				$mapCateArt[$v->type][$v->id] = $k;
			}elseif($v->channel){
				$articleList['DataSet'][$k]->channel_name = $ArticleType[$v->channel];
			}
		}

		if(!empty($typeIds)){
			$types = $ArticleTypeModel->getAll(array('__IN__'=>array('id'=>$typeIds)));
			foreach($types as $v){
				foreach($mapCateArt[$v->id] as $_v){
					$articleList['DataSet'][$_v]->category_name = $v->name;
					$articleList['DataSet'][$_v]->channel_name = $ArticleType[$v->type];
				}
			}
		}

		include "tpl/article_list.php";
}
?>