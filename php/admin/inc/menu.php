<?php
/**
 * 左侧菜单
 *
 * title 标题
 * versionFlag 判断各版本所拥有的权限
 * hide 不显示
 */
return array(
    1 => array(
        'title' => '用户管理',
        'menu' => array(
            array(
                'title' => '用户信息',
                'url' => 'index.php?module=user_action',
            ),
            array(
                'title' => '用户收藏管理',
                'url' => 'index.php?module=favorites_action',
                'versionFlag' => 'goodsCollect',
            ),
            array(
                'title' => '用户地址管理',
                'url' => 'index.php?module=user_address_action',
            ),
            array(
                'title' => '用户推荐关系信息',
                'url' => 'index.php?module=user_connection_action',
                'versionFlag' => 'distributorSubordinateInfo',
            ),
            array(
                'title' => '消费记录管理',
                'url' => 'index.php?module=pay_records_action',
                'hide' => true,
            ),
            array(
                'title' => '优惠劵管理',
                'url' => 'index.php?module=coupon_action',
            ),
            array(
                'title' => '积分消费记录',
                'url' => 'index.php?module=integral_pay_action',
                'versionFlag' => 'integralUseRecord',
            ),
            array(
                'title' => '积分获取记录',
                'url' => 'index.php?module=integral_record_action',
                'versionFlag' => 'integralGetRecord',
            ),
            array(
                'title' => '用户产品浏览记录',
                'url' => 'index.php?module=visit_records_action',
            ),
        ),
    ),
    2 => array(
        'title' => '订单管理',
        'menu' => array(
            array(
                'title' => '全部订单列表',
                'url' => 'index.php?module=orders_action',
            ),
            array(
                'title' => '待付款订单列表',
                'url' => 'index.php?module=orders_action&order_status_id=0',
            ),
            array(
                'title' => '待发货订单列表',
                'url' => 'index.php?module=orders_action&order_status_id=1',
            ),
            array(
                'title' => '已发货订单列表',
                'url' => 'index.php?module=orders_action&order_status_id=2',
            ),
            array(
                'title' => '已确认订单列表',
                'url' => 'index.php?module=orders_action&order_status_id=3',
            ),
            array(
                'title' => '已评论订单列表',
                'url' => 'index.php?module=orders_action&comment=1',
            ),
            array(
                'title' => '订单评价管理',
                'url' => 'index.php?module=comment_action',
            ),
            array(
                'title' => '物流查看',
                'url' => 'index.php?module=check_express_action',
                'versionFlag' => 'setWaybill',
            ),
        ),
    ),
    3 => array(
        'title' => '产品管理',
        'menu' => array(
            array(
                'title' => '产品类型信息',
                'url' => 'index.php?module=product_type_action',
            ),
            array(
                'title' => '产品属性列表',
                'url' => 'index.php?module=attribute_action',
            ),
            array(
                'title' => '产品列表',
                'url' => 'index.php?module=product_action',
            ),
            array(
                'title' => '产品单位信息',
                'url' => 'index.php?module=unit_action',
            ),
            array(
                'title' => '产品标签',
                'url' => 'index.php?module=goods_tag_action',
                'versionFlag' => 'goodsTag',
            ),
        ),
    ),
    6 => array(
        'title' => '微信公众平台设置',
        'menu' => array(
            array(
                'title' => '自定义菜单',
                'url' => 'index.php?module=tp_diymen_class',
            ),
            array(
                'title' => '自定义关注回复',
                'url' => 'index.php?module=tp_subscribe',
            ),
            array(
                'title' => '自定义图文回复管理',
                'url' => 'index.php?module=tp_img',
            ),
            array(
                'title' => '自定义文本回复管理',
                'url' => 'index.php?module=tp_text',
            ),
            array(
                'title' => '微信卡券管理',
                'url' => 'index.php?module=wx_coupon',
                'versionFlag' => 'wxCardManagement',
//                'hide' => true,
            ),
            array(
                'title' => '卡券兑换记录',
                'url' => 'index.php?module=wx_card_exchange_record_action',
                'versionFlag' => 'wxCardManagement',
//                'hide' => true,
            ),
            array(
                'title' => '消息模板',
                'url' => 'index.php?module=wx_msg_tpl',
            ),
            array(
                'title' => '红包管理',
                'url' => 'index.php?module=redpack',
            ),
        ),
    ),
    7 => array(
        'title' => '设置管理',
        'menu' => array(
            array(
                'title' => '系统设置',
                'url' => 'index.php?module=setting',
            ),
            array(
                'title' => '首页图片管理',
                'url' => 'index.php?module=ad_action',
            ),
            array(
                'title' => '管理员列表',
                'url' => 'index.php?module=admin_action',
            ),
            array(
                'title' => '管理员组列表',
                'url' => 'index.php?module=admin_group_action',
            ),
            array(
                'title' => '管理员操作日志',
                'url' => 'index.php?module=admin_log_action',
            ),
        ),
    ),
    8 => array(
        'title' => '文章管理',
        'menu' => array(
            array(
                'title' => '文章信息列表',
                'url' => 'index.php?module=article_action',

            ),
	        array(
	                'title' => '公告信息列表',
	                'url' => 'index.php?module=announcement_action',

	            ),
        ),
    ),
    9 => array(
        'title' => '分销商管理',
        'menu' => array(
            array(
                'title' => '分销商申请信息',
                'url' => 'index.php?module=agent_application_action',
            ),
            array(
                'title' => '加盟分销商信息',
                'url' => 'index.php?module=agent_info_action',
            ),
            array(
                'title' => '分销商提现信息',
                'url' => 'index.php?module=distributor_money_action',
                'versionFlag' => 'distributorWithdrawDeposit',
            ),
            array(
                'title' => '二维码权限申请信息',
                'url' => 'index.php?module=distributor_application_action',
                'versionFlag' => 'distributorQRCodeApply',
            ),
            array(
                'title' => '代销规则',
                'url' => 'index.php?module=article_action&type=7',
                'hide' => true,
            ),
        ),
    ),
    10 => array(
        'title' => '活动促销',
        'menu' => array(
//             array(
//                 'title' => '转盘设置',
//                 'url' => 'index.php?module=lottery_action',
//                 'versionFlag' => 'turntableLottery',
//                 'hide' => true,
//             ),
//             array(
//                 'title' => '砸金蛋设置',
//                 'url' => 'index.php?module=egg_action',
//                 'versionFlag' => 'eggGame',
//   //              'hide' => true,
//             ),
            array(
                'title' => '活动设置',
                'url' => 'index.php?module=lottery_action',
                'versionFlag' => 'turntableLottery',
            ),
            array(
                'title' => '积分兑换商品信息',
                'url' => 'index.php?module=integral_product_action',
                'versionFlag' => 'integralExchange',
            ),
            array(
                'title' => '积分兑换管理',
                'url' => 'index.php?module=integral_orders_action',
                'versionFlag' => 'integralExchangeManagement',
            ),
        ),
    ),
    11 => array(
        'title' => '门店资料管理',
        'menu' => array(
            array(
                'title' => '门店资料',
                'url' => 'index.php?module=store_information_action',
                'versionFlag' => 'storeInfoManagement',
            ),
        ),
    ),
    12 => array(
        'title' => '统计汇总',
        'menu' => array(
            array(
                'title' => '新注册会员统计',
                'url' => 'index.php?module=count_action&act=user_count',
            ),
            array(
                'title' => '订单数统计',
                'url' => 'index.php?module=count_action&act=order_count',
            ),
        ),
    ),
);