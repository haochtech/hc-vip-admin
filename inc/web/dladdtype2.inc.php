<?php
global $_GPC, $_W;
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu();
	$info = pdo_get('zhvip_type2',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
	$type = pdo_getall('zhvip_type',array('uniacid' => $_W['uniacid'],'store_id'=>$storeid));
		if(checksubmit('submit')){
			$data['img']=$_GPC['img'];
			$data['type_name']=$_GPC['type_name'];
			$data['num']=$_GPC['num'];
			$data['state']=$_GPC['state'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){
			$data['type_id']=$_GPC['type_id'];				
				$res=pdo_insert('zhvip_type2',$data);
				if($res){
					message('添加成功',$this->createWebUrl2('dlfenlei',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhvip_type2', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl2('dlfenlei',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/dladdtype2');