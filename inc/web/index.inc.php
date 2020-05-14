<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$time=date("Y-m-d");
$time="'%$time%'";
$order = "select sum(money) as total from " . tablename("zhvip_order")." WHERE time LIKE ".$time." and uniacid=".$_W['uniacid']." and state=2";
$order = pdo_fetch($order);//今天的买单销售额

$order2 = "select sum(money) as total from " . tablename("zhvip_order")." WHERE time LIKE ".$time." and uniacid=".$_W['uniacid']." and state=2 and (pay_type=1 || (pay_type2!='会员卡扣款' and pay_type2!=''))";
$order2 = pdo_fetch($order2);//今天的实际收入

$czorder = "select sum(money) as total from " . tablename("zhvip_czorder")." WHERE time LIKE ".$time." and uniacid=".$_W['uniacid']." and state=2";
$czorder = pdo_fetch($czorder);//今天的充值
$czorder2 = "select sum(money2) as total from " . tablename("zhvip_czorder")." WHERE time LIKE ".$time." and uniacid=".$_W['uniacid']." and state=2";
$czorder2 = pdo_fetch($czorder2);//今天的充值


$shoporder = "select sum(money) as total from " . tablename("zhvip_shoporder")." WHERE from_unixtime(pay_time) LIKE ".$time." and uniacid=".$_W['uniacid']." and state in (4,5,8)";
$shoporder = pdo_fetch($shoporder);//今天的商城订单
$shoporder2 = "select sum(money) as total from " . tablename("zhvip_shoporder")." WHERE from_unixtime(pay_time) LIKE ".$time." and uniacid=".$_W['uniacid']." and state in (4,5,8) and pay_type=1";
$shoporder2 = pdo_fetch($shoporder2);//今天的实收商城订单

$jryxe=$order['total']+$shoporder['total'];
$jrcz=$czorder['total'];
$jrss=$order2['total']+$jrcz+$shoporder2['total'];
$time2=date("Y-m-d");
$time3=date("Y-m-d",strtotime("-1 day"));
$time4=date("Y-m");
//会员总数
$totalhy=pdo_get('zhvip_user', array('uniacid'=>$_W['uniacid'] ,'grade >'=>0), array('count(id) as count'));
//今日新增会员
$sql=" select a.* from (select  id,grade,FROM_UNIXTIME(time) as time  from".tablename('zhvip_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' and grade>0 ";
$jr=count(pdo_fetchall($sql));
//昨日新增
$sql2=" select a.* from (select  id,grade,FROM_UNIXTIME(time) as time  from".tablename('zhvip_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' and grade>0 ";
$zuor=count(pdo_fetchall($sql2));
//本月新增
$sql3=" select a.* from (select  id,grade,FROM_UNIXTIME(time) as time  from".tablename('zhvip_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time4}%'  and grade>0";
$beny=count(pdo_fetchall($sql3));

//用户总数
$totalyh=pdo_get('zhvip_user', array('uniacid'=>$_W['uniacid'] ), array('count(id) as count'));
//今日新增会员
$jryh=" select a.* from (select  id,grade,FROM_UNIXTIME(time) as time  from".tablename('zhvip_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%'";
$jryh=count(pdo_fetchall($jryh));
//昨日新增
$zuoryh=" select a.* from (select  id,grade,FROM_UNIXTIME(time) as time  from".tablename('zhvip_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$zuoryh=count(pdo_fetchall($zuoryh));
//本月新增
$benyyh=" select a.* from (select  id,grade,FROM_UNIXTIME(time) as time  from".tablename('zhvip_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time4}%'";
$benyyh=count(pdo_fetchall($benyyh));
include $this->template('web/index');