<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['tid']=trim($_GPC['tid']);
            $data['tid2']=trim($_GPC['tid2']);
            $data['tid3']=trim($_GPC['tid3']);
            $data['tid4']=trim($_GPC['tid4']);
            $data['sj_tid']=trim($_GPC['sj_tid']);
            $data['kc_tid']=trim($_GPC['kc_tid']);
            $data['yue_tid']=trim($_GPC['yue_tid']);
            $data['jf_tid']=trim($_GPC['jf_tid']);
            $data['uniacid']=trim($_W['uniacid']);
            if($_GPC['id']==''){                
                $res=pdo_insert('zhvip_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('template',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhvip_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('template',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/template');