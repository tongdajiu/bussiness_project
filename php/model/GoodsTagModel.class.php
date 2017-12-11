<?php
/**
 * 商品标签模型
 */
class GoodsTagModel extends Model{
    public function __construct($db, $table=''){
        $table = 'goods_tag';
        parent::__construct($db, $table);
    }
}