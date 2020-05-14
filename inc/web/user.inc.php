<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if (checksubmit('submit')) {
    $op = $_GPC['keywords'];
    $where = "%$op%";
} else {
    $where = '%%';
}
$pageindex = max(1, intval($_GPC['page']));
$pagesize = 10;
$sql = "select a.*,b.name as level_name,d.name as st_name  from " . tablename("zhvip_user") . "a" . " left join " . tablename("zhvip_level") . " b on b.id=a.grade left join " . tablename("zhvip_stinfo") . " c on c.code=a.vip_code left join " . tablename("zhvip_stlist") . " d on d.id=c.type_id WHERE  (a.nickname LIKE :name || a.name LIKE :name || a.tel LIKE :name || a.vip_code LIKE :name || d.name LIKE :name)  and a.uniacid=:uniacid and a.grade>0 order by id desc";
$select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
$list = pdo_fetchall($select_sql, array(':uniacid' => $_W['uniacid'], ':name' => $where));
$total = pdo_fetchcolumn("select count(*)  from " . tablename("zhvip_user") . "a" . " left join " . tablename("zhvip_level") . " b on b.id=a.grade left join " . tablename("zhvip_stinfo") . " c on c.code=a.vip_code left join " . tablename("zhvip_stlist") . " d on d.id=c.type_id WHERE  (a.nickname LIKE :name || a.name LIKE :name || a.tel LIKE :name || a.vip_code LIKE :name || d.name LIKE :name)  and a.uniacid=:uniacid and a.grade>0", array(':uniacid' => $_W['uniacid'], ':name' => $where));
$pager = pagination($total, $pageindex, $pagesize);
if ($_GPC['id']) {
    $res4 = pdo_delete("zhvip_user", array('id' => $_GPC['id']));
    if ($res4) {
        message('删除成功！', $this->createWebUrl('user'), 'success');
    } else {
        message('删除失败！', '', 'error');
    }
}
if (checksubmit('submit2')) {
    $res = pdo_update('zhvip_user', array('wallet +=' => $_GPC['reply']), array('id' => $_GPC['id2']));
    if ($res) {
        $data['money'] = $_GPC['reply'];
        $data['user_id'] = $_GPC['id2'];
        $data['type'] = 1;
        $data['note'] = '后台充值';
        $data['time'] = date('Y-m-d H:i:s');
        $data['uniacid'] = $_W['uniacid'];//小程序id
        $res2 = pdo_insert('zhvip_qbmx', $data);
        $qbid = pdo_insertid();
        file_get_contents("" . $_W['siteroot'] . "app/index.php?i=" . $_W['uniacid'] . "&c=entry&a=wxapp&do=YueMessage&m=zh_vip&id=" . $qbid);//模板消息
        if ($res2) {
            $data2['user_id'] = $_GPC['id2'];
            $data2['state'] = 2;
            $data2['uniacid'] = $_W['uniacid'];
            $data2['time'] = date("Y-m-d H:i:s");
            $data2['money'] = $_GPC['reply'];
            $data2['note'] = '后台充值';
            $data2['account_id']=$_W['uid'];
            pdo_insert('zhvip_czorder', $data2);
            message('充值成功！', $this->createWebUrl('user'), 'success');
        } else {
            message('充值失败！', '', 'error');
        }
    }
}
if (checksubmit('submit3')) {
    $res = pdo_update('zhvip_user', array('integral +=' => $_GPC['reply']), array('id' => $_GPC['id3']));
    if ($res) {
        $data['score'] = $_GPC['reply'];
        $data['user_id'] = $_GPC['id3'];
        $data['type'] = 1;
        $data['note'] = '后台充值';
        $data['cerated_time'] = date('Y-m-d H:i:s');
        $data['uniacid'] = $_W['uniacid'];//小程序id
        $res2 = pdo_insert('zhvip_jfmx', $data);
        if ($res2) {
            message('充值成功！', $this->createWebUrl('user'), 'success');
        } else {
            message('充值失败！', '', 'error');
        }
    }
}
if($_GPC['op']=='dc') {

  $count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("zhvip_user"). "  where uniacid=".$_W['uniacid']." and grade>0");
  $pagesize = ceil($count/5000);
        //array_unshift( $names,  '活动名称'); 

  $header = array(
    'id'=>'用户id',
    'name'=>'姓名',
    'tel'=>'电话',
    'openid'=>'openid',
    'level_name' => '会员等级',
    'st_name' => '实体卡列表名称',
    'type' => '会员卡类型',
    'code_time' => '开卡时间',
    'vip_time' => '到期时间',
    'vip_code' => '会员卡号', 
    'cumulative' => '累计消费', 
    'wallet' => '钱包',
    'integral' => '积分'
    );

  $keys = array_keys($header);
  $html = "\xEF\xBB\xBF";
  foreach ($header as $li) {
    $html .= $li . "\t ,";
  }
  $html .= "\n";
  for ($j = 1; $j <= $pagesize; $j++) {
    $sql = "select a.*,b.name as level_name,d.name as st_name from " . tablename("zhvip_user")." a" . " left join " . tablename("zhvip_level") . " b on b.id=a.grade left join " . tablename("zhvip_stinfo") . " c on c.code=a.vip_code left join " . tablename("zhvip_stlist") . " d on d.id=c.type_id   where a.uniacid=".$_W['uniacid']." and a.grade>0  limit " . ($j - 1) * 5000 . ",5000 ";
    $list = pdo_fetchall($sql);            
  }
  if (!empty($list)) {
    $size = ceil(count($list) / 500);
    for ($i = 0; $i < $size; $i++) {
      $buffer = array_slice($list, $i * 500, 500);
      $user = array();
      foreach ($buffer as $k =>$row) {
        if($row['type']==1){
          $row['type']='虚拟卡';
        }else{
          $row['type']='实体卡';
        }
         $row['code_time']=date("Y-m-d H:i:s",$row['code_time']);
         $row['vip_time']=date("Y-m-d H:i:s",$row['vip_time']);
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
  header("Content-Disposition:attachment; filename=会员数据.csv");
  echo $html;
  exit();
}
include $this->template('web/user');