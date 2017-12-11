<?php
/**
 * 申请信息模型
 */
class DistributorApplicationModel extends Model{

    public function __construct($db, $table=''){
        $table = 'distributor_application';
        parent::__construct($db, $table);
    }
}