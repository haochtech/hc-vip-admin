<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL COMMENT '账号',
  `pwd` varchar(50) NOT NULL COMMENT '密码',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `state` int(11) NOT NULL DEFAULT '1' COMMENT '1.启用2.禁用',
  `uniacid` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '1.店员2.店长',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_account','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_account')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_account','account')) {pdo_query("ALTER TABLE ".tablename('zhvip_account')." ADD   `account` varchar(20) NOT NULL COMMENT '账号'");}
if(!pdo_fieldexists('zhvip_account','pwd')) {pdo_query("ALTER TABLE ".tablename('zhvip_account')." ADD   `pwd` varchar(50) NOT NULL COMMENT '密码'");}
if(!pdo_fieldexists('zhvip_account','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_account')." ADD   `store_id` int(11) NOT NULL COMMENT '门店id'");}
if(!pdo_fieldexists('zhvip_account','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_account')." ADD   `state` int(11) NOT NULL DEFAULT '1' COMMENT '1.启用2.禁用'");}
if(!pdo_fieldexists('zhvip_account','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_account')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_account','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_account')." ADD   `type` int(11) NOT NULL DEFAULT '1' COMMENT '1.店员2.店长'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(300) NOT NULL COMMENT '图片',
  `src` varchar(300) NOT NULL COMMENT '链接地址',
  `created_time` datetime NOT NULL COMMENT '创建时间',
  `orderby` int(4) NOT NULL COMMENT '排序',
  `status` int(4) NOT NULL COMMENT '状态1.启用，2禁用',
  `type` int(11) NOT NULL COMMENT '1首页幻灯片 2.开屏广告',
  `store_id` int(11) NOT NULL,
  `appid` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '幻灯片标题',
  `xcx_name` varchar(30) NOT NULL COMMENT '小程序名称',
  `uniacid` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `src2` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_ad','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_ad','logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `logo` varchar(300) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('zhvip_ad','src')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `src` varchar(300) NOT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('zhvip_ad','created_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `created_time` datetime NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('zhvip_ad','orderby')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `orderby` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_ad','status')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `status` int(4) NOT NULL COMMENT '状态1.启用，2禁用'");}
if(!pdo_fieldexists('zhvip_ad','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `type` int(11) NOT NULL COMMENT '1首页幻灯片 2.开屏广告'");}
if(!pdo_fieldexists('zhvip_ad','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_ad','appid')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('zhvip_ad','title')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `title` varchar(50) NOT NULL COMMENT '幻灯片标题'");}
if(!pdo_fieldexists('zhvip_ad','xcx_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `xcx_name` varchar(30) NOT NULL COMMENT '小程序名称'");}
if(!pdo_fieldexists('zhvip_ad','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_ad','item')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `item` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_ad','src2')) {pdo_query("ALTER TABLE ".tablename('zhvip_ad')." ADD   `src2` varchar(200) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `storeid` varchar(1000) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `from_user` varchar(100) NOT NULL DEFAULT '',
  `accountname` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `salt` varchar(10) NOT NULL DEFAULT '',
  `pwd` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pay_account` varchar(200) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:店长,2:店员',
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(15) NOT NULL,
  `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_admin','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_admin','weid')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号'");}
if(!pdo_fieldexists('zhvip_admin','storeid')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `storeid` varchar(1000) NOT NULL");}
if(!pdo_fieldexists('zhvip_admin','uid')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `uid` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('zhvip_admin','from_user')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `from_user` varchar(100) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('zhvip_admin','accountname')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `accountname` varchar(50) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('zhvip_admin','password')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `password` varchar(200) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('zhvip_admin','salt')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `salt` varchar(10) NOT NULL DEFAULT ''");}
if(!pdo_fieldexists('zhvip_admin','pwd')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `pwd` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_admin','mobile')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `mobile` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_admin','email')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `email` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_admin','username')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `username` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_admin','pay_account')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `pay_account` varchar(200) NOT NULL");}
if(!pdo_fieldexists('zhvip_admin','displayorder')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_admin','dateline')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `dateline` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('zhvip_admin','status')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态'");}
if(!pdo_fieldexists('zhvip_admin','role')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:店长,2:店员'");}
if(!pdo_fieldexists('zhvip_admin','lastvisit')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `lastvisit` int(10) unsigned NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('zhvip_admin','lastip')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `lastip` varchar(15) NOT NULL");}
if(!pdo_fieldexists('zhvip_admin','areaid')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id'");}
if(!pdo_fieldexists('zhvip_admin','is_admin_order')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `is_admin_order` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_admin','is_notice_order')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `is_notice_order` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_admin','is_notice_queue')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `is_notice_queue` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_admin','is_notice_service')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `is_notice_service` tinyint(1) unsigned NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_admin','is_notice_boss')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `is_notice_boss` tinyint(1) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('zhvip_admin','remark')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `remark` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注'");}
if(!pdo_fieldexists('zhvip_admin','lat')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度'");}
if(!pdo_fieldexists('zhvip_admin','lng')) {pdo_query("ALTER TABLE ".tablename('zhvip_admin')." ADD   `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_assess` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(11) NOT NULL COMMENT '商品',
  `store_id` int(11) NOT NULL,
  `spec` varchar(100) NOT NULL COMMENT '规格',
  `user_img` varchar(200) NOT NULL COMMENT '用户头像',
  `user_name` varchar(20) NOT NULL COMMENT '用户昵称',
  `order_num` varchar(30) NOT NULL COMMENT '订单号',
  `score` int(11) NOT NULL COMMENT '分数',
  `content` text NOT NULL COMMENT '评价内容',
  `img` text NOT NULL COMMENT '图片',
  `cerated_time` varchar(20) NOT NULL COMMENT '创建时间',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `uniacid` varchar(50) NOT NULL,
  `reply` varchar(1000) NOT NULL COMMENT '商家回复',
  `status` int(4) NOT NULL COMMENT '评价状态1，未回复，2已回复',
  `reply_time` datetime NOT NULL COMMENT '回复时间',
  `good_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_assess','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_assess','good_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `good_id` int(11) NOT NULL COMMENT '商品'");}
if(!pdo_fieldexists('zhvip_assess','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_assess','spec')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `spec` varchar(100) NOT NULL COMMENT '规格'");}
if(!pdo_fieldexists('zhvip_assess','user_img')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `user_img` varchar(200) NOT NULL COMMENT '用户头像'");}
if(!pdo_fieldexists('zhvip_assess','user_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `user_name` varchar(20) NOT NULL COMMENT '用户昵称'");}
if(!pdo_fieldexists('zhvip_assess','order_num')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `order_num` varchar(30) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('zhvip_assess','score')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `score` int(11) NOT NULL COMMENT '分数'");}
if(!pdo_fieldexists('zhvip_assess','content')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `content` text NOT NULL COMMENT '评价内容'");}
if(!pdo_fieldexists('zhvip_assess','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `img` text NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('zhvip_assess','cerated_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `cerated_time` varchar(20) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('zhvip_assess','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `user_id` int(11) NOT NULL COMMENT '用户ID'");}
if(!pdo_fieldexists('zhvip_assess','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_assess','reply')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `reply` varchar(1000) NOT NULL COMMENT '商家回复'");}
if(!pdo_fieldexists('zhvip_assess','status')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `status` int(4) NOT NULL COMMENT '评价状态1，未回复，2已回复'");}
if(!pdo_fieldexists('zhvip_assess','reply_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `reply_time` datetime NOT NULL COMMENT '回复时间'");}
if(!pdo_fieldexists('zhvip_assess','good_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_assess')." ADD   `good_name` varchar(20) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_coupons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '优惠券名称',
  `type` int(11) NOT NULL COMMENT '1.优惠券2.代金券',
  `full` int(11) NOT NULL COMMENT '满',
  `reduction` int(11) NOT NULL COMMENT '减',
  `start_time` varchar(20) NOT NULL COMMENT '开始时间',
  `end_time` varchar(20) NOT NULL COMMENT '结束时间',
  `store_id` int(11) NOT NULL COMMENT '商家id',
  `uniacid` int(11) NOT NULL,
  `details` varchar(100) NOT NULL,
  `level_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_coupons','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_coupons','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `name` varchar(20) NOT NULL COMMENT '优惠券名称'");}
if(!pdo_fieldexists('zhvip_coupons','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `type` int(11) NOT NULL COMMENT '1.优惠券2.代金券'");}
if(!pdo_fieldexists('zhvip_coupons','full')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `full` int(11) NOT NULL COMMENT '满'");}
if(!pdo_fieldexists('zhvip_coupons','reduction')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `reduction` int(11) NOT NULL COMMENT '减'");}
if(!pdo_fieldexists('zhvip_coupons','start_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `start_time` varchar(20) NOT NULL COMMENT '开始时间'");}
if(!pdo_fieldexists('zhvip_coupons','end_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `end_time` varchar(20) NOT NULL COMMENT '结束时间'");}
if(!pdo_fieldexists('zhvip_coupons','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `store_id` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('zhvip_coupons','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_coupons','details')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `details` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_coupons','level_type')) {pdo_query("ALTER TABLE ".tablename('zhvip_coupons')." ADD   `level_type` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_czhd` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `full` int(11) NOT NULL,
  `reduction` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_czhd','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_czhd')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_czhd','full')) {pdo_query("ALTER TABLE ".tablename('zhvip_czhd')." ADD   `full` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_czhd','reduction')) {pdo_query("ALTER TABLE ".tablename('zhvip_czhd')." ADD   `reduction` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_czhd','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_czhd')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_czorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `time` varchar(20) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `money2` decimal(10,2) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.待支付2已支付',
  `uniacid` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `note` varchar(50) NOT NULL,
  `pay_type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_czorder','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_czorder','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','code')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `code` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','form_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `form_id` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','money2')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `money2` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `state` int(11) NOT NULL COMMENT '1.待支付2已支付'");}
if(!pdo_fieldexists('zhvip_czorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','account_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `account_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','note')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `note` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_czorder','pay_type')) {pdo_query("ALTER TABLE ".tablename('zhvip_czorder')." ADD   `pay_type` varchar(10) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_dyj` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dyj_title` varchar(50) NOT NULL COMMENT '打印机标题',
  `dyj_id` varchar(50) NOT NULL COMMENT '打印机编号',
  `dyj_key` varchar(50) NOT NULL COMMENT '打印机key',
  `uniacid` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `mid` varchar(100) NOT NULL,
  `api` varchar(100) NOT NULL,
  `yy_id` varchar(20) NOT NULL,
  `token` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_dyj','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_dyj','dyj_title')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `dyj_title` varchar(50) NOT NULL COMMENT '打印机标题'");}
if(!pdo_fieldexists('zhvip_dyj','dyj_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `dyj_id` varchar(50) NOT NULL COMMENT '打印机编号'");}
if(!pdo_fieldexists('zhvip_dyj','dyj_key')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `dyj_key` varchar(50) NOT NULL COMMENT '打印机key'");}
if(!pdo_fieldexists('zhvip_dyj','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_dyj','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `type` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_dyj','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_dyj','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `state` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_dyj','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_dyj','mid')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `mid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_dyj','api')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `api` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_dyj','yy_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `yy_id` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_dyj','token')) {pdo_query("ALTER TABLE ".tablename('zhvip_dyj')." ADD   `token` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_formid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `form_id` varchar(200) NOT NULL,
  `time` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_formid','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_formid')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_formid','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_formid')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_formid','form_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_formid')." ADD   `form_id` varchar(200) NOT NULL");}
if(!pdo_fieldexists('zhvip_formid','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_formid')." ADD   `time` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_formid','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_formid')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `type_id` int(11) NOT NULL COMMENT '商品分类',
  `img` text NOT NULL COMMENT '商品图片',
  `money` decimal(10,2) NOT NULL COMMENT '售价',
  `money2` decimal(10,2) NOT NULL COMMENT '原价',
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT '1.上架2.下架',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `inventory` int(11) NOT NULL COMMENT '库存',
  `details` text NOT NULL COMMENT '详情',
  `store_id` int(11) NOT NULL COMMENT '商家id',
  `sales` int(11) NOT NULL COMMENT '销量',
  `logo` varchar(100) NOT NULL,
  `num` int(11) NOT NULL,
  `is_gg` int(11) NOT NULL DEFAULT '2' COMMENT '是否开启规格',
  `quantity` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_goods','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_goods','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `name` varchar(50) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('zhvip_goods','type_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `type_id` int(11) NOT NULL COMMENT '商品分类'");}
if(!pdo_fieldexists('zhvip_goods','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `img` text NOT NULL COMMENT '商品图片'");}
if(!pdo_fieldexists('zhvip_goods','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `money` decimal(10,2) NOT NULL COMMENT '售价'");}
if(!pdo_fieldexists('zhvip_goods','money2')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `money2` decimal(10,2) NOT NULL COMMENT '原价'");}
if(!pdo_fieldexists('zhvip_goods','is_show')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `is_show` int(11) NOT NULL DEFAULT '1' COMMENT '1.上架2.下架'");}
if(!pdo_fieldexists('zhvip_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('zhvip_goods','inventory')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `inventory` int(11) NOT NULL COMMENT '库存'");}
if(!pdo_fieldexists('zhvip_goods','details')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `details` text NOT NULL COMMENT '详情'");}
if(!pdo_fieldexists('zhvip_goods','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `store_id` int(11) NOT NULL COMMENT '商家id'");}
if(!pdo_fieldexists('zhvip_goods','sales')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `sales` int(11) NOT NULL COMMENT '销量'");}
if(!pdo_fieldexists('zhvip_goods','logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `logo` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_goods','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_goods','is_gg')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `is_gg` int(11) NOT NULL DEFAULT '2' COMMENT '是否开启规格'");}
if(!pdo_fieldexists('zhvip_goods','quantity')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `quantity` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_goods','t_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_goods')." ADD   `t_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_help` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL COMMENT '标题',
  `answer` text NOT NULL COMMENT '回答',
  `sort` int(4) NOT NULL COMMENT '排序',
  `uniacid` varchar(50) NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_help','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_help')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_help','question')) {pdo_query("ALTER TABLE ".tablename('zhvip_help')." ADD   `question` varchar(200) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('zhvip_help','answer')) {pdo_query("ALTER TABLE ".tablename('zhvip_help')." ADD   `answer` text NOT NULL COMMENT '回答'");}
if(!pdo_fieldexists('zhvip_help','sort')) {pdo_query("ALTER TABLE ".tablename('zhvip_help')." ADD   `sort` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_help','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_help')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_help','created_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_help')." ADD   `created_time` datetime NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_jfgoods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '名称',
  `img` varchar(100) NOT NULL,
  `money` int(11) NOT NULL COMMENT '价格',
  `type_id` int(11) NOT NULL COMMENT '分类id',
  `goods_details` text NOT NULL,
  `process_details` text NOT NULL,
  `attention_details` text NOT NULL,
  `number` int(11) NOT NULL COMMENT '数量',
  `time` varchar(50) NOT NULL COMMENT '期限',
  `is_open` int(11) NOT NULL COMMENT '1.开启2关闭',
  `type` int(11) NOT NULL COMMENT '1.余额2.实物',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `hb_moeny` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_jfgoods','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_jfgoods','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `name` varchar(50) NOT NULL COMMENT '名称'");}
if(!pdo_fieldexists('zhvip_jfgoods','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_jfgoods','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `money` int(11) NOT NULL COMMENT '价格'");}
if(!pdo_fieldexists('zhvip_jfgoods','type_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `type_id` int(11) NOT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('zhvip_jfgoods','goods_details')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `goods_details` text NOT NULL");}
if(!pdo_fieldexists('zhvip_jfgoods','process_details')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `process_details` text NOT NULL");}
if(!pdo_fieldexists('zhvip_jfgoods','attention_details')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `attention_details` text NOT NULL");}
if(!pdo_fieldexists('zhvip_jfgoods','number')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `number` int(11) NOT NULL COMMENT '数量'");}
if(!pdo_fieldexists('zhvip_jfgoods','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `time` varchar(50) NOT NULL COMMENT '期限'");}
if(!pdo_fieldexists('zhvip_jfgoods','is_open')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `is_open` int(11) NOT NULL COMMENT '1.开启2关闭'");}
if(!pdo_fieldexists('zhvip_jfgoods','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `type` int(11) NOT NULL COMMENT '1.余额2.实物'");}
if(!pdo_fieldexists('zhvip_jfgoods','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_jfgoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_jfgoods','hb_moeny')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfgoods')." ADD   `hb_moeny` decimal(10,2) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_jfmx` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `score` int(11) NOT NULL COMMENT '积分',
  `type` int(11) NOT NULL COMMENT '1.加2减',
  `cerated_time` varchar(20) NOT NULL,
  `note` varchar(20) NOT NULL COMMENT '备注',
  `uniacid` varchar(20) NOT NULL COMMENT '小程序id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_jfmx','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfmx')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_jfmx','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfmx')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('zhvip_jfmx','score')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfmx')." ADD   `score` int(11) NOT NULL COMMENT '积分'");}
if(!pdo_fieldexists('zhvip_jfmx','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfmx')." ADD   `type` int(11) NOT NULL COMMENT '1.加2减'");}
if(!pdo_fieldexists('zhvip_jfmx','cerated_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfmx')." ADD   `cerated_time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_jfmx','note')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfmx')." ADD   `note` varchar(20) NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('zhvip_jfmx','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfmx')." ADD   `uniacid` varchar(20) NOT NULL COMMENT '小程序id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_jfrecord` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `good_id` int(11) NOT NULL COMMENT '商品id',
  `time` varchar(20) NOT NULL COMMENT '兑换时间',
  `user_name` varchar(20) NOT NULL COMMENT '用户地址',
  `user_tel` varchar(20) NOT NULL COMMENT '用户电话',
  `address` varchar(200) NOT NULL COMMENT '地址',
  `note` varchar(20) NOT NULL,
  `integral` int(11) NOT NULL COMMENT '积分',
  `good_name` varchar(50) NOT NULL COMMENT '商品名称',
  `good_img` varchar(100) NOT NULL,
  `state` int(11) NOT NULL DEFAULT '2' COMMENT '1.未处理 2.已处理',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_jfrecord','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_jfrecord','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('zhvip_jfrecord','good_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `good_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('zhvip_jfrecord','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `time` varchar(20) NOT NULL COMMENT '兑换时间'");}
if(!pdo_fieldexists('zhvip_jfrecord','user_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `user_name` varchar(20) NOT NULL COMMENT '用户地址'");}
if(!pdo_fieldexists('zhvip_jfrecord','user_tel')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `user_tel` varchar(20) NOT NULL COMMENT '用户电话'");}
if(!pdo_fieldexists('zhvip_jfrecord','address')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `address` varchar(200) NOT NULL COMMENT '地址'");}
if(!pdo_fieldexists('zhvip_jfrecord','note')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `note` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_jfrecord','integral')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `integral` int(11) NOT NULL COMMENT '积分'");}
if(!pdo_fieldexists('zhvip_jfrecord','good_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `good_name` varchar(50) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('zhvip_jfrecord','good_img')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `good_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_jfrecord','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_jfrecord')." ADD   `state` int(11) NOT NULL DEFAULT '2' COMMENT '1.未处理 2.已处理'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_jftype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `img` varchar(100) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_jftype','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_jftype')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_jftype','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_jftype')." ADD   `name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_jftype','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_jftype')." ADD   `img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_jftype','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_jftype')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_jftype','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_jftype')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_level` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '等级名称',
  `img` varchar(200) NOT NULL COMMENT '等级背景',
  `details` text NOT NULL COMMENT '等级说明',
  `discount` decimal(10,1) NOT NULL COMMENT '折扣',
  `level` int(11) NOT NULL COMMENT '级别',
  `threshold` decimal(10,2) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `my_img` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_level','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_level','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD   `name` varchar(20) NOT NULL COMMENT '等级名称'");}
if(!pdo_fieldexists('zhvip_level','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD   `img` varchar(200) NOT NULL COMMENT '等级背景'");}
if(!pdo_fieldexists('zhvip_level','details')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD   `details` text NOT NULL COMMENT '等级说明'");}
if(!pdo_fieldexists('zhvip_level','discount')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD   `discount` decimal(10,1) NOT NULL COMMENT '折扣'");}
if(!pdo_fieldexists('zhvip_level','level')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD   `level` int(11) NOT NULL COMMENT '级别'");}
if(!pdo_fieldexists('zhvip_level','threshold')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD   `threshold` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_level','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_level','my_img')) {pdo_query("ALTER TABLE ".tablename('zhvip_level')." ADD   `my_img` varchar(200) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_mallset` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `freight` decimal(10,2) NOT NULL COMMENT '运费',
  `full` decimal(10,2) NOT NULL COMMENT '满多少包邮',
  `uniacid` int(11) NOT NULL,
  `is_zt` int(11) NOT NULL DEFAULT '2' COMMENT '是否开启自提',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_mallset','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_mallset')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_mallset','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_mallset')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_mallset','freight')) {pdo_query("ALTER TABLE ".tablename('zhvip_mallset')." ADD   `freight` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('zhvip_mallset','full')) {pdo_query("ALTER TABLE ".tablename('zhvip_mallset')." ADD   `full` decimal(10,2) NOT NULL COMMENT '满多少包邮'");}
if(!pdo_fieldexists('zhvip_mallset','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_mallset')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_mallset','is_zt')) {pdo_query("ALTER TABLE ".tablename('zhvip_mallset')." ADD   `is_zt` int(11) NOT NULL DEFAULT '2' COMMENT '是否开启自提'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_mynumcard` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `lq_time` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_mynumcard','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_mynumcard')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_mynumcard','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_mynumcard')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_mynumcard','card_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_mynumcard')." ADD   `card_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_mynumcard','number')) {pdo_query("ALTER TABLE ".tablename('zhvip_mynumcard')." ADD   `number` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_mynumcard','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_mynumcard')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_mynumcard','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_mynumcard')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_mynumcard','lq_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_mynumcard')." ADD   `lq_time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_mynumcard','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_mynumcard')." ADD   `type` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '标题',
  `title_color` varchar(20) NOT NULL COMMENT '标题选中颜色',
  `title_color2` varchar(20) NOT NULL COMMENT '标题未选中颜色',
  `logo` varchar(200) NOT NULL COMMENT '选中图片',
  `logo2` varchar(200) NOT NULL COMMENT '未选中图片',
  `url` varchar(200) NOT NULL COMMENT '跳转链接',
  `num` int(11) NOT NULL COMMENT '排序',
  `state` int(11) NOT NULL DEFAULT '1' COMMENT '1开启2关闭',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_nav','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_nav','title')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `title` varchar(20) NOT NULL COMMENT '标题'");}
if(!pdo_fieldexists('zhvip_nav','title_color')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `title_color` varchar(20) NOT NULL COMMENT '标题选中颜色'");}
if(!pdo_fieldexists('zhvip_nav','title_color2')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `title_color2` varchar(20) NOT NULL COMMENT '标题未选中颜色'");}
if(!pdo_fieldexists('zhvip_nav','logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `logo` varchar(200) NOT NULL COMMENT '选中图片'");}
if(!pdo_fieldexists('zhvip_nav','logo2')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `logo2` varchar(200) NOT NULL COMMENT '未选中图片'");}
if(!pdo_fieldexists('zhvip_nav','url')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `url` varchar(200) NOT NULL COMMENT '跳转链接'");}
if(!pdo_fieldexists('zhvip_nav','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_nav','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `state` int(11) NOT NULL DEFAULT '1' COMMENT '1开启2关闭'");}
if(!pdo_fieldexists('zhvip_nav','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_nav')." ADD   `uniacid` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_numcard` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `number` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `time` varchar(20) NOT NULL,
  `store_id` varchar(50) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1.次卡',
  `details` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_numcard','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_numcard','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard','number')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `number` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `store_id` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `type` int(11) NOT NULL COMMENT '1.次卡'");}
if(!pdo_fieldexists('zhvip_numcard','details')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard')." ADD   `details` text NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_numcard_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `card_id` int(11) NOT NULL COMMENT '次卡id',
  `time` varchar(20) NOT NULL COMMENT '时间',
  `uniacid` int(11) NOT NULL,
  `hx_id` int(11) NOT NULL COMMENT '核销员id',
  `num` int(11) NOT NULL COMMENT '次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_numcard_record','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard_record')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_numcard_record','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard_record')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('zhvip_numcard_record','card_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard_record')." ADD   `card_id` int(11) NOT NULL COMMENT '次卡id'");}
if(!pdo_fieldexists('zhvip_numcard_record','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard_record')." ADD   `time` varchar(20) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('zhvip_numcard_record','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard_record')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcard_record','hx_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard_record')." ADD   `hx_id` int(11) NOT NULL COMMENT '核销员id'");}
if(!pdo_fieldexists('zhvip_numcard_record','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcard_record')." ADD   `num` int(11) NOT NULL COMMENT '次数'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_numcardorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` varchar(20) NOT NULL,
  `code` varchar(100) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.待付款2.已付款',
  `money` decimal(10,2) NOT NULL,
  `card_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `pay_type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_numcardorder','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_numcardorder','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcardorder','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcardorder','code')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `code` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcardorder','form_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `form_id` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcardorder','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `state` int(11) NOT NULL COMMENT '1.待付款2.已付款'");}
if(!pdo_fieldexists('zhvip_numcardorder','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcardorder','card_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `card_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcardorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_numcardorder','pay_type')) {pdo_query("ALTER TABLE ".tablename('zhvip_numcardorder')." ADD   `pay_type` int(11) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_num` varchar(50) NOT NULL COMMENT '订单号',
  `price` decimal(10,2) NOT NULL COMMENT '总价',
  `money` decimal(10,2) NOT NULL COMMENT '付款金额',
  `preferential` decimal(10,2) NOT NULL COMMENT '折扣金额',
  `preferential2` decimal(10,2) NOT NULL COMMENT '优惠券',
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `time` varchar(20) NOT NULL COMMENT '下单时间',
  `uniacid` int(11) NOT NULL,
  `pay_type` int(11) NOT NULL COMMENT '1.微信支付2余额支付',
  `coupons_id` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT '2',
  `code` varchar(100) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `account_id` int(11) NOT NULL,
  `pay_type2` varchar(10) NOT NULL,
  `note` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_order','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_order','order_num')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `order_num` varchar(50) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('zhvip_order','price')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `price` decimal(10,2) NOT NULL COMMENT '总价'");}
if(!pdo_fieldexists('zhvip_order','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `money` decimal(10,2) NOT NULL COMMENT '付款金额'");}
if(!pdo_fieldexists('zhvip_order','preferential')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `preferential` decimal(10,2) NOT NULL COMMENT '折扣金额'");}
if(!pdo_fieldexists('zhvip_order','preferential2')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `preferential2` decimal(10,2) NOT NULL COMMENT '优惠券'");}
if(!pdo_fieldexists('zhvip_order','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_order','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_order','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `time` varchar(20) NOT NULL COMMENT '下单时间'");}
if(!pdo_fieldexists('zhvip_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_order','pay_type')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `pay_type` int(11) NOT NULL COMMENT '1.微信支付2余额支付'");}
if(!pdo_fieldexists('zhvip_order','coupons_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `coupons_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_order','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `state` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('zhvip_order','code')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `code` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_order','form_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `form_id` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_order','account_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `account_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_order','pay_type2')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `pay_type2` varchar(10) NOT NULL");}
if(!pdo_fieldexists('zhvip_order','note')) {pdo_query("ALTER TABLE ".tablename('zhvip_order')." ADD   `note` varchar(50) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_ordergoods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(300) NOT NULL COMMENT '商品图片',
  `number` int(11) NOT NULL COMMENT '数量',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `money` decimal(10,2) NOT NULL COMMENT '商品金额',
  `uniacid` varchar(50) NOT NULL,
  `good_id` int(11) NOT NULL COMMENT '商品id',
  `spec` varchar(50) NOT NULL COMMENT '规格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_ordergoods','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_ordergoods','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD   `img` varchar(300) NOT NULL COMMENT '商品图片'");}
if(!pdo_fieldexists('zhvip_ordergoods','number')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD   `number` int(11) NOT NULL COMMENT '数量'");}
if(!pdo_fieldexists('zhvip_ordergoods','order_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD   `order_id` int(11) NOT NULL COMMENT '订单id'");}
if(!pdo_fieldexists('zhvip_ordergoods','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD   `name` varchar(50) NOT NULL COMMENT '商品名称'");}
if(!pdo_fieldexists('zhvip_ordergoods','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD   `money` decimal(10,2) NOT NULL COMMENT '商品金额'");}
if(!pdo_fieldexists('zhvip_ordergoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD   `uniacid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_ordergoods','good_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD   `good_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('zhvip_ordergoods','spec')) {pdo_query("ALTER TABLE ".tablename('zhvip_ordergoods')." ADD   `spec` varchar(50) NOT NULL COMMENT '规格'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_qbmx` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `type` int(11) NOT NULL COMMENT '1.加2减',
  `time` varchar(20) NOT NULL COMMENT '创建时间',
  `note` varchar(20) NOT NULL COMMENT '备注',
  `uniacid` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_qbmx','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_qbmx')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_qbmx','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_qbmx')." ADD   `user_id` int(11) NOT NULL COMMENT '用户id'");}
if(!pdo_fieldexists('zhvip_qbmx','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_qbmx')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('zhvip_qbmx','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_qbmx')." ADD   `type` int(11) NOT NULL COMMENT '1.加2减'");}
if(!pdo_fieldexists('zhvip_qbmx','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_qbmx')." ADD   `time` varchar(20) NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('zhvip_qbmx','note')) {pdo_query("ALTER TABLE ".tablename('zhvip_qbmx')." ADD   `note` varchar(20) NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('zhvip_qbmx','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_qbmx')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_qbmx','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_qbmx')." ADD   `store_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_shopcar` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `spec` varchar(100) NOT NULL,
  `combination_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_shopcar','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shopcar')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_shopcar','good_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shopcar')." ADD   `good_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_shopcar','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shopcar')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_shopcar','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shopcar')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_shopcar','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_shopcar')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_shopcar','spec')) {pdo_query("ALTER TABLE ".tablename('zhvip_shopcar')." ADD   `spec` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_shopcar','combination_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shopcar')." ADD   `combination_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_shopcar','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_shopcar')." ADD   `money` decimal(10,2) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_shoporder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_num` varchar(100) NOT NULL COMMENT '订单号',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `price` decimal(10,2) NOT NULL COMMENT '原价',
  `preferential` decimal(10,2) NOT NULL COMMENT '折扣金额',
  `preferential2` decimal(10,2) NOT NULL COMMENT '优惠金额',
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `time` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `pay_type` int(11) NOT NULL COMMENT '付款方式',
  `coupons_id` int(11) NOT NULL COMMENT '优惠券id',
  `state` int(11) NOT NULL COMMENT '1.待支付2.已支付3.待配送4.配送中5.已完成6.已评价7.退款中8.退款通过9.退款拒绝',
  `code` varchar(100) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `note` varchar(100) NOT NULL COMMENT '备注',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `tel` varchar(20) NOT NULL COMMENT '电话',
  `user_name` varchar(20) NOT NULL COMMENT '姓名',
  `is_zt` int(11) NOT NULL COMMENT '1.是 2.不是 (自提)',
  `is_del` int(11) NOT NULL DEFAULT '2' COMMENT '1.删除 2.未删除',
  `pay_time` int(11) NOT NULL COMMENT '付款时间',
  `freight` decimal(10,2) NOT NULL COMMENT '运费',
  `kd_num` varchar(50) NOT NULL COMMENT '快递单号',
  `complete_time` varchar(20) NOT NULL COMMENT '完成时间',
  `kd_name` varchar(20) NOT NULL,
  `zt_time` varchar(20) NOT NULL,
  `form_id2` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_shoporder','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_shoporder','order_num')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `order_num` varchar(100) NOT NULL COMMENT '订单号'");}
if(!pdo_fieldexists('zhvip_shoporder','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `money` decimal(10,2) NOT NULL COMMENT '金额'");}
if(!pdo_fieldexists('zhvip_shoporder','price')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `price` decimal(10,2) NOT NULL COMMENT '原价'");}
if(!pdo_fieldexists('zhvip_shoporder','preferential')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `preferential` decimal(10,2) NOT NULL COMMENT '折扣金额'");}
if(!pdo_fieldexists('zhvip_shoporder','preferential2')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `preferential2` decimal(10,2) NOT NULL COMMENT '优惠金额'");}
if(!pdo_fieldexists('zhvip_shoporder','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_shoporder','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_shoporder','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_shoporder','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_shoporder','pay_type')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `pay_type` int(11) NOT NULL COMMENT '付款方式'");}
if(!pdo_fieldexists('zhvip_shoporder','coupons_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `coupons_id` int(11) NOT NULL COMMENT '优惠券id'");}
if(!pdo_fieldexists('zhvip_shoporder','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `state` int(11) NOT NULL COMMENT '1.待支付2.已支付3.待配送4.配送中5.已完成6.已评价7.退款中8.退款通过9.退款拒绝'");}
if(!pdo_fieldexists('zhvip_shoporder','code')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `code` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_shoporder','form_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `form_id` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_shoporder','note')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `note` varchar(100) NOT NULL COMMENT '备注'");}
if(!pdo_fieldexists('zhvip_shoporder','address')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `address` varchar(100) NOT NULL COMMENT '地址'");}
if(!pdo_fieldexists('zhvip_shoporder','tel')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `tel` varchar(20) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('zhvip_shoporder','user_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `user_name` varchar(20) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('zhvip_shoporder','is_zt')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `is_zt` int(11) NOT NULL COMMENT '1.是 2.不是 (自提)'");}
if(!pdo_fieldexists('zhvip_shoporder','is_del')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `is_del` int(11) NOT NULL DEFAULT '2' COMMENT '1.删除 2.未删除'");}
if(!pdo_fieldexists('zhvip_shoporder','pay_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `pay_time` int(11) NOT NULL COMMENT '付款时间'");}
if(!pdo_fieldexists('zhvip_shoporder','freight')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `freight` decimal(10,2) NOT NULL COMMENT '运费'");}
if(!pdo_fieldexists('zhvip_shoporder','kd_num')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `kd_num` varchar(50) NOT NULL COMMENT '快递单号'");}
if(!pdo_fieldexists('zhvip_shoporder','complete_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `complete_time` varchar(20) NOT NULL COMMENT '完成时间'");}
if(!pdo_fieldexists('zhvip_shoporder','kd_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `kd_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_shoporder','zt_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `zt_time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_shoporder','form_id2')) {pdo_query("ALTER TABLE ".tablename('zhvip_shoporder')." ADD   `form_id2` varchar(100) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_spec` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '规格名称',
  `good_id` int(11) NOT NULL COMMENT '商品id',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_spec','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_spec','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec')." ADD   `name` varchar(20) NOT NULL COMMENT '规格名称'");}
if(!pdo_fieldexists('zhvip_spec','good_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec')." ADD   `good_id` int(11) NOT NULL COMMENT '商品id'");}
if(!pdo_fieldexists('zhvip_spec','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_spec','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_spec_combination` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `money` decimal(10,2) NOT NULL,
  `combination` varchar(50) NOT NULL,
  `number` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_spec_combination','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_combination')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_spec_combination','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_combination')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_spec_combination','combination')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_combination')." ADD   `combination` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_spec_combination','number')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_combination')." ADD   `number` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_spec_combination','good_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_combination')." ADD   `good_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_spec_val` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '规格属性名称',
  `spec_id` int(11) NOT NULL COMMENT '规格id',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_spec_val','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_val')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_spec_val','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_val')." ADD   `name` varchar(50) NOT NULL COMMENT '规格属性名称'");}
if(!pdo_fieldexists('zhvip_spec_val','spec_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_val')." ADD   `spec_id` int(11) NOT NULL COMMENT '规格id'");}
if(!pdo_fieldexists('zhvip_spec_val','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_val')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_spec_val','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_val')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_spec_val','good_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_spec_val')." ADD   `good_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_stinfo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `pwd` varchar(20) NOT NULL COMMENT '密码',
  `state` int(11) NOT NULL COMMENT '1.绑定2.未绑定',
  `term` int(11) NOT NULL COMMENT '期限',
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_stinfo','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_stinfo')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_stinfo','code')) {pdo_query("ALTER TABLE ".tablename('zhvip_stinfo')." ADD   `code` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_stinfo','pwd')) {pdo_query("ALTER TABLE ".tablename('zhvip_stinfo')." ADD   `pwd` varchar(20) NOT NULL COMMENT '密码'");}
if(!pdo_fieldexists('zhvip_stinfo','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_stinfo')." ADD   `state` int(11) NOT NULL COMMENT '1.绑定2.未绑定'");}
if(!pdo_fieldexists('zhvip_stinfo','term')) {pdo_query("ALTER TABLE ".tablename('zhvip_stinfo')." ADD   `term` int(11) NOT NULL COMMENT '期限'");}
if(!pdo_fieldexists('zhvip_stinfo','type_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_stinfo')." ADD   `type_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_stlist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` varchar(20) NOT NULL COMMENT '时间',
  `number` int(11) NOT NULL COMMENT '数量',
  `term` int(11) NOT NULL COMMENT '期限',
  `uniacid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_stlist','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_stlist')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_stlist','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_stlist')." ADD   `time` varchar(20) NOT NULL COMMENT '时间'");}
if(!pdo_fieldexists('zhvip_stlist','number')) {pdo_query("ALTER TABLE ".tablename('zhvip_stlist')." ADD   `number` int(11) NOT NULL COMMENT '数量'");}
if(!pdo_fieldexists('zhvip_stlist','term')) {pdo_query("ALTER TABLE ".tablename('zhvip_stlist')." ADD   `term` int(11) NOT NULL COMMENT '期限'");}
if(!pdo_fieldexists('zhvip_stlist','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_stlist')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_stlist','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_stlist')." ADD   `name` varchar(20) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_store` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '商家名称',
  `logo` varchar(200) NOT NULL COMMENT '商家logo',
  `address` varchar(200) NOT NULL COMMENT '商家地址',
  `tel` varchar(20) NOT NULL COMMENT '电话',
  `coordinates` varchar(50) NOT NULL COMMENT '坐标',
  `wallet` decimal(10,2) NOT NULL COMMENT '钱包',
  `username` varchar(20) NOT NULL COMMENT '账号',
  `password` varchar(20) NOT NULL COMMENT '密码',
  `is_default` int(11) NOT NULL DEFAULT '2' COMMENT '1.是2.否',
  `num` int(11) NOT NULL COMMENT '排序',
  `sentiment` int(11) NOT NULL COMMENT '人气',
  `uniacid` int(11) NOT NULL,
  `announcement` varchar(200) NOT NULL COMMENT '公告',
  `appid` varchar(20) NOT NULL,
  `xcx_name` varchar(20) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `md_img` varchar(100) NOT NULL,
  `md_img2` varchar(100) NOT NULL,
  `cz_img` varchar(300) NOT NULL,
  `sms_tel` varchar(20) NOT NULL,
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_store','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_store','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `name` varchar(20) NOT NULL COMMENT '商家名称'");}
if(!pdo_fieldexists('zhvip_store','logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `logo` varchar(200) NOT NULL COMMENT '商家logo'");}
if(!pdo_fieldexists('zhvip_store','address')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `address` varchar(200) NOT NULL COMMENT '商家地址'");}
if(!pdo_fieldexists('zhvip_store','tel')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `tel` varchar(20) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('zhvip_store','coordinates')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `coordinates` varchar(50) NOT NULL COMMENT '坐标'");}
if(!pdo_fieldexists('zhvip_store','wallet')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `wallet` decimal(10,2) NOT NULL COMMENT '钱包'");}
if(!pdo_fieldexists('zhvip_store','username')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `username` varchar(20) NOT NULL COMMENT '账号'");}
if(!pdo_fieldexists('zhvip_store','password')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `password` varchar(20) NOT NULL COMMENT '密码'");}
if(!pdo_fieldexists('zhvip_store','is_default')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `is_default` int(11) NOT NULL DEFAULT '2' COMMENT '1.是2.否'");}
if(!pdo_fieldexists('zhvip_store','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_store','sentiment')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `sentiment` int(11) NOT NULL COMMENT '人气'");}
if(!pdo_fieldexists('zhvip_store','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_store','announcement')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `announcement` varchar(200) NOT NULL COMMENT '公告'");}
if(!pdo_fieldexists('zhvip_store','appid')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `appid` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_store','xcx_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `xcx_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_store','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `type` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_store','md_img')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `md_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_store','md_img2')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `md_img2` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_store','cz_img')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `cz_img` varchar(300) NOT NULL");}
if(!pdo_fieldexists('zhvip_store','sms_tel')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `sms_tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_store','admin_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_store')." ADD   `admin_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_storead` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(300) NOT NULL COMMENT '图片',
  `src` varchar(300) NOT NULL COMMENT '链接地址',
  `created_time` datetime NOT NULL COMMENT '创建时间',
  `orderby` int(4) NOT NULL COMMENT '排序',
  `status` int(4) NOT NULL COMMENT '状态1.启用，2禁用',
  `store_id` int(11) NOT NULL,
  `appid` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '幻灯片标题',
  `xcx_name` varchar(30) NOT NULL COMMENT '小程序名称',
  `uniacid` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `src2` varchar(200) NOT NULL COMMENT '外部',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_storead','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_storead','logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `logo` varchar(300) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('zhvip_storead','src')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `src` varchar(300) NOT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('zhvip_storead','created_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `created_time` datetime NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('zhvip_storead','orderby')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `orderby` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_storead','status')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `status` int(4) NOT NULL COMMENT '状态1.启用，2禁用'");}
if(!pdo_fieldexists('zhvip_storead','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_storead','appid')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('zhvip_storead','title')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `title` varchar(50) NOT NULL COMMENT '幻灯片标题'");}
if(!pdo_fieldexists('zhvip_storead','xcx_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `xcx_name` varchar(30) NOT NULL COMMENT '小程序名称'");}
if(!pdo_fieldexists('zhvip_storead','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_storead','item')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `item` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_storead','src2')) {pdo_query("ALTER TABLE ".tablename('zhvip_storead')." ADD   `src2` varchar(200) NOT NULL COMMENT '外部'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_system` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(100) NOT NULL,
  `appsecret` varchar(100) NOT NULL,
  `mchid` varchar(20) NOT NULL COMMENT '商户号',
  `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥',
  `url_name` varchar(20) NOT NULL COMMENT '后台名称',
  `details` text NOT NULL COMMENT '关于我们',
  `url_logo` varchar(100) NOT NULL COMMENT '后台logo',
  `link_name` varchar(20) NOT NULL COMMENT '平台名称',
  `link_logo` varchar(100) NOT NULL COMMENT '平台logo',
  `link_tel` varchar(20) NOT NULL COMMENT '平台电话',
  `link_color` varchar(20) NOT NULL COMMENT '平台颜色 ',
  `bq_name` varchar(20) NOT NULL COMMENT '版权名称',
  `bq_logo` varchar(100) NOT NULL COMMENT '版权logo',
  `support` varchar(20) NOT NULL COMMENT '技术支持',
  `tz_appid` varchar(100) NOT NULL COMMENT '跳转appid',
  `tz_name` varchar(20) NOT NULL COMMENT '跳转名称',
  `uniacid` int(11) NOT NULL,
  `mapkey` varchar(100) NOT NULL,
  `appkey` varchar(50) NOT NULL,
  `tpl_id` varchar(50) NOT NULL,
  `is_sms` int(11) NOT NULL DEFAULT '2' COMMENT '1.开启2关闭',
  `is_yue` int(11) NOT NULL DEFAULT '2' COMMENT '1.开启2.关闭',
  `tid` varchar(200) NOT NULL COMMENT '客户买单通知',
  `tid2` varchar(200) NOT NULL COMMENT '客户开卡通知',
  `follow` varchar(200) NOT NULL,
  `opencard` int(11) NOT NULL,
  `integral` int(11) NOT NULL,
  `is_jf` int(11) NOT NULL DEFAULT '1',
  `is_jfpay` int(11) NOT NULL DEFAULT '1',
  `jf_proportion` int(11) NOT NULL DEFAULT '10',
  `apiclient_cert` text NOT NULL,
  `apiclient_key` text NOT NULL,
  `tid3` varchar(200) NOT NULL,
  `model` int(11) NOT NULL DEFAULT '2',
  `mr_logo` varchar(200) NOT NULL,
  `qhmd_img` varchar(100) NOT NULL,
  `qhmd_name` varchar(20) NOT NULL,
  `qhmd_url` varchar(100) NOT NULL,
  `qhmd_type` int(11) NOT NULL,
  `qhmd_url2` varchar(100) NOT NULL,
  `qhmd_appid` varchar(50) NOT NULL,
  `qhmd_appidname` varchar(20) NOT NULL,
  `is_sc` int(11) NOT NULL DEFAULT '2',
  `vip_qx` int(11) NOT NULL DEFAULT '2',
  `vip_xy` text NOT NULL,
  `md_xs` int(11) NOT NULL DEFAULT '1',
  `is_stk` int(11) NOT NULL DEFAULT '1',
  `sms_tel` varchar(20) NOT NULL,
  `tpl2_id` varchar(50) NOT NULL,
  `tpl3_id` varchar(50) NOT NULL,
  `tid4` varchar(100) NOT NULL,
  `is_ck` int(11) NOT NULL DEFAULT '1',
  `sj_tid` varchar(200) NOT NULL,
  `kc_tid` varchar(100) NOT NULL,
  `yue_tid` varchar(100) NOT NULL,
  `jf_tid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_system','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_system','appid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `appid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','appsecret')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `appsecret` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','mchid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `mchid` varchar(20) NOT NULL COMMENT '商户号'");}
if(!pdo_fieldexists('zhvip_system','wxkey')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `wxkey` varchar(100) NOT NULL COMMENT '商户秘钥'");}
if(!pdo_fieldexists('zhvip_system','url_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `url_name` varchar(20) NOT NULL COMMENT '后台名称'");}
if(!pdo_fieldexists('zhvip_system','details')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `details` text NOT NULL COMMENT '关于我们'");}
if(!pdo_fieldexists('zhvip_system','url_logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `url_logo` varchar(100) NOT NULL COMMENT '后台logo'");}
if(!pdo_fieldexists('zhvip_system','link_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `link_name` varchar(20) NOT NULL COMMENT '平台名称'");}
if(!pdo_fieldexists('zhvip_system','link_logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `link_logo` varchar(100) NOT NULL COMMENT '平台logo'");}
if(!pdo_fieldexists('zhvip_system','link_tel')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `link_tel` varchar(20) NOT NULL COMMENT '平台电话'");}
if(!pdo_fieldexists('zhvip_system','link_color')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `link_color` varchar(20) NOT NULL COMMENT '平台颜色 '");}
if(!pdo_fieldexists('zhvip_system','bq_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `bq_name` varchar(20) NOT NULL COMMENT '版权名称'");}
if(!pdo_fieldexists('zhvip_system','bq_logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `bq_logo` varchar(100) NOT NULL COMMENT '版权logo'");}
if(!pdo_fieldexists('zhvip_system','support')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `support` varchar(20) NOT NULL COMMENT '技术支持'");}
if(!pdo_fieldexists('zhvip_system','tz_appid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tz_appid` varchar(100) NOT NULL COMMENT '跳转appid'");}
if(!pdo_fieldexists('zhvip_system','tz_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tz_name` varchar(20) NOT NULL COMMENT '跳转名称'");}
if(!pdo_fieldexists('zhvip_system','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','mapkey')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `mapkey` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','appkey')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `appkey` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','tpl_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tpl_id` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','is_sms')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `is_sms` int(11) NOT NULL DEFAULT '2' COMMENT '1.开启2关闭'");}
if(!pdo_fieldexists('zhvip_system','is_yue')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `is_yue` int(11) NOT NULL DEFAULT '2' COMMENT '1.开启2.关闭'");}
if(!pdo_fieldexists('zhvip_system','tid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tid` varchar(200) NOT NULL COMMENT '客户买单通知'");}
if(!pdo_fieldexists('zhvip_system','tid2')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tid2` varchar(200) NOT NULL COMMENT '客户开卡通知'");}
if(!pdo_fieldexists('zhvip_system','follow')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `follow` varchar(200) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','opencard')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `opencard` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','integral')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `integral` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','is_jf')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `is_jf` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_system','is_jfpay')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `is_jfpay` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_system','jf_proportion')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `jf_proportion` int(11) NOT NULL DEFAULT '10'");}
if(!pdo_fieldexists('zhvip_system','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `apiclient_cert` text NOT NULL");}
if(!pdo_fieldexists('zhvip_system','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `apiclient_key` text NOT NULL");}
if(!pdo_fieldexists('zhvip_system','tid3')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tid3` varchar(200) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','model')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `model` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('zhvip_system','mr_logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `mr_logo` varchar(200) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','qhmd_img')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `qhmd_img` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','qhmd_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `qhmd_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','qhmd_url')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `qhmd_url` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','qhmd_type')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `qhmd_type` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','qhmd_url2')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `qhmd_url2` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','qhmd_appid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `qhmd_appid` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','qhmd_appidname')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `qhmd_appidname` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','is_sc')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `is_sc` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('zhvip_system','vip_qx')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `vip_qx` int(11) NOT NULL DEFAULT '2'");}
if(!pdo_fieldexists('zhvip_system','vip_xy')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `vip_xy` text NOT NULL");}
if(!pdo_fieldexists('zhvip_system','md_xs')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `md_xs` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_system','is_stk')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `is_stk` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_system','sms_tel')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `sms_tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','tpl2_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tpl2_id` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','tpl3_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tpl3_id` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','tid4')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `tid4` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','is_ck')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `is_ck` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_system','sj_tid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `sj_tid` varchar(200) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','kc_tid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `kc_tid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','yue_tid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `yue_tid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_system','jf_tid')) {pdo_query("ALTER TABLE ".tablename('zhvip_system')." ADD   `jf_tid` varchar(100) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_timeorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `day` int(11) NOT NULL,
  `state` int(11) NOT NULL COMMENT '1.未付款2.已付款',
  `code` varchar(50) NOT NULL,
  `form_id` varchar(50) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `time` varchar(20) NOT NULL,
  `pay_time` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_timeorder','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_timeorder','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_timeorder','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_timeorder','day')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `day` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_timeorder','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `state` int(11) NOT NULL COMMENT '1.未付款2.已付款'");}
if(!pdo_fieldexists('zhvip_timeorder','code')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `code` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_timeorder','form_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `form_id` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_timeorder','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_timeorder','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `time` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_timeorder','pay_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_timeorder')." ADD   `pay_time` varchar(20) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_topnav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(300) NOT NULL COMMENT '图片',
  `src` varchar(300) NOT NULL COMMENT '链接地址',
  `created_time` datetime NOT NULL COMMENT '创建时间',
  `orderby` int(4) NOT NULL COMMENT '排序',
  `status` int(4) NOT NULL COMMENT '状态1.启用，2禁用',
  `type` int(11) NOT NULL COMMENT '1首页幻灯片 2.开屏广告',
  `store_id` int(11) NOT NULL,
  `appid` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '幻灯片标题',
  `xcx_name` varchar(30) NOT NULL COMMENT '小程序名称',
  `uniacid` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `src2` varchar(200) NOT NULL COMMENT '外部',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_topnav','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_topnav','logo')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `logo` varchar(300) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('zhvip_topnav','src')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `src` varchar(300) NOT NULL COMMENT '链接地址'");}
if(!pdo_fieldexists('zhvip_topnav','created_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `created_time` datetime NOT NULL COMMENT '创建时间'");}
if(!pdo_fieldexists('zhvip_topnav','orderby')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `orderby` int(4) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_topnav','status')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `status` int(4) NOT NULL COMMENT '状态1.启用，2禁用'");}
if(!pdo_fieldexists('zhvip_topnav','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `type` int(11) NOT NULL COMMENT '1首页幻灯片 2.开屏广告'");}
if(!pdo_fieldexists('zhvip_topnav','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `store_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_topnav','appid')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `appid` varchar(30) NOT NULL");}
if(!pdo_fieldexists('zhvip_topnav','title')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `title` varchar(50) NOT NULL COMMENT '幻灯片标题'");}
if(!pdo_fieldexists('zhvip_topnav','xcx_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `xcx_name` varchar(30) NOT NULL COMMENT '小程序名称'");}
if(!pdo_fieldexists('zhvip_topnav','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_topnav','item')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `item` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_topnav','src2')) {pdo_query("ALTER TABLE ".tablename('zhvip_topnav')." ADD   `src2` varchar(200) NOT NULL COMMENT '外部'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `state` int(11) NOT NULL DEFAULT '1',
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_type','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_type')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_type','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_type')." ADD   `name` varchar(50) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('zhvip_type','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_type')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_type')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('zhvip_type','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_type')." ADD   `state` int(11) NOT NULL DEFAULT '1'");}
if(!pdo_fieldexists('zhvip_type','store_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_type')." ADD   `store_id` int(11) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_type2` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL COMMENT '分类名称',
  `num` int(11) NOT NULL COMMENT '排序',
  `uniacid` int(11) NOT NULL COMMENT '小程序id',
  `img` varchar(100) NOT NULL COMMENT '图片',
  `type_id` int(11) NOT NULL COMMENT '分类id',
  `state` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_type2','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_type2')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_type2','type_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_type2')." ADD   `type_name` varchar(50) NOT NULL COMMENT '分类名称'");}
if(!pdo_fieldexists('zhvip_type2','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_type2')." ADD   `num` int(11) NOT NULL COMMENT '排序'");}
if(!pdo_fieldexists('zhvip_type2','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_type2')." ADD   `uniacid` int(11) NOT NULL COMMENT '小程序id'");}
if(!pdo_fieldexists('zhvip_type2','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_type2')." ADD   `img` varchar(100) NOT NULL COMMENT '图片'");}
if(!pdo_fieldexists('zhvip_type2','type_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_type2')." ADD   `type_id` int(11) NOT NULL COMMENT '分类id'");}
if(!pdo_fieldexists('zhvip_type2','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_type2')." ADD   `state` int(11) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL,
  `img` varchar(200) NOT NULL,
  `time` varchar(20) NOT NULL COMMENT '注册时间',
  `nickname` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `tel` varchar(20) NOT NULL COMMENT '电话',
  `birthday` varchar(20) NOT NULL COMMENT '生日',
  `address` varchar(200) NOT NULL COMMENT '地址',
  `wallet` decimal(10,2) NOT NULL COMMENT '钱包',
  `integral` int(11) NOT NULL COMMENT '积分',
  `email` varchar(30) NOT NULL COMMENT '邮箱',
  `education` varchar(20) NOT NULL COMMENT '学历',
  `industry` varchar(20) NOT NULL COMMENT '行业',
  `hobby` varchar(20) NOT NULL COMMENT '爱好',
  `grade` int(11) NOT NULL COMMENT '等级',
  `vip_code` varchar(20) NOT NULL COMMENT '会员卡号',
  `code_time` int(11) NOT NULL COMMENT '开卡/升卡时间',
  `uniacid` int(11) NOT NULL,
  `vip_number` varchar(20) NOT NULL,
  `cumulative` decimal(10,2) NOT NULL COMMENT '总累计金额',
  `level_cumulative` decimal(10,2) NOT NULL COMMENT '等级累计金额',
  `vip_time` int(11) NOT NULL,
  `note` varchar(100) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_user','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_user','openid')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `openid` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_user','img')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `img` varchar(200) NOT NULL");}
if(!pdo_fieldexists('zhvip_user','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `time` varchar(20) NOT NULL COMMENT '注册时间'");}
if(!pdo_fieldexists('zhvip_user','nickname')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `nickname` varchar(20) CHARACTER SET utf8mb4 NOT NULL");}
if(!pdo_fieldexists('zhvip_user','name')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `name` varchar(20) NOT NULL COMMENT '姓名'");}
if(!pdo_fieldexists('zhvip_user','tel')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `tel` varchar(20) NOT NULL COMMENT '电话'");}
if(!pdo_fieldexists('zhvip_user','birthday')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `birthday` varchar(20) NOT NULL COMMENT '生日'");}
if(!pdo_fieldexists('zhvip_user','address')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `address` varchar(200) NOT NULL COMMENT '地址'");}
if(!pdo_fieldexists('zhvip_user','wallet')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `wallet` decimal(10,2) NOT NULL COMMENT '钱包'");}
if(!pdo_fieldexists('zhvip_user','integral')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `integral` int(11) NOT NULL COMMENT '积分'");}
if(!pdo_fieldexists('zhvip_user','email')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `email` varchar(30) NOT NULL COMMENT '邮箱'");}
if(!pdo_fieldexists('zhvip_user','education')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `education` varchar(20) NOT NULL COMMENT '学历'");}
if(!pdo_fieldexists('zhvip_user','industry')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `industry` varchar(20) NOT NULL COMMENT '行业'");}
if(!pdo_fieldexists('zhvip_user','hobby')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `hobby` varchar(20) NOT NULL COMMENT '爱好'");}
if(!pdo_fieldexists('zhvip_user','grade')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `grade` int(11) NOT NULL COMMENT '等级'");}
if(!pdo_fieldexists('zhvip_user','vip_code')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `vip_code` varchar(20) NOT NULL COMMENT '会员卡号'");}
if(!pdo_fieldexists('zhvip_user','code_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `code_time` int(11) NOT NULL COMMENT '开卡/升卡时间'");}
if(!pdo_fieldexists('zhvip_user','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `uniacid` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_user','vip_number')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `vip_number` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_user','cumulative')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `cumulative` decimal(10,2) NOT NULL COMMENT '总累计金额'");}
if(!pdo_fieldexists('zhvip_user','level_cumulative')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `level_cumulative` decimal(10,2) NOT NULL COMMENT '等级累计金额'");}
if(!pdo_fieldexists('zhvip_user','vip_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `vip_time` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_user','note')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `note` varchar(100) NOT NULL");}
if(!pdo_fieldexists('zhvip_user','type')) {pdo_query("ALTER TABLE ".tablename('zhvip_user')." ADD   `type` int(11) NOT NULL DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_useradd` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `is_default` int(11) NOT NULL COMMENT '1.是 2.不是 (默认)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_useradd','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_useradd')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_useradd','address')) {pdo_query("ALTER TABLE ".tablename('zhvip_useradd')." ADD   `address` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_useradd','area')) {pdo_query("ALTER TABLE ".tablename('zhvip_useradd')." ADD   `area` varchar(50) NOT NULL");}
if(!pdo_fieldexists('zhvip_useradd','user_name')) {pdo_query("ALTER TABLE ".tablename('zhvip_useradd')." ADD   `user_name` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_useradd','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_useradd')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_useradd','tel')) {pdo_query("ALTER TABLE ".tablename('zhvip_useradd')." ADD   `tel` varchar(20) NOT NULL");}
if(!pdo_fieldexists('zhvip_useradd','is_default')) {pdo_query("ALTER TABLE ".tablename('zhvip_useradd')." ADD   `is_default` int(11) NOT NULL COMMENT '1.是 2.不是 (默认)'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_usercoupons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `coupons_id` int(11) NOT NULL,
  `time` varchar(20) NOT NULL COMMENT '领取时间',
  `use_time` varchar(20) NOT NULL COMMENT '使用时间',
  `state` int(11) NOT NULL COMMENT '1.使用2.未使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_usercoupons','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_usercoupons')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_usercoupons','user_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_usercoupons')." ADD   `user_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_usercoupons','coupons_id')) {pdo_query("ALTER TABLE ".tablename('zhvip_usercoupons')." ADD   `coupons_id` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_usercoupons','time')) {pdo_query("ALTER TABLE ".tablename('zhvip_usercoupons')." ADD   `time` varchar(20) NOT NULL COMMENT '领取时间'");}
if(!pdo_fieldexists('zhvip_usercoupons','use_time')) {pdo_query("ALTER TABLE ".tablename('zhvip_usercoupons')." ADD   `use_time` varchar(20) NOT NULL COMMENT '使用时间'");}
if(!pdo_fieldexists('zhvip_usercoupons','state')) {pdo_query("ALTER TABLE ".tablename('zhvip_usercoupons')." ADD   `state` int(11) NOT NULL COMMENT '1.使用2.未使用'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_zhvip_vipset` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('zhvip_vipset','id')) {pdo_query("ALTER TABLE ".tablename('zhvip_vipset')." ADD 
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('zhvip_vipset','days')) {pdo_query("ALTER TABLE ".tablename('zhvip_vipset')." ADD   `days` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_vipset','money')) {pdo_query("ALTER TABLE ".tablename('zhvip_vipset')." ADD   `money` decimal(10,2) NOT NULL");}
if(!pdo_fieldexists('zhvip_vipset','num')) {pdo_query("ALTER TABLE ".tablename('zhvip_vipset')." ADD   `num` int(11) NOT NULL");}
if(!pdo_fieldexists('zhvip_vipset','uniacid')) {pdo_query("ALTER TABLE ".tablename('zhvip_vipset')." ADD   `uniacid` int(11) NOT NULL");}
