<?php
/**
 * 优惠卷模型
 */
class CouponModel extends Model{

    public function __construct($db, $table=''){
        $table = 'coupon';
        parent::__construct($db, $table);
    }



}