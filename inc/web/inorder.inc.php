<?php
global $_GPC, $_W;
$system=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  a.uniacid=:uniacid and a.state=2 and a.store_id='.$storeid;
if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $where.=" and (a.order_num LIKE  concat('%', :order_no,'%') or b.name LIKE  concat('%', :order_no,'%') or c.name LIKE  concat('%', :order_no,'%') or c.vip_code LIKE  concat('%', :order_no,'%') or e.name LIKE  concat('%', :order_no,'%'))";   
   $data[':order_no']=$op;
}   
if($_GPC['time']){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
   $where.=" and UNIX_TIMESTAMP(a.time) >={$start} and UNIX_TIMESTAMP(a.time) <={$end}";
}
$sql="SELECT a.*,b.name as store_name,c.name as user_name,c.vip_code,e.name as st_name FROM ".tablename('zhvip_order') .  " a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id " . " left join " . tablename("zhvip_user") . " c on c.id=a.user_id left join " . tablename("zhvip_stinfo") . " d on d.code=c.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id ".$where." ORDER BY a.id DESC";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhvip_order') .  " a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id " . " left join " . tablename("zhvip_user") . " c on c.id=a.user_id left join " . tablename("zhvip_stinfo") . " d on d.code=c.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id ".$where." ORDER BY a.id DESC",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
include $this->template('web/inorder');