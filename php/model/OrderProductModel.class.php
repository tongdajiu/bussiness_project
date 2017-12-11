<?php
/**
 * 订单商品
 */
class OrderProductModel extends Model
{
	public function __construct($db, $table=''){
		$table = 'order_product';
		parent::__construct($db, $table);
	}
	
	/**
	 * 
	 * @param $order_id 订单编号
	 * @return 订单的商品总数
	 */
	public function get_results_orderSum($order_id){
		$sql = "select SUM(shopping_number) from ".$this->getTable()." where order_id='".$order_id."'";

		$row = $this->conn->get_var($sql);

		return $row;
	}
	
	
}


?>