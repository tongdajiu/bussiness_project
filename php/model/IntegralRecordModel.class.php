<?php
/**
 * 积分获取记录
 */
class IntegralRecordModel extends Model
{
	public function __construct($db, $table=''){
		$table = 'integral_record';
		parent::__construct($db, $table);
	}	
}
?>