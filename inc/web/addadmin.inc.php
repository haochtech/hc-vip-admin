<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhvip_account',array('id'=>$_GPC['id']));
$store=pdo_getall('zhvip_store',array('uniacid'=>$_W['uniacid'],'type'=>1));

if(checksubmit('submit')){
        $data['account']=$_GPC['account'];
        $data['pwd']=md5($_GPC['pwd']);
        $data['store_id']=$_GPC['store_id'];
        $data['state']=$_GPC['state'];
        $data['uniacid']=$_W['uniacid'];
     if($_GPC['id']==''){  
        $res=pdo_insert('zhvip_account',$data);
        if($res){
             message('添加成功！', $this->createWebUrl('admin'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{
        $res=pdo_update('zhvip_account',$data,array('id'=>$_GPC['id']));
        if($res){
             message('编辑成功！', $this->createWebUrl('admin'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}

include $this->template('web/addadmin');