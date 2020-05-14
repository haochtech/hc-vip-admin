<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhtc_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['tx_sxf']=$_GPC['tx_sxf'];
            $data['tx_money']=$_GPC['tx_money'];
            $data['uniacid']=$_W['uniacid'];
            $data['tx_details']=html_entity_decode($_GPC['tx_details']);
            if($_GPC['id']==''){                
                $res=pdo_insert('zhtc_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('txsz',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhtc_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('txsz',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

include $this->template('web/txsz');