<?php
global $_GPC, $_W;
load()->func('tpl');
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getMainMenu2($storeid,$action);

$sql="select a.* ,b.name from " . tablename("zhvip_assess") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id where a.uniacid=:uniacid and a.id=:id";
$list=pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));
$good=pdo_getall('zhvip_goods',array('store_id'=>$storeid));
if($list['img']){
			if(strlen($list['img'])>51){
			$img= explode(',',$list['img']);
		}else{
			$img=array(
				0=>$list['img']
				);
		}
		}
if (checksubmit('submit')) {
	$data['good_id']=$_GPC['good_id'];
	$data['spec']=$_GPC['spec'];
	if($_GPC['user_img']!=$list['user_img']){
		$data['user_img']=$_W['attachurl'].$_GPC['user_img'];
	}
	
	$data['user_name']=$_GPC['user_name'];
	$data['score']=$_GPC['score'];
	$data['content']=$_GPC['content'];
	$data['cerated_time']=$_GPC['cerated_time'];
	if($_GPC['img']){
		$data['img']=implode(",",$_GPC['img']);
	}else{
		$data['img']='';
	}
	$data['reply']=$_GPC['reply'];
	$data['uniacid']=$_W['uniacid'];
	$data['store_id']=$storeid;

	if($_GPC['id']){
		$res=pdo_update("zhvip_assess",$data,array('id'=>$_GPC['id']));
		if($res){
			message('修改成功',$this->createWebUrl('assess',array()),'success');
		}else{
			message('修改失败','','error');
		}
	}else{
		$res=pdo_insert("zhvip_assess",$data);
		if($res){
			message('添加成功',$this->createWebUrl('assess',array()),'success');
		}else{
			message('添加失败','','error');
		}
	}

	
}
include $this->template('web/assessinfo');