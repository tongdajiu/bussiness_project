<?php
/**
 * 设置模型类
 */
$__CUR_DIR = dirname(__FILE__);
define('SETTING_CACHE_DIR', $__CUR_DIR.'/../data');

class SettingModel extends Model{
    private $cacheFile;

    public function __construct($db){
        $table = 'setting';
        parent::__construct($db, $table);
        !file_exists(SETTING_CACHE_DIR) && mkdir(SETTING_CACHE_DIR, 0777, true);
        $this->cacheFile = SETTING_CACHE_DIR.'/setting.php';
    }

    /**
     * 获取全部项
     *
     * @return array
     */
    public function getItems(){
        $data = include_once($this->cacheFile);
        empty($data) && $data = $this->reCache();
        return $data;
    }

    /**
     * 获取指定项的内容
     *
     * @param string $key 指定项的key
     * @return string
     */
    public function getItem($key){
        $data = $this->getItems();
        return $data[$key];
    }

    /**
     * 重新生成缓存文件
     *
     * @return array
     */
    public function reCache(){
        $data = $this->getOriItems();
        file_put_contents($this->cacheFile, "<?php\r\nreturn ".var_export($data, true).";\r\n?>");
        return $data;
    }

    /**
     * 修改多个设置项
     *
     * @param array $data 数据，key=>value
     * @return boolean
     */
    public function modifyItems($data){
        $success = true;
        if(!empty($data)){
            foreach($data as $k => $v){
                $_data = array('key'=>$k, 'value'=>$v);
                if($this->add($_data, '', true) === false){
                    $success = false;
                    break;
                }
            }
        }
        $success && $this->reCache();
        return $success;
    }

    /**
     * 直接从数据库获取数据
     *
     * @return array
     */
    public function getOriItems(){
        $data = array();
        $rs = $this->getAll();
        if(!empty($rs)){
            foreach($rs as $v){
                $data[$v->key] = $v->value;
            }
        }
        return $data;
    }
}