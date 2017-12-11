<?php
/**
 * 图文信息模型
 */
class TpImgModel extends Model
{
    public function __construct($db, $table='')
    {
        $table = 'tp_img';
        parent::__construct($db, $table);
    }

}