<?php
/**
 * 资金模型类
 */
class MoneyModel extends Model{
    //返利类型日志
    const LOG_TYPE_REBATE = 1;//结算
    const LOG_TYPE_TUI = 2;//退款
    const LOG_TYPE_TI = 3;//提現
    /**
     * 添加日志
     *
     * @param array $data 日志信息
     *      uid 用户id
     *      money 金额，负数为减
     *      remark 备注
     *      type 类型
     * @return boolean
     */
    public function addLog($data){
        $success = false;
        if(!empty($data)){
            $log = array(
                'user_id' => $data['uid'],
                'time'   => time(),
                'money'  => $data['money'],
                'remark' => $data['remark'],
                'type'   => $data['type'],
            );
            $success = ($this->add($log, 'money_log') === false) ? false : true;
        }
        return $success;
    }
}