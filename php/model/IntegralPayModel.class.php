<?php
/**
 * 积分使用记录
 */
class IntegralPayModel extends Model{
	public function __construct($db, $table=''){
		$table = 'integral_pay';
		parent::__construct($db, $table);
	}
	
	/**
	 * 添加积分使用记录
	 * @param integer 		type	  	'0-》历史积分升级会员，1-》购物，2-》兑换'
	 * @param integer 		userid   	'所属用户',
	 * @param integer 		integral 	'使用积分的数量',
	 * @param integer 		addtime 	'记录产生时间',
	 * @param string		remarks 	'备注'
	 * @return integer|boolean
	 */
    public function addIntegralPay($type,$userid,$integral,$remarks = '') {
		$data = array(
			'status' 	=> 1,
			'type' 		=> $type,
			'userid' 	=> $userid,
			'integral' 	=> $integral,
			'remarks' 	=> $remarks,
			'addtime' 	=> time()
		);
		return parent::add($data, 'integral_pay');
    }
}
?>