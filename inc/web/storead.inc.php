<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if(checksubmit('submit')){
  $op=$_GPC['keywords'];
  $where="%$op%"; 
}else{
  $where='%%';
}
  $pageindex = max(1, intval($_GPC['page']));
  $pagesize=10;
  $sql="select * from " . tablename("zhvip_store") ." WHERE  name LIKE :name  and type=2 and uniacid=:uniacid";
  $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $list = pdo_fetchall($select_sql,array(':uniacid'=>$_W['uniacid'],':name'=>$where));   

  $total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_store") ." WHERE  name LIKE :name  and type=2 and uniacid=:uniacid",array(':uniacid'=>$_W['uniacid'],':name'=>$where));

  $pager = pagination($total, $pageindex, $pagesize);

  
  if($_GPC['op']=="del"){

    $res4=pdo_delete("zhvip_store",array('id'=>$_GPC['id']));
    if($res4){
     message('删除成功！', $this->createWebUrl('storead'), 'success');
    }else{
        message('删除失败！','','error');
    }
  }
  if($_GPC['is_default']){
    $res=pdo_update("zhvip_store",array('is_default'=>$_GPC['is_default']),array('id'=>$_GPC['id']));
    if($res){
     message('修改成功！', $this->createWebUrl('storead'), 'success');
    }else{
        message('修改失败！','','error');
    }
  }

include $this->template('web/storead');