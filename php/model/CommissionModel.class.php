<?php
/**
 * 佣金
 */
class CommissionModel extends Model{
    /**
     * 添加记录
     *
     * @param array $data 记录信息
     *      uid 用户id
     *      money 金额，负数为减
     *      remark 备注
     *      orderno 订单号
     * @return integer
     */
    public function addLog($data){
        $success = false;
        if(!empty($data)){
            $log = array(
                'user_id' => $data['uid'],
                'time' => time(),
                'money' => $data['money'],
                'remark' => $data['remark'],
                'order_no' => $data['orderno'],
            );
            $success = ($this->add($log, 'commission_log') === false) ? false : true;
        }
        return $success;
    }

    /**
     * 获取佣金总额
     *
     * @param integer|array $uids 用户id
     * @param array $timeRange 时间范围，start开始时间，end结束时间
     * @return number
     */
    public function getTotalAmount($uids, $timeRange=array()){
        $amount = 0;
        if(!empty($uids)){
            !is_array($uids) && $uids = array($uids);
            $sql = 'SELECT SUM(`money`) FROM `commission_log` WHERE `user_id` in ('.implode(',', $uids).')';
            (isset($timeRange['start']) && ($timeRange['start'] > 0)) && $sql .= ' AND `time`>='.$timeRange['start'];
            (isset($timeRange['end']) && ($timeRange['end'] > 0)) && $sql .= ' AND `time`<='.$timeRange['end'];
            $amount = $this->conn->get_var($sql);
        }
        return $amount;
    }
}