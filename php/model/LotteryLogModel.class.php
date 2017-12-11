<?php
/**
 * 转盘抽奖信息记录模型
 */
class LotteryLogModel extends Model{

    public function __construct($db, $table=''){
        $table = 'lottery_log';
        parent::__construct($db, $table);
    }



}