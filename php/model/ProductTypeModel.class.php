<?php
/**
 * 产品分类
 */
class ProductTypeModel extends Model
{
	 public function __construct($db, $table='')
	 {
        $table = 'product_type';
        parent::__construct($db, $table);
    }

	//获取product_type中所有父类类型，即classid为0
    public function getList( $keys )
    {
    	$arr      = null;
		$arrWhere = array( 'classid' => $keys );
		$rs = $this->getAll( $arrWhere, "`sorting` asc,`id` desc", 'OBJECT');
		
		if ( $rs != null )
		{
			foreach( $rs as $val )
			{
				$arr[$val->id] = $val;
			}
		}
		
		return $arr;
    }
	// 分类信息
    function getInfo($id)
	{
		$arrWhere = array( 'id' => $id );
		return $this->get( $arrWhere);
	}
}