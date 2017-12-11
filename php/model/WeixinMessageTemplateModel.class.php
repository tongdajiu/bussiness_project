<?php
/**
 * 微信消息模板
 *
 *
 */
define('WX_TPL_CACHE_DIR', DATA_DIR.'/wx/msgtpl');

include_once('WeixinMsgTplUtilsModel.class.php');
class WeixinMessageTemplateModel extends WeixinMsgTplUtilsModel{
    private $cacheDir = WX_TPL_CACHE_DIR;

    public function __construct($db, $table=''){
        $table = 'wx_msg_tpl';
        parent::__construct($db, $table);
        !file_exists($this->cacheDir) && mkdir($this->cacheDir, 0777, true);
    }

    public function getAll($cond=array(), $order=array(), $output = OBJECT){
        $list = parent::getAll($cond, $order, $output);
        foreach($list as $k => $v){
            switch($output){
                case OBJECT:
                    $list[$k]->data = $this->transformData($v->data);
                    break;
                case ARRAY_A:
                    $list[$k]['data'] = $this->transformData($v['data']);
                    break;
                case ARRAY_N:
                    break;
            }
        }
        return $list;
    }

    public function get($cond=array(), $fields='*', $outputType=OBJECT){
        $tpl = parent::get($cond, $fields, $outputType);
        switch($outputType){
            case OBJECT:
                $tpl->data = $this->transformData($tpl->data);
                break;
            case ARRAY_A:
                $tpl['data'] = $this->transformData($tpl['data']);
                break;
            case ARRAY_N:
                break;
        }
        return $tpl;
    }

    /**
     * 转换模板数据格式，array <=> json
     *
     * @param array|string $data 数据
     * @return array|string
     */
    private function transformData($data){
        return is_array($data) ? serialize($data) : unserialize($data);
    }

    /**
     * 保存消息模板信息
     *
     * @param string $flag 模板类型标识
     * @param array $data 相关信息
     *      tplId string 模板ID
     *      data array 模板各项数据对应的信息，array(系统信息标识=>array('key'=>微信信息标识,'color'=>微信信息颜色))
     * @return boolean
     */
    public function save($flag, $data){
        $tplData = array(
            'tpl_id' => $data['tplId'],
            'data' => $this->transformData($data['data']),
        );
        if(parent::modify($tplData, array('flag'=>$flag)) === false){
            return false;
        }else{
            $this->saveCache($flag);
            return true;
        }
    }

    /**
     * 生成发送模板消息所需的数据格式
     *
     * @param string $tplType 模板类型
     * @param string $toopenid 接收者的openid
     * @param string $url 链接地址
     * @param array $dataMap 数据标识与数据的对应关系，array(本系统内容标识=>内容)
     * @param array $dataContent
     * @return array
     */
    public function genTemplateData($tplType, $toopenid, $url, $dataContent){
        $tplInfo = $this->getFromCache($tplType);
        $dataMap = $this->getMapContent($dataContent, $tplInfo['data']);
        $tplData = array();
        foreach($dataMap as $_flag => $_content){
            $tplData[$tplInfo['data'][$_flag]['key']] = array(
                'value' => $_content,
                'color' => $tplInfo['data'][$_flag]['color'],
            );
        }
        $data = array(
            'touser' => $toopenid,
            'template_id' => $tplInfo['tpl_id'],
            'url' => $url,
            'data' => $tplData,
        );
        return $data;
    }

    /**
     * 保存缓存
     *
     * @param string $type 类型
     * @return array
     */
    private function saveCache($type){
        $tpl = $this->get(array('flag'=>$type), '*', ARRAY_A);
        file_put_contents($this->getCacheFile($type), $this->transformData($tpl));
        return $tpl;
    }

    /**
     * 从缓存中获取模板设置信息
     *
     * @param string $type 类型
     * @return array
     */
    private function getFromCache($type){
        $nocache = false;
        $cacheFile = $this->getCacheFile($type);
        if(!file_exists($cacheFile)){
            $nocache = true;
        }else{
            $tpl = file_get_contents($cacheFile);
            if(empty($tpl)){
                $nocache = true;
            }else{
                $tpl = $this->transformData($tpl);
            }
        }
        $nocache && $tpl = $this->saveCache($type);
        return $tpl;
    }

    /**
     * 获取缓存文件路径
     *
     * @param string $type 类型
     * @return string
     */
    private function getCacheFile($type){
        return $this->cacheDir.'/'.$type.'.tpl';
    }
}