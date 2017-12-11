<?php
/**
 * 积分兑换订单
 */
class IntegralOrdersModel extends Model {
	public function __construct($db, $table=''){
		$table = 'integral_orders';
		parent::__construct($db, $table);
	}
	
	/**
     * 生成订单号(时间微秒，长度20)
     *
     * @return string
     */
    static public function genNo(){
        list($sec, $usec) = explode(" ", microtime());
        $sec = $sec * 1000000;
        return date('YmdHis', time()).intval($sec);
    }
    
}
?>