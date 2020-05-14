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
$sql="select a.*,b.nickname,b.img,b.name,b.tel,b.vip_code,b.vip_number,c.name as level_name  from " . tablename("zhvip_timeorder") ."a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id left join " . tablename("zhvip_level") . " c on c.id=b.grade WHERE  b.nickname LIKE :name  and a.uniacid=:uniacid  and state=2 order by a.time desc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,array(':uniacid'=>$_W['uniacid'],':name'=>$where));	

$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_timeorder") ."a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id WHERE  b.nickname LIKE :name  and a.uniacid=:uniacid and state=2",array(':uniacid'=>$_W['uniacid'],':name'=>$where));
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['id']){
	// $res=pdo_delete("zhvip_order",array('user_id'=>$_GPC['id']));
	// $res2=pdo_delete("zhvip_usercoupons",array('user_id'=>$_GPC['id']));
	// $res3=pdo_delete("zhvip_uservoucher",array('user_id'=>$_GPC['id']));
	$res4=pdo_delete("zhvip_timeorder",array('id'=>$_GPC['id']));
	if($res4){
		message('删除成功！', $this->createWebUrl('viprecord'), 'success');
	}else{
		message('删除失败！','','error');
	}
}
include $this->template('web/viprecord');