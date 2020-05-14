<?php
global $_GPC, $_W;
$system=pdo_get('zhvip_system',array('uniacid'=>$_W['uniacid']));

$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  a.uniacid=:uniacid and a.state=2 ';
if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $where.=" and (a.order_num LIKE  concat('%', :order_no,'%') or b.name LIKE  concat('%', :order_no,'%') or c.name LIKE  concat('%', :order_no,'%') or c.vip_code LIKE  concat('%', :order_no,'%') or e.name LIKE  concat('%', :order_no,'%'))";   
   $data[':order_no']=$op;
}   
if($_GPC['time']){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and UNIX_TIMESTAMP(a.time) >={$start} and UNIX_TIMESTAMP(a.time) <={$end}";

}
$sql="SELECT a.*,b.name as store_name,c.name as user_name,c.vip_code,e.name as st_name FROM ".tablename('zhvip_order') .  " a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id " . " left join " . tablename("zhvip_user") . " c on c.id=a.user_id left join " . tablename("zhvip_stinfo") . " d on d.code=c.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id ".$where." ORDER BY a.id DESC";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhvip_order') .  " a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id " . " left join " . tablename("zhvip_user") . " c on c.id=a.user_id left join " . tablename("zhvip_stinfo") . " d on d.code=c.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id ".$where." ORDER BY a.id DESC",$data);


$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['dc_time']) {
	// print_r($_GPC['dc_time']);die;

	if($_GPC['dc_time']['start']==$_GPC['dc_time']['end']){
		$dcstart=strtotime(date('Y-m-d 00:00:00'));
		$dcend=strtotime(date('Y-m-d 23:59:59'));
		$note=$_GPC['dc_time']['start']."订单数据";
	}else{
		$dcstart=strtotime($_GPC['dc_time']['start']);
		$dcend=strtotime($_GPC['dc_time']['end']);

		$note=$_GPC['dc_time']['start']."至".$_GPC['dc_time']['end']."订单数据";
	}
	

if($_GPC['store_id']){
	$count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("zhvip_order"). "  where UNIX_TIMESTAMP(time)>=".$dcstart." and unix_timestamp(time)<=".$dcend."  and uniacid=".$_W['uniacid']." and state=2 and store_id=".$_GPC['store_id']);
	$orderwhere=' and a.store_id='.	$_GPC['store_id'];
}else{
	$count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("zhvip_order"). "  where UNIX_TIMESTAMP(time)>=".$dcstart." and unix_timestamp(time)<=".$dcend."  and uniacid=".$_W['uniacid']." and state=2");
	$orderwhere='';
}
  
  $pagesize = ceil($count/5000);
        //array_unshift( $names,  '活动名称'); 

  $header = array(
    'order_num'=>'订单号',
    'money'=>'金额',
    'preferential'=>'优惠金额',
    'user_id' => '用户id',
    'user_name' => '付款人',
    'vip_code' => '卡号',
    'st_name' => '实体卡列表名称',
    'store_name'=>'下单门店',
    'time' => '下单时间',
    );

  $keys = array_keys($header);
  $html = "\xEF\xBB\xBF";
  foreach ($header as $li) {
    $html .= $li . "\t ,";
  }
  $html .= "\n";
  for ($j = 1; $j <= $pagesize; $j++) {
    $sql = "select a.*,b.name as store_name,c.name as user_name,c.vip_code,e.name as st_name from " . tablename("zhvip_order")." a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id  left join " . tablename("zhvip_user") . " c on c.id=a.user_id left join " . tablename("zhvip_stinfo") . " d on d.code=c.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id where UNIX_TIMESTAMP(a.time)>=".$dcstart." and UNIX_TIMESTAMP(a.time)<=".$dcend." and a.uniacid=".$_W['uniacid']." and a.state=2 ".$orderwhere." limit " . ($j - 1) * 5000 . ",5000 ";
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
        if(!$row['st_name']){
          $row['st_name']='无';
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



include $this->template('web/order');