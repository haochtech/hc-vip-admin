<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"]; 
$cur_store = $this->getStoreById($storeid); 

$info=pdo_get('zhvip_goods',array('id'=>$_GPC['id']));

$img=@explode(",",$info['img']);

$type=pdo_getall('zhvip_type',array('uniacid'=>$_W['uniacid'],'state'=>1,'store_id'=>$storeid),array(),'','num asc');
$typeid=pdo_get('zhvip_type2',array('id'=>$info['type_id']));

include $this->template('web/addgoods');