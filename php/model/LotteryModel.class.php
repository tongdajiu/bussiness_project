<?php
/**
 * 转盘抽奖模型
 */
class LotteryModel extends Model{
    public function __construct($db, $table=''){
        $table = 'lottery';
        parent::__construct($db, $table);
    }
}