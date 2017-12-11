<?php
/**
 * 砸金蛋信息模型
 */
class EggLogModel extends Model{
    public function __construct($db, $table=''){
        $table = 'egg_log';
        parent::__construct($db, $table);
    }
}