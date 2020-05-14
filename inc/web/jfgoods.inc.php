<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('zhvip_jfgoods',array('uniacid' => $_W['uniacid']),array(),'','num ASC');

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select a.* ,b.name as type_name from " . tablename("zhvip_jfgoods") . " a"  . " left join " . tablename("zhvip_jftype") . " b on b.id=a.type_id where a.uniacid=".$_W['uniacid']."  order by num asc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql);	   
$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_jfgoods") . " a"  . " left join " . tablename("zhvip_jftype") . " b on b.id=a.type_id where a.uniacid=".$_W['uniacid']."");
$pager = pagination($total, $pageindex, $pagesize);


if($_GPC['is_open']){
	$res=pdo_update('zhvip_jfgoods',array('is_open'=>$_GPC['is_open']),array('id'=>$_GPC['good_id']));
		if($res){
        message('操作成功',$this->createWebUrl('jfgoods',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['id']){
    $res=pdo_delete('zhvip_jfgoods',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('jfgoods',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/jfgoods');