-- ----------------------------
-- Table structure for ad
-- ----------------------------
DROP TABLE IF EXISTS `ad`;
CREATE TABLE `ad` (
  `id` bigint(20) NOT NULL auto_increment COMMENT '焦点图编号id',
  `status` int(1) default '0' COMMENT '状态(取业务字典：0未审核1已审核)',
  `type` int(1) default '0' COMMENT '类型(取业务字典：1.首页主推图2.首页滚动图 3.分类)',
  `typeclass` int(1) default '0' COMMENT '获取produc_type表的分类id',
  `location` int(11) default NULL COMMENT '位置值',
  `title` varchar(255) default NULL COMMENT '标题',
  `url` varchar(255) default NULL COMMENT '链接地址',
  `images` varchar(255) default NULL COMMENT '图片地址',
  `size_tips` varchar(50) default NULL COMMENT '图片尺寸提示',
  `background_color` varchar(25) default NULL COMMENT '广告图背景颜色值',
  `create_by` bigint(20) default '0' COMMENT '创建者',
  `create_date` datetime default NULL COMMENT '创建时间',
  `update_by` bigint(20) default '0' COMMENT '更新者',
  `update_date` datetime default NULL COMMENT '更新时间',
  `remarks` varchar(255) default NULL COMMENT '备注信息',
  `sorting` int(10) default '0' COMMENT '排序',
  `class_image` varchar(255) default NULL COMMENT '分类标题图片',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告管理(首页焦点图)';

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` bigint(11) NOT NULL auto_increment COMMENT '编号',
  `username` varchar(255) NOT NULL default '' COMMENT '账号',
  `name` varchar(50) NOT NULL default '' COMMENT '管理员名称',
  `password` varchar(100) NOT NULL default '' COMMENT '管理员密码',
  `add_time` int(11) NOT NULL default '0' COMMENT '添加时间',
  `last_login_time` int(11) NOT NULL default '0' COMMENT '最后登陆时间',
  `privileges` varchar(50) default '' COMMENT '管理员权限',
  `last_ip` varchar(30) NOT NULL default '' COMMENT '最后登陆IP',
  `is_del` tinyint(1) NOT NULL default '1' COMMENT '是否允许删除 1是 0否',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态：0有效，1无效',
  `admin_type` tinyint(1) NOT NULL default '0' COMMENT '1为最高管理员，0为普通管理员',
  PRIMARY KEY  (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Table structure for admin_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
  `id` bigint(20) unsigned NOT NULL auto_increment COMMENT '编号id',
  `aid` int(11) unsigned NOT NULL COMMENT '管理员id',
  `uname` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '管理员账号',
  `name` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '管理员名称',
  `type` tinyint(2) unsigned NOT NULL COMMENT '操作类型:1用户管理；2订单管理；3产品管理；4设置管理；5文章管理；6分销商管理',
  `optitle` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '操作标题',
  `opcontent` text collate utf8_unicode_ci COMMENT '操作内容',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY  (`id`),
  KEY `admin` (`aid`,`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员操作日志表';

-- ----------------------------
-- Table structure for ad_index
-- ----------------------------
DROP TABLE IF EXISTS `ad_index`;
CREATE TABLE `ad_index` (
  `id` int(11) NOT NULL auto_increment,
  `sorting` int(11) default '0' COMMENT '排序',
  `group_id` int(11) default '0' COMMENT '分类',
  `title` varchar(255) default '' COMMENT '标题',
  `image` varchar(255) default '' COMMENT '图片',
  `url` varchar(255) default '' COMMENT '图片链接',
  `addtime` int(11) default '0' COMMENT '添加时间',
  `size_tips` varchar(255) default '' COMMENT '图片尺寸提示',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='首页广告图片';

-- ----------------------------
-- Table structure for agent_application
-- ----------------------------
DROP TABLE IF EXISTS `agent_application`;
CREATE TABLE `agent_application` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户ID',
  `name` varchar(255) default '' COMMENT '真实姓名',
  `mobile` varchar(255) default '' COMMENT '手机号码',
  `id_number` varchar(255) default '' COMMENT '身份证号码',
  `email` varchar(255) default '' COMMENT '邮箱',
  `author_status` int(1) default '0' COMMENT '认证状态（0 待验证 1 验证通过 2 验证未通过）',
  `addTime` int(11) default '0' COMMENT '申请时间',
  `remark` text COMMENT '备注',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销申请表';

-- ----------------------------
-- Table structure for agent_change_record
-- ----------------------------
DROP TABLE IF EXISTS `agent_change_record`;
CREATE TABLE `agent_change_record` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(1) default '1' COMMENT '来源',
  `userid` int(11) default '0' COMMENT '用户ID',
  `status` int(11) default '0' COMMENT '状态',
  `money` decimal(10,2) default NULL,
  `addtime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销兑换金额记录';

-- ----------------------------
-- Table structure for agent_info
-- ----------------------------
DROP TABLE IF EXISTS `agent_info`;
CREATE TABLE `agent_info` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户ID',
  `type` int(11) default '0' COMMENT '类型（1 普通分销商 2 高级分销商）',
  `name` varchar(255) default '' COMMENT '真实姓名',
  `mobile` varchar(255) default '' COMMENT '手机号码',
  `email` varchar(255) default '' COMMENT '邮箱',
  `id_number` varchar(255) default '' COMMENT '身份证号码',
  `pre_money` decimal(10,2) default NULL,
  `join_money` decimal(10,2) default NULL,
  `city` varchar(255) default '' COMMENT '代理城市',
  `join_time` int(11) default '0' COMMENT '加盟时间',
  `status` int(1) default '0' COMMENT '分销状态（0 暂停合作 1 正常 ）',
  `addTime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销信息表';

-- ----------------------------
-- Table structure for agent_total
-- ----------------------------
DROP TABLE IF EXISTS `agent_total`;
CREATE TABLE `agent_total` (
  `id` int(11) NOT NULL auto_increment,
  `agent_userid` int(11) default '0' COMMENT '分销商用户ID',
  `year` varchar(4) default '0' COMMENT '年份',
  `month` varchar(2) default '0' COMMENT '月份',
  `total_price` double(10,2) default '0.00' COMMENT '销售总额',
  `level` varchar(255) default '' COMMENT '换算级别',
  `back_integral` int(11) default '0' COMMENT '返还积分',
  `status` int(1) default '0' COMMENT '结算状态（0 未结算 1 已结算）',
  `summary_time` int(11) default '0' COMMENT '结算时间',
  `addTime` int(11) default '0' COMMENT '汇总时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销销售汇总表';

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `status` int(11) default '0' COMMENT '状态',
  `sorting` int(11) default '0' COMMENT '排序',
  `type` int(11) default '0' COMMENT '类型',
  `title` varchar(255) default '' COMMENT '标题',
  `content` text COMMENT '内容',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='介绍类信息表';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '1', '0', '1', '关于我们', '', '0');
INSERT INTO `article` VALUES ('2', '1', '0', '2', '联系我们', '', '0');
INSERT INTO `article` VALUES ('3', '1', '0', '3', '会员尊享', '', '0');
INSERT INTO `article` VALUES ('4', '1', '0', '4', '单位信息', '', '0');
INSERT INTO `article` VALUES ('5', '1', '0', '5', '品牌故事', '', '0');
INSERT INTO `article` VALUES ('6', '1', '0', '6', '首页广告管理', '', '0');
INSERT INTO `article` VALUES ('7', '1', '0', '7', '分销规则', '', '0');
INSERT INTO `article` VALUES ('8', '1', '0', '8', '如何购买', '', '0');
INSERT INTO `article` VALUES ('9', '1', '0', '9', '配送服务', '', '0');
INSERT INTO `article` VALUES ('10', '1', '0', '10', '如何申请', '', '0');
INSERT INTO `article` VALUES ('11', '1', '0', '11', '积分玩不停', '', '0');

-- ----------------------------
-- Table structure for attribute
-- ----------------------------
DROP TABLE IF EXISTS `attribute`;
CREATE TABLE `attribute` (
  `attr_id` int(10) unsigned NOT NULL auto_increment COMMENT '属性id',
  `attr_name` varchar(100) NOT NULL default '' COMMENT '属性名称',
  `attr_value` text NOT NULL COMMENT '属性值',
  `sorting` mediumint(8) unsigned NOT NULL default '0' COMMENT '排序，数字越大越靠前',
  PRIMARY KEY  (`attr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品属性表';

-- ----------------------------
-- Table structure for blessing
-- ----------------------------
DROP TABLE IF EXISTS `blessing`;
CREATE TABLE `blessing` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(3) default '0' COMMENT '类型',
  `name` varchar(255) default '' COMMENT '姓名',
  `toname` varchar(255) default '' COMMENT '对方姓名',
  `click` int(11) default '0' COMMENT '查看次数',
  `content` text COMMENT '祝福内容',
  `mid` varchar(50) default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `userid` int(11) default '0' COMMENT '所属用户',
  `product_id` int(11) default '0' COMMENT '产品编号',
  `product_name` varchar(110) default NULL COMMENT '产品名称',
  `product_model` varchar(110) default NULL COMMENT '产品规格',
  `product_price` decimal(10,2) default NULL,
  `product_price_old` decimal(10,2) default NULL,
  `product_image` varchar(80) default '' COMMENT '产品图片',
  `order_id` varchar(110) default NULL COMMENT '订单编号',
  `shopping_number` int(11) default '0',
  `shopping_size` varchar(255) default '',
  `shopping_colorid` int(11) default '0',
  `integral` int(5) default '0' COMMENT '积分数',
  `paying_status` int(5) default '0' COMMENT '支付状态',
  `product_type` int(11) default '0' COMMENT '商品类型：3为团购商品,4->抢购商品，5->满M元送N元,6->第二件半价,7->买一送一,8->特惠专享',
  `type` int(11) default '0' COMMENT '家庭套餐类型：11->素食，12->水果，178->水产,13->荤食,1->汤料',
  `promotions_content` varchar(255) default '' COMMENT '促销备注',
  `addTime` varchar(50) default NULL COMMENT '记录产生时间',
  `attribute_id` int(11) default NULL COMMENT '属性id',
  `attribute` varchar(110) default NULL COMMENT '属性',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='当端购物车';

-- ----------------------------
-- Table structure for cart2
-- ----------------------------
DROP TABLE IF EXISTS `cart2`;
CREATE TABLE `cart2` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `userid` int(11) default '0' COMMENT '所属用户',
  `product_id` int(11) default '0' COMMENT '产品编号',
  `product_name` varchar(110) default NULL COMMENT '产品名称',
  `product_model` varchar(110) default NULL COMMENT '产品规格',
  `product_price` decimal(10,2) default NULL,
  `product_price_old` decimal(10,2) default NULL,
  `product_image` varchar(80) default '' COMMENT '产品图片',
  `order_id` varchar(110) default NULL COMMENT '订单编号',
  `shopping_number` int(11) default '0',
  `shopping_size` varchar(255) default '',
  `shopping_colorid` int(11) default '0',
  `integral` int(5) default '0' COMMENT '积分数',
  `paying_status` int(5) default '0' COMMENT '支付状态',
  `product_type` int(11) default '0' COMMENT '商品类型：3为团购商品,4->抢购商品，5->满M元送N元,6->第二件半价,7->买一送一,8->特惠专享',
  `type` int(11) default '0' COMMENT '家庭套餐类型：11->素食，12->水果，178->水产,13->荤食,1->汤料',
  `promotions_content` varchar(255) default '' COMMENT '促销备注',
  `addTime` varchar(50) default NULL COMMENT '记录产生时间',
  `attribute_id` int(11) default NULL COMMENT '属性id',
  `attribute` varchar(110) default NULL COMMENT '属性',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='当端购物车';

-- ----------------------------
-- Table structure for cart2_oneyuan
-- ----------------------------
DROP TABLE IF EXISTS `cart2_oneyuan`;
CREATE TABLE `cart2_oneyuan` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `product_id` int(11) default '0' COMMENT '产品id',
  `phase_id` int(11) default '0' COMMENT '期次id',
  `product_name` varchar(255) default '' COMMENT '产品名称',
  `product_model` varchar(255) default '' COMMENT '产品规格',
  `product_price` decimal(10,2) default NULL,
  `product_price_old` decimal(10,2) default NULL,
  `product_image` varchar(255) default '' COMMENT '产品图片',
  `order_id` int(11) default '0' COMMENT '订单id',
  `lucky_number` varchar(255) default '' COMMENT '幸运号码',
  `shopping_number` int(11) default '0' COMMENT '购买数量',
  `product_type` int(11) default '0' COMMENT '产品类型：0商城产品',
  `type` int(11) default '0' COMMENT '类型：0普通购买 1分享',
  `addtime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='一元购订单详情';

-- ----------------------------
-- Table structure for cart_oneyuan
-- ----------------------------
DROP TABLE IF EXISTS `cart_oneyuan`;
CREATE TABLE `cart_oneyuan` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `product_id` int(11) default '0' COMMENT '产品id',
  `phase_id` int(11) default '0' COMMENT '期次id',
  `product_name` varchar(255) default '' COMMENT '产品名称',
  `product_model` varchar(255) default '' COMMENT '产品规格',
  `product_price` decimal(10,2) default NULL,
  `product_price_old` decimal(10,2) default NULL,
  `product_image` varchar(255) default '' COMMENT '产品图片',
  `order_id` int(11) default '0' COMMENT '订单id',
  `shopping_number` int(11) default '0' COMMENT '购买数量',
  `product_type` int(11) default '0' COMMENT '产品类型：0商城产品',
  `type` int(11) default '0' COMMENT '类型：0普通购买',
  `addtime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='一元购购物车';

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `order_id` int(11) default '0' COMMENT '订单id',
  `order_number` int(11) default '0' COMMENT '订单号',
  `product_id` int(11) default '0' COMMENT '产品ID',
  `score` int(1) default '0' COMMENT '1=>差评;2=>中评;3=>好评',
  `customer_id` int(11) default '0' COMMENT '客户id',
  `shipping_firstname` varchar(255) default NULL COMMENT '收货人(客户)',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  `comment` text COMMENT '评价内容',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='评价';

-- ----------------------------
-- Table structure for commission_log
-- ----------------------------
DROP TABLE IF EXISTS `commission_log`;
CREATE TABLE `commission_log` (
  `id` bigint(20) unsigned NOT NULL auto_increment COMMENT '自增id',
  `user_id` bigint(20) unsigned NOT NULL default '0' COMMENT '用户id',
  `time` int(10) unsigned NOT NULL default '0' COMMENT '时间',
  `money` decimal(14,6) unsigned NOT NULL default '0.000000' COMMENT '金额',
  `remark` text NOT NULL COMMENT '备注',
  `order_no` varchar(20) NOT NULL default '' COMMENT '返利的订单号',
  PRIMARY KEY  (`id`),
  KEY `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金记录表';

-- ----------------------------
-- Table structure for coupon
-- ----------------------------
DROP TABLE IF EXISTS `coupon`;
CREATE TABLE `coupon` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT '优惠券编号',
  `name` varchar(200) NOT NULL default '' COMMENT '优惠券名',
  `type` smallint(1) unsigned NOT NULL default '0' COMMENT '类型，0:满减(例：满100减20)，1：直接减（立剪5元）',
  `start_time` int(10) unsigned NOT NULL default '0' COMMENT '有效期开始时间',
  `end_time` int(10) unsigned NOT NULL default '0' COMMENT '有效期结束时间',
  `create_time` int(10) unsigned NOT NULL default '0' COMMENT '创建时间',
  `vaild_type` tinyint(1) NOT NULL default '0' COMMENT '0: 按优惠券生效的时间 1:按用户得到优惠券的时间',
  `vaild_date` int(5) NOT NULL default '0' COMMENT '有效天数（用于针对用户得到优惠券的时间开始算有效期） 如果按生效时间则该字段为空',
  `status` smallint(1) unsigned NOT NULL default '1' COMMENT '状态  0：失效  1：有效',
  `max_use` int(5) unsigned NOT NULL default '0' COMMENT '允许使用的最抵金额  0为无限制。例如：满100减20则此处为 100',
  `discount` int(5) unsigned NOT NULL default '0' COMMENT '可抵金额',
  PRIMARY KEY  (`id`),
  KEY `valid_time` (`start_time`,`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='优惠券表';

-- ----------------------------
-- Table structure for distributor_application
-- ----------------------------
DROP TABLE IF EXISTS `distributor_application`;
CREATE TABLE `distributor_application` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0' COMMENT '用户id',
  `name` varchar(255) default NULL COMMENT '姓名',
  `add_time` int(11) NOT NULL default '0' COMMENT '申请时间',
  `update_time` int(11) NOT NULL default '0' COMMENT '审核时间',
  `status` tinyint(1) default '0' COMMENT '状态：0未审核，1审核通过',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='申请信息';

-- ----------------------------
-- Table structure for distributor_money
-- ----------------------------
DROP TABLE IF EXISTS `distributor_money`;
CREATE TABLE `distributor_money` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0' COMMENT '用户id',
  `name` varchar(255) character set utf8 NOT NULL default '' COMMENT '姓名',
  `mobile` varchar(255) NOT NULL default '0' COMMENT '手机号',
  `id_number` varchar(255) NOT NULL default '0' COMMENT '身份证号码',
  `d_money` decimal(14,2) unsigned default '0.00' COMMENT '申请金额',
  `add_time` int(11) NOT NULL default '0' COMMENT '申请时间',
  `status` tinyint(1) default '0' COMMENT '状态：0未审核，1审核通过 , 2审核失败',
  `through_time` int(11) default '0' COMMENT '审核通过时间',
  `username` varchar(255) NOT NULL default '' COMMENT '审核人账号',
  `play_type` tinyint(1) default '0' COMMENT '状态：0未打款，1已打款',
  `play_time` int(11) NOT NULL default '0' COMMENT '打款时间',
  `pay_method` tinyint(1) default '0' COMMENT '提现方式：1-支付宝，2-微信支付',
  `account_number` varchar(255) NOT NULL default '' COMMENT '账号',
  `remark` text character set utf8 COMMENT '备注',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='分销商提现申请记录表';

-- ----------------------------
-- Table structure for draw_activity
-- ----------------------------
DROP TABLE IF EXISTS `draw_activity`;
CREATE TABLE `draw_activity` (
  `id` int(11) NOT NULL auto_increment,
  `sorting` int(11) default '0' COMMENT '排序',
  `title` varchar(255) default '' COMMENT '标题',
  `content` text COMMENT '内容',
  `background_image` varchar(255) default '' COMMENT '背景图片',
  `start_date` int(11) default '0' COMMENT '开始日期',
  `end_date` int(11) default '0' COMMENT '结束日期',
  `number` varchar(10) default '' COMMENT '中奖号码',
  `add_time` int(11) default '0' COMMENT '添加时间',
  `state` int(1) default '0' COMMENT '活动状态：0 正在进行 1活动结束',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for draw_number
-- ----------------------------
DROP TABLE IF EXISTS `draw_number`;
CREATE TABLE `draw_number` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `openid` varchar(50) default '' COMMENT '公众号id',
  `name` varchar(255) default '' COMMENT '微信名称',
  `activity_id` int(11) default '0' COMMENT '抽奖活动id',
  `number` varchar(255) default '' COMMENT '抽奖号',
  `addTime` int(11) default '0' COMMENT '添加时间',
  `suserid` int(11) default '0' COMMENT '来源用户id',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户抽奖号';

-- ----------------------------
-- Table structure for egg_address
-- ----------------------------
DROP TABLE IF EXISTS `egg_address`;
CREATE TABLE `egg_address` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `userid` int(11) default '0' COMMENT '所属用户',
  `status` int(2) default '0' COMMENT '状态',
  `chick` int(4) default '0' COMMENT '使用次数',
  `city` varchar(20) default '' COMMENT '城市',
  `area` varchar(20) default NULL COMMENT '区',
  `address` text COMMENT '详细地址',
  `shipping_firstname` varchar(255) default '' COMMENT '收货人',
  `telephone` varchar(255) default '' COMMENT '电话号码',
  `remark` varchar(255) default NULL COMMENT '备注',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='砸蛋抽奖地址记录';

-- ----------------------------
-- Table structure for egg_game
-- ----------------------------
DROP TABLE IF EXISTS `egg_game`;
CREATE TABLE `egg_game` (
  `id` int(11) NOT NULL auto_increment,
  `money` decimal(10,2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砸蛋游戏控制';

-- ----------------------------
-- Table structure for egg_number
-- ----------------------------
DROP TABLE IF EXISTS `egg_number`;
CREATE TABLE `egg_number` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `openid` varchar(50) default '' COMMENT '邀请人的openid',
  `name` varchar(255) default '' COMMENT '微信名称',
  `number` varchar(255) default '' COMMENT '砸蛋次数',
  `addTime` int(11) default '0' COMMENT '添加时间',
  `updateTime` int(11) default '0' COMMENT '更新时间',
  `prizenumber` varchar(255) default '' COMMENT '奖品',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='砸蛋';

-- ----------------------------
-- Table structure for favorites
-- ----------------------------
DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `status` int(1) default '0' COMMENT '状态',
  `type` int(11) default '0' COMMENT '类型',
  `userid` int(11) default '0' COMMENT '所属用户',
  `product_id` int(11) default '0' COMMENT '产品ID',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='收藏';

-- ----------------------------
-- Table structure for focus
-- ----------------------------
DROP TABLE IF EXISTS `focus`;
CREATE TABLE `focus` (
  `id` int(11) NOT NULL auto_increment,
  `sorting` int(11) default '0',
  `pic` varchar(255) default '',
  `addtime` int(11) default '0',
  `urls` varchar(255) default '',
  `type` int(5) default '0',
  `status` int(11) default NULL,
  `title` varchar(255) default NULL,
  `group_id` int(11) default '1' COMMENT '分组id',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for goods_tag
-- ----------------------------
DROP TABLE IF EXISTS `goods_tag`;
CREATE TABLE `goods_tag` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default NULL COMMENT '标题',
  `images` varchar(255) default '' COMMENT '标签图',
  `size` varchar(50) default '0' COMMENT '图片尺寸',
  `type` tinyint(1) NOT NULL default '0' COMMENT '类型',
  `add_time` int(11) NOT NULL default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品标签图记录表';

-- ----------------------------
-- Table structure for greeting_cards
-- ----------------------------
DROP TABLE IF EXISTS `greeting_cards`;
CREATE TABLE `greeting_cards` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default '' COMMENT '贺卡名称',
  `background` varchar(255) default '' COMMENT '背景图片',
  `text_background` varchar(255) default '' COMMENT '文字背景图片',
  `pic1` varchar(255) default '' COMMENT '敲蛋后图片1',
  `pic1_url` varchar(255) default '' COMMENT '图片1链接地址',
  `pic2` varchar(255) default '' COMMENT '敲蛋后图片2',
  `pic2_url` varchar(255) default '' COMMENT '图片2链接地址',
  `pic3` varchar(255) default '' COMMENT '敲蛋后图片3',
  `pic3_url` varchar(255) default '' COMMENT '图片3链接地址',
  `writing` text COMMENT '文字',
  `music` varchar(255) default '' COMMENT '音乐',
  `footer` varchar(255) default '' COMMENT '底部文字',
  `footer_url` varchar(255) default '' COMMENT '底部文字链接',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for information
-- ----------------------------
DROP TABLE IF EXISTS `information`;
CREATE TABLE `information` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `status` int(1) default '0' COMMENT '状态',
  `sorting` int(11) default '0' COMMENT '排序',
  `type` int(11) default '0' COMMENT '类型',
  `title` varchar(255) default '' COMMENT '标题',
  `content` text COMMENT '内容',
  `addtime` varchar(255) default NULL COMMENT '记录产生时间',
  `hits` int(11) default '0' COMMENT '查看次数',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='活动信息';

-- ----------------------------
-- Table structure for integral_orders
-- ----------------------------
DROP TABLE IF EXISTS `integral_orders`;
CREATE TABLE `integral_orders` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `customer_id` int(11) NOT NULL default '0' COMMENT '顾客id',
  `order_number` varchar(20) NOT NULL COMMENT '对外订单号',
  `all_integral` int(11) NOT NULL COMMENT '消耗总积分',
  `receiver` varchar(32) NOT NULL COMMENT '收货人',
  `address` varchar(128) NOT NULL COMMENT '详细地址',
  `phone` varchar(32) NOT NULL COMMENT '联系方式',
  `delivery_status` tinyint(1) unsigned NOT NULL default '0' COMMENT '发货状态：0未发货；1已发货',
  `receiving_state` tinyint(1) unsigned NOT NULL default '0' COMMENT '收货状态：0未收货；1已收货',
  `create_time` int(10) NOT NULL default '0' COMMENT '订单生成时间',
  `delivery_time` int(10) NOT NULL default '0' COMMENT '订单发货时间',
  `receiving_time` int(10) NOT NULL default '0' COMMENT '订单收货时间',
  `ip` varchar(15) NOT NULL COMMENT 'IP地址',
  `express_type` varchar(255) NOT NULL COMMENT '快递类型',
  `express_number` varchar(255) NOT NULL COMMENT '快递编号',
  `user_del` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否删除（用户触发）：1是 0否',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分兑换订单表';

-- ----------------------------
-- Table structure for integral_orders_detail
-- ----------------------------
DROP TABLE IF EXISTS `integral_orders_detail`;
CREATE TABLE `integral_orders_detail` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号id',
  `userid` int(11) NOT NULL default '0' COMMENT '所属用户',
  `product_id` int(11) NOT NULL default '0' COMMENT '积分商品id',
  `product_name` varchar(100) NOT NULL COMMENT '积分商品名称',
  `product_image` varchar(255) NOT NULL COMMENT '积分商品图片',
  `product_integral` int(5) NOT NULL default '0' COMMENT '商品兑换所需积分',
  `shipping_number` int(5) NOT NULL default '0' COMMENT '购买数量',
  `integral_orders_id` int(11) NOT NULL default '0' COMMENT '积分兑换订单id',
  PRIMARY KEY  (`id`),
  KEY `integral` (`userid`,`integral_orders_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分兑换订单详情表';

-- ----------------------------
-- Table structure for integral_pay
-- ----------------------------
DROP TABLE IF EXISTS `integral_pay`;
CREATE TABLE `integral_pay` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `status` int(11) default '0' COMMENT '状态',
  `type` int(11) default '1' COMMENT '0-》历史积分升级会员，1-》购物，2-》兑换',
  `userid` int(11) NOT NULL default '0' COMMENT '用户id',
  `integral` int(11) default '0' COMMENT '使用积分的数量',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  `remarks` varchar(255) default '' COMMENT '备注',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='积分使用记录';

-- ----------------------------
-- Table structure for integral_product
-- ----------------------------
DROP TABLE IF EXISTS `integral_product`;
CREATE TABLE `integral_product` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号id',
  `name` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '积分商品名称',
  `image` varchar(255) NOT NULL COMMENT '商品图片',
  `inventory` int(11) NOT NULL default '0' COMMENT '库存',
  `description` text character set utf8 collate utf8_unicode_ci COMMENT '商品详情',
  `integral` int(5) NOT NULL default '0' COMMENT '消耗积分',
  `sorting` int(11) NOT NULL default '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL default '0' COMMENT '状态：1上架，0下架',
  PRIMARY KEY  (`id`),
  KEY `integral` (`sorting`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分商品表';

-- ----------------------------
-- Table structure for integral_record
-- ----------------------------
DROP TABLE IF EXISTS `integral_record`;
CREATE TABLE `integral_record` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) default '0' COMMENT '积分产生类型',
  `status` int(11) default '0' COMMENT '状态',
  `userid` int(11) default '0' COMMENT '用户ID',
  `pin_id` int(11) default '0' COMMENT '团购ID',
  `pin_type` int(11) default '0' COMMENT '团购类型0->发起，1->参与，',
  `order_id` int(11) default '0' COMMENT '订单id',
  `integral` double(7,2) default '0.00' COMMENT '积分',
  `addtime` int(11) default '0' COMMENT '时间',
  `total_time` int(11) default '0' COMMENT '积分入账时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='积分获取记录';

-- ----------------------------
-- Table structure for invite_prize_records
-- ----------------------------
DROP TABLE IF EXISTS `invite_prize_records`;
CREATE TABLE `invite_prize_records` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) unsigned default '0' COMMENT '被邀请用户ID',
  `addtime` int(11) unsigned default '0' COMMENT '添加时间',
  `fuserid` int(11) unsigned default '0' COMMENT '邀请人ID',
  `exp_value` decimal(10,2) default NULL,
  `effective_time` int(11) default '0' COMMENT '有效期',
  `status` int(11) default '0' COMMENT '激活，关闭',
  `card_number` varchar(255) default '' COMMENT '优惠卷编号',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户推荐奖励记录';

-- ----------------------------
-- Table structure for lottery
-- ----------------------------
DROP TABLE IF EXISTS `lottery`;
CREATE TABLE `lottery` (
  `lottery_id` int(11) unsigned NOT NULL auto_increment COMMENT '抽奖id',
  `subject` varchar(255) NOT NULL default '' COMMENT '主题',
  `status` tinyint(1) unsigned NOT NULL default '0' COMMENT '状态，0禁用，1启用',
  `start_time` int(10) unsigned NOT NULL default '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL default '0' COMMENT '结束时间',
  `background` varchar(255) default NULL COMMENT '背景图',
  `title_image` varchar(255) default NULL COMMENT '标题图',
  `turntable` varchar(255) default NULL COMMENT '转盘图',
  `pointer` varchar(255) default NULL COMMENT '指针图标',
  `explain_image` varchar(255) default NULL COMMENT '活动说明图',
  PRIMARY KEY  (`lottery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='转盘信息表';

-- ----------------------------
-- Table structure for lottery_log
-- ----------------------------
DROP TABLE IF EXISTS `lottery_log`;
CREATE TABLE `lottery_log` (
  `lottery_log_id` bigint(30) unsigned NOT NULL auto_increment COMMENT '抽奖结果id',
  `user_id` bigint(20) unsigned NOT NULL default '0' COMMENT '会员id',
  `time` int(10) unsigned NOT NULL default '0' COMMENT '抽奖时间',
  `prize` varchar(255) NOT NULL default '' COMMENT '奖品',
  `prize_type` tinyint(1) NOT NULL default '1' COMMENT '奖品类型，1不中，2微信红包，3优惠券，4转发攒运气',
  `prize_val` varchar(50) NOT NULL default '' COMMENT '奖品值，根据prize_type值而定，0红包金额，1券码',
  PRIMARY KEY  (`lottery_log_id`),
  KEY `user` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='抽奖记录表';

-- ----------------------------
-- Table structure for lottery_setting
-- ----------------------------
DROP TABLE IF EXISTS `lottery_setting`;
CREATE TABLE `lottery_setting` (
  `id` int(11) NOT NULL auto_increment,
  `prize` varchar(50) NOT NULL default '0' COMMENT '奖品',
  `prize_type` tinyint(1) NOT NULL default '1' COMMENT '奖品类型，1不中，2微信红包，3优惠券，4转发攒运气',
  `prize_val` varchar(50) default '' COMMENT '奖品值：对应coupon表下的id',
  `pos` int(11) NOT NULL default '0' COMMENT '角度值',
  `chance` int(11) NOT NULL default '0' COMMENT '概率',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='转盘设置表';

-- ----------------------------
-- Table structure for money_log
-- ----------------------------
DROP TABLE IF EXISTS `money_log`;
CREATE TABLE `money_log` (
  `id` bigint(20) unsigned NOT NULL auto_increment COMMENT '自增id',
  `user_id` bigint(20) unsigned NOT NULL default '0' COMMENT '用户id',
  `time` int(10) unsigned NOT NULL default '0' COMMENT '时间',
  `money` decimal(14,6) unsigned NOT NULL default '0.000000' COMMENT '金额',
  `remark` text NOT NULL COMMENT '备注',
  `type` tinyint(1) unsigned NOT NULL default '0' COMMENT '类型',
  PRIMARY KEY  (`id`),
  KEY `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户资金明细表';

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL auto_increment COMMENT '编号',
  `customer_id` int(11) default '0' COMMENT '顾客ID',
  `customer_group_id` int(11) default '0' COMMENT '顾客团购ID',
  `email` varchar(96) default '' COMMENT '邮箱',
  `telephone` varchar(32) default '' COMMENT '手机号',
  `cellphone` varchar(255) default '' COMMENT '固定电话',
  `shipping_firstname` varchar(32) default '' COMMENT '收货人',
  `shipping_address_1` varchar(128) default '' COMMENT '详细地址',
  `shipping_address_2` varchar(128) default '' COMMENT '后备详细地址',
  `shipping_city` varchar(128) default '' COMMENT '城市',
  `shipping_postcode` varchar(10) default '' COMMENT '邮编',
  `shipping_method` varchar(128) default '' COMMENT '收货方式',
  `remark` text COMMENT '备注',
  `order_status_id` int(11) default '0' COMMENT '订单状态',
  `date_added` datetime default '0000-00-00 00:00:00',
  `date_modified` datetime default '0000-00-00 00:00:00',
  `ip` varchar(15) default '' COMMENT 'IP地址',
  `order_number` varchar(20) default NULL,
  `pay_method` varchar(255) default '' COMMENT '付款方式',
  `rebate` decimal(10,2) default NULL,
  `coupon` varchar(255) default '' COMMENT '优惠卷号',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  `abolishment_status` int(1) default '0' COMMENT '取消状态：0->正常；1->取消',
  `paid_price` decimal(10,2) default NULL,
  `isread` int(1) default '0' COMMENT '是否查看',
  `status_time` int(11) default '0' COMMENT '状态更改时间',
  `all_price` decimal(10,2) default NULL,
  `group_buy_price` decimal(10,2) default NULL,
  `sign_userid` int(11) default '0' COMMENT '签收人ID',
  `status_bu` int(2) default '-1' COMMENT '补发货状态',
  `huodong_order_status` int(1) default '0' COMMENT '活动订单状态',
  `pay_online` decimal(10,2) default NULL,
  `promotions_price` decimal(10,2) default NULL,
  `express_type` varchar(255) default '' COMMENT '快递类型',
  `express_number` varchar(255) default '' COMMENT '快递编号',
  `user_del` int(11) default '0' COMMENT '用户点击删除为1,否则为0',
  `storeName` varchar(255) default NULL COMMENT '商家名称',
  `cashStatus` int(11) default '0',
  `status_introduce` int(1) default '0' COMMENT '是否实体店',
  `is_send` int(1) default '0' COMMENT '是否发送消息',
  `out_trade_no` varchar(255) default '' COMMENT '微信支付订单号',
  `settled` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否已结算，0否1是',
  PRIMARY KEY  (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品订单';

-- ----------------------------
-- Table structure for orders_oneyuan
-- ----------------------------
DROP TABLE IF EXISTS `orders_oneyuan`;
CREATE TABLE `orders_oneyuan` (
  `order_id` int(11) NOT NULL auto_increment,
  `order_number` int(11) default '0' COMMENT '订单号',
  `userid` int(11) default '0' COMMENT '用户id',
  `email` varchar(255) default '' COMMENT '邮箱',
  `telephone` varchar(255) default '' COMMENT '电话',
  `cellphone` varchar(255) default '' COMMENT '固话',
  `shipping_firstname` varchar(255) default '' COMMENT '收货人',
  `shipping_address_1` varchar(255) default '' COMMENT '详细地址',
  `shipping_address_2` varchar(255) default '' COMMENT '备用地址',
  `shipping_city` varchar(255) default '' COMMENT '城市',
  `shipping_postcode` varchar(255) default '' COMMENT '邮编',
  `shipping_method` int(11) default '0' COMMENT '收货方式：0快递',
  `remark` text COMMENT '订单备注',
  `order_status_id` int(11) default '0' COMMENT '订单状态：0未付款 1待发货 2已发货 3待确认 4待评价',
  `date_added` datetime default '0000-00-00 00:00:00' COMMENT '添加日期',
  `date_modified` datetime default '0000-00-00 00:00:00' COMMENT '修改日期',
  `ip` varchar(255) default '' COMMENT '用户ip',
  `pay_method` int(11) default '0' COMMENT '付款方式：0微信支付',
  `rebate` decimal(10,2) default NULL,
  `abolishment_status` int(11) default '0' COMMENT '取消状态：0正常 1取消',
  `paid_price` decimal(10,2) default NULL,
  `status_time` int(11) default '0' COMMENT '状态更新时间',
  `all_price` decimal(10,2) default NULL,
  `pay_online` decimal(10,2) default NULL,
  `express_type` varchar(255) default '' COMMENT '快递类型',
  `express_number` varchar(255) default '' COMMENT '快递单号',
  `user_del` varchar(255) default '0' COMMENT '用户删除状态：0正常 2删除',
  `status_introduce` int(1) default '0' COMMENT '是否实体店',
  `is_send` int(1) default '0' COMMENT '是否已发送消息',
  `out_trade_no` varchar(255) default '' COMMENT '微信支付订单号',
  `addtime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='一元购订单';

-- ----------------------------
-- Table structure for order_num
-- ----------------------------
DROP TABLE IF EXISTS `order_num`;
CREATE TABLE `order_num` (
  `order_num` bigint(12) NOT NULL auto_increment COMMENT '订单号',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  PRIMARY KEY  (`order_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='单号产生时间';

-- ----------------------------
-- Table structure for pay_records
-- ----------------------------
DROP TABLE IF EXISTS `pay_records`;
CREATE TABLE `pay_records` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `type` int(5) default '0' COMMENT '类型',
  `userid` int(11) default '0' COMMENT '所属用户',
  `order_num` varchar(255) default '' COMMENT '订单号',
  `status` int(5) default '0' COMMENT '状态',
  `money` decimal(10,2) default NULL,
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='消费记录';

-- ----------------------------
-- Table structure for pin
-- ----------------------------
DROP TABLE IF EXISTS `pin`;
CREATE TABLE `pin` (
  `id` int(11) NOT NULL auto_increment,
  `status` int(1) default '0' COMMENT '-1->等待付款后开始拼单(未开始)，0->拼单结束,1->拼单进行中，2->拼单成功，已免运费',
  `price` double(8,2) default '0.00' COMMENT '金额',
  `name` varchar(50) default '' COMMENT '发起人昵称',
  `title` varchar(255) default '' COMMENT '发起的标题',
  `content` text COMMENT '发起的口号',
  `sorting` int(11) default '0' COMMENT '排序',
  `close_status` int(11) default '0' COMMENT '关闭状态：1为关闭',
  `isread` int(1) default '0' COMMENT '是否查看',
  `order_id` int(11) default '0' COMMENT '订单id',
  `userid` int(11) default '0' COMMENT '用户id',
  `show_cart` int(1) default '0' COMMENT '是否显示',
  `show_status` int(1) default '0' COMMENT '显示状态',
  `starttime` int(11) default '0' COMMENT '开始时间',
  `endtime` int(11) default '0' COMMENT '结束时间',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  `product_id` int(11) default '0' COMMENT '产品ID',
  `pin_type` int(1) default '0' COMMENT '类型',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='团购发起';

-- ----------------------------
-- Table structure for pin_details
-- ----------------------------
DROP TABLE IF EXISTS `pin_details`;
CREATE TABLE `pin_details` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `userid` int(11) default '0' COMMENT '用户',
  `status` int(3) default '0' COMMENT '状态',
  `pin_id` int(11) default '0' COMMENT '参与的团购单号',
  `type` int(1) default '0' COMMENT '1->发起者，0->参与者',
  `name` varchar(50) default '' COMMENT '顾客名称',
  `orderid` int(11) default '0' COMMENT '订单号',
  `price` decimal(10,2) default NULL,
  `refund` int(1) default '0' COMMENT '退款',
  `bank_card_number` varchar(60) default '' COMMENT '银行卡号',
  `addtime` int(11) default '0' COMMENT '参与时间',
  `address_id` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='团购参与表';

-- ----------------------------
-- Table structure for pin_join
-- ----------------------------
DROP TABLE IF EXISTS `pin_join`;
CREATE TABLE `pin_join` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `pin_id` int(11) default '0' COMMENT '团购id',
  `wx_no` varchar(255) default '' COMMENT '微信号',
  `buy_number` int(11) default '1' COMMENT '购买份数',
  `addtime` int(11) default '0' COMMENT '添加时间',
  `is_add_cart` int(1) default '0' COMMENT '是否已经加入购物车',
  `address_id` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购报名记录';

-- ----------------------------
-- Table structure for pin_num_sys
-- ----------------------------
DROP TABLE IF EXISTS `pin_num_sys`;
CREATE TABLE `pin_num_sys` (
  `id` int(11) NOT NULL auto_increment,
  `number` int(11) default '0' COMMENT '参团人数',
  `money` decimal(10,2) default NULL,
  `product_id` int(11) default '0' COMMENT '产品id',
  `status` int(1) default '0' COMMENT '审核状态',
  `brand` varchar(255) default '斤' COMMENT '规格单位',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购人数规则';

-- ----------------------------
-- Table structure for pin_records
-- ----------------------------
DROP TABLE IF EXISTS `pin_records`;
CREATE TABLE `pin_records` (
  `id` int(11) NOT NULL auto_increment,
  `pin_id` int(11) unsigned default NULL COMMENT '团购ID',
  `userid` int(11) unsigned default '0' COMMENT '用户ID',
  `addtime` int(11) unsigned default '0' COMMENT '添加时间',
  `type` int(11) unsigned default '0' COMMENT '记录类型（1分享；2网页浏览；3点击分享链接）',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购相关记录';

-- ----------------------------
-- Table structure for pin_sys
-- ----------------------------
DROP TABLE IF EXISTS `pin_sys`;
CREATE TABLE `pin_sys` (
  `id` int(11) NOT NULL auto_increment,
  `money` decimal(10,2) default NULL,
  `discount` int(3) default '0' COMMENT '折扣',
  `product_id` int(11) default '0' COMMENT '产品ID',
  `status` int(1) default '0' COMMENT '状态',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团购系统设置表';

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL auto_increment COMMENT '产品编号',
  `name` varchar(100) default '' COMMENT '产品名称',
  `title` text COMMENT '产品的简单的描述',
  `model` varchar(64) default '' COMMENT '货号',
  `image` varchar(255) default NULL COMMENT '商品图片',
  `category_id` int(11) default '0' COMMENT '产品一级类型',
  `category_id2` int(11) default '0' COMMENT '二级类型',
  `category_big` int(11) default '0' COMMENT '团购0/礼品1/换购2/',
  `price` decimal(10,2) default NULL,
  `price_old` decimal(10,2) default NULL,
  `status` tinyint(3) default '0' COMMENT '商品状态',
  `viewed` int(6) default '0' COMMENT '浏览次数',
  `description` text COMMENT '详细介绍',
  `sorting` int(11) default '0' COMMENT '商品排序',
  `hot` int(11) default '0' COMMENT '热门状态',
  `inventory` int(11) default '0' COMMENT '库存数',
  `unit` varchar(255) default '份' COMMENT '单位',
  `standard` varchar(255) default '' COMMENT '规格',
  `brand` varchar(255) default '' COMMENT '品牌',
  `origin_place` varchar(255) default '' COMMENT '产地',
  `range_s` varchar(255) default '' COMMENT '配送范围',
  `distribution_date` varchar(255) default '' COMMENT '配送时间',
  `integral` int(5) default '0' COMMENT '积分',
  `random` int(5) default '0' COMMENT '随机数',
  `sell_number` int(11) default '0' COMMENT '已销售数量',
  `list_des` varchar(20) default NULL COMMENT '列表备注',
  `altitude` int(11) unsigned default NULL COMMENT '海拔高度',
  `notes` text COMMENT '冲泡注意事项',
  `teapot` text COMMENT '茶壶',
  `teacup` text COMMENT '茶碗',
  `tag_title` varchar(255) default NULL COMMENT '对应goods_tag表下的id',
  PRIMARY KEY  (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品';

-- ----------------------------
-- Table structure for productimage
-- ----------------------------
DROP TABLE IF EXISTS `productimage`;
CREATE TABLE `productimage` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `image` varchar(100) default '/images/toy_default.jpg' COMMENT '图片路径',
  `addTime` int(2) default '0' COMMENT '记录产生时间',
  `productId` int(11) default '0' COMMENT '所属产品',
  `status` int(2) default NULL COMMENT '状态',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品图集';

-- ----------------------------
-- Table structure for product_attr
-- ----------------------------
DROP TABLE IF EXISTS `product_attr`;
CREATE TABLE `product_attr` (
  `id` bigint(10) unsigned NOT NULL auto_increment COMMENT '自增id',
  `product_id` bigint(20) unsigned NOT NULL default '0' COMMENT '产品id',
  `attr_group` text NOT NULL COMMENT '属性组合，json格式，格式：{属性id:内容}',
  `price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '价格',
  `store` mediumint(10) unsigned NOT NULL default '0' COMMENT '库存',
  PRIMARY KEY  (`id`),
  KEY `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品属性关联表';

-- ----------------------------
-- Table structure for product_label
-- ----------------------------
DROP TABLE IF EXISTS `product_label`;
CREATE TABLE `product_label` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default NULL COMMENT '标题',
  `images` varchar(255) default '' COMMENT '标签图',
  `size` varchar(50) default '0' COMMENT '图片尺寸',
  `type` tinyint(1) NOT NULL default '0' COMMENT '类型',
  `add_time` int(11) NOT NULL default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品标签记录表';

-- ----------------------------
-- Table structure for product_phase
-- ----------------------------
DROP TABLE IF EXISTS `product_phase`;
CREATE TABLE `product_phase` (
  `id` int(11) NOT NULL auto_increment,
  `phase_number` varchar(255) default '',
  `product_id` int(11) default '0' COMMENT '产品id',
  `total_amount` int(11) default '0' COMMENT '参购总人数',
  `limit_amount` int(11) default '0' COMMENT '限制人次：0为不限制',
  `title` varchar(255) default NULL COMMENT '标题',
  `description` text COMMENT '描述',
  `sorting` int(11) default '0' COMMENT '排序',
  `status` int(1) default '0' COMMENT '状态：0未审核 1已审核',
  `sale_status` int(3) default '0' COMMENT '销售状态：0未销售 1销售中 2已结束',
  `starttime` int(11) default '0' COMMENT '开始时间',
  `endtime` int(11) default '0' COMMENT '结束时间',
  `finishtime` int(11) default '0' COMMENT '揭晓时间',
  `final_lucky_number` varchar(255) default '' COMMENT '中奖幸运号码',
  `addtime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品期次表';

-- ----------------------------
-- Table structure for product_price
-- ----------------------------
DROP TABLE IF EXISTS `product_price`;
CREATE TABLE `product_price` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) default '0' COMMENT '产品ID',
  `sorting` int(11) default '0' COMMENT '排序',
  `standard` varchar(255) default '' COMMENT '产品规格',
  `price` decimal(10,2) default NULL,
  `price_old` decimal(10,2) default NULL,
  `status` int(1) default '0' COMMENT '状态',
  `addtime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品价格';

-- ----------------------------
-- Table structure for product_tag
-- ----------------------------
DROP TABLE IF EXISTS `product_tag`;
CREATE TABLE `product_tag` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL default '0' COMMENT '商品id',
  `product_name` varchar(255) default '' COMMENT '商品名',
  `tag_id` int(11) NOT NULL default '0' COMMENT '标签id',
  `tag_title` varchar(255) default '' COMMENT '标签标题',
  `tag_image` varchar(255) default '' COMMENT '标签图',
  `add_time` int(11) NOT NULL default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品标签信息表';

-- ----------------------------
-- Table structure for product_taste_apply
-- ----------------------------
DROP TABLE IF EXISTS `product_taste_apply`;
CREATE TABLE `product_taste_apply` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `product_id` int(11) default '0' COMMENT '产品id',
  `name` varchar(255) default '' COMMENT '申请人姓名',
  `tel` varchar(255) default '' COMMENT '联系号码',
  `address` varchar(255) default '' COMMENT '联系地址',
  `status` int(1) default '0' COMMENT '审核状态',
  `addtime` int(11) default '0' COMMENT '申请时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品品尝申请';

-- ----------------------------
-- Table structure for product_type
-- ----------------------------
DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `classid` int(5) default '0' COMMENT '父类',
  `name` varchar(255) default '' COMMENT '类型名称',
  `num` int(5) default '0' COMMENT '商品数',
  `sorting` int(5) default '0' COMMENT '排序',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品目录';

-- ----------------------------
-- Table structure for promotions_new
-- ----------------------------
DROP TABLE IF EXISTS `promotions_new`;
CREATE TABLE `promotions_new` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `status` int(11) default '0' COMMENT '状态',
  `title` varchar(255) default '' COMMENT '促销活动标题',
  `start_time` int(11) default '0' COMMENT '开始时间',
  `end_time` int(11) default '0' COMMENT '结束时间',
  `all_money` decimal(10,2) default NULL,
  `send_money` decimal(10,2) default NULL,
  `rebate` decimal(10,2) default NULL,
  `image1` varchar(255) default '' COMMENT '活动的头部背景图',
  `image2` varchar(255) default '' COMMENT '活动装饰图',
  `is_end` int(11) default NULL COMMENT '是否结束',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='促销活动';

-- ----------------------------
-- Table structure for promotions_product
-- ----------------------------
DROP TABLE IF EXISTS `promotions_product`;
CREATE TABLE `promotions_product` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `status` int(1) default '0' COMMENT '状态',
  `sorting` int(11) default '0' COMMENT '推荐值',
  `p_id` int(11) default '0' COMMENT '促销ID',
  `product_id` int(11) default '0' COMMENT '商品id',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  `number` int(11) default '0' COMMENT '活动数量',
  `pro_price` varchar(255) default NULL COMMENT '特价',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='促销商品设置表';

-- ----------------------------
-- Table structure for redbag_activity
-- ----------------------------
DROP TABLE IF EXISTS `redbag_activity`;
CREATE TABLE `redbag_activity` (
  `id` int(11) NOT NULL auto_increment,
  `sorting` int(11) default '0' COMMENT '排序',
  `title` varchar(255) default '' COMMENT '标题',
  `content` text COMMENT '内容',
  `background_image` varchar(255) default '' COMMENT '背景图片',
  `start_date` int(11) default '0' COMMENT '开始日期',
  `end_date` int(11) default '0' COMMENT '结束日期',
  `add_time` int(11) default '0' COMMENT '添加时间',
  `state` int(1) default '0' COMMENT '活动状态：0 正在进行 1活动结束',
  `prize_count` int(11) default '1' COMMENT '未取红包个数',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for redbag_prize
-- ----------------------------
DROP TABLE IF EXISTS `redbag_prize`;
CREATE TABLE `redbag_prize` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `openid` varchar(50) default '' COMMENT '公众号id',
  `name` varchar(255) default '' COMMENT '微信名称',
  `activity_id` int(11) default '0' COMMENT '红包活动id',
  `prize` varchar(255) default '' COMMENT '中奖内容',
  `addTime` int(11) default '0' COMMENT '添加时间',
  `suserid` int(11) default '0' COMMENT '来源用户id',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户抽奖号';

-- ----------------------------
-- Table structure for redbag_records
-- ----------------------------
DROP TABLE IF EXISTS `redbag_records`;
CREATE TABLE `redbag_records` (
  `id` int(11) NOT NULL auto_increment,
  `userid` varchar(255) default '' COMMENT '用户id',
  `price` int(11) default '0' COMMENT '金额',
  `addtime` int(11) default '0' COMMENT '发放时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包发放记录';

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `key` varchar(50) NOT NULL default '' COMMENT '键名',
  `value` varchar(500) NOT NULL default '' COMMENT '值',
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设置表';

-- ----------------------------
-- Table structure for shake_activity
-- ----------------------------
DROP TABLE IF EXISTS `shake_activity`;
CREATE TABLE `shake_activity` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `type` int(5) default '0' COMMENT '活动类型',
  `title` varchar(255) default '' COMMENT '活动标题',
  `starttime` int(11) default '0' COMMENT '活动开始时间',
  `endtime` int(11) default '0' COMMENT '活动结束时间',
  `addTime` bigint(14) default '0' COMMENT '记录产生时间',
  `sorting` int(11) NOT NULL default '0' COMMENT '排序',
  `status` int(1) NOT NULL default '1' COMMENT '审核状态',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='摇一摇活动';

-- ----------------------------
-- Table structure for share_records
-- ----------------------------
DROP TABLE IF EXISTS `share_records`;
CREATE TABLE `share_records` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) unsigned default '0' COMMENT '用户ID',
  `addtime` int(11) unsigned default '0' COMMENT '添加时间',
  `type` int(11) unsigned default '0' COMMENT '记录类型（1分享；2点击分享）',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='摇一摇获奖记录';

-- ----------------------------
-- Table structure for shop
-- ----------------------------
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
  `id` bigint(11) NOT NULL auto_increment COMMENT '编号',
  `uid` bigint(11) NOT NULL COMMENT '所属用户id',
  `name` varchar(50) default NULL COMMENT '店铺名称',
  `icon` varchar(255) default NULL COMMENT '头像',
  `addtime` int(10) default NULL COMMENT '添加时间',
  PRIMARY KEY  (`id`),
  KEY `user` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺信息表';

-- ----------------------------
-- Table structure for shop_prize
-- ----------------------------
DROP TABLE IF EXISTS `shop_prize`;
CREATE TABLE `shop_prize` (
  `id` int(11) NOT NULL auto_increment,
  `shop_id` int(11) default '0' COMMENT '店铺id',
  `price` int(11) default '0' COMMENT '奖品价值',
  `image` varchar(255) default '' COMMENT '奖品图片',
  `name` varchar(255) default '' COMMENT '奖品名称',
  `prize_no` varchar(255) default '' COMMENT '奖品编号',
  `probability` int(11) default '0' COMMENT '概率（单位‰）',
  `sorting` int(11) default '0' COMMENT '排序',
  `status` int(1) default '0' COMMENT '审核状态',
  `source` int(11) default '0' COMMENT '奖品来源（1摇一摇2扫二维码3官方发布）',
  `introduce` text COMMENT '奖品介绍',
  `addtime` varchar(255) default '' COMMENT '添加时间',
  `account` int(11) default '0' COMMENT '库存',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户奖品表';

-- ----------------------------
-- Table structure for shop_prize_records
-- ----------------------------
DROP TABLE IF EXISTS `shop_prize_records`;
CREATE TABLE `shop_prize_records` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `shop_id` int(11) default '0' COMMENT '商户id',
  `prize_id` int(11) default '0' COMMENT '奖品id',
  `shake_id` int(11) default '0' COMMENT '摇一摇活动id',
  `is_used` int(1) default '0' COMMENT '是否被使用',
  `used_time` int(11) default '0' COMMENT '使用时间',
  `book_time` int(11) default '0' COMMENT '预约取件时间',
  `status` int(1) default '0' COMMENT '审核状态',
  `addtime` int(11) default '0' COMMENT '添加时间',
  `ticket_no` bigint(14) default '0' COMMENT '兑奖号',
  `effective_time` int(11) default '0' COMMENT '有效期',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='摇一摇获奖记录';

-- ----------------------------
-- Table structure for shop_product
-- ----------------------------
DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE `shop_product` (
  `id` bigint(20) NOT NULL auto_increment COMMENT '编号',
  `uid` bigint(11) NOT NULL COMMENT '用户id',
  `product_id` bigint(11) NOT NULL COMMENT '产品id',
  `addtime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY  (`id`),
  KEY `rel` (`uid`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺与产品关联表';

-- ----------------------------
-- Table structure for store_images
-- ----------------------------
DROP TABLE IF EXISTS `store_images`;
CREATE TABLE `store_images` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `store_id` int(11) unsigned NOT NULL COMMENT '门店id',
  `image` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '图片',
  `sorting` int(11) unsigned NOT NULL default '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL default '0' COMMENT '状态：0未审核 1已审核',
  `create_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY  (`id`),
  KEY `store` (`store_id`,`sorting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店图册表';

-- ----------------------------
-- Table structure for store_information
-- ----------------------------
DROP TABLE IF EXISTS `store_information`;
CREATE TABLE `store_information` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `uid` int(11) unsigned NOT NULL COMMENT '门店负责人id',
  `name` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '名称',
  `mobile` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `address` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '详细地址',
  `longitude` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '经度',
  `latitude` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '纬度',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL default '0' COMMENT '状态： 0 未审核 1已审核',
  PRIMARY KEY  (`id`),
  KEY `store` (`uid`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店资料表';

-- ----------------------------
-- Table structure for sweepstakes
-- ----------------------------
DROP TABLE IF EXISTS `sweepstakes`;
CREATE TABLE `sweepstakes` (
  `Id` int(11) NOT NULL auto_increment,
  `uid` int(11) default '0' COMMENT '所属用户',
  `status` int(1) default '0' COMMENT '状态',
  `from_uid` int(11) default '0' COMMENT '邀请人',
  `snumber` varchar(20) default '' COMMENT '抽奖号',
  `source` varchar(20) default '' COMMENT '受邀 奖励 自发',
  `addTime` int(11) default '0' COMMENT '记录时间',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tp_classify
-- ----------------------------
DROP TABLE IF EXISTS `tp_classify`;
CREATE TABLE `tp_classify` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL,
  `info` varchar(90) NOT NULL COMMENT '分类描述',
  `sorts` varchar(6) NOT NULL COMMENT '显示顺序',
  `img` char(255) NOT NULL,
  `url` char(255) NOT NULL,
  `status` varchar(1) NOT NULL,
  `token` varchar(30) NOT NULL,
  `keyword` varchar(255) NOT NULL default '' COMMENT '关键词',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tp_diymen_class
-- ----------------------------
DROP TABLE IF EXISTS `tp_diymen_class`;
CREATE TABLE `tp_diymen_class` (
  `id` int(11) NOT NULL auto_increment,
  `type` tinyint(1) NOT NULL COMMENT '菜单的响应动作类型 1:click   2:view',
  `token` varchar(60) NOT NULL,
  `pid` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `is_show` tinyint(1) NOT NULL,
  `sort` tinyint(3) NOT NULL,
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tp_img
-- ----------------------------
DROP TABLE IF EXISTS `tp_img`;
CREATE TABLE `tp_img` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `uid` int(11) NOT NULL,
  `uname` varchar(90) NOT NULL default '' COMMENT '管理员名称',
  `keyword` char(255) NOT NULL default '' COMMENT '关键词',
  `type` varchar(1) NOT NULL COMMENT '关键词匹配类型',
  `text` text NOT NULL COMMENT '简介',
  `classid` int(11) NOT NULL default '0' COMMENT '分类ID',
  `classname` varchar(60) NOT NULL default '' COMMENT '分类名',
  `pic` char(255) NOT NULL COMMENT '封面图片',
  `showpic` varchar(1) NOT NULL COMMENT '图片是否显示封面',
  `info` text NOT NULL COMMENT '图文详细内容',
  `url` char(255) NOT NULL COMMENT '图文外链地址',
  `createtime` varchar(13) NOT NULL,
  `uptatetime` varchar(13) NOT NULL,
  `click` int(11) NOT NULL,
  `token` char(30) NOT NULL,
  `title` varchar(60) NOT NULL,
  `model` varchar(255) default NULL,
  `video` varchar(255) default NULL,
  `address` varchar(80) default NULL,
  PRIMARY KEY  (`id`),
  KEY `classid` (`classid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信图文';

-- ----------------------------
-- Table structure for tp_keyword
-- ----------------------------
DROP TABLE IF EXISTS `tp_keyword`;
CREATE TABLE `tp_keyword` (
  `id` int(11) NOT NULL auto_increment,
  `keyword` char(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `token` varchar(60) NOT NULL,
  `module` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `token` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tp_text
-- ----------------------------
DROP TABLE IF EXISTS `tp_text`;
CREATE TABLE `tp_text` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `uname` varchar(90) NOT NULL,
  `keyword` char(255) NOT NULL,
  `type` varchar(1) NOT NULL,
  `text` text NOT NULL,
  `createtime` varchar(13) NOT NULL,
  `updatetime` varchar(13) NOT NULL,
  `click` int(11) NOT NULL,
  `token` char(30) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文本回复表';

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `name` varchar(255) default NULL COMMENT '名称',
  `status` int(2) default '0' COMMENT '状态',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='单位';

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `type` int(11) default '0' COMMENT '0->普通会员，1->会员卡领取账户，8->商家店铺账号',
  `level` int(11) default '0' COMMENT '会员级别',
  `status` int(11) default '0' COMMENT '状态',
  `sorting` int(11) default '1' COMMENT '排序',
  `username` varchar(255) default NULL COMMENT '账户',
  `pass` varchar(255) default NULL COMMENT '密码',
  `name` varchar(255) default NULL COMMENT '姓名',
  `sex` int(11) default '0' COMMENT '性别',
  `birthday` varchar(255) default '' COMMENT '生日',
  `email` varchar(255) default NULL COMMENT '邮箱',
  `tel` varchar(100) default NULL COMMENT '电话',
  `phone` varchar(255) default '' COMMENT '手机',
  `lastaccess` int(11) default '0' COMMENT '登陆时间',
  `landing_num` int(11) default '0' COMMENT '登录次数',
  `integral` int(11) default '0' COMMENT '总积分',
  `invitation_name` varchar(255) default '' COMMENT '邀请人',
  `isread` int(1) default '0' COMMENT '是否查看',
  `openid` varchar(255) default NULL COMMENT '微信ID',
  `addTime` int(11) default '0' COMMENT '记录产生时间',
  `minfo` varchar(255) default '' COMMENT '邀请码',
  `fminfo` varchar(255) default '' COMMENT '被邀请号码',
  `privileges` varchar(50) default '' COMMENT '用户权限',
  `money` decimal(14,6) unsigned default '0.000000' COMMENT '金额',
  `freeze_money` decimal(14,2) unsigned default '0.00' COMMENT '冻结金额',
  `is_attention` int(1) default '0' COMMENT '是否关注(0未关注 1已关注)',
  `head_image` varchar(255) default '' COMMENT '头像',
  `add_type` varchar(255) default '0' COMMENT '添加渠道：0 平台注册，1 扫描二维码',
  `redbag_number` int(11) default '1' COMMENT '未领取红包个数',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户信息';

-- ----------------------------
-- Table structure for user_address
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `userid` int(11) default '0' COMMENT '所属用户',
  `status` int(2) default '0' COMMENT '状态',
  `chick` int(4) default '0' COMMENT '使用次数',
  `city` varchar(20) character set utf8 default '' COMMENT '城市',
  `area` varchar(20) character set utf8 default NULL COMMENT '区',
  `address` text character set utf8 COMMENT '详细地址',
  `shipping_firstname` varchar(255) character set utf8 default '' COMMENT '收货人',
  `telephone` varchar(255) character set utf8 default '' COMMENT '电话号码',
  `remark` varchar(255) character set utf8 default NULL COMMENT '备注',
  `is_default` int(1) default '0' COMMENT '是否默认：1为默认',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='用户多地址记录';

-- ----------------------------
-- Table structure for user_connection
-- ----------------------------
DROP TABLE IF EXISTS `user_connection`;
CREATE TABLE `user_connection` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `userid` int(11) default '0' COMMENT '当前用户',
  `fuserid` int(11) default '0' COMMENT '邀请人',
  `minfo` varchar(100) default '' COMMENT '邀请M码信息',
  `type` int(11) default '0' COMMENT '关系产生的来源',
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  `path` varchar(100) NOT NULL default '' COMMENT '用户关系id链',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user_coupon
-- ----------------------------
DROP TABLE IF EXISTS `user_coupon`;
CREATE TABLE `user_coupon` (
  `id` int(11) NOT NULL auto_increment,
  `coupon_num` varchar(20) NOT NULL default '' COMMENT '优惠券编号',
  `user_id` bigint(20) unsigned NOT NULL default '0' COMMENT '会员id',
  `coupon_id` int(11) unsigned NOT NULL default '0' COMMENT '优惠券id 对应coupon.id',
  `status` tinyint(1) unsigned NOT NULL default '1' COMMENT '状态，0禁用，1启用',
  `get_time` int(10) unsigned NOT NULL default '0' COMMENT '获取时间',
  `is_used` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否已使用，0否1是',
  `use_time` int(10) unsigned NOT NULL default '0' COMMENT '使用时间',
  `valid_stime` int(10) unsigned NOT NULL default '0' COMMENT '有效期开始时间',
  `valid_etime` int(10) unsigned NOT NULL default '0' COMMENT '有效期结束时间',
  `from` int(10) unsigned default '0' COMMENT '获取来源,',
  PRIMARY KEY  (`id`),
  KEY `ids` (`user_id`,`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户优惠券表';

-- ----------------------------
-- Table structure for user_group
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default '' COMMENT '分组名称',
  `classid` int(11) default '0' COMMENT '父类id',
  `sorting` int(11) default '0' COMMENT '排序',
  `lat` varchar(255) default '' COMMENT '纬度',
  `lng` varchar(255) default '' COMMENT '经度',
  `addtime` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分组';

-- ----------------------------
-- Table structure for user_location
-- ----------------------------
DROP TABLE IF EXISTS `user_location`;
CREATE TABLE `user_location` (
  `id` int(11) NOT NULL auto_increment,
  `openid` varchar(255) default '' COMMENT '微信号',
  `longitude` varchar(255) default '' COMMENT '经度',
  `latitude` varchar(255) default '' COMMENT '纬度',
  `addTime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户位置推送记录表';

-- ----------------------------
-- Table structure for user_pay
-- ----------------------------
DROP TABLE IF EXISTS `user_pay`;
CREATE TABLE `user_pay` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `status` int(11) default '0' COMMENT '状态',
  `type` int(11) default '0' COMMENT '100为内部员工的充值,56为员工购买会员卡,1会员卡激活充值，2充值返现',
  `cash_num` varchar(255) default '' COMMENT '充值的会员卡卡号',
  `payment` decimal(10,2) default NULL,
  `addtime` int(11) default '0' COMMENT '记录产生时间',
  `userid` int(11) default '0' COMMENT '所属用户',
  `card_number` varchar(255) default '' COMMENT '流水号/后台充值的账号',
  `pay_status` int(11) default '0' COMMENT '支付状态',
  `order_number` varchar(255) default '' COMMENT '订单号',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='付款信息';

-- ----------------------------
-- Table structure for user_privileges
-- ----------------------------
DROP TABLE IF EXISTS `user_privileges`;
CREATE TABLE `user_privileges` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL COMMENT '权限名称',
  `sorting` int(11) default '0' COMMENT '排序',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户权限表';

-- ----------------------------
-- Table structure for user_prize_record
-- ----------------------------
DROP TABLE IF EXISTS `user_prize_record`;
CREATE TABLE `user_prize_record` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户id',
  `product_id` int(11) default '0' COMMENT '产品id',
  `phase_id` int(11) default '0' COMMENT '期次id',
  `lucky_number` varchar(255) default '' COMMENT '幸运号码',
  `addtime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户中奖记录';

-- ----------------------------
-- Table structure for visit_records
-- ----------------------------
DROP TABLE IF EXISTS `visit_records`;
CREATE TABLE `visit_records` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default '0' COMMENT '用户ID',
  `product_id` int(11) default '0' COMMENT '产品ID',
  `addtime` int(11) default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户浏览记录';

-- ----------------------------
-- Table structure for wx_card
-- ----------------------------
DROP TABLE IF EXISTS `wx_card`;
CREATE TABLE `wx_card` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID',
  `card_id` varchar(255) default '0' COMMENT '卡券ID',
  `reduce_cost` int(11) default '0' COMMENT '卡券面值',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='卡券';

-- ----------------------------
-- Table structure for wx_card_exchange_records
-- ----------------------------
DROP TABLE IF EXISTS `wx_card_exchange_records`;
CREATE TABLE `wx_card_exchange_records` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID',
  `user_id` int(11) default '0' COMMENT '用户ID',
  `card_id` varchar(255) default '' COMMENT '卡券ID',
  `coupon_id` int(11) default '0' COMMENT '优惠券ID',
  `reduce_cost` int(11) default '0' COMMENT '卡券面值',
  `wx_code` varchar(255) default '' COMMENT '卡券序列号',
  `addtime` int(11) default '0' COMMENT '产生时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='卡券兑换记录';

-- ----------------------------
-- Table structure for wx_msg_tpl
-- ----------------------------
DROP TABLE IF EXISTS `wx_msg_tpl`;
CREATE TABLE `wx_msg_tpl` (
  `flag` varchar(30) NOT NULL default '' COMMENT '标识',
  `name` varchar(20) NOT NULL default '' COMMENT '名称',
  `tpl_id` varchar(50) NOT NULL default '' COMMENT '微信消息模板id',
  `data` text NOT NULL COMMENT '模板数据json格式，{系统数据标识:{key:微信模板数据标识,color:数据颜色,content:内容}}',
  PRIMARY KEY  (`flag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信消息模板表';

-- ----------------------------
-- Table structure for wx_pay_info
-- ----------------------------
DROP TABLE IF EXISTS `wx_pay_info`;
CREATE TABLE `wx_pay_info` (
  `transaction_id` varchar(32) NOT NULL default '' COMMENT '微信支付订单号',
  `out_trade_no` varchar(32) NOT NULL default '' COMMENT '系统订单号',
  `time_end` varchar(14) NOT NULL default '' COMMENT '微信支付完成时间',
  `openid` varchar(128) NOT NULL default '' COMMENT '用户openid',
  `trade_type` varchar(16) NOT NULL default '' COMMENT '交易类型，JSAPI、NATIVE、APP',
  `bank_type` varchar(16) NOT NULL default '' COMMENT '付款银行',
  `total_fee` int(10) unsigned NOT NULL default '0' COMMENT '总金额，单位分',
  `fee_type` varchar(8) NOT NULL default '' COMMENT '货币种类',
  `cash_fee` int(10) unsigned NOT NULL default '0' COMMENT '现金支付金额，单位分',
  `cash_fee_type` varchar(16) NOT NULL default '' COMMENT '现金支付货币类型',
  `coupon_fee` int(10) unsigned NOT NULL default '0' COMMENT '代金券或立减优惠金额，单位分',
  `coupon_count` int(10) unsigned NOT NULL default '0' COMMENT '代金券或立减优惠使用数量',
  `coupon_ids` text NOT NULL COMMENT '代金券或立减优惠ID，多个ID以逗号分隔',
  `coupon_fees` text NOT NULL COMMENT '单个代金券或立减优惠支付金额，单位分，各金额以逗号分隔',
  `time` int(10) unsigned NOT NULL default '0' COMMENT '生成记录的时间',
  PRIMARY KEY  (`transaction_id`),
  KEY `order` (`out_trade_no`),
  KEY `time` (`time`,`time_end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信支付信息表';
