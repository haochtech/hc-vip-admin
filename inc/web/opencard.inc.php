<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['opencard']=$_GPC['opencard'];
            $data['mr_logo']=$_GPC['mr_logo'];
            $data['vip_qx']=$_GPC['vip_qx'];
             $data['is_stk']=$_GPC['is_stk'];
             $data['vip_xy']=html_entity_decode($_GPC['vip_xy']);
          
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){                
                $res=pdo_insert('zhvip_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('opencard',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhvip_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('opencard',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/opencard');