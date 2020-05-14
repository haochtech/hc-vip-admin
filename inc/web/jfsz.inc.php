<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['integral']=$_GPC['integral'];
            $data['is_jf']=$_GPC['is_jf'];
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){                
                $res=pdo_insert('zhvip_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('jfsz',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhvip_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('jfsz',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/jfsz');