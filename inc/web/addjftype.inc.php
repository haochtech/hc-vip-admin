<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('zhvip_jftype',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
			$data['img']=$_GPC['img'];
			$data['num']=$_GPC['num'];
			$data['name']=$_GPC['name'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){				
				$res=pdo_insert('zhvip_jftype',$data);
				if($res){
					message('添加成功',$this->createWebUrl('jftype',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhvip_jftype', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('jftype',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addjftype');