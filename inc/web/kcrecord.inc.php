<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  a.uniacid=:uniacid and a.card_id='.$_GPC['card_id'];
if(checksubmit('submit')){
	$op=$_GPC['keywords'];
	$where.=" and b.name LIKE  concat('%', :name,'%') ";	
	$data[':name']=$op;
   }
 $data[':uniacid']=$_W['uniacid'];
$sql="SELECT a.*,b.name,c.name as hx_name FROM ".tablename('zhvip_numcard_record') . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id left join " . tablename("zhvip_user") . " c on c.id=a.hx_id".$where;
 $total=pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('zhvip_numcard_record') . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id left join " . tablename("zhvip_user") . " c on c.id=a.hx_id ".$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
include $this->template('web/kcrecord');