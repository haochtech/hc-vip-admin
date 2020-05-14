<?php
global $_GPC, $_W;
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getMainMenu2();
$info = pdo_get('zhvip_type',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
    if(checksubmit('submit')){
      $data['num']=$_GPC['num'];
      $data['name']=$_GPC['name'];
     $data['store_id']=$storeid;
      $data['state']=$_GPC['state'];
      $data['uniacid']=$_W['uniacid'];
      if($_GPC['id']==''){        
        $res=pdo_insert('zhvip_type',$data);
        if($res){
          message('添加成功',$this->createWebUrl('fenlei',array()),'success');
        }else{
          message('添加失败','','error');
        }
      }else{
        $res = pdo_update('zhvip_type', $data, array('id' => $_GPC['id']));
        if($res){
          message('编辑成功',$this->createWebUrl('fenlei',array()),'success');
        }else{
          message('编辑失败','','error');
        }
      }
    }
include $this->template('web/addtype');