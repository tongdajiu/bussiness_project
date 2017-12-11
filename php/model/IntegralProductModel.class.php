<?php
/**
 * 积分商品信息
 */
class IntegralProductModel extends Model {

     public function __construct($db, $table=''){
        $table = 'integral_product';
        parent::__construct($db, $table);
    }
}
?>