<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_get('zhvip_coupons',array('id'=>$_GPC['id']));
$type=pdo_getall('zhvip_store',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
	if(!$_GPC['level_type']){
		message('会员级别限制不能为零或空','','error');
	}
	$data['name']=$_GPC['name'];
	$data['type']=$_GPC['type'];
	$data['store_id']=$_GPC['store_id'];
	$data['reduction']=$_GPC['reduction'];
	$data['full']=$_GPC['full'];
	$data['details']=$_GPC['details'];
	$data['start_time']=$_GPC['time']['start'];
	$data['end_time']=$_GPC['time']['end'];
	$data['level_type']=$_GPC['level_type'];
	$data['uniacid']=$_W['uniacid'];
if($_GPC['id']==''){
	$res=pdo_insert('zhvip_coupons',$data);
	if($res){
		message('添加成功',$this->createWebUrl('coupons',array()),'success');
	}else{
		message('添加失败','','error');
	}
	}else{
		$res = pdo_update('zhvip_coupons', $data, array('id' => $_GPC['id']));
		if($res){
			message('编辑成功',$this->createWebUrl('coupons',array()),'success');
		}else{
			message('编辑失败','','error');
		}
	}
}
include $this->template('web/addcoupons');