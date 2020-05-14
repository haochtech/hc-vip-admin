<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $where=' WHERE  a.uniacid=:uniacid';
		if(checksubmit('submit')){
			$op=$_GPC['keywords'];
			$where.=" and b.name LIKE  concat('%', :name,'%') ";	
			$data[':name']=$op;
	       }
	       $data[':uniacid']=$_W['uniacid'];

$sql="SELECT a.*,b.name as md_name  FROM ".tablename('zhvip_coupons') .  " a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id".$where;
 $total=pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('zhvip_coupons') .  " a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id".$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
   if($_GPC['id']){
    $res=pdo_delete('zhvip_coupons',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('coupons',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
    include $this->template('web/coupons');