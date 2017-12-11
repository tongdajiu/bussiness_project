<?php
/**
 * 分销商信息模型
 */
class AgentApplicationModel extends Model{

    public function __construct($db, $table=''){
        $table = 'agent_application';
        parent::__construct($db, $table);
    }
}