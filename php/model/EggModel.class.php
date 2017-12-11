<?php
/**
 * 砸金蛋设置模型
 */
class EggModel extends Model{
    public function __construct($db, $table=''){
        $table = 'egg';
        parent::__construct($db, $table);
    }
}