<?php
/**
 * 门店资料模型
 */
class StoreInformationModel extends Model{
	public function __construct($db, $table=''){
        $table = 'store_information';
        parent::__construct($db, $table);
    }
}
?>