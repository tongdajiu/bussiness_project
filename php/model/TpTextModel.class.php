<?php
/**
 * 文信息模型
 */
class TpTextModel extends Model
{
    public function __construct($db, $table='')
    {
        $table = 'tp_text';
        parent::__construct($db, $table);
    }

}