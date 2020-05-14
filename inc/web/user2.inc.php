<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if(checksubmit('submit')){
	$op=$_GPC['keywords'];
	$where="%$op%";	
}else{
	$where='%%';
}
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=10;
	$sql="select a.*,b.name as level_name  from " . tablename("zhvip_user") ."a"  . " left join " . tablename("zhvip_level") . " b on b.id=a.grade WHERE  a.nickname LIKE :name  and a.uniacid=:uniacid order by id desc";
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,array(':uniacid'=>$_W['uniacid'],':name'=>$where));	   
	$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_user") ." WHERE  nickname LIKE :name  and uniacid=:uniacid",array(':uniacid'=>$_W['uniacid'],':name'=>$where));
	$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['id']){
	// $res=pdo_delete("zhvip_order",array('user_id'=>$_GPC['id']));
	// $res2=pdo_delete("zhvip_usercoupons",array('user_id'=>$_GPC['id']));
	// $res3=pdo_delete("zhvip_uservoucher",array('user_id'=>$_GPC['id']));
	$res4=pdo_delete("zhvip_user",array('id'=>$_GPC['id']));
	if($res4){
	   message('删除成功！', $this->createWebUrl('user2'), 'success');
	}else{
	   message('删除失败！','','error');
	}
}
include $this->template('web/user2');