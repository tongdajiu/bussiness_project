<?php
/**
 * 微信预付单模型
 */
class WxPayInfoModel extends Model{
    public function __construct($db, $table=''){
        $table = 'wx_pay_info';
        parent::__construct($db, $table);
    }
}