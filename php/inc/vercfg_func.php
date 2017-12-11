<?php
/**
 * 权限列表
 *
 * title 标题
 * name  对应值
 * versions 允许使用的版本
 */
return array(
    1 => array(
        'title' => '用户管理',
        'name'  => 'user',
        'menu' => array(
            array(
                'title'     => '用户信息',
                'name'      => 'user_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                	array( 'title' => '信息导出', 'name' => 'excel_out' ),
                )
            ),
            array(
                'title'     => '用户收藏管理',
                'name'      => 'favorites_action',
                'versions'  => array(1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                )
            ),
            array(
                'title'     => '用户地址管理',
                'name'      => 'user_address_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title'     => '用户推荐关系信息',
                'name'      => 'user_connection_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                    array( 'title' => '上下线会员', 'name' => 'chain' ),
                )
            ),
            array(
                'title' => '消费记录管理',
                'name'  => 'pay_records_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                )
            ),
            array(
                'title'     => '优惠劵管理',
                'name'      => 'coupon_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                	array( 'title' => '使用记录', 'name' => 'use' ),
                )
            ),
            array(
                'title' => '积分消费记录',
                'name'  => 'integral_pay_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                )
            ),
            array(
                'title' => '积分获取记录',
                'name'  => 'integral_record_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                )
            ),
 /*
        		array(
                'title'     => '用户产品浏览记录',
                'name'      => 'visit_records_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
*/       
        ),

    ),
    2 => array(
        'title' => '订单管理',
        'name'  => 'order',
        'menu' => array(
            array(
                'title'     => '订单列表',
                'name'      => 'orders_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                	array( 'title' => '单据打印', 'name' => 'order_print' ),
                	array( 'title' => '订单导出', 'name' => 'excel_out' ),
                )
            ),
            array(
                'title'     => '订单评价管理',
                'name'      => 'comment_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title'     => '物流查看',
                'name'      => 'check_express_action',
                'versions'  => array(1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                )
            ),
        ),
    ),
    3 => array(
        'title' => '产品管理',
        'name'  => 'goods',
        'menu' => array(
            array(
                'title' => '产品类型信息',
                'name'  => 'product_type_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '产品属性列表',
                'name'  => 'attribute_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '产品列表',
                'name'  => 'product_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '产品单位信息',
                'name'  => 'unit_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '产品标签图',
                'name'  => 'goods_tag_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
        ),
    ),
    6 => array(
        'title' => '微信公众平台设置',
        'name'  => 'weixin',
        'menu' => array(
            array(
                'title' => '自定义菜单',
                'name'  => 'tp_diymen_class',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '自定义关注回复',
                'name'  => 'tp_subscribe',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '自定义图文回复管理',
                'name'  => 'tp_img',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '自定义文本回复管理',
                'name'  => 'tp_text',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '微信卡券管理',
                'name'  => 'wx_coupon',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )

            ),
            array(
                'title' => '卡券兑换记录',
                'name'  => 'wx_card_exchange_record_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )

            ),
            array(
                'title' => '消息模板',
                'name'  => 'wx_msg_tpl',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '红包管理',
                'name'  => 'redpack',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
        ),
    ),
    7 => array(
        'title' => '设置管理',
        'name'  => 'system',
        'menu' => array(
            array(
                'title' => '系统设置',
                'name'  => 'setting',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '首页图片管理',
                'name'  => 'ad_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '管理员列表',
                'name'  => 'admin_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '管理员组列表',
                'name'  => 'admin_group_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '管理员操作日志',
                'name'  => 'admin_log_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                )
            ),
        ),
    ),
    8 => array(
        'title' => '文章管理',
        'name'  => 'article',
        'menu' => array(
            array(
                'title' => '文章信息列表',
                'name'  => 'article_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
	        array(
	                'title' => '公告信息列表',
                    'name'  => 'announcement_action',
	                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
	       ),
	        array(
	                'title' => '文章分类列表',
                    'name'  => 'article_type_action',
	                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
	       ),
        	
        	
        ),
    ),
    9 => array(
        'title' => '分销商管理',
        'name'  => 'distribution',
        'menu' => array(
            array(
                'title' => '分销商申请信息',
                'name'  => 'agent_application_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                	array( 'title' => '审核', 'name' => 'ustatus' ),
                )
            ),
            array(
                'title' => '加盟分销商信息',
                'name'  => 'agent_info_action',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                    array( 'title' => '下线消费', 'name' => 'view' ),
                    array( 'title' => '佣金记录', 'name' => 'commission' ),
                )
            ),
            array(
                'title' => '分销商提现信息',
                'name'  => 'distributor_money_action',
                'versions' => array(1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '打款操作', 'name' => 'update_play' ),
                )
            ),
            array(
                'title' => '二维码权限申请信息',
                'name'  => 'distributor_application_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '代销规则',
                'name'  => 'article_action',
                'versions' => array(1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
        ),
    ),
    10 => array(
        'title' => '活动促销',
        'name'  => 'activity',
        'menu' => array(
            array(
                'title' => '活动设置',
                'name'  => 'lottery_action',
                'versions' => array(1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '积分兑换商品信息',
                'name'  => 'integral_product_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
            array(
                'title' => '积分兑换管理',
                'name'  => 'integral_orders_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                	array( 'title' => '订单详情', 'name' => 'detail' ),
                	array( 'title' => '发货操作', 'name' => 'deliver' ),
                	array( 'title' => '确认订单', 'name' => 'confirm' ),
                	array( 'title' => '单据打印', 'name' => 'print' ),
                	array( 'title' => '导出excel', 'name' => 'excel_out' ),
                )
            ),
        ),
    ),
    11 => array(
        'title' => '门店资料管理',
        'name'  => 'store',
        'menu' => array(
            array(
                'title' => '门店资料',
                'name'  => 'store_information_action',
                'versions' => array(2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'list' ),
                    array( 'title' => '添加', 'name' => 'add' ),
                    array( 'title' => '修改', 'name' => 'edit' ),
                    array( 'title' => '删除', 'name' => 'del' ),
                )
            ),
        ),
    ),
    12 => array(
        'title' => '统计汇总',
        'name'  => 'statistics',
        'menu' => array(
            array(
                'title' => '新注册会员统计',
                'name'  => 'count_action&act=user_count',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'user_count' ),
                )
            ),
            array(
                'title' => '订单数统计',
                'name'  => 'count_action&act=order_count',
                'versions'  => array(0,1,2),
                'menu'      => array(
                    array( 'title' => '列表', 'name' => 'order_count' ),
                )
            ),
        ),
    ),
);

?>