<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=15;

if($_GPC['user_id']){
  $where=' WHERE  b.uniacid=:uniacid and a.state=2 and a.user_id='.$_GPC['user_id'];
}else{
  $where=' WHERE  b.uniacid=:uniacid and a.state=2';
}

if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $where.=" and (b.name LIKE  concat('%', :order_no,'%') or c.name LIKE  concat('%', :order_no,'%') or b.vip_code LIKE  concat('%', :order_no,'%') or e.name LIKE  concat('%', :order_no,'%'))";   
   $data[':order_no']=$op;
}   
if($_GPC['time']){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and UNIX_TIMESTAMP(a.time) >={$start} and UNIX_TIMESTAMP(a.time) <={$end}";

}
$data[':uniacid']=$_W['uniacid'];


$sql="select a.* ,b.name,b.img,b.vip_code,e.name as st_name,c.name as store_name from " . tablename("zhvip_czorder") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id " . " left join " . tablename("zhvip_store") . " c on c.id=a.store_id left join " . tablename("zhvip_stinfo") . " d on d.code=b.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id  ".$where."  order by a.id DESC";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,$data);	   
$total=pdo_fetchcolumn("select count(*) from " . tablename("zhvip_czorder") . " a"  . " left join " . tablename("zhvip_user") . " b on b.id=a.user_id " . " left join " . tablename("zhvip_store") . " c on c.id=a.store_id left join " . tablename("zhvip_stinfo") . " d on d.code=b.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id ".$where,$data);
$pager = pagination($total, $pageindex, $pagesize);




if($_GPC['dc_time']) {
	// print_r($_GPC['dc_time']);die;

	if($_GPC['dc_time']['start']==$_GPC['dc_time']['end']){
		$dcstart=strtotime(date('Y-m-d 00:00:00'));
		$dcend=strtotime(date('Y-m-d 23:59:59'));
		$note=$_GPC['dc_time']['start']."充值订单数据";
	}else{
		$dcstart=strtotime($_GPC['dc_time']['start']);
		$dcend=strtotime($_GPC['dc_time']['end']);

		$note=$_GPC['dc_time']['start']."至".$_GPC['dc_time']['end']."充值订单数据";
	}
	

if($_GPC['user_id']){
	$count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("zhvip_czorder"). "  where UNIX_TIMESTAMP(time)>=".$dcstart." and unix_timestamp(time)<=".$dcend."  and uniacid=".$_W['uniacid']." and state=2  and user_id=".$_GPC['user_id']);
	$orderwhere=' and a.user_id='.	$_GPC['user_id'];
}else{
	$count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("zhvip_czorder"). "  where UNIX_TIMESTAMP(time)>=".$dcstart." and unix_timestamp(time)<=".$dcend."  and uniacid=".$_W['uniacid']." and state=2");
	$orderwhere='';
}
  
  $pagesize = ceil($count/5000);
        //array_unshift( $names,  '活动名称'); 

  $header = array(
    'user_id' => '用户id',
    'vip_code' => '会员卡号',
    'st_name' => '实体卡列表名称',
    'user_name' => '付款人',
    'money'=>'充值金额',
    'money2'=>'赠送金额',
    'pay_type'=>'充值方式',
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
    $sql = "select a.*,b.name as store_name,c.name as user_name,c.vip_code,e.name as st_name from " . tablename("zhvip_czorder")." a"  . " left join " . tablename("zhvip_store") . " b on a.store_id=b.id  left join " . tablename("zhvip_user") . " c on c.id=a.user_id left join " . tablename("zhvip_stinfo") . " d on d.code=c.vip_code left join " . tablename("zhvip_stlist") . " e on e.id=d.type_id  where UNIX_TIMESTAMP(a.time)>=".$dcstart." and UNIX_TIMESTAMP(a.time)<=".$dcend." and a.uniacid=".$_W['uniacid']." and a.state=2  ".$orderwhere." limit " . ($j - 1) * 5000 . ",5000 ";
    $orderlist = pdo_fetchall($sql);            
  }

  if (!empty($orderlist)) {
    $size = ceil(count($orderlist) / 500);
    for ($i = 0; $i < $size; $i++) {
      $buffer = array_slice($orderlist, $i * 500, 500);
      $user = array();
      foreach ($buffer as $k =>$row) {
      	if($row['store_id']==0 and $row['code']==''){
      		$row['pay_type']='后台充值';
      	}elseif($row['store_id']==0 and $row['code']){
      		$row['pay_type']='开卡充值';
      	}elseif($row['code']){
			$row['pay_type']='在线充值';
      	}else{
      		$row['pay_type']='手机端后台充值--'.$row['pay_type'];
      	}
      	if(!$row['store_name']){
      		$row['store_name']='平台';
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



include $this->template('web/userczorder');
