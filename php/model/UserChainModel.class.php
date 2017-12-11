<?php
/**
 * 用户链模型
 */
include_once(LIB_DIR.'/Category.class.php');

class UserChainModel extends Model{
    public function __construct($db, $table=''){
        $table = 'user_connection';
        parent::__construct($db, $table);
    }

    /**
     * 获取指定用户的上级用户链
     *
     * @param integer $uid 指定的用户id
     * @return array('uid'=>上级用户id,'level'=>上级用户相对指定用户的等级)
     */
    public function getUpUids($uid){
        if(empty($uid)) return array();
        $chain = $this->get(array('userid'=>$uid), 'path', ARRAY_A);
        $uids = array_filter(explode(',', $chain['path']));
        $uids = array_reverse($uids, true);
        $data = array();
        $level = 1;
        foreach($uids as $k => $uid){
            $data[$uid] = array('uid'=>$uid, 'level'=>$level);
            $level++;
        }
        return $data;
    }

    /**
     * 获取指定用户有效上级用户可得的佣金
     * todo 目前规则：分销商身份的上级用户才有佣金
     *
     * @param integer $uid 指定用户
     * @param float $money 指定用户作为返利的佣金基数
     * @param array $level 各有效等级的返利百分比，按等级顺序排列
     * @return array(各上级用户id=>佣金)
     */
    public function getBrokerage($uid, $money, $level=array()){
        $data = array();
        if(!empty($level)){
            $chainInfo = $this->get(array('userid'=>$uid));
            $path = explode(',', $chainInfo->path);
            $path = array_filter($path);
            if(!empty($path)){
                $validPath = array();
                $levelNum = count($level);

                //获取上级用户对应的分销商身份
                $sql = 'SELECT `userid` FROM `agent_info` WHERE `userid` IN ('.implode(',', $path).')';
                $agents = $this->conn->get_results($sql);
                if(!empty($agents)){
                    $agentUid = array();
                    foreach($agents as $v){
                        $agentUid[] = $v->userid;
                    }
                    foreach($path as $k => $v){
                        in_array($v, $agentUid) && $validPath[] = $v;
                    }
                }

                if(!empty($validPath)){
                    $ups = array_slice($validPath, -$levelNum);//有效的上级用户，有返利
                    if(!empty($ups)){
                        $ups = array_reverse($ups);
                        $comUserNum = count($ups);//获得提成的用户人数
                        $remainTotalCommission = array_sum($level);//剩余可分配的提成比率
                        $levelIndex = 1;
                        foreach($ups as $k => $upuid){
                            if(isset($level[$k])){
                                $rate = ($levelIndex == $comUserNum) ? $remainTotalCommission : $level[$k];
                                $_rebate = $money * $rate / 100;
                                $data[$upuid] = sprintf('%.6f', $_rebate);//todo %.2f临时改为%.6f，测试后需改回
                                $remainTotalCommission -= $rate;
                                $levelIndex++;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 获取下级用户数量
     *
     * @param integer $uid 用户id
     * @return integer
     */
    public function getSubordinateCount($uid){
        $count = 0;
        if($uid){
            $uids = array();
            $sql = "SELECT * FROM `".$this->table."` WHERE `path` LIKE '%,{$uid},%'";
            $rs = $this->conn->get_results($sql);
            if($rs !=''){
            foreach($rs as $v){
                $uids[$v->userid] = $v->userid;
                $uids[$v->fuserid] = $v->fuserid;
            }
            }
            unset($uids[$uid]);
            if(!empty($uids)){
                $sql = 'SELECT COUNT(*) FROM `user` WHERE `id` IN ('.implode(',', $uids).')';
                $count = $this->conn->get_var($sql);
            }
        }
        return $count;
    }

    /**
     * 获取指定用户的下级用户
     *
     * @param integer $uid 用户id
     * @return array('uid'=>下级用户id,'level'=>下级用户相对指定用户的等级)
     */
    public function getDownUids($uid){
        if(empty($uid)) return array();
        $data = array();
        $sql = "SELECT * FROM `".$this->table."` WHERE `path` LIKE '%,{$uid},%' ORDER BY `path` ASC";
        $_rs = $this->conn->get_results($sql, ARRAY_A);
        foreach($_rs as $v){
            $level = 1;
            $_uids = array_values(array_filter(explode(',', $v['path'])));
            $index = array_search($uid, $_uids);
            if(($index !== false) && ($index < count($_uids))){
                $sub = array_slice($_uids, $index+1);
                foreach($sub as $_v){
                    if(!isset($uids[$_v])){
                        $data[$_v] = array('uid'=>$_v, 'level'=>$level);
                    }
                    $level++;
                }
                $data[$v['userid']] = array('uid'=>$v['userid'], 'level'=>$level);
            }
        }
        return $data;
    }
}