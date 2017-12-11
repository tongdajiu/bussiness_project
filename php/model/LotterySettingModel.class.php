<?php
/**
 * 转盘抽奖设置模型
 */
class LotterySettingModel extends Model{
    public function __construct($db, $table=''){
        $table = 'lottery_setting';
        parent::__construct($db, $table);
    }
}