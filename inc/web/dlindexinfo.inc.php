<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getNaveMenu();

if($_GPC['id']){
setcookie("storeid",$_GPC['id']);
$storeid=$_GPC['id'];

}else{
$storeid=$_COOKIE["storeid"];

}
$cur_store = $this->getStoreById($storeid);
$time=date("Y-m-d");
$time="'%$time%'";
$order = "select sum(money) as total from " . tablename("zhvip_order")." WHERE time LIKE ".$time." and uniacid=".$_W['uniacid']." and state=2 and store_id=".$storeid;
$order = pdo_fetch($order);//今天的买单销售额
$order2 = "select sum(money) as total from " . tablename("zhvip_order")." WHERE time LIKE ".$time." and uniacid=".$_W['uniacid']." and state=2 and (pay_type=1 || (pay_type2!='会员卡扣款' and pay_type2!='')) and store_id=".$storeid;
$order2 = pdo_fetch($order2);//今天的实际收入

$czorder = "select sum(money) as total from " . tablename("zhvip_czorder")." WHERE time LIKE ".$time." and uniacid=".$_W['uniacid']." and state=2 and store_id=".$storeid;
$czorder = pdo_fetch($czorder);//今天的充值
$czorder2 = "select sum(money2) as total from " . tablename("zhvip_czorder")." WHERE time LIKE ".$time." and uniacid=".$_W['uniacid']." and state=2 and store_id=".$storeid;
$czorder2 = pdo_fetch($czorder2);//今天的充值

$jrcz=$czorder2['total']+$czorder['total'];
$jrss=$order2['total']+$jrcz;


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





include $this->template('web/dlindexinfo');