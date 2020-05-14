<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getNaveMenu();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$item=pdo_get('zhvip_store',array('id'=>$storeid));
    if(checksubmit('submit')){
            $data['sms_tel']=$_GPC['sms_tel'];
            $res = pdo_update('zhvip_store', $data, array('id' => $_GPC['id']));
            if($res){
                message('编辑成功',$this->createWebUrl2('insms',array()),'success');
            }else{
                message('编辑失败','','error');
            }
        }
include $this->template('web/insms');