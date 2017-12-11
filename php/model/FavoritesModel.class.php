<?php
/**
 * 收藏夹模型
 */
class FavoritesModel extends Model{
    public function __construct($db, $table=''){
        $table = 'favorites';
        parent::__construct($db, $table);
    }

    public function getList( $id )
    {
      $strSQL = "SELECT f.`id`,f.`status`,f.`type`,(SELECT `name` FROM `user` WHERE `id`=f.`userid`) AS username, (SELECT `name` FROM `product` WHERE `product_id`=f.`product_id`) AS productname FROM favorites AS f";
      $list = $this->getALL($strSQL);
      return $list;
    }
}