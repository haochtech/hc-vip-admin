<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$pageindex = max(1, intval($_GPC['page']));
$pagesize=15;
$sql="select a.* ,b.name,b.img,c.name as store_name from " . tablename("zhvip_qbmx") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id " . " left join " . tablename("zhvip_store") . " c on c.id=a.store_id where (a.note='在线充值' || a.note='后台充值' || a.note='充值赠送') and b.uniacid = :uniacid and a.store_id=".$storeid." order by a.id asc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,array(':uniacid'=>$_W['uniacid']));	   
$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_qbmx") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id " . " left join " . tablename("zhvip_store") . " c on c.id=a.store_id where (a.note='在线充值' || a.note='后台充值' || a.note='充值赠送') and b.uniacid = :uniacid and a.store_id=".$storeid,array(':uniacid'=>$_W['uniacid']));
$pager = pagination($total, $pageindex,$pagesize);
include $this->template('web/inczjl');

