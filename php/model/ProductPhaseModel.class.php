<?php
/**
 * 产品期次
 */
class ProductPhaseModel extends Model{
	 public function __construct($db, $table=''){
        $table = 'product_phase';
        parent::__construct($db, $table);
    }
}