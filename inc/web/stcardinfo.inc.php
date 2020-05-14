<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  type_id='.$_GPC['type_id'];
if(checksubmit('submit')){
	$op=$_GPC['keywords'];
	$where.=" and code LIKE  concat('%', :name,'%') ";	
	$data[':name']=$op;
   }



$sql="SELECT * FROM ".tablename('zhvip_stinfo').$where;
 $total=pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('zhvip_stinfo').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
include $this->template('web/stcardinfo');