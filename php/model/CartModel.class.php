<?php
/**
 * 购物车
 */
class CartModel extends Model{
    public function __construct($db, $table=''){
        $table = 'cart';
        parent::__construct($db, $table);
    }

    /**
     * 重获取购物车实时信息
     *
     * @param array $data 购物车信息，cart表结构
     * @return array
     */
    public function realtime($arrCartData){
        $Product = D('Product');

        if (  ! is_array($arrCartData) )
        {
            return null;
        }


        foreach( $arrCartData as $arrCart  )
        {
            $data[ $arrCart->product_id ] = $arrCart;

            $arrProduct = $Product->get( array("product_id"=> $arrCart->product_id ) );
            $data[ $arrCart->product_id ]->product_price = $arrProduct->price;
            $data[ $arrCart->product_id ]->product_store = $arrProduct->inventory;
        }

        return $data;
  /*
        //商品实时价格与库存
        $attrIds = array();
        $proIds = array();
        $attrProIndex = array();//有属性的商品
        $comProIndex = array();//没有属性的商品
        $proAttrs = array();//各商品与所属的属性
        foreach($data as $k => $v){
            if($v->attribute_id){//有指定属性
                $attrProIndex[] = $k;
                $attrIds[] = $v->attribute_id;
                $proAttrs[$v->product_id][] = $v->attribute_id;
            }else{
                $comProIndex[] = $k;
                $proIds[] = $v->product_id;
                $proAttrs[$v->product_id] = 0;
            }
        }
        $arrProduct = $Product->get
        foreach (  )
      
        $bPrice = $Product->getValidBargainPrice($proAttrs);
        if(!empty($proIds)){//没有属性的商品
            $products = array();
            $rs = $Product->getAll(array('__IN__'=>array('product_id'=>$proIds)));
            foreach($rs as $v){
                $products[$v->product_id] = $v;
            }
            foreach($comProIndex as $index){
                $curBPrice = $bPrice[$data[$index]->product_id][0];
                !empty($curBPrice) && $data[$index]->bargain = $curBPrice['id'];
                $data[$index]->product_price = isset($curBPrice['price']) ? $curBPrice['price'] : $products[$data[$index]->product_id]->price;
                $data[$index]->product_store = isset($curBPrice['store']) ? $curBPrice['store'] : $products[$data[$index]->product_id]->inventory;
            }
        }

        if(!empty($attrIds)){//对应属性
            $attrs = $Product->getAttrs($attrIds);
            foreach($attrProIndex as $index){
                $curBPrice = $bPrice[$data[$index]->product_id][$data[$index]->attribute_id];
                !empty($curBPrice) && $data[$index]->bargain = $curBPrice['id'];
                $data[$index]->product_price = isset($curBPrice['price']) ? $curBPrice['price'] : $attrs[$data[$index]->attribute_id]['price'];
                $data[$index]->product_store = isset($curBPrice['store']) ? $curBPrice['store'] : $attrs[$data[$index]->attribute_id]['store'];
            }
        }

        return $data;
*/

    }
}