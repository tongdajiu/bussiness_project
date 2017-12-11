<?php
!defined('HN1') && exit('Access Denied.');

include_once DATA_DIR.'/dbConfig.php';

//产地海拔分类，对应altitude
$ProductCategory = array(
	1 => "600-700米",
	2 => "700-800米",
	3 => "800-900米",
	4 => "900-1000米",
	5 => "1000米以上",
);

//审核状态
$AuditState = array(
	0 => '待审核',
	1 => '已审核',
	2 => '审核不通过',
);

//产品大类
$CategoryBig = array(
	0 => '普通',
	1 => '团购',
	2 => '换购',
);

//是否
$YesOrNo = array(
	0 => '否',
	1 => '是',
);

//性别
$Gender = array(
	0 => '男',
	1 => '女',
);

//会员类型
$UserType = array(
	0 => '普通会员',
	1 => '高级会员',
);

//会员级别
$UserLevel = array(
	0 => '普通会员',
);

//付款方式
$PayMethod = array(
	1=> '微信支付',
	//2=> '网银支付',
//	3=> '货到付款',
//	4=> '到店自提',
//	5=> '支付宝转账',
);

//取消状态
$AbolishmentStatus = array(
	0 => '正常',
	1 => '取消',
);

//付款状态
$PayStatus = array(
	0 => '未付款',
	1 => '已付款',
);

//订单状态
$OrderStatus = array(
	0 => '等待付款',
	1 => '等待发货',
	2 => '已发货',
	3 => '已确认',
);


//产品类型（订单）
$ProductType = array(
	0 => '普通商品',
	1 => '会员尊享',
	2 => '抢购商品',
);

//评价
$Score = array(
	1 => '差评',
	2 => '中评',
	3 => '好评',
);

//收藏类型
$FavoritesType	= array(
	0 => '产品收藏',
);
//首页记录类型
$shareTypes	= array(
	1 => '分享',
	2 => '点击分享',
);

//激活状态
$ActivateStatus = array(
	1 => '已激活',
	0 => '未激活',
);

//优惠劵类型
$CouponType = array(
	0 => '电子优惠劵',
	1 => '实物优惠券',
);

//优惠劵面值
$ExpValue = array(
	'5.00' => '5元',
	'10.00' => '10元',
	'15.00' => '15元',
	'20.00' => '20元',
	'25.00' => '25元',
	'30.00' => '30元',
	'50.00' => '50元',
);

//团购状态
$PinType = array(
	-1 => '等待发起人付款',
	0 => '团购结束',
	1 => '团购进行中',
	2 => '团购成功',
);

//团购关闭状态
$PinCloseStatus = array(
	0 => '开启',
	1 => '关闭',
);

//产品上下架类型
$Productstatus = array(
	0 => '下架',
	1 => '上架',
);

//团购参与者类型
$PinDetailState = array(
	0 => '参与者',
	1 => '发起者',
);

//团购信息获取渠道
$pinGetType = array(
	1 => '分享',
	2 => '查看参与页',
	3 => '点击分享',
);

//用户消费类型
$UserPayType = array(
	1 => '购买产品'
);

//物流接口
$LogisticsInterface = array(
	'kuaidi'	=>	'快递'
);

//物流类型
$ExpressType = array(
    'ziqu'=>'自取',
	'shunfeng' => '顺丰快递',
	'shentong' => '申通快递',
	'zhongtong' => '中通快递',
	'yuantong' => '圆通快递',
	'huitong' => '汇通快递',
	'tiantian' => '天天快递',
	'yunda' => '韵达快递',
	'dhl' => 'DHL快递',
	'zhaijisong' => '宅急送',
	'debang' => '德邦物流',
	'ems' => 'EMS国内',
	'eyoubao' => 'E邮宝',
	'guotong' => '国通快递',
	'longbang' => '龙邦速递',
	'lianbang' => '联邦快递',
	'tnt' => 'TNT快递',
	'xinbang' => '新邦物流',
	'zhongtie' => '中铁快运',
	'zhongyou' => '中邮物流',
);

//热门状态
$HotType = array(
	0 => '普通商品',
	1 => '热门商品',
	2 => '团购商品',
	3 => '抢购商品',
);

//积分获取来源
$IntegralType = array(
	1 => '购买产品',
	2 => '账号注册',
	3 => '推荐人积分获取',
	4 => '订单评论',
	5 => '分享',
	6 => '被推荐人(购物)',
);

//积分使用类型
$IntegralPayType = array(
	0 => '兑换优惠券',
	1 => '抵扣货款',
	2 => '兑换商品',
);
//团购口号
$pin_content = array(

    1 => '品质好,价格低,够新鲜,一起团吧',
	2 => '好姐妹抱成一团,把价格杀到底',
	3 => '团购更给力,钱包少鸭梨',
	4 => '你不会眼睁睁看着我一个人在战斗吧',
	5 => '一起团购吧，省下的钱再搓一顿！',

);

$return_money=array(
	0 =>0.1,
    3000 =>0.15,
	5000 =>0.175,

);
$agent_application_status=array(
    0 =>'待认证',
	1 =>'已认证',
	2 =>'认证不通过',
);

//重要参数
$important_var = array(
	'discount' => 1,	//全场折扣
);

$addType = array(
	0 => '商城注册',
//	1 => '二维码扫描',
);

$redbagPrize = array(
	1 => '5元',
	2 => '5元',
	3 => '5元',
	4 => '5元',
	5 => '5元',
	6 => '5元',
	7 => '5元',
	8 => '5元',
	9 => '10元',
	10 => '10元',
	11 => '10元',
	12 => '10元',
	13 => '10元',
	14 => '10元',
	15 => '15元',
	16 => '15元',
	17 => '20元',
	18 => '20元',
	19 => '25元',
	20 => '30元',
);

//展示全部价格的产品
$showPriceProduct = array(34,50,51,53,54);

//不能申请试饮的产品
$CantApplyProduct = array(34,50,51,53,54);

//销售状态
$SaleStatus = array(
	0 => '未开始',
	1 => '进行中',
	2 => '揭晓中',
	3 => '已结束',
);
//发货方式
$ShippingMtthod = array(
	0 => '快递',
	1 => '自取',
);

//活动类型
$ActivityType = array(
	1 => '大转盘',
	2 => '砸金蛋',
	3 => '摇一摇'
);

//奖品类型
$PrizeType = array(
	0 => '不中',
	1 => '优惠券',
	2 => '转发攒运气'
);

//文章类型
$ArticleType = array(
	1 => '帮助中心',
	2 => '分销规则',
	3 => '品牌文化'
);

//公告类型
$AnnouncementType = array(
	1 => '首页',
	2 => '推送',
	3 => '通知',
);

//提现方式
$Transfers = array(
		1 => '支付宝',
		2 => '微信',
);

?>