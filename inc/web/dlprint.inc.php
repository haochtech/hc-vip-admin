<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getNaveMenu();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$list=pdo_getall('zhvip_dyj',array('store_id'=>$storeid,'uniacid'=>$_W['uniacid']));
if($_GPC['id']){
	$result = pdo_delete('zhvip_dyj', array('id'=>$_GPC['id']));
		if($result){
			message('删除成功',$this->createWebUrl2('dlprint',array()),'success');
		}else{
			message('删除失败','','error');
		}
}
include $this->template('web/dlprint');