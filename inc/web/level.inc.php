<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list=pdo_getall('zhvip_level',array('uniacid'=>$_W['uniacid']));
if($_GPC['op']=='delete'){
	$user=pdo_get('zhvip_user',array('grade'=>$_GPC['id']));
	if($user){
		message('该等级下有会员,无法删除!','','error');
	}else{
		$res=pdo_delete('zhvip_level',array('id'=>$_GPC['id']));
		if($res){
		    message('删除成功！', $this->createWebUrl('level'), 'success');
		}else{
			message('删除失败！','','error');
		}
	}
	
}
include $this->template('web/level');