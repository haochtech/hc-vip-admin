<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $sql="select a.* ,b.name as md_name from " . tablename("zhvip_account") . " a"  . " left join " . tablename("zhvip_store") . " b on b.id=a.store_id   WHERE a.uniacid=:uniacid";
$list=pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
if($_GPC['op']=='delete'){
	$res=pdo_delete('zhvip_account',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('admin'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['state']){
	$data['state']=$_GPC['state'];
	$res=pdo_update('zhvip_account',$data,array('id'=>$_GPC['id']));
	if($res){
		 message('编辑成功！', $this->createWebUrl('admin'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/admin');