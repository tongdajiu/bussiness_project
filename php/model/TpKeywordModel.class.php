<?php
/**
 * 关键字信息模型
 */
class TpKeywordModel extends Model
{
	public $web_site;
    public function __construct($db, $table='')
    {
        $table = 'tp_keyword';
        parent::__construct($db, $table);
    }

	/**
	 * 功能：判断关键字是否可用
	 *
	 * @param string $type     类型
	 * @param string $keyword  关键字
	 * @return boolean
	 */
	public function isEnable( $type, $keyword )
	{
		$arrWhere 	= array( 'keyword'=>$keyword );
		$rs = $this->get( $arrWhere );

		if ( $rs == null )
		{
			return true;
		}

		if ( $rs->keyword == 'subscribe' )
		{
			return false;
		}

		if ( $rs->module == 'Text' || $type == 'Text' )
		{
			return false;
		}

		return true;
	}


	/*
	 * 功能：通过关键字获取信息列表
	 * */
	public function getKeywordList( $keyword, $site='' )
	{
		$arrWhere['keyword'] = $keyword;
		$arrData	= $this->getAll( $arrWhere );

		if ( $arrData == null )
		{
			return null;
		}
		$k = 0;
		foreach( $arrData as $data )
		{
			// 如果是文本
			if ( $data->module == 'Text' )
			{
				$rs['type'] = 'Text';
				$this->table = 'tp_text';
				$arrWhere['id'] = $data->pid;
				$arrCol = array( 'text' );
				$rs['data'] = $this->get( $arrWhere,$arrCol )->text;
			}
			else
			{
				$rs['type'] = 'News';
				$this->table = 'tp_img';

				$arrWhere['id'] = $data->pid;
				$arrCol 		= array( 'id','title','text','pic','url' );
				$arr 			= $this->get( $arrWhere,$arrCol );

				$rs['data'][$k]['Title'] 		= $arr->title;
				$rs['data'][$k]['Description'] 	= $arr->text;
				$rs['data'][$k]['PicUrl'] 		= $arr->pic;
				if ( $arr->url == '' )
				{
					$rs['data'][$k]['Url'] 		= $site . 'wx_article.php?id=' . $arr->id;
				}
				else
				{
					$rs['data'][$k]['Url'] 		= $arr->url;
				}


			}

			$k++;
		}

		return $rs;
	}

	/*
	 * 功能：获取关注推送的信息
	 * */
	public function getSubscribeList( $site )
	{
		$arrWhere['keyword'] = 'subscribe';
		$arrData	= $this->get( $arrWhere );

		if ( $arrData == null )
		{
			return null;
		}

		$k = 0;
		// 如果是文本
		if ( $arrData->module == 'Text' )
		{
			$rs['type'] = 'Text';
			$this->table = 'tp_text';
			$arrCol = array( 'text' );
			$rs['data'] = $this->get( $arrWhere,$arrCol )->text;
		}
		else
		{
			$rs['type'] = 'News';
			$this->table = 'tp_img';
			$arrWhere['keyword'] = 'subscribe';
			$arrCol 		= array( 'id','title','text','pic','url' );
			$arr 			= $this->get( $arrWhere,$arrCol );

			$rs['data'][$k]['Title'] 		= $arr->title;
			$rs['data'][$k]['Description'] 	= $arr->text;
			$rs['data'][$k]['PicUrl'] 		= $arr->pic;
			if ( $arr->url == '' )
			{
				$rs['data'][$k]['Url'] 		= $site . 'wx_article.php?id=' . $arr->id;
			}
			else
			{
				$rs['data'][$k]['Url'] 		= $arr->url;
			}
			$k++;
		}

		return $rs;
	}

}