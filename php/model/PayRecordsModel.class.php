<?php
/**
 * 产品期次
 */
class PayRecordsModel extends Model{
	 public function __construct($db, $table=''){
        $table = 'pay_records';
        parent::__construct($db, $table);
    }
}