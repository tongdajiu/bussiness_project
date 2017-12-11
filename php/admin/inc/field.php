<?php
return array(
	'user'=>array(
		'level'=>'会员级别',
		'sorting'=>'推荐值',
		'name'=>'姓名',
		'sex'=>'性别',
		'birthday'=>'生日',
		'email'=>'邮箱',
		'tel'=>	'电话',
		'phone'=>'手机',
		'invitation_name'=>'邀请人'
	),
	'admin'=>array(
		'name'=>'管理员名称',
		'privileges'=>'权限',
		'status'=>'状态',
		'password' => '密码'
	),
	'user_address'=>array(
		'city'	=>	'城市',
		'area'	=>	'区',
		'address'	=>	'详细地址'
	),
	'user_connection'=>array(
		'userid'=>'当前用户id',
		'fuserid'=>'邀请人id',
		'minfo'=>'邀请M码信息'
	),
	'coupon'=>array(
		'type'=>'类型',
		'exp_value'=>'体验面值',
		'starttime'=>'生效时间',
		'endtime'=>'有效时间'
	),
	'orders'=>array(
		'email'=>'电子邮箱',
		'telephone'=>'联系电话',
		'cellphone'=>'固定电话',
		'shipping_firstname'=>'收货人姓名',
		'shipping_address_1'=>'详细地址',
		'shipping_address_2'=>'备用详细地址',
		'shipping_postcode'=>'邮编',
		'shipping_method'=>'发货方式',
		'remark'=>'备注',
		'order_status_id'=>'订单状态',
		'pay_method'=>'支付方式',
		'express_type'=>'物流类型',
		'express_number'=>'物流编号',
		'status_introduce'=>'是否实体店',
		'date_modified'=>'更新时间'
	),
	'product_type'=>array(
		'classid' => '父类',
		'name'	=>	'类型名称',
		'num'	=>	'商品数',
		'sorting'	=>	'排序'
	),
	'attribute'=>array(
		'attr_name'		=>	'属性名称',
		'attr_value'	=>	'属性值',
		'sorting'		=>	'排序'
	),
	'product_attr'=>array(
		'product_id'	=> '产品id',
		'attr_group'	=> '属性组合',
		'store'	=>	'库存',
		'price'	=>	'价格'
	),
	'product'=>array(
		'name' => '产品名称',
		'title' => '产品简单描述',
		'model' => '货号',
		'image' => '图片',
		'category_id' => '父级类型',
		'category_id2' => '次级类型',
		'price' => '产品价格',
		'price_old' => '产品原价',
		'status' => '审核状态',
		'viewed' => '浏览次数',
		'description' => '详细介绍',
		'sorting' => '排序',
		'hot' => '产品状态类型',
		'inventory' => '库存',
		'unit' => '单位',
		'integral' => '积分',
		'sell_number' => '销售数量'
	),
	'product_phase'=>array(
		'phase_number' 	=> 	'期次编码',
		'total_amount'	=>	'总人数',
		'limit_amount'	=>	'限购人数(0为不限制)',
		'sale_status'	=>	'销售状态',
		'title'			=>	'标题',
		'description'	=>	'描述',
		'sorting'		=>	'排序'
	),
	'ad'=>array(
		'status' 	=> 	'审核',
		'type'		=>	'信息类型',
		'typeclass'	=>	'次级信息类型',
		'title'		=>	'标题',
		'url'		=>	'链接',
		'images'	=>	'图片'
	),
	'agent_application'=>array(
		'name'		=>	'真实姓名',
		'mobile'	=>	'手机号码',
		'id_number'	=>	'身份证号码',
		'email'		=>	'邮箱'
	),
	'agent_info'=>array(
		'name'		=>	'真实姓名',
		'mobile'	=>	'手机号码',
		'id_number'	=>	'身份证号码',
		'email'		=>	'邮箱',
		'pre_money'	=>	'保证金',
		'join_money'=>	'加盟费'
	),
	'store_information'=>array(
		'uid'		=>	'负责人id',
		'name'		=>	'门店名称',
		'mobile'	=>	'联系手机',
		'address'	=>	'详细地址',
		'longitude'	=>	'经度',
		'latitude'	=>	'纬度'
	),
	'integral_product'=>array(
		'name'			=>	'积分商品名称',
		'image'			=>	'商品图片',
		'inventory'		=>	'库存',
		'integral'		=>	'兑换积分',
		'description'	=>	'商品详情',
		'sorting'		=>	'排序'
	),
	'integral_orders'=>array(
		'phone'	=>	'联系电话',
		'receiver'	=>	'收货人',
		'address'	=>	'收货地址',
		'express_type'	=>	'物流类型',
		'express_number'	=>	'物流编号'
	)
)
?>