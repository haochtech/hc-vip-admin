<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=15;
if($_GPC['user_id']){
  $where=' WHERE a.uniacid=:uniacid and a.state!=1 and a.user_id='.$_GPC['user_id'];
}else{
  $where=' WHERE a.uniacid=:uniacid and a.state!=1';
}

if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $where.=" and (a.order_num LIKE  concat('%', :order_no,'%') or a.user_name LIKE  concat('%', :order_no,'%') or a.tel LIKE  concat('%', :order_no,'%') or c.name LIKE  concat('%', :order_no,'%') or e.name LIKE  concat('%', :order_no,'%') or b.vip_code LIKE  concat('%', :order_no,'%'))";   
   $data[':order_no']=$op;
}   
if($_GPC['time']){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and UNIX_TIMESTAMP(a.time) >={$start} and UNIX_TIMESTAMP(a.time) <={$end}";

}
$data[':uniacid']=$_W['uniacid'];


$sql="select a.* ,c.name as store_name,b.vip_code,e.name as st_name from " . tablename("zhvip_shoporder") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id " . " left join " . tablename("zhvip_store") . " c on c.id=a.store_id left join " . tablename("zhvip_stinfo") . " d on d.code=b.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id  ".$where."  order by a.id DESC";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,$data);	   
$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_shoporder") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id " . " left join " . tablename("zhvip_store") . " c on c.id=a.store_id left join " . tablename("zhvip_stinfo") . " d on d.code=b.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id ".$where,$data);
$pager = pagination($total, $pageindex, $pagesize);





if($_GPC['dc_time']) {
    // print_r($_GPC['dc_time']);die;

    if($_GPC['dc_time']['start']==$_GPC['dc_time']['end']){
        $dcstart=strtotime(date('Y-m-d 00:00:00'));
        $dcend=strtotime(date('Y-m-d 23:59:59'));
        $note=$_GPC['dc_time']['start']."商城订单数据";
    }else{
        $dcstart=strtotime($_GPC['dc_time']['start']);
        $dcend=strtotime($_GPC['dc_time']['end']);

        $note=$_GPC['dc_time']['start']."至".$_GPC['dc_time']['end']."商城订单数据";
    }
    

if($_GPC['user_id']){
    $count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("zhvip_shoporder"). "  where pay_time>=".$dcstart." and pay_time<=".$dcend."  and uniacid=".$_W['uniacid']." and state!=1 and user_id=".$_GPC['user_id']);
    $orderwhere=' and a.user_id='. $_GPC['user_id'];
}else{
    $count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("zhvip_shoporder"). "  where pay_time>=".$dcstart." and pay_time<=".$dcend."  and uniacid=".$_W['uniacid']." and state!=1");
    $orderwhere='';
}
  
  $pagesize = ceil($count/5000);
        //array_unshift( $names,  '活动名称'); 

  $header = array(
    'order_num'=>'订单号',
    'money'=>'金额',
    'preferential'=>'折扣金额',
    'preferential2'=>'优惠金额',
    'user_id' => '用户id',
    'vip_code' => '会员卡号',
    'st_name' => '实体卡列表名称',
    'user_name' => '联系人',
    'address' => '地址',
    'tel' => '电话',
    'state' => '订单状态',
    'store_name'=>'下单门店',
    'pay_time' => '下单时间',
    );

  $keys = array_keys($header);
  $html = "\xEF\xBB\xBF";
  foreach ($header as $li) {
    $html .= $li . "\t ,";
  }
  $html .= "\n";
  for ($j = 1; $j <= $pagesize; $j++) {
    $sql = "select a.*,b.name as store_name,c.vip_code,e.name as st_name from " . tablename("zhvip_shoporder")." a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id  left join " . tablename("zhvip_user") . " c on c.id=a.user_id left join " . tablename("zhvip_stinfo") . " d on d.code=c.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id  where a.pay_time>=".$dcstart." and 
    a.pay_time<=".$dcend." and a.uniacid=".$_W['uniacid']." and a.state!=1  ".$orderwhere." limit " . ($j - 1) * 5000 . ",5000 ";
    $orderlist = pdo_fetchall($sql);            
  }

  if (!empty($orderlist)) {
    $size = ceil(count($orderlist) / 500);
    for ($i = 0; $i < $size; $i++) {
      $buffer = array_slice($orderlist, $i * 500, 500);
      $user = array();
      foreach ($buffer as $k =>$row) {
        if($row['pay_type']==1){
          $row['pay_type']='微信支付';
        }elseif($row['pay_type']==2){
          $row['pay_type']='余额支付';
        }
$row['pay_time']=date("Y-m-d H:i:s");
        if($row['state']==2){
          $row['state']='已支付';
        }elseif($row['state']==3){
          $row['state']='待配送';
        }elseif($row['state']==4){
          $row['state']='配送中';
        }elseif($row['state']==5){
          $row['state']='已完成';
        }elseif($row['state']==6){
          $row['state']='已评价';
        }elseif($row['state']==7){
          $row['state']='退款中';
        }elseif($row['state']==8){
          $row['state']='退款通过';
        }elseif($row['state']==9){
          $row['state']='退款拒绝';
        }

        foreach ($keys as $key) {
          $data5[] = $row[$key];
        }
        $user[] = implode("\t ,", $data5) . "\t ,";
        unset($data5);
      }
      $html .= implode("\n", $user) . "\n";
    }
  }
  
  header("Content-type:text/csv");
  header("Content-Disposition:attachment; filename=".$note.".csv");
  echo $html;
  exit();
}
include $this->template('web/userscorder');
