<?php
/**
 * 分销商申请模型
 */
class AgentInfoModel extends Model{

    public function __construct($db, $table=''){
        $table = 'agent_info';
        parent::__construct($db, $table);
    }
}