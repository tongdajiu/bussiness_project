<?php
if ( !defined('HN1') ) die("no permission");

class lotteryBean{
    private $db;
    private $setting;

    public function __get($para_name){
        if(isset($this->$para_name)){
            return($this->$para_name);
        }else{
            return(NULL);
        }
    }

    public function __set($para_name, $val){
        $this->$para_name = $val;
    }

    /**
     * 抽奖
     *
     * @param integer $uid 会员id
     * @return array
     */
    public function lottery(){
        return $this->get_result();
    }

    /**
     * 获得抽奖结果
     *
     * @return array
     */
    private function get_result(){
        $prizes = $this->setting['prize'];
        $chance = array();
        foreach($prizes as $prize){
            if($prize['chance'] == 0) continue;
            $fills = array_fill(0, $prize['chance'], array('type'=>$prize['type'],'data'=>$prize['data']));
            $chance = array_merge($chance, $fills);
        }
        shuffle($chance);
        $result = array_rand($chance);
        return $chance[$result];
    }

    /**
     * 判断能否抽奖
     *
     * @param integer $uid 会员id
     * @return boolean
     */
    public function can_lottery($uid){
        //当周范围
        list($_year, $_month, $_day) = explode('-', date('Y-m-d', time()));

//        $week = get_weekinfo_by_date( date('Y-m-d',time()));

        $trange['start'] = strtotime($_year.'-'.$_month.'-'.$_day.' 0:0:0');
        $trange['end']   = strtotime($_year.'-'.$_month.'-'.$_day.' 23:59:59');
//        $trange['start'] = $this->getFirstTimeForWeek(time());// $this->this_monday(time(),true);
//        $trange['end']   = $trange['start'] + 86400 * 7 -1;// $this->this_sunday(time(),true);

        //未抽则可抽，已抽过则判断是否有额外的抽奖次数
        $sqlExt = 'SELECT * FROM `lottery_log` WHERE `user_id`='.$uid.' AND `time`>='.$trange['start'].' AND `time`<='.$trange['end'];
        $lotteriedNum = count($this->db->get_results($sqlExt));//已抽次数
        if($lotteriedNum == 0) return true;//未抽
//        if($lotteriedNum >= $this->setting['per_week_free_num']) return false;//每天次数已用完
        //指定时间段内首次抽奖记录
//        $sqlTmp = $sqlExt.' ORDER BY `time` ASC LIMIT 1';
//        $firstLottery = $this->db->get_row($sqlTmp);

        //当天抽中可额外的次数
        $sqlExt .= ' AND `prize_type`=2';
        $prizeExtNum = count($this->db->get_results($sqlExt));

        //转发次数
        $sql = 'SELECT * FROM `lottery_forward` WHERE `user_id`='.$uid.' AND `time`>='.$trange['start'].' AND `time`<='.$trange['end'];
        $forwardNum = count($this->db->get_results($sql));
        //指定时间段内首次转发记录
//        $sqlTmp = $sql.' ORDER BY `time` ASC LIMIT 1';
//        $firstForward = $this->db->get_row($sqlTmp);

        //如果抽中2次，只转发一次，额外未抽，则只有一次机会，额外抽一次，则没有机会
        //如果抽中2次，转了10次，额外未抽，则有2次机会，额外抽1次，则有1次机会，额外抽2次，则没有机会

        //额外机会次数
        $extNum = min($prizeExtNum, $forwardNum);
//        //指定时间段内首次转发早于首次抽奖，则首次转发可获得多一次抽奖机会
//        ($firstForward->time > $firstLottery->time) && $extNum++;
        //指定时间段内有转发或有抽中额外机会，并且转发次数多于/等于额外机会次数，额外机会增加一次
        ((($prizeExtNum > 0) || ($forwardNum > 0)) && ($forwardNum >= $prizeExtNum)) && $extNum++;

        //第1次不限制
        return ($lotteriedNum-intval($this->setting['per_day_free_num']) < $extNum) ? true : false;
    }

//    //这个星期的星期一
//    // @$timestamp ，某个星期的某一个时间戳，默认为当前时间
//    // @is_return_timestamp ,是否返回时间戳，否则返回时间格式
//    public function this_monday($timestamp=0,$is_return_timestamp=true){
//        static $cache ;
//        $id = $timestamp.$is_return_timestamp;
//
//        if(!isset($cache[$id])){
//            if(!$timestamp) $timestamp = time();
//            $monday_date = date('Y-m-d', $timestamp-86400*date('w',$timestamp)+(date('w',$timestamp)>0?86400:-/*6*86400*/518400));
//            if($is_return_timestamp){
//                $cache[$id] = strtotime($monday_date);
//            }else{
//                $cache[$id] = $monday_date;
//            }
//        }
//
//        return $cache[$id];
//
//    }
//
//    //这个星期的星期天
//    // @$timestamp ，某个星期的某一个时间戳，默认为当前时间
//    // @is_return_timestamp ,是否返回时间戳，否则返回时间格式
//     public function this_sunday($timestamp=0,$is_return_timestamp=true){
//        static $cach ;
//        $id = $timestamp.$is_return_timestamp;
//        if(!isset($cach[$id])){
//            if(!$timestamp) $timestamp = time();
//            $sunday =$this-> this_monday($timestamp) + /*6*86400*/518400;
//            if($is_return_timestamp){
//                $cach[$id] = $sunday;
//            }else{
//                $cach[$id] = date('Y-m-d',$sunday);
//            }
//        }
//        return $cach[$id];
//    }

    /**
     * 获取指定时间所在自然星期的第一天(星期天)0点时间戳
     *
     * @param integer $time 指定时间戳
     * @return integer
     */
    private function getFirstTimeForWeek($time){
        $zeroCurDay = mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time));//指定时间当天0点
        $weekDay = date('w', $time);
        return $zeroCurDay - $weekDay * 86400;
    }

    /**
     * 添加转发记录
     *
     * @param integer $uid 会员id
     */
    public function add_forward_log($uid){
        $sql = 'INSERT INTO `lottery_forward`(`user_id`,`time`) VALUES('.$uid.','.time().')';
        $this->db->query($sql);
    }

    /**
     * 获取抽奖信息
     *
     * @param integer $id 抽奖id
     * @return object
     */
    public function get($id){
        $result = null;
        if($id){
            $sql = 'SELECT * FROM `lottery` WHERE `lottery_id`='.$id;
            $result = $this->db->get_row($sql);
        }
        return $result;
    }

    /**
     * 更改转发的拥有者
     *
     * @param integer $oldUid 旧的拥有者
     * @param integer $newUid 新的拥有者
     * @return boolean
     */
    public function change_forward_owner($oldUid, $newUid){
        $sql = 'UPDATE `lottery_forward` SET `user_id`='.$newUid.' WHERE `user_id`='.$oldUid;
        return $this->db->query($sql);
    }
}
?>