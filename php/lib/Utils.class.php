<?php
/**
 * 工具类
 */
class Utils{
    /**
     * 获取用户级别有效的返利比例
     *
     * @param string|array $setLevel 设置的返利比例
     * @param integer $maxLevel 有效的最大级别数
     * @return array
     */
    static public function getValidLevelRebateRate($setLevel, $maxLevel=3){
        !is_array($setLevel) && $setLevel = explode('#', $setLevel);
        $setLevel = array_values(array_filter($setLevel));
        return array_slice($setLevel, 0, $maxLevel);
    }
}