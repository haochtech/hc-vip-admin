<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid and state=2";
$where2=" where uniacid=:uniacid and state=2 and form_id !=''";
$data[':uniacid']=$_W['uniacid'];
$time=date("Y-m-d");
$time2=strtotime(date("Y-m-d",strtotime("-7 day")));
$time3=date("Y-m");
$storeid=$_COOKIE["storeid"];

$pageindex = max(1, intval($_GPC['page']));
$pagesize=20;
if(!empty($_GPC['time'])){
$start=strtotime($_GPC['time']['start']);
$end=strtotime($_GPC['time']['end']);
}

if($_GPC['ordertype']==1){
    $sql="select * from " . tablename("zhvip_order").$where." and time LIKE '%{$time}%'";
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_order").$where." and time LIKE '%{$time}%'",$data);
}
if($_GPC['ordertype']==2){
    $sql="select * from " . tablename("zhvip_order").$where." and UNIX_TIMESTAMP(time) >{$time2}";
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_order").$where." and UNIX_TIMESTAMP(time) >{$time2}",$data);
}
if($_GPC['ordertype']==3){
    $sql="select * from " . tablename("zhvip_order").$where." and time LIKE '%{$time3}%'";
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_order").$where." and time LIKE '%{$time3}%'",$data);
}
if($_GPC['ordertype']==4){
    $sql="select * from " . tablename("zhvip_order").$where;
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_order").$where,$data);
}




if($_GPC['ordertype']==5){
    $sql="select * from " . tablename("zhvip_czorder").$where2." and time LIKE '%{$time}%'";
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_czorder").$where2." and time LIKE '%{$time}%'",$data);
}
if($_GPC['ordertype']==6){
    $sql="select * from " . tablename("zhvip_czorder").$where2." and UNIX_TIMESTAMP(time) >{$time2}";
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_czorder").$where2." and UNIX_TIMESTAMP(time) >{$time2}",$data);
}
if($_GPC['ordertype']==7){
    $sql="select * from " . tablename("zhvip_czorder").$where2." and time LIKE '%{$time3}%'";
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_czorder").$where2." and time LIKE '%{$time3}%'",$data);
}
if($_GPC['ordertype']==8){
    $sql="select * from " . tablename("zhvip_czorder").$where2;
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_czorder").$where2,$data);
}




if($_GPC['ordertype']==9){
    $sql="select * from " . tablename("zhvip_numcardorder").$where." and time LIKE '%{$time}%'";
    $total=pdo_fetchcolumn("select  count(*) from " . tablename("zhvip_numcardorder").$where." and time LIKE '%{$time}%'",$data);
}
if($_GPC['ordertype']==10){
    $sql="select * from " . tablename("zhvip_numcardorder").$where." and UNIX_TIMESTAMP(time) >{$time2}";
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_numcardorder").$where." and UNIX_TIMESTAMP(time) >{$time2}",$data);
}
if($_GPC['ordertype']==11){
    $sql="select * from " . tablename("zhvip_numcardorder").$where." and time LIKE '%{$time3}%'";
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_numcardorder").$where." and time LIKE '%{$time3}%'",$data);
}
if($_GPC['ordertype']==12){
    $sql="select * from " . tablename("zhvip_numcardorder").$where;
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_numcardorder").$where,$data);
}


if($_GPC['ordertype']==13){
    $sql="select * from " . tablename("zhvip_shoporder")." where state in (4,5,8) and from_unixtime(pay_time) LIKE '%{$time}%' and uniacid=".$_W['uniacid'];
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_shoporder")." where state in (4,5,8) and from_unixtime(pay_time) LIKE '%{$time}%' and uniacid=".$_W['uniacid']);
}
if($_GPC['ordertype']==14){
    $sql="select * from " . tablename("zhvip_shoporder")." where state in (4,5,8) and  pay_time >{$time2} and uniacid=".$_W['uniacid'];
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_shoporder")." where state in (4,5,8) and  pay_time >{$time2} and uniacid=".$_W['uniacid']);
}
if($_GPC['ordertype']==15){
     $sql="select * from " . tablename("zhvip_shoporder")." where state in (4,5,8) and  from_unixtime(pay_time) LIKE '%{$time3}%' and uniacid=".$_W['uniacid'];
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_shoporder")." where state in (4,5,8) and  from_unixtime(pay_time) LIKE '%{$time3}%' and uniacid=".$_W['uniacid']);
}
if($_GPC['ordertype']==16){
    $sql="select * from " . tablename("zhvip_shoporder") . " where state in (4,5,8) and uniacid=".$_W['uniacid'];
    $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_shoporder")." where state in (4,5,8) and uniacid=".$_W['uniacid']);
}
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$xsinfo=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
include $this->template('web/xsdatalist');