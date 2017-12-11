<?php
define('HN1', true);
require_once('global.php');

/*
 * 微信的图文文章
 * */
class wx_article
{
	private $_upload_file;
	private $_web_site;

	public function __construct( $db )
	{
		$this->TpImgModel 		= new TpImgModel( $db );
	}

	/*
	 * 功能：页面显示
	 * */
	public function show( $act )
	{
		switch( $act )
		{
			/*============ 列表页面 ============*/
			default:
				$id 	= !isset($_GET['id'])  		? 0 :  intval($_REQUEST['id']);

				if ( $id <= 0 )
				{
					redirect( WEB_SIZE, '传入参数有误！');
					exit;
				}

				$arrWhere['id'] = $id;
				$obj = $this->TpImgModel->get($arrWhere);

				if ( $obj == null )
				{
					redirect( WEB_SIZE, '传入参数有误！');
					exit;
				}

				include_once(TEMPLATE_DIR.'/wx_article_detail_web.php');
		}
	}

}


define('SCRIPT_ROOT', dirname(__FILE__) . '/');
require_once SCRIPT_ROOT . 'model/TpImgModel.class.php';

$wx_article = new wx_article( $db );
$act = 'one';
$wx_article->show( $act );

?>
