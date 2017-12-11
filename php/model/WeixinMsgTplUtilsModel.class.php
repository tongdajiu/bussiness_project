<?php
/**
 * 微信消息模板工具
 */
class WeixinMsgTplFlagMap{
    static public $map = array(
        'first' => array(
            'name' => 'first',
            'fixText' => true,
        ),
        'remark' => array(
            'name' => 'remark',
            'fixText' => true,
        ),
        'orderNo' => array(
            'name' => '订单号',
        ),
        'integral' => array(
            'name' => '兑换积分',
        ),
        'orderMoney' => array(
            'name' => '订单金额',
        ),
        'buyTime' => array(
            'name' => '购买时间',
        ),
        'goodsName' => array(
            'name' => '商品名称',
        ),
        'goods' => array(
            'name' => '商品',
        ),
        'deliveryAddress' => array(
            'name' => '收货地址',
        ),
        'consignee' => array(
            'name' => '收货人',
        ),
        'consigneePhone' => array(
            'name' => '收货人电话',
        ),
    );
}

class WeixinMsgTplUtilsModel extends Model{
    /**
     * 获取本系统标识的对应字典
     *
     * @return array
     */
    public function getMapDict(){
        return WeixinMsgTplFlagMap::$map;
    }

    /**
     * 生成各标识对应的内容
     *
     * @param array $data 本系统标识对应的内容
     * @return array
     */
    public function getMapContent($data, $tplData){
        $tplDataContent = array();
        $map = $this->getMapDict();
        foreach($tplData as $k => $v){
            if(!empty($v['content'])){
                $tplDataContent[$k] = $v['content'];
            }
        }

        if(in_array('integral', array_keys($data)))
        {
			$this->setTable('integral_orders');//表名
            $integral_order = $this->get(array('order_number'=>$data['orderNo']));

            $this->setTable('integral_orders_detail');
            $goods =  $this->get(array('integral_orders_id'=>$integral_order->id));

            $tplDataContent['orderNo'] = $data['orderNo'];
            $tplDataContent['orderMoney'] = $integral_order->all_integral.'积分';
            $tplDataContent['buyTime'] = date('Y-m-d H:i:s', $integral_order->create_time);
            $tplDataContent['deliveryAddress'] = $integral_order->address;
            $tplDataContent['consignee'] = $integral_order->receiver;
            $tplDataContent['consigneePhone'] = $integral_order->phone;
            $tplDataContent['goodsName'] = $goods->product_name;
            $tplDataContent['goods'] = $goods->product_name;
        }
        elseif(in_array('orderNo', array_keys($data)))
        {
            $this->setTable('orders');
            $order = $this->get(array('order_number'=>$data['orderNo']));
            $this->setTable('order_product');
            $goods =  $this->get(array('order_id'=>$order->order_id));
            $tplDataContent['orderNo'] = $data['orderNo'];
            $tplDataContent['orderMoney'] = $order->all_price.'元';
            $tplDataContent['buyTime'] = date('Y-m-d H:i:s', $order->addtime);
            $tplDataContent['deliveryAddress'] = $order->shipping_address_1;
            $tplDataContent['consignee'] = $order->shipping_firstname;
            $tplDataContent['consigneePhone'] = $order->telephone;
            $tplDataContent['goodsName'] = $goods->product_name;
            $tplDataContent['goods'] = $goods->product_name;
        }
        return $tplDataContent;
    }
}