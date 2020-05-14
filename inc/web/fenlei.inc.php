<?php
global $_GPC, $_W;
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getMainMenu2();
$list = pdo_getall('zhvip_type',array('uniacid' => $_W['uniacid'],'store_id'=>$storeid),array(),'','num ASC');

 $type=pdo_getall('zhvip_type',array('uniacid'=>$_W['uniacid'],'store_id'=>$storeid),array(),'','num asc');
$type2=pdo_getall('zhvip_type2',array('uniacid'=>$_W['uniacid']),array(),'','num asc');



      foreach($list as $key => $value){
         $data=$this->getSon($value['id'],$type2);
         $list[$key]['ej']=$data;
       
    }
if($_GPC['op']=='delete'){
    $res=pdo_delete('zhvip_type',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('fenlei',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='delete2'){
    $res=pdo_delete('zhvip_type2',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('fenlei',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
   $res=pdo_update('zhvip_type',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('fenlei',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='change2'){
     $res=pdo_update('zhvip_type2',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('fenlei',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
include $this->template('web/fenlei');