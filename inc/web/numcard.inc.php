<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  uniacid=:uniacid';
if(checksubmit('submit')){
	$op=$_GPC['keywords'];
	$where.=" and name LIKE  concat('%', :name,'%') ";	
	$data[':name']=$op;
   }
 $data[':uniacid']=$_W['uniacid'];



$sql="SELECT * FROM ".tablename('zhvip_numcard').$where." order  by num asc";
 $total=pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('zhvip_numcard').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
   if($_GPC['id']){
    $res=pdo_delete('zhvip_numcard',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('numcard',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
    include $this->template('web/numcard');