<?php
global $_GPC, $_W;
load()->func('tpl');
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);
 $where="WHERE  a.uniacid=".$_W['uniacid']." and a.store_id=".$storeid;
// if(checksubmit('submit')){
// 	$op=$_GPC['keywords'];
// 	$where="%$op%";
// }else{
// 	$where='%%';
// }
if(checksubmit('submit')){
	$op=$_GPC['keywords'];
	$where.=" and (a.content LIKE  concat('%', :name,'%') || b.name LIKE  concat('%', :name,'%')) ";	
	$data[':name']=$op;
}else{
	if($_GPC['good_id']){
	$where.=" and a.good_id=".$_GPC['good_id'];
	}
}

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select a.*,b.name as  good_name from ". tablename("zhvip_assess").  " a"  . " left join " . tablename("zhvip_goods") . " b on a.good_id=b.id ". $where." order by a.id DESC";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,$data);   
$total = pdo_fetchcolumn("select count(*) from ".tablename("zhvip_assess").  " a"  . " left join " . tablename("zhvip_goods") . " b on a.good_id=b.id ". $where,$data);	
$pager = pagination($total, $pageindex, $pagesize);
if(checksubmit('submit2')){
	$result = pdo_update('zhvip_assess', array('reply' => $_GPC['reply'],'status'=>2,'reply_time'=>date("Y-m-d H:i:s")), array('id' => $_GPC['id']));
	if($result){
			message('回复成功',$this->createWebUrl2('dlassess',array()),'success');
		}else{
			message('回复失败','','error');
		}
}
if($_GPC['op']=='delete'){
	$result = pdo_delete('zhvip_assess', array('id'=>$_GPC['id']));
	if($result){
		message('删除成功',$this->createWebUrl2('dlassess',array()),'success');
	}else{
		message('删除失败','','error');
	}
}



include $this->template('web/dlassess');