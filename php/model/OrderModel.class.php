<?php
/**
 * 订单
 */
class OrderModel extends Model{
    /**
     * 获取下线用户订单总额
     *
     * @param integer $uid 用户id
     * @param integer $status 订单状态，-1全部，0待付款，1待发货，2已发货，3已确认
     * @param array $timeRange 时间范围，start开始时间，end结束时间
     * @param boolean $self 是否包含指定用户本身
     * @return number
     */
    public function getSubordinateTotalAmount($uid, $status=-1, $timeRange=array(), $self=false){
        $amount = 0;
        $sql = "SELECT * FROM `user_connection` WHERE `path` LIKE '%,{$uid},%'";
        $rs = $this->conn->get_results($sql);
        $orderUids = array();
        $self && $orderUids[] = $uid;
        if($rs !=''){
        foreach($rs as $v){
            $_path = explode(',', $v->path);
            $_path = array_filter($_path);
            $_index = array_search($uid, $_path);
            if(($_index !== false) && (count($_path) > $_index)){
                $_lowUid = array_slice($_path, $_index);
                $orderUids = array_merge($orderUids, $_lowUid);
            }
            $orderUids[] = $v->userid;
        }
        }
        if(!empty($orderUids)){
            $sql = 'SELECT SUM(`all_price`) FROM `orders` WHERE `customer_id` IN ('.implode(',', $orderUids).')';
            ($status > -1) && $sql .= ' AND `order_status_id`='.$status;
            (isset($timeRange['start']) && ($timeRange['start'] > 0)) && $sql .= ' AND `addtime`>='.$timeRange['start'];
            (isset($timeRange['end']) && ($timeRange['end'] > 0)) && $sql .= ' AND `addtime`<='.$timeRange['end'];
            $amount = $this->conn->get_var($sql);
        }
        return $amount;
    }

    /**
     * 生成订单号(时间微秒，长度20)
     *
     * @return string
     */
    static public function genNo(){
        list($sec, $usec) = explode(" ", microtime());
        $sec = $sec * 1000000;
        return date('YmdHis', time()).intval($sec);
    }

    /**
     * 获取下单用户信息
     *
     * @param array $orderNo 订单号
     * @return array(订单号=>用户信息)
     */
    public function getUsers($orderNo){
        $list = array();
        !is_array($orderNo) && $orderNo = array($orderNo);
        $sql = "SELECT o.`order_number`,u.* FROM `orders` AS o LEFT JOIN `user` AS u ON o.`customer_id`=u.`id` WHERE o.`order_number` IN ('".implode("','", $orderNo)."')";
        $rs = $this->conn->get_results($sql, ARRAY_A);
        foreach($rs as $v){
            $list[$v['order_number']] = $v;
        }
        return $list;
    }


   public function __construct($db, $table=''){
        $table = 'orders';
        parent::__construct($db, $table);
    }

    //获取没评价的订单
    public function getResultsNotComment($userid)
    {
		$sql = "select a.* from orders as a where a.customer_id='" . $userid . "'  and  order_status_id=3  and user_del<>2 ";
		$sql .= " and not EXISTS(select 1 from comment as b where b.order_id = a.order_id)";
		return $this->query($sql);
	}




}