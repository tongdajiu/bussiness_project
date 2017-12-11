<?php
/**
 * 分类
 *
 * @author WillZheng <shaoweizheng@163.com|qq252075062>
 */
class Category{
    private $data;

    public function __construct($data=array()){
        $this->data = $data;
    }

    /**
     * 获取树形结构数据
     *
     * @param integer $pid 父id
     * @param string $childname 子元素的键名
     * @return array
     */
    public function getTree($pid=0, $childname='child'){
        $tree = array();
        foreach($this->data as $v){
            if($v['pid'] == $pid){
                $v[$childname] = $this->getTree($v['id'], $childname);
                $tree[] = $v;
            }
        }
        return $tree;
    }

    /**
     * 获取一维数据结构数据
     *
     * @param integer $pid 父id
     * @param string $delimiter 层级识别符
     * @param integer $level 层级
     * @return array
     */
    public function getSimpleTree($pid=0, $delimiter='--', $level=0, $cfg=array('delimiterName'=>'delimiter', 'levelName'=>'treeLevel')){
        $delimiterName = (isset($cfg['delimiterName']) && !empty($cfg['delimiterName'])) ? $cfg['delimiterName'] : 'delimiter';
        $levelName = (isset($cfg['levelName']) && !empty($cfg['levelName'])) ? $cfg['levelName'] : 'treeLevel';
        $tree = array();
        foreach($this->data as $v){
            if($v['pid'] == $pid){
                $v[$delimiterName] = str_repeat($delimiter, $level);
                $v[$levelName] = $level + 1;
                $tree[] = $v;
                $tree = array_merge($tree, $this->getSimpleTree($v['id'], $delimiter, $v[$levelName], array('delimiterName'=>$delimiterName, 'levelName'=>$levelName)));
            }
        }
        return $tree;
    }
}