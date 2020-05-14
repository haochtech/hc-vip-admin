<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  a.uniacid=:uniacid and a.card_id='.$_GPC['card_id'];
if(checksubmit('submit')){
	$op=$_GPC['keywords'];
	$where.=" and b.name LIKE  concat('%', :name,'%') ";	
	$data[':name']=$op;
   }
 $data[':uniacid']=$_W['uniacid'];



$sql="SELECT a.*,b.name as user_name,c.name as card_name FROM ".tablename('zhvip_mynumcard') . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id left join " . tablename("zhvip_numcard") . " c on c.id=a.card_id".$where;
 $total=pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('zhvip_mynumcard') . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id".$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);

if(checksubmit('submit2')){
  if($_GPC['reply']<=0){
    message('次数不能小于零','','error');
  }else{
    $res=pdo_update('zhvip_mynumcard',array('number -='=>$_GPC['reply']),array('id'=>$_GPC['id2']));
      $res2=pdo_get('zhvip_mynumcard',array('id'=>$_GPC['id2']));
      if($res){
       $data2['user_id']=$res2['user_id'];
      $data2['card_id']=$res2['card_id'];
      $data2['hx_id']=0;
      $data2['num']=$_GPC['reply'];
      $data2['time']=date('Y-m-d H:i:s');
      $data2['uniacid']=$_W['uniacid'];
      pdo_insert('zhvip_numcard_record',$data2);
       if($res2){
        file_get_contents("".$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&a=wxapp&do=kcMessage&m=zh_vip&id=".$_GPC['id2']);//模板消息
       message('扣次成功！', $this->createWebUrl('record',array('card_id'=>$_GPC['card_id'])), 'success');
      }else{
       message('扣次失败！','','error');
      }
    }
  }
      
}
include $this->template('web/record');