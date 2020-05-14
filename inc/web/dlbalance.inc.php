<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getNaveMenu();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$pageindex = max(1, intval($_GPC['page']));
$pagesize=20;
$userInfo=pdo_get('zhvip_user',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['user_id']),array('id','name','img','nickname'));
$data[':uniacid']=$_W['uniacid'];
$data[':user_id']=$_GPC['user_id'];
$where=' WHERE  uniacid=:uniacid and user_id=:user_id ';
if($_GPC['keywords']){
   $where.=" and note LIKE  concat('%', :keywords,'%') ";
   $data[':keywords']=$_GPC['keywords'];
}   
if($_GPC['time']){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and UNIX_TIMESTAMP(time) >={$start} and UNIX_TIMESTAMP(time) <={$end}";

}
$sql="SELECT * FROM ".tablename('zhvip_qbmx').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhvip_order').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);


include $this->template('web/dlbalance');