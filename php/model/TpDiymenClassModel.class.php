<?php
/**
 * 微信菜单模型
 */
class TpDiymenClassModel extends Model
{
    public function __construct($db, $table='')
    {
        $table = 'tp_diymen_class';
        parent::__construct($db, $table);
    }

	/*
	 * 功能：获取微信列表（数据表记录）
	 * */
	public function getList()
	{
		$arrWhere 	= array( 'pid' => 0 );
    	$arrData  	= $this->getAll( $arrWhere );
   		$rs			= null;

		foreach ( $arrData as $key=>$data )
		{
			$arrWhere  = array( 'pid' => $data->id );
			$ChildData = $this->getAll( $arrWhere );

			$rs[$key] = $data;
			$rs[$key]->child = $ChildData;
		}

		return $rs;
	}


	/*
	 * 功能：获取微信自定义菜单（用于生成微信菜单时直接使用）
	 * */
    public function getMenu()
    {
    	$arrWhere = array( 'pid' => 0 );
    	$arrData  = $this->getAll( $arrWhere );
		$rs 	  = null;

		$key = 0;
    	foreach( $arrData as $data )
    	{
    		if ( $data->title != '' )
    		{
    			$arrWhere 		= array( 'pid' => $data->id );
	    		$arrChildDatas  = $this->getAll( $arrWhere );
				$ChildData 		= null;
				$cKey			= 0;

	    		foreach ( $arrChildDatas as $arrChildData  )
	    		{
	    			if ( $arrChildData->title != '' )
	    			{
	    				$ChildData[$cKey]['name'] = $arrChildData->title;

	    				if ( $arrChildData->type == 1 )
						{
	    					$ChildData[$cKey]['type'] = 'click';
	    					$ChildData[$cKey]['key']  = $arrChildData->keyword;
						}
						else
						{
							$ChildData[$cKey]['type'] = 'view';
	    					$ChildData[$cKey]['url']  = $arrChildData->url;
						}

	    				$cKey++;
	    			}
	    		}

	    		if ( $ChildData == null )
	    		{
	    			$rs[$key]['name'] = $data->title;
	    			if ( $arrChildData->type == 1 )
					{
    					$rs[$key]['type'] = 'click';
    					$rs[$key]['key']  = $data->keyword;
					}
					else
					{
						$rs[$key]['type'] = 'view';
    					$rs[$key]['url']  = $data->url;
					}
	    		}
	    		else
	    		{
	    			$rs[$key]['name'] = $data->title;
	    			$rs[$key]['sub_button'] = $ChildData;
	    		}


	    		$key++;
    		}
    	}

    	return $rs;
    }

}