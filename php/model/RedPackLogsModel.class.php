<?php
/**
 * 红包记录模型
 */
class RedPackLogsModel extends Model
{
	public function __construct($db, $table='')
	{
	    $table = 'redpack_logs';
	    parent::__construct($db, $table);
	}

}
?>