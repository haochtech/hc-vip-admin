<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['link_name']=$_GPC['link_name'];
            $data['link_logo']=$_GPC['link_logo'];
            $data['qhmd_img']=$_GPC['qhmd_img'];
            $data['is_sc']=$_GPC['is_sc'];
            $data['qhmd_name']=$_GPC['qhmd_name'];
            $data['qhmd_url']=$_GPC['qhmd_url'];
            $data['qhmd_type']=$_GPC['qhmd_type'];
            $data['qhmd_url2']=$_GPC['qhmd_url2'];
            $data['qhmd_appid']=$_GPC['qhmd_appid'];
            $data['qhmd_appidname']=$_GPC['qhmd_appidname'];
            $data['model']=$_GPC['model'];
            $data['md_xs']=$_GPC['md_xs'];
            $data['follow']=$_GPC['follow'];
            if($_GPC['link_color']){
                $data['link_color']=$_GPC['link_color'];
            }else{
                $data['link_color']="#ff7f46";
            }
            $data['link_tel']=$_GPC['link_tel'];
            $data['details']=html_entity_decode($_GPC['details']);
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){                
                $res=pdo_insert('zhvip_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhvip_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/settings');