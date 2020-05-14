<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getNaveMenu();
$storeid=$_COOKIE["storeid"]; 
$cur_store = $this->getStoreById($storeid); 

$info=pdo_get('zhvip_goods',array('id'=>$_GPC['id']));
if($info['img']){
			if(strlen($info['img'])>51){
			$img= explode(',',$info['img']);
		}else{
			$img=array(
				0=>$info['img']
				);
		}
		}
$type=pdo_getall('zhvip_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
$typeid=pdo_get('zhvip_type2',array('id'=>$info['type_id']));

include $this->template('web/dladdgoods');