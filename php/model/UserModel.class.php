<?php
/**
 * 用户模型
 */
class UserModel extends Model{
    public function __construct($db, $table=''){
        $table = 'user';
        parent::__construct($db, $table);
    }

    /**
     * 获取加密过的密码
     *
     * @param string $pwd 明文密码
     * @return string
     */
    static public function getEncryptionPassword($pwd){
        return strtoupper(md5($pwd));
    }

    /**
     * 操作金额
     *
     * @param integer $uid 用户id
     * @param number $money 金额，负数为减
     * @return boolean
     */
    public function opMoney($uid, $money){
        $success = false;
        if($uid && $money){
            $sql = 'UPDATE `user` SET `money`=`money`+'.$money.' WHERE `id`='.$uid;
            $success = ($this->conn->query($sql) === false) ? false : true;
        }
        return $success;
    }
    
    
    /**
     * 更新用户积分
     *
     * @param integer $userid 用户id
     * @param integer $integral 积分，负数为减
     * @return boolean
     */
    public function update_integral($integral, $userid){
    	$success = false;
    	
    	if($integral && $userid){
    		$sql = 'UPDATE `user` SET `integral`=`integral`+'.$integral.' WHERE `id`='.$userid;
    		$success = ($this->conn->query($sql) === false) ? false : true;
    	}
    	return $success;
    }
    
    
    
}