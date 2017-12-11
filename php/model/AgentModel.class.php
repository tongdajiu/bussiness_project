<?php
/**
 * 分销商
 */
class AgentModel extends Model{
    /**
     * 根据条件判断用户是否为分销商
     *
     * @param integer|string $flag 根据的条件的内容
     * @param string $flagType 条件类型，uid用户id(默认)，uname用户名，openid微信openid
     * @param boolean $ignoreStatus 是否忽略分销商状态，false则状态为0也是非分销商，默认为true
     * @return boolean
     */
    public function isAgent($flag, $flagType='uid', $ignoreStatus=true){
        $types = array('uid', 'uname', 'openid');
        !in_array($flagType, $types) && $flagType = 'uid';
        $sql = "SELECT * FROM `agent_info` AS ai LEFT JOIN `user` AS u ON ai.`userid`=u.`id` WHERE ";
        switch($flagType){
            case 'uid':
                $sql .= 'u.`id`='.$flag;
                break;
            case 'uname':
                $sql .= "u.`username`='{$flag}'";
                break;
            case 'openid':
                $sql .= "u.`openid`='{$flag}'";
                break;
        }
        !$ignoreStatus && $sql .= ' AND ai.`status`=1';
        $rs = $this->conn->get_row($sql);
        return empty($rs) ? false : true;
    }
}