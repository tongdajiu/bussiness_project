<?php
/**
 * 门店图册模型
 */
class StoreImagesModel extends Model{
	public function __construct($db, $table=''){
        $table = 'store_images';
        parent::__construct($db, $table);
    }
}
?>