<?php
/**
 * 店铺
 */
class ShopModel extends Model{
    /**
     * 是否销售商品
     *
     * @param integer $uid 用户id
     * @param integer $pid 商品id
     * @return boolean
     */
    public function isSell($uid, $pid){
        $rs = $this->get(array('uid'=>$uid, 'product_id'=>$pid), '*', OBJECT, 'shop_product');
        return empty($rs) ? false : true;
    }

    /**
     * 加入商品
     *
     * @param integer $uid 用户id
     * @param integer $pid 商品id
     * @return integer|boolean
     */
    public function addProduct($uid, $pid){
        $data = array('uid'=>$uid, 'product_id'=>$pid, 'addtime'=>time());
        return $this->add($data, 'shop_product');
    }

    /**
     * 删除加入的商品
     *
     * @param integer $uid 用户id
     * @param integer|array $pid 商品id
     * @return boolean
     */
    public function deleteProduct($uid, $pid){
        !is_array($pid) && $pid = array($pid);
        $cond = array('uid'=>$uid, '__IN__'=>array('product_id'=>$pid));
        return $this->delete($cond, 'shop_product');
    }
}