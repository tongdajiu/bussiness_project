<?php
/**
 * 用户地址
 */
class UserAddressModel extends Model{

    public function __construct($db, $table=''){
        $table = 'user_address';
        parent::__construct($db, $table);
    }
}
?>