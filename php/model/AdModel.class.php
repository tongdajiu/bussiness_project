<?php
/**
 * 首页图片模型
 */
class AdModel extends Model
{
	 public function __construct($db, $table=''){
        $table = 'ad';
        parent::__construct($db, $table);
    }

	// 获取首页广告图片
    public function getAdImg()
	{
		$arrWhere = array( 'status'=>1, 'type'=>4 );
		return $this->getAll( $arrWhere, '`id` DESC', 'OBJECT', 5);
	}

	// 获取首页主推图
	function getAdBackground()
	{
		$arrWhere = array( 'status'=>1, 'type'=>1 );
		return $this->getAll( $arrWhere, '`id` DESC', 'OBJECT', 1 );
	}
}
?>