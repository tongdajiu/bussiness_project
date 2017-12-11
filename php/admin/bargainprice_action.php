<?php
/**
 * 商品特价
 */
!defined('HN1') && exit('Access Denied.');
define('__CUR_MODULE', '?module=bargainprice_action');

$Product = D('Product');

$act = trim($_GET['act']);

switch($act){
    case 'add':
        if(isPost()){
            $data = __getData();
            ($Product->addBargainPrice($data) === false) ? redirect($_SERVER['HTTP_REFERER'], '添加失败') : redirect(__CUR_MODULE.'&id='.$data['product_id'], '添加成功');
        }else{
            $productId = intval($_GET['pid']);
            empty($productId) && redirect($_SERVER['HTTP_REFERER'], '参数错误');
            $product = $Product->getInfo($productId);
            empty($product) && redirect($_SERVER['HTTP_REFERER'], '商品不存在');

            $attrMap = __getAttrs($product);
            include_once('tpl/bargainprice_form.php');
        }
        break;
    case 'edit':
        if(isPost()){
            $id = intval($_POST['id']);
            empty($id) && redirect($_SERVER['HTTP_REFERER'], '参数错误');
            $data = __getData();
            ($Product->modifyBargainPrice($id, $data) === false) ? redirect($_SERVER['HTTP_REFERER'], '修改失败') : redirect(__CUR_MODULE.'&id='.$data['product_id'], '修改成功');
        }else{
            $productId = intval($_GET['pid']);
            empty($productId) && redirect($_SERVER['HTTP_REFERER'], '参数错误');
            $id = intval($_GET['id']);
            empty($id) && redirect($_SERVER['HTTP_REFERER'], '参数错误');

            $product = $Product->getInfo($productId);
            empty($product) && redirect($_SERVER['HTTP_REFERER'], '商品不存在');
            $info = $Product->getBargainPrice($id);
            empty($info) && redirect($_SERVER['HTTP_REFERER'], '特价信息存在');

            $selAttr = array($info['product_attr_id']=>' selected');
            $sTime = empty($info['start_time']) ? '' : date('Y-m-d H:i:s', $info['start_time']);
            $eTime = empty($info['end_time']) ? '' : date('Y-m-d H:i:s', $info['end_time']);
            $attrMap = __getAttrs($product);
            include_once('tpl/bargainprice_form.php');
        }
        break;
    case 'del':
        $ids = $_POST['id'];
        empty($ids) && redirect($_SERVER['HTTP_REFERER'], '请选择要删除的数据');
        ($Product->deleteBargainPrice($ids) === false) ? redirect($_SERVER['HTTP_REFERER'], '删除失败') : redirect($_SERVER['HTTP_REFERER'], '删除成功');
        break;
    default:
        $time = time();
        $id = intval($_GET['id']);
        empty($id) && redirect($_SERVER['HTTP_REFERER'], '参数错误');

        $product = $Product->getInfo($id);
        empty($product) && redirect($_SERVER['HTTP_REFERER'], '商品不存在');

        $list = $Product->getBargainPrices($id);
        foreach($list as $k => $v){
            if(isset($v['attr']['attr']) && !empty($v['attr']['attr'])){
                $tmp = array();
                foreach($v['attr']['attr'] as $_v){
                    $tmp[] = $_v['attr_name'].':'.$_v['attr_value']['value'];
                }
                $list[$k]['attrname'] = implode(',', $tmp);
            }else{
                $list[$k]['attrname'] = '-';
            }
        }
        include_once('tpl/bargainprice_list.php');
        break;
}

function __getAttrs($product){
    global $Product;
    $ProAttrs = $Product->getAttrList($product->product_id);
    if(!empty($ProAttrs)){
        $attrMap = array();
        foreach($ProAttrs as $v){
            $tmp = array();
            foreach($v['attr'] as $_v){
                $tmp[] = $_v['attr_name'].':'.$_v['attr_value']['value'];
            }
            $tmp = array('attr'=>implode(';', $tmp), 'store'=>$v['store'], 'price'=>$v['price']);
            $attrMap[$v['id']] = $tmp;
        }
    }else{
        $attrMap = array(
            0 => array(
                'attr' => '没有属性',
                'store' => $product->inventory,
                'price' => $product->price,
            ),
        );
    }
    return $attrMap;
}

function __getData(){
    global $Product;
    $data = $_POST['data'];
    $data['start_time'] = empty($data['start_time']) ? 0 : strtotime($data['start_time']);
    $data['end_time'] = empty($data['end_time']) ? 0 : strtotime($data['end_time']);
    ($data['start_time'] && $data['end_time'] && ($data['start_time'] > $data['end_time'])) && redirect($_SERVER['HTTP_REFERER'], '结束时间不能早于开始时间');
    !is_numeric($data['price']) && redirect($_SERVER['HTTP_REFERER'], '价格必须为数字');
    if($data['store'] == ''){
        $data['store'] = -1;
    }else{
        $data['store'] = intval($data['store']);
        if($data['product_attr_id']){//商品有属性
            $attr = $Product->getAttr($data['product_attr_id']);
            $validStore = $attr['store'];
        }else{
            $product = $Product->getInfo($data['product_id']);
            $validStore = $product->inventory;
        }
        ($data['store'] > $validStore) && redirect($_SERVER['HTTP_REFERER'], '库存超出');
    }

    return $data;
}