<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=15;
$where=' WHERE  b.uniacid=:uniacid and a.state=2';
if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $where.=" and (b.name LIKE  concat('%', :order_no,'%') or c.name LIKE  concat('%', :order_no,'%'))";   
   $data[':order_no']=$op;
}   
if($_GPC['time']){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and UNIX_TIMESTAMP(a.time) >={$start} and UNIX_TIMESTAMP(a.time) <={$end}";

}
$data[':uniacid']=$_W['uniacid'];


$sql="select a.* ,b.name,b.img,c.name as store_name from " . tablename("zhvip_czorder") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id " . " left join " . tablename("zhvip_store") . " c on c.id=a.store_id  ".$where."  order by a.id DESC";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,$data);	   
$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_czorder") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id " . " left join " . tablename("zhvip_store") . " c on c.id=a.store_id ".$where,$data);
$pager = pagination($total, $pageindex, $pagesize);
include $this->template('web/czjl');
