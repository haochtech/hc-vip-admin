<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_get('zhvip_numcard',array('id'=>$_GPC['id']));
$store=pdo_getall('zhvip_store',array('uniacid'=>$_W['uniacid']));
// if($list['store_id']){
// 	if(strpos($list['store_id'],',')){
// 	$store_id= explode(',',$list['store_id']);
// 	$store_id=json_encode($store_id);
// }else{
// 	$store_id=  array(
// 		0=>$list['store_id']
// 	);
// $store_id=json_encode($store_id);
// }
// }
if(checksubmit('submit')){
	$data['name']=$_GPC['name'];
	$data['number']=$_GPC['number'];
	$data['money']=$_GPC['money'];
	$data['store_id']=$_GPC['store_id'];
	// if($_GPC['store_id']){
	// 		$data['store_id']=implode(",",$_GPC['store_id']);
	// 	}else{
	// 		$data['store_id']='';
	// 	}
	$data['type']=1;
	$data['num']=$_GPC['num'];
	$data['img']=$_GPC['img'];
	$data['time']=$_GPC['time'];
	 $data['details']=html_entity_decode($_GPC['details']);
	$data['uniacid']=$_W['uniacid'];
if($_GPC['id']==''){
	$res=pdo_insert('zhvip_numcard',$data);
	if($res){
		message('添加成功',$this->createWebUrl('numcard',array()),'success');
	}else{
		message('添加失败','','error');
	}
	}else{
		$res = pdo_update('zhvip_numcard', $data, array('id' => $_GPC['id']));
		if($res){
			message('编辑成功',$this->createWebUrl('numcard',array()),'success');
		}else{
			message('编辑失败','','error');
		}
	}
}

include $this->template('web/addnumcard');