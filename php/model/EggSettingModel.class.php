<?php
/**
 * 砸金蛋奖品设置模型
 */
class EggSettingModel extends Model{
    public function __construct($db, $table=''){
        $table = 'egg_setting';
        parent::__construct($db, $table);
    }
}