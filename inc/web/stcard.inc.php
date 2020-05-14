<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  uniacid=:uniacid';

$data[':uniacid']=$_W['uniacid'];
$sql="SELECT * FROM ".tablename('zhvip_stlist').$where;
$total=pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('zhvip_stlist').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
for($o=0;$o<count($list);$o++){
  $info=pdo_get('zhvip_stinfo',array('type_id'=>$list[$o]['id'],'state'=>1),array('COUNT(id) as count'));
  $list[$o]['count']=$info['count'];
}
$pager = pagination($total, $pageindex, $pagesize);

if(checksubmit('submit')){
  $num=$_GPC['js_money'];
  $day=$_GPC['js_num'];
  $data3['time']=date('Y-m-d H:i:s');
  $data3['number']=$num;
  $data3['name']=$_GPC['name'];
  $data3['term']=$day;
  $data3['uniacid']=$_W['uniacid'];
  $res=pdo_insert('zhvip_stlist',$data3);
  $id=pdo_insertid();
  for($i=0;$i<$num;$i++){
      $data2['code']=str_shuffle(date('Ymd').rand(1111,9999));
      $data2['pwd']=str_shuffle(rand(100000,999999));
      $data2['state']=2;//未绑定
      $data2['term']=$day;//期限
      $data2['type_id']=$id;
      pdo_insert('zhvip_stinfo',$data2); 
  }
  if($res){
     message('生成成功！', $this->createWebUrl('stcard'), 'success');
  }else{
    message('生成失败！','','error');
  }

}




if($_GPC['op']=='dc') {
$st=pdo_get('zhvip_stlist',array('id'=>$_GPC['type_id']));
  $count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("zhvip_stinfo")." WHERE type_id=".$_GPC['type_id']);
  $pagesize = ceil($count/5000);
        //array_unshift( $names,  '活动名称'); 

  $header = array(
    'item'=>'序号',
    'st_name' => '实体卡列表名称',
    'code' => '卡号',
    'pwd' => '密码', 
    'term' => '期限', 
    'state' => '状态'
    );

  $keys = array_keys($header);
  $html = "\xEF\xBB\xBF";
  foreach ($header as $li) {
    $html .= $li . "\t ,";
  }
  $html .= "\n";
  for ($j = 1; $j <= $pagesize; $j++) {
    $sql = "select * from " . tablename("zhvip_stinfo")."  WHERE  type_id=".$_GPC['type_id']."  limit " . ($j - 1) * 5000 . ",5000 ";
    $list = pdo_fetchall($sql);            
  }
  if (!empty($list)) {
    $size = ceil(count($list) / 500);
    for ($i = 0; $i < $size; $i++) {
      $buffer = array_slice($list, $i * 500, 500);
      $user = array();
      foreach ($buffer as $k =>$row) {
        $row['item']= $k+1;
        if($row['state']==1){
          $row['state']='已绑定';
        }elseif($row['state']==2){
          $row['state']='未绑定';
        }
$row['st_name']=$st['name'];
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
  header("Content-Disposition:attachment; filename=实体卡数据.csv");
  echo $html;
  exit();
}

include $this->template('web/stcard');