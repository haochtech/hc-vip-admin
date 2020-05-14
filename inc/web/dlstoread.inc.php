<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getNaveMenu();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$list=pdo_getall('zhvip_storead',array('uniacid'=>$_W['uniacid'],'store_id'=>$storeid),array(),'','orderby ASC');
if($_GPC['op']=='delete'){
	$res=pdo_delete('zhvip_storead',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl2('dlstoread'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['status']){
	$data['status']=$_GPC['status'];
	$res=pdo_update('zhvip_storead',$data,array('id'=>$_GPC['id']));
	if($res){
		 message('编辑成功！', $this->createWebUrl2('dlstoread'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/dlstoread');