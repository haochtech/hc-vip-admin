<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('zhvip_vipset',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
			$data['days']=$_GPC['days'];
			$data['money']=$_GPC['money'];
			$data['num']=$_GPC['num'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){				
				$res=pdo_insert('zhvip_vipset',$data);
				if($res){
					message('添加成功',$this->createWebUrl('vipset',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhvip_vipset', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('vipset',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}

include $this->template('web/addvipset');