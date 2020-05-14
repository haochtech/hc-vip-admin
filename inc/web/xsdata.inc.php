<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid and state=2";
$where2=" where uniacid=:uniacid and state=2 and form_id !=''";
$data[':uniacid']=$_W['uniacid'];
$time=date("Y-m-d");
$time2=strtotime(date("Y-m-d",strtotime("-7 day")));
$time3=date("Y-m");
$order="select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_order").$where;

$shoporder="select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_shoporder")." where state in (4,5,8) and uniacid=".$_W['uniacid'];

$order1="select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_order").$where." and time LIKE '%{$time}%'";
$shoporder1="select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_shoporder")." where state in (4,5,8) and from_unixtime(pay_time) LIKE '%{$time}%' and uniacid=".$_W['uniacid'];


$order2="select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_order").$where." and UNIX_TIMESTAMP(time) >{$time2}";
$shoporder2="select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_shoporder")." where state in (4,5,8) and pay_time >{$time2} and uniacid=".$_W['uniacid'];

$order3="select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_order").$where." and time LIKE '%{$time3}%'";
$shoporder3="select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_shoporder")." where state in (4,5,8) and from_unixtime(pay_time) LIKE '%{$time3}%' and uniacid=".$_W['uniacid'];
//总销售额
$order = pdo_fetch($order,$data);

//今日销售额
$order1 = pdo_fetch($order1,$data);
//近7日销售额
$order2 = pdo_fetch($order2,$data);
//本月销售额
$order3 = pdo_fetch($order3,$data);


//总销售额
$shoporder = pdo_fetch($shoporder);

//今日销售额
$shoporder1 = pdo_fetch($shoporder1);
//近7日销售额
$shoporder2 = pdo_fetch($shoporder2);
//本月销售额
$shoporder3 = pdo_fetch($shoporder3);



$czorder = "select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_czorder").$where2;
$czorder1 = "select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_czorder").$where2." and time LIKE '%{$time}%'";
$czorder2 = "select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_czorder").$where2." and UNIX_TIMESTAMP(time) >{$time2}";
$czorder3 = "select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_czorder").$where2." and time LIKE '%{$time3}%'";

//总充值金额
$czorder = pdo_fetch($czorder,$data);
//今日日充值金额
$czorder1 = pdo_fetch($czorder1,$data);

//近7日充值金额
$czorder2 = pdo_fetch($czorder2,$data);
//本月充值金额
$czorder3 = pdo_fetch($czorder3,$data);

$ckorder = "select IFNULL(sum(money),0.00 ) as total  from " . tablename("zhvip_numcardorder").$where;
$ckorder1 = "select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_numcardorder").$where." and time LIKE '%{$time}%'";
$ckorder2 = "select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_numcardorder").$where." and UNIX_TIMESTAMP(time) >{$time2}";
$ckorder3 = "select IFNULL(sum(money),0.00) as total from " . tablename("zhvip_numcardorder").$where." and time LIKE '%{$time3}%'";
//总次卡销售金额
$ckorder = pdo_fetch($ckorder,$data);

//今日次卡销售金额
$ckorder1 = pdo_fetch($ckorder1,$data);
//近7日次卡销售金额
$ckorder2 = pdo_fetch($ckorder2,$data);
//本月次卡销售金额
$ckorder3 = pdo_fetch($ckorder3,$data);

include $this->template('web/xsdata');