<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
if(checksubmit('submit')){
	$op=$_GPC['keywords'];
	$where="%$op%";	
}else{
	$where='%%';
}
$type=pdo_getall('zhvip_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=20;
$sql="select a.*,b.type_name,b.type_id  from " . tablename("zhvip_goods") ."a"  . " left join " . tablename("zhvip_type2") . " b on b.id=a.type_id WHERE  a.name LIKE :name  and a.uniacid=:uniacid and a.store_id=".$storeid;
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,array(':uniacid'=>$_W['uniacid'],':name'=>$where));	   
$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_goods") ."a"  . " left join " . tablename("zhvip_type2") . " b on b.id=a.type_id WHERE  name LIKE :name  and a.uniacid=:uniacid and a.store_id=".$storeid,array(':uniacid'=>$_W['uniacid'],':name'=>$where));
$pager = pagination($total, $pageindex, $pagesize);

foreach ($list as $key => $value){
if($value['type_id']>0){
  pdo_update('zhvip_goods',array('t_id'=>$value['type_id']),array('id'=>$value['id'],'store_id'=>$storeid));
}
}

if($_GPC['op']=="delete"){
  $res=pdo_delete("zhvip_goods",array('id'=>$_GPC['id']));
  if($res){
  	pdo_delete("zhvip_shopcar",array('good_id'=>$_GPC['id']));
  	pdo_delete("zhvip_spec_combination",array('good_id'=>$_GPC['id']));
  	pdo_delete("zhvip_spec_val",array('good_id'=>$_GPC['id']));
    message('删除成功！', $this->createWebUrl('goods'), 'success');
  }else{
    message('删除失败！','','error');
  }
}
if($_GPC['op']=="show"){
	$res=pdo_update('zhvip_goods',array('is_show'=>$_GPC['is_show']),array('id'=>$_GPC['id']));
	if($res){
       message('编辑成功！', $this->createWebUrl('goods'), 'success');
	}else{
	   message('编辑失败！','','error');
	}
}


include $this->template('web/goods');