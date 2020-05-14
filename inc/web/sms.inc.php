<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['appkey']=trim($_GPC['appkey']);
            $data['tpl_id']=trim($_GPC['tpl_id']);
             $data['tpl2_id']=trim($_GPC['tpl2_id']);
              $data['tpl3_id']=trim($_GPC['tpl3_id']);
            $data['is_sms']=$_GPC['is_sms'];
            if($_GPC['appkey']==''){
                message('短信应用key不能为空!','','error'); 
            }
            if($_GPC['tpl_id']==''){
                message('短信模板id不能为空!','','error'); 
            }
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){                
                $res=pdo_insert('zhvip_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('sms',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhvip_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('sms',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/sms');