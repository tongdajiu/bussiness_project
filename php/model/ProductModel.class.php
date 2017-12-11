<?php
/**
 * 商品信息模型
 */
class ProductModel extends Model
{
    public function __construct($db, $table='')
    {
        $table = 'product';
        parent::__construct($db, $table);
    }

	// 获取首页商品
    function getNewList()
	{
		$arrWhere = array( 'status'=>1 );
		return $this->getAll( $arrWhere, '`product_id` DESC', 'OBJECT', 4);
	}


	// 获取商品列表
    function getList( $category_id = '', $page, $perpage )
	{
		$arrWhere['status'] = 1;

		if ( intval($category_id) > 0  )
		{
			$arrWhere['category_id'] = $category_id;
		}

		return $this->gets( $arrWhere, '`sorting` ASC,`product_id` DESC', $page, $perpage );
	}

	// 商品搜索列表
	function getSearchList( $name='' )
	{
		$arrWhere['status'] = 1;

		if ( $name != '' )
		{
			$arrWhere['name'] = array('like'=>'%'.$name.'%');
		}

		return $this->getAll( $arrWhere, '`sorting` ASC,`product_id` DESC');
	}


	// 商品详情
	function getInfo( $id )
	{
		$arrWhere = array('product_id'=>$id);
		return $this->get( $arrWhere );
	}

	/**
	 * 获取特价列表
	 *
	 * @param integer $id 商品id
	 * @return array
	 */
	public function getBargainPrices($id){
		$list = array();
		$rs = $this->getAll(array('product_id'=>$id), array('id'=>'asc'), ARRAY_A, '', '', 'product_bargain_price');
		$pAttrIds = array();
		foreach($rs as $v){
			$pAttrIds[] = $v['product_attr_id'];
		}
		$pAttrIds = array_filter($pAttrIds);
		if(!empty($pAttrIds)){
			$pAttrs = array();
			$attrRs = $this->getAttrList($id);
			foreach($attrRs as $v){
				$pAttrs[$v['id']] = $v;
			}
		}
		foreach($rs as $v){
			isset($pAttrs[$v['product_attr_id']]) && $v['attr'] = $pAttrs[$v['product_attr_id']];
			$list[] = $v;
		}
		return $list;
	}

	/**
	 * 获取特价信息
	 *
	 * @param integer $id 特价id
	 * @return array
	 */
	public function getBargainPrice($id){
		return $this->get(array('id'=>$id), '*', ARRAY_A, 'product_bargain_price');
	}

	/**
	 * 获取商品的属性
	 *
	 * @param integer $id 商品id
	 * @return array
	 */
	public function getAttrList($id){
		$list = array();
		$rs = $this->getAll(array('product_id'=>$id), array('id'=>'asc'), ARRAY_A, '', '', 'product_attr');
		foreach($rs as $v){
			$v['attr'] = json_decode($v['attr_group'], true);
			$list[] = $v;
		}
		return $list;
	}

	/**
	 * 根据商品属性id获取相应属性信息
	 *
	 * @param integer|array $ids 商品属性id
	 * @return array
	 */
	public function getAttrs($ids){
		$list = array();
		$rs = $this->getAll(array('__IN__'=>array('id'=>$ids)), array(), ARRAY_A, '', '', 'product_attr');
		foreach($rs as $v){
			$list[$v['id']] = $v;
		}
		return $list;
	}

	/**
	 * 获取关联的属性
	 *
	 * @param integer $id 关联属性id
	 * @return array
	 */
	public function getAttr($id){
		return $this->get(array('id'=>$id), '*', ARRAY_A, 'product_attr');
	}

	/**
	 * 添加特价
	 *
	 * @param array $data 特价相关信息
	 * @return integer|boolean
	 */
	public function addBargainPrice($data){
		return $this->add($data, 'product_bargain_price');
	}

	/**
	 * 修改特价信息
	 *
	 * @param integer $id 特价id
	 * @param array $data 特价信息
	 * @return integer|boolean
	 */
	public function modifyBargainPrice($id, $data){
		return $this->modify($data, array('id'=>$id), 'product_bargain_price');
	}

	/**
	 * 删除特价
	 *
	 * @param integer|array $id 特价id
	 * @return integer|boolean
	 */
	public function deleteBargainPrice($id){
		!is_array($id) && $id = array($id);
		return $this->delete('id IN ('.implode(',', $id).')', 'product_bargain_price');
	}

	/**
	 * 清理无用的特价
	 *
	 * @param integer $id 商品id
	 */
	public function cleanBargainPrice($id){
		$attrs = $this->getAttrList($id);
		$attrIds = array();
		foreach($attrs as $v){
			$attrIds[] = $v['id'];
		}
		$cond = 'product_id='.$id;
		!empty($attrIds) && $cond .= ' and product_attr_id not in ('.implode(',', $attrIds).')';
		$this->delete($cond, 'product_bargain_price');
	}

	/**
	 * 获取商品当前的有效特价
	 *
	 * @param array $data 相关信息，array(商品id=>array(属性id))
	 * @return array
	 * 		array(商品id=>array(属性id=>array('id'=>特价记录id, 'price'=>特价,'store'=>库存,'stime'=>开始时间,'etime'=>结束时间)))
	 */
	public function getValidBargainPrice($data){
		$cond = array();
		foreach($data as $pid => $aids){
			if(empty($aids)){
				$cond[] = 'product_id='.$pid.' and product_attr_id=0';
			}else{
				foreach($aids as $aid){
					$cond[] = 'product_id='.$pid.' and product_attr_id='.$aid;
				}
			}
		}
		if(!empty($cond)){
			$time = time();
			$cond = 'start_time<='.$time.' and end_time>='.$time.' and (('.implode(') or (', $cond).'))';
		}
		$rs = $this->getAll($cond, array('start_time'=>'asc'), ARRAY_A, '', '', 'product_bargain_price');
		$list = array();
		foreach($rs as $v){
			if(isset($list[$v['product_id']][$v['product_attr_id']])) continue;
			$tmp = array('id'=>$v['id'], 'price'=>$v['price']);
			($v['store'] >= 0) && $tmp['store'] = $v['store'];
			$v['start_time'] && $tmp['stime'] = $v['start_time'];
			$v['end_time'] && $tmp['etime'] = $v['end_time'];
			$list[$v['product_id']][$v['product_attr_id']] = $tmp;
		}
		return $list;
	}
}