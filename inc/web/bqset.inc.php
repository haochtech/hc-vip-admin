<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['support']=$_GPC['support'];
            $data['url_name']=$_GPC['url_name'];
            $data['url_logo']=$_GPC['url_logo'];
            $data['bq_name']=$_GPC['bq_name'];
            $data['bq_logo']=$_GPC['bq_logo'];
            $data['tz_appid']=trim($_GPC['tz_appid']);
            $data['tz_name']=$_GPC['tz_name'];
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){                
                $res=pdo_insert('zhvip_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('bqset',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhvip_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('bqset',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/bqset');