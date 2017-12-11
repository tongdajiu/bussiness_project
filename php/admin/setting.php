<?php
!defined('HN1') && exit ('Access Denied.');
include_once(MODEL_DIR.'/SettingModel.class.php');
$objSetting = new SettingModel($db);
include_once(LIB_DIR.'/File.class.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = $_POST['data'];
    $success = ($objSetting->modifyItems($data) === false) ? '保存失败' : '保存成功';
	createAdminLog($db,5,"编辑系统设置");
    redirect('?module='.'setting', $success);
    exit();
}else{
    $templates = __getTpl();
    $data = $objSetting->getOriItems();
    $selTpl = array($data['template']=>' selected');
    include "tpl/setting_web.php";
}

/**
 * 获取模板及其皮肤
 *
 * @return array
 */
function __getTpl(){
    $tplDir = ROOT_DIR.'/'.TEMPLATE_DIR_NAME;
    try{
        $dirs = File::scan($tplDir);
    }catch(Exception $e){
        echo $e->getMessage();
        exit();
    }

    $list = array();
    foreach($dirs as $tpl){
        if($tpl['type'] == 'dir'){
            $tmp = array(
                'flag' => $tpl['name'],
                'cfg' => parse_ini_file($tpl['path'].File::$DS.'config_tpl.ini'),
                'skin' => array(),
            );

            //皮肤
            $skinDirs = File::scan($tpl['path'].File::$DS.SKIN_DIR_NAME);
            foreach($skinDirs as $skin){
                if($skin['type'] == 'dir'){
                    $tmp['skin'][$skin['name']] = array(
                        'flag' => $skin['name'],
                        'cfg' => parse_ini_file($skin['path'].File::$DS.'config_skin.ini'),
                    );
                }
            }
            $def = array('default'=>$tmp['skin']['default']);
            unset($tmp['skin']['default']);
            $tmp['skin'] = array_merge_recursive($def, $tmp['skin']);
            $list[$tpl['name']] = $tmp;
        }
    }
    $def = array('default'=>$list['default']);
    unset($list['default']);
    $list = array_merge_recursive($def, $list);
    return $list;
}
?>